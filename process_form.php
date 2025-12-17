<?php
// Sichere Session-Einstellungen
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// Rate Limiting und Config laden
require_once 'rate_limit.php';
require_once '../../config.php'; // Zwei Ebenen höher: aus imadchatila raus, aus public_html raus

// CSRF-Token Validierung
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Sicherheitsfehler: Ungültiges CSRF-Token. Bitte laden Sie die Seite neu.");
}

// Rate Limiting prüfen
$rateLimiter = new RateLimiter('rate_limit.log', $rateLimitMaxAttempts, $rateLimitTimeWindow);
$userIP = $_SERVER['REMOTE_ADDR'];

if (!$rateLimiter->isAllowed($userIP)) {
    $remainingTime = $rateLimiter->getRemainingTime($userIP);
    $minutes = ceil($remainingTime / 60);
    die("Zu viele Anfragen von Ihrer IP-Adresse. Bitte warten Sie $minutes Minuten und versuchen Sie es erneut.");
}

// Honeypot-Prüfung
if (!empty($_POST['website'])) {
    die("Bot erkannt – Nachricht wurde nicht gesendet.");
}

$fehler = [];

// reCAPTCHA v3 Server-Side Validation mit Score-Bewertung
if (isset($_POST['recaptcha_response'])) {
    $recaptchaToken = $_POST['recaptcha_response'];
    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

    $postData = http_build_query([
        'secret'   => $recaptchaSecretKey,
        'response' => $recaptchaToken,
        'remoteip' => $userIP
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $postData,
            'timeout' => 10
        ]
    ];

    $context  = stream_context_create($options);
    $response = @file_get_contents($verifyURL, false, $context);

    if ($response === false) {
        $fehler[] = "reCAPTCHA-Dienst nicht erreichbar. Bitte versuchen Sie es später erneut.";
    } else {
        $responseData = json_decode($response);
        
        // Prüfe ob Response gültig ist
        if (!$responseData || !isset($responseData->success)) {
            $fehler[] = "Ungültige reCAPTCHA-Antwort erhalten.";
        } 
        // Prüfe Success-Status
        elseif (!$responseData->success) {
            $fehler[] = "reCAPTCHA-Verifizierung fehlgeschlagen.";
        }
        // Prüfe ob Score vorhanden ist
        elseif (!isset($responseData->score)) {
            $fehler[] = "reCAPTCHA-Score fehlt in der Antwort.";
        }
        // Prüfe Action (sollte 'submit' sein)
        elseif (!isset($responseData->action) || $responseData->action !== 'submit') {
            $fehler[] = "reCAPTCHA-Action stimmt nicht überein.";
        }
        // Bewerte den Score (0.0 = Bot, 1.0 = Mensch)
        else {
            $score = $responseData->score;
            
            // Score muss mindestens 0.5 betragen
            if ($score < 0.5) {
                $fehler[] = "reCAPTCHA-Verifizierung fehlgeschlagen. Sie wurden als potenzieller Bot eingestuft (Score: " . number_format($score, 2) . ").";
            }
            // Optional: Logs für Monitoring (Score wird aktiv abgerufen und verwendet)
            // error_log("reCAPTCHA Score für IP $userIP: $score");
        }
    }
} else {
    $fehler[] = "reCAPTCHA-Token fehlt. Bitte stellen Sie sicher, dass JavaScript aktiviert ist.";
}

// Felder-Validierung
$felder = ['name', 'email', 'subject', 'message'];

foreach ($felder as $feld) {
    if (empty($_POST[$feld])) {
        $fehler[] = "Das Feld '$feld' muss ausgefüllt werden.";
    }
}

// E-Mail-Validierung (strenger)
if (!empty($_POST['email'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $fehler[] = "Die E-Mail-Adresse ist ungültig.";
    }

    // Prüfe auf verdächtige Zeichen
    if (preg_match('/[<>"\'\r\n\t%]/', $_POST['email'])) {
        $fehler[] = "Ungültige Zeichen in E-Mail-Adresse erkannt.";
    }
}

// Funktion zur Bereinigung von Header-Injections
function clean_header($string) {
    return str_replace(["\r", "\n", "\t", "%0a", "%0d", "%0A", "%0D"], '', $string);
}

// Funktion zur Längenprüfung
function validate_length($string, $max_length) {
    return mb_strlen($string) <= $max_length;
}

// Längenbeschränkungen
if (!empty($_POST['name']) && !validate_length($_POST['name'], 100)) {
    $fehler[] = "Der Name ist zu lang (max. 100 Zeichen).";
}

if (!empty($_POST['subject']) && !validate_length($_POST['subject'], 200)) {
    $fehler[] = "Der Betreff ist zu lang (max. 200 Zeichen).";
}

if (!empty($_POST['message']) && !validate_length($_POST['message'], 2000)) {
    $fehler[] = "Die Nachricht ist zu lang (max. 2000 Zeichen).";
}

// Prüfung auf verdächtige Inhalte
if (!empty($_POST['email'])) {
    $suspicious_patterns = [
        '/bcc:/i',
        '/cc:/i',
        '/to:/i',
        '/from:/i',
        '/reply-to:/i',
        '/content-type:/i',
        '/mime-version:/i',
        '/x-mailer:/i'
    ];

    foreach ($suspicious_patterns as $pattern) {
        if (preg_match($pattern, $_POST['email'])) {
            $fehler[] = "Ungültige E-Mail-Adresse erkannt.";
            break;
        }
    }
}

// Wenn keine Fehler vorhanden sind, E-Mail senden
if (empty($fehler)) {
    // Rate Limit Eintrag speichern
    $rateLimiter->recordAttempt($userIP);

    // Daten aus dem Formular holen und bereinigen
    $name = clean_header(htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8'));
    $email = clean_header(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
    $betreff = clean_header(htmlspecialchars(trim($_POST['subject']), ENT_QUOTES, 'UTF-8'));
    $nachricht = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

    // Zusätzliche Validierung der bereinigten E-Mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $fehler[] = "Die E-Mail-Adresse ist nach der Bereinigung ungültig.";
    }

    if (empty($fehler)) {
        // E-Mail an dich (Empfänger) senden
        // WICHTIG: Reply-To wird NICHT auf die User-Email gesetzt (Sicherheit!)
        $headers_an_dich = "From: noreply@imadchatila.ch" . "\r\n";
        $headers_an_dich .= "Reply-To: noreply@imadchatila.ch" . "\r\n";
        $headers_an_dich .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
        $headers_an_dich .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        // E-Mail-Inhalt für dich (mit User-Email im Body)
        $email_inhalt_an_dich = "Name: $name\n";
        $email_inhalt_an_dich .= "E-Mail: $email\n";
        $email_inhalt_an_dich .= "Betreff: $betreff\n\n";
        $email_inhalt_an_dich .= "Nachricht:\n$nachricht\n";
        $email_inhalt_an_dich .= "\n---\n";
        $email_inhalt_an_dich .= "Gesendet von IP: " . $userIP . "\n";
        $email_inhalt_an_dich .= "Datum: " . date('Y-m-d H:i:s') . "\n";
        $email_inhalt_an_dich .= "User-Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unbekannt') . "\n";

        $vollstaendiger_betreff = $betreff_prefix . $betreff;

        // E-Mail an dich senden
        $erfolg_an_dich = mail($empfaenger, $vollstaendiger_betreff, $email_inhalt_an_dich, $headers_an_dich);

        // Bestätigungs-E-Mail an Sender
        if ($erfolg_an_dich) {
            $headers_bestaetigung = "From: $absender_name <$empfaenger>" . "\r\n";
            $headers_bestaetigung .= "Reply-To: $empfaenger" . "\r\n";
            $headers_bestaetigung .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
            $headers_bestaetigung .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            $betreff_bestaetigung = "Danke für Ihre Nachricht: $betreff";

            $bestaetigung_inhalt = "Hallo $name,\n\n";
            $bestaetigung_inhalt .= "vielen Dank für Ihre Nachricht über mein Kontaktformular auf meiner Portfolio-Seite.\n\n";
            $bestaetigung_inhalt .= "Ihre Nachricht wurde erfolgreich übermittelt und ich werde sie schnellstmöglich bearbeiten.\n\n";
            $bestaetigung_inhalt .= "Hier eine Kopie Ihrer gesendeten Nachricht:\n\n";
            $bestaetigung_inhalt .= "----------------------------------------\n";
            $bestaetigung_inhalt .= "Betreff: $betreff\n";
            $bestaetigung_inhalt .= "Nachricht:\n$nachricht\n";
            $bestaetigung_inhalt .= "----------------------------------------\n\n";
            $bestaetigung_inhalt .= "Bei Fragen können Sie gerne direkt auf diese E-Mail antworten.\n\n";
            $bestaetigung_inhalt .= "Beste Grüsse\n";
            $bestaetigung_inhalt .= "$absender_name\n";
            $bestaetigung_inhalt .= "$website_address";

            $erfolg_bestaetigung = @mail($email, $betreff_bestaetigung, $bestaetigung_inhalt, $headers_bestaetigung);

            if (!$erfolg_bestaetigung) {
                error_log("Bestätigungs-E-Mail konnte nicht gesendet werden an: $email");
            }
        }

        // Überprüfen, ob die Haupt-E-Mail gesendet wurde
        if ($erfolg_an_dich) {
            // CSRF-Token erneuern für nächste Anfrage
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // Weiterleitung zur "Danke"-Seite
            header("Location: danke.html");
            exit;
        } else {
            $fehler[] = "Beim Senden der E-Mail ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.";
        }
    }
}

// Wenn Fehler aufgetreten sind, zurück zum Formular mit Fehlermeldungen
if (!empty($fehler)) {
    echo "<!DOCTYPE html>";
    echo "<html lang='de'><head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Fehler beim Senden</title>";
    echo "<meta http-equiv='refresh' content='7;url=index.php#contact'>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background-color: #f9f9f9; }";
    echo "h1 { color: #e74c3c; }";
    echo "ul { background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }";
    echo "li { margin-bottom: 10px; color: #c0392b; }";
    echo "a { color: #3498db; text-decoration: none; }";
    echo "a:hover { text-decoration: underline; }";
    echo "</style>";
    echo "</head><body>";
    echo "<h1>⚠️ Es sind Fehler aufgetreten</h1>";
    echo "<ul>";
    foreach ($fehler as $meldung) {
        echo "<li>" . htmlspecialchars($meldung, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul>";
    echo "<p>Sie werden in 7 Sekunden zum Formular zurückgeleitet. <a href='index.php#contact'>Klicken Sie hier</a>, wenn die Weiterleitung nicht automatisch erfolgt.</p>";
    echo "</body></html>";
    exit;
}
?>