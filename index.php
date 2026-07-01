<?php
// CSRF-Token Session starten
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// CSRF-Token generieren falls nicht vorhanden
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imad Chatila - Portfolio</title>
    <link rel="preload" as="image" href="./images/site/hintergrundbild_v_1.webp" type="image/webp" fetchpriority="high">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="./images/favicons/favicon-32x32.png">
    <script src="https://www.google.com/recaptcha/api.js?render=6LfnRQcsAAAAALioZagT869ZEeZmtc-l-5_0UUYF" async defer></script>

</head>

<body>
    <header>
        <nav>
            <div class="logo">Imad Chatila</div>
            <ul class="nav-links">
                <li><a href="#about">Über mich</a></li>
                <li><a href="#resume">Lebenslauf</a></li>
                <li><a href="#projekte">Projekte</a></li>
                <li><a href="#contact">Kontakt</a></li>
            </ul>
            <button class="hamburger">☰</button>
        </nav>
    </header>

    <main>
        <section id="about">
            <figure class="profile-image">
                <img src="./images/portraits/profilbild.jpg" alt="Profilbild von Imad Chatila">
            </figure>
            <article class="about-content">
                <h1><i class="fa-solid fa-user"></i> Über mich</h1>
                <p>Hallo! Ich bin Imad Chatila, 1984 im Libanon geboren und seit 1988 in der Schweiz zu Hause.</p>

                <h2>Meine Werte</h2>
                <p>Zuverlässigkeit und Organisation sind für mich selbstverständlich. Ich erledige Aufgaben termingerecht und strukturiert. Neue Technologien und Programmierkonzepte wecken meine Neugier und motivieren mich, ständig dazuzulernen. Durch meine langjährige Erfahrung im Detailhandel weiss ich ausserdem, wie wichtig es ist, auf die Bedürfnisse von Anwendern einzugehen. Kundenorientierung ist für mich nicht nur ein Schlagwort, sondern gelebte Praxis.</p>

                <h2>Meine Ausbildung</h2>
                <p>Von September 2024 bis Juni 2026 habe ich an der Benedict-Schule in Zürich den schulischen Teil der zweijährigen Ausbildung zum Informatiker EFZ, Fachrichtung Applikationsentwicklung für Berufsumsteiger, absolviert. Für den Abschluss fehlt mir nun noch die praktische Berufserfahrung im Betrieb, um anschliessend die IPA zu absolvieren und den EFZ-Abschluss zu erlangen.</p>

                <h2>Projekte & Ausblick</h2>
                <p>Während meiner Ausbildung konnte ich verschiedene Schul- und Lernprojekte umsetzen und dabei Grundlagen in Webentwicklung, Programmierung, Datenbanken und Softwarestruktur sammeln. Auf dieser Website zeige ich eine Auswahl dieser Projekte und dokumentiere meinen Lernweg in der Applikationsentwicklung.</p>

                <p>Besonders interessieren mich Webanwendungen, Datenbanken und die strukturierte Umsetzung von Softwarelösungen. Mein nächster Schritt ist es, diese Kenntnisse in einem professionellen Umfeld praktisch anzuwenden, mich in bestehende Projekte einzuarbeiten und fachlich weiter zu wachsen.</p>

                <h2>Ziele</h2>
                <p>Mein nächstes Ziel ist eine Praktikums- oder Einstiegsstelle in der Applikationsentwicklung, in der ich meine Kenntnisse praktisch anwenden und weiterentwickeln kann. Besonders interessieren mich Webentwicklung, Datenbanken, strukturierte Softwarelösungen und die Arbeit an realen Projekten im Team. Langfristig möchte ich Applikationen entwickeln, die technisch sauber umgesetzt und für Anwender verständlich und nützlich sind.</p>

                <h2>Freizeit & Leidenschaft</h2>
                <p>
                    Wenn ich nicht am Code feile, findest du mich im Fitnessstudio oder beim Musikhören, oft elektronische Musik zur Entspannung oder Inspiration.
                    Ab und zu gönne ich mir eine Auszeit in der Natur, um den Kopf frei zu bekommen und neue Energie zu tanken.
                </p>
                <p>Manchmal schiesse ich auch gerne Fotos, um besondere Augenblicke festzuhalten.</p>

                <h2>Bilder von mir und anderen Momenten</h2>
                <p>
                    Hier ist eine Fotoserie aus demselben Blickwinkel, die den Wandel der Natur vor meinem Fenster in allen vier Jahreszeiten zeigt.
                </p>

                <div class="gallery gallery-seasons">
                    <figure>
                        <img src="./images/jahreszeiten/sommer.jpg" alt="Sommer – Sonne auf der Wiese, Himmel bewölkt" style="width:100%">
                        <figcaption>Sommer - Obwohl der Himmel bewölkt war, lag über der Wiese trotzdem Sonnenlicht.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/jahreszeiten/herbst.jpg" alt="Herbst – buntes Laub" style="width:100%">
                        <figcaption>Herbst - Die Bäume färben sich in warmen Tönen, die Stimmung wird ruhiger.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/jahreszeiten/winter.jpg" alt="Winter – verschneite Landschaft" style="width:100%">
                        <figcaption>Winter - Die Landschaft liegt still unter einer Schneedecke.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/jahreszeiten/fruehling.jpg" alt="Frühling – grüne Wiese im Regen" style="width:100%">
                        <figcaption>Frühling - Die Wiese ist wieder grün, doch an diesem Tag regnete es stark.</figcaption>
                    </figure>
                </div>

                <p>Und hier ein paar persönliche Augenblicke:</p>

                <div class="gallery gallery-portraits">
                    <figure>
                        <img src="./images/portraits/schnee.jpg" alt="Selbstporträt im Schnee">
                        <figcaption>Eiskalte Tage, an denen tanzende Schneeflocken im Zwielicht flüstern und die Kälte ihr uraltes Lied singt.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/portraits/see.jpg" alt="Selbstporträt am See">
                        <figcaption>Unter einem staubverhangenen Himmel glimmt die Sonne wie ein ferner Wächter über dem stillen Gewässer.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/portraits/portrait_01.jpg" alt="Selbstporträt zu Hause">
                        <figcaption>Ein Selfie zu Hause.</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/portraits/city.jpg" alt="Selbstporträt in Zürich">
                        <figcaption>Aufgenommen auf dem Lindenhof in Zürich mit Blick auf den Zürichsee und die Stadt.</figcaption>
                    </figure>
                </div>
            </article>
        </section>

        <section id="resume">
            <h1><i class="fa-solid fa-file-lines"></i> Lebenslauf</h1>

            <article class="resume-content">
                <h2>Mein Weg in die IT: Von der Praxis zur digitalen Zukunft</h2>

                <p>Mein beruflicher Weg begann nicht direkt in der Informatik, sondern in einem Umfeld, in dem Kundennähe, Organisation und Verantwortung wichtig waren. Mehrere Jahre war ich als selbstständiger Detailhändler tätig und habe Kunden beraten, den Verkauf organisiert, administrative Aufgaben übernommen und Abläufe im Alltag koordiniert.</p>

                <p>Mit der Zeit wuchs mein Interesse an Technologie, digitalen Lösungen und Softwareentwicklung immer stärker. Besonders spannend finde ich, wie Anwendungen Prozesse vereinfachen, Informationen verständlich darstellen und konkrete Probleme im Alltag lösen können.</p>

                <p>Von September 2024 bis Juni 2026 absolvierte ich an der Benedict-Schule in Zürich den schulischen Teil der zweijährigen Ausbildung zum Informatiker EFZ, Fachrichtung Applikationsentwicklung für Berufsumsteiger. Dabei konnte ich Grundlagen in HTML, CSS, JavaScript, PHP, SQL, NoSQL, Java, Python und C++ sammeln und erste Schul- und Lernprojekte umsetzen.</p>

                <p>Aktuell suche ich eine Praktikums- oder Einstiegsstelle in der Applikationsentwicklung, um meine Kenntnisse in der Praxis anzuwenden, weitere Berufserfahrung zu sammeln und anschliessend die IPA sowie den EFZ-Abschluss absolvieren zu können.</p>

                <p>Mein kaufmännischer und kundenorientierter Hintergrund hilft mir dabei, technische Aufgaben nicht nur aus Sicht des Codes zu betrachten, sondern auch mit Blick auf Anwender, Abläufe und verständliche Lösungen.</p>

                <p>Mein Ziel ist es, mich Schritt für Schritt zu einem zuverlässigen Applikationsentwickler weiterzuentwickeln und an Softwarelösungen mitzuarbeiten, die im Alltag echten Nutzen bringen.</p>

                <figure class="resume-image">
                    <img src="./images/portraits/spaziergang.jpg" alt="Imad läuft in einer Landschaft">
                    <figcaption>Ein Schritt nach vorn – mein Weg in die IT.</figcaption>
                </figure>
            </article>
        </section>

        <section id="projekte">
            <h1><i class="fa-solid fa-code"></i> Projekte</h1>

            <article class="projekt">
                <p class="date-box">Mai 2026</p>
                <h2>System Info Tool mit C# und WPF</h2>
                <p>
                    Eine portable Windows-Desktop-App, die ohne Installation als einzelne EXE-Datei gestartet werden kann.
                    Die Anwendung liest wichtige Hardware- und Systeminformationen aus und stellt sie übersichtlich als Report dar.
                    Dazu gehören unter anderem Informationen zu Windows, BIOS, CPU, GPU, RAM, Mainboard, Speicher, Monitoren, Audio, Netzwerk und Uptime.
                </p>

                <p>
                    Das Projekt wurde als Weiterentwicklung meines früheren PowerShell-System-Info-Tools umgesetzt.
                    Dabei lag der Fokus darauf, eine benutzerfreundlichere Oberfläche mit C# und WPF zu erstellen und die Systemdaten strukturierter aufzubereiten.
                    Zusätzlich kann der Report in die Zwischenablage kopiert oder als TXT-Datei gespeichert werden.
                </p>

                <p>Technologien: C#, WPF, .NET, System.Management, LibreHardwareMonitorLib, Vortice.DXGI</p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/system_info_tool_c_sharp.png" alt="Screenshot des System Info Tools mit C# und WPF">
                    <figcaption>Screenshot des System Info Tools mit C# und WPF.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/system_info_tool_c-sharp" target="_blank" class="button-projekt">Code auf GitHub</a>
                    <a href="https://github.com/masterkreb/system_info_tool_c-sharp/releases/latest" target="_blank" class="button-projekt">Download</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">Dezember 2025</p>
                <h2>Mobile Einkaufsliste mit Barcode-Scanner</h2>
                <p>Eine mobile App zur Verwaltung von Einkaufslisten, entwickelt mit React Native.
                    Die App ermöglicht das Erstellen und Teilen von Listen, das Hinzufügen von Artikeln über die Handykamera als Barcode-Scanner und die Echtzeit-Synchronisation zwischen Geräten.</p>

                <p>Das Projekt wurde als Leistungsnachweis im Informatikunterricht entwickelt.
                    Meine Rolle lag in der Konzeption, der detaillierten Planung der Features (wie Barcode-Erkennung und Cloud-Speicher) und der Steuerung der KI, welche die Code-Generierung übernommen hat. </p>

                <p>Technologien: React Native, Expo, Firebase (Firestore & Authentication)</p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/einkaufsliste.png" alt="Screenshot der Familien-Einkaufsliste Seite">
                    <figcaption>Screenshot der Familien-Einkaufsliste.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/einkaufsliste" target="_blank" class="button-projekt">Code auf GitHub</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">November 2025</p>
                <h2>GamerFeed – RSS Feed News-Aggregator</h2>
                <p>
                    Ein News-Aggregator, der Gaming-Nachrichten aus verschiedenen Quellen sammelt und übersichtlich darstellt.
                </p>

                <p>
                    Das Projekt wurde vollständig mit KI-Unterstützung entwickelt.
                    Ich habe das Konzept geplant, Features definiert und die KI mit Anweisungen gesteuert.
                    Der Code wurde von der KI generiert.
                </p>

                <p>
                    Technologien: React, TypeScript, Tailwind CSS, Vercel, PostgreSQL
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/gamerfeed.jpg" alt="Screenshot der GamerFeed Seite">
                    <figcaption>Screenshot der GamerFeed Seite.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/gamerfeed" target="_blank" class="button-projekt">Code auf GitHub</a>
                    <a href="https://gamerfeed.vercel.app/" target="_blank" class="button-projekt">Live-Demo</a>
                </div>
            </article>


            <article class="projekt">
                <p class="date-box">Juni 2025</p>
                <h2>Pacman Teamprojekt - Agile Spieleentwicklung mit Python</h2>
                <p>
                    Im Rahmen des Informatikunterrichts haben wir als Team von 6 Personen ein klassisches Pac-Man-Spiel in Python entwickelt.
                    Der Fokus lag dabei weniger auf dem Code selbst, sondern auf dem agilen Arbeiten mit Scrum und dem Einsatz von Versionskontrolle mit GitHub.
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/pacman.png" alt="Screenshot des Pacman-Spiels">
                    <figcaption>Screenshot des Pacman-Spiels.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/projekt_pacman" target="_blank" class="button-projekt">Code auf GitHub</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">Seit Mai 2025</p>
                <h2>Aktuelle Portfolio-Seite mit PHP und CI/CD</h2>
                <p>
                    Dieses Projekt begann im Rahmen des HTML- und CSS-Unterrichts als persönliche One-Page-Portfolio-Seite.
                    Seitdem habe ich die Website laufend erweitert und technisch verbessert.
                    Heute dient sie als zentrale Portfolio-Seite, auf der ich meinen Werdegang, meine Projekte und meine Kontaktmöglichkeit präsentiere.
                </p>

                <p>
                    Die Seite wird auf meinem cyon-Webhosting betrieben und wurde inzwischen unter anderem mit PHP, einem Kontaktformular mit CSRF-Schutz, reCAPTCHA und automatischem Deployment über GitHub Actions erweitert.
                    Dadurch kann ich Änderungen lokal entwickeln, über GitHub versionieren und automatisch live veröffentlichen.
                </p>

                <p>
                    Technologien: HTML, CSS, JavaScript, PHP, GitHub Actions, cyon Webhosting
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/portfolio-seite_2.jpg" alt="Screenshot der Portfolio-Seite">
                    <figcaption>Screenshot der Portfolio-Seite.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/portfolio2" target="_blank" class="button-projekt">Code auf GitHub</a>                 
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">März 2025</p>
                <h2>YouTube Downloader mit PowerShell</h2>
                <p>
                    Dieses Projekt wurde im Rahmen des Informatikunterrichts (PowerShell-Lernprojekt, Klasse ITB1c) von mir entwickelt.
                    Ein einfaches PowerShell-Tool zum Herunterladen von YouTube-Videos über einen Videolink.
                    Das Tool nutzt yt-dlp als Backend.
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/powershell_youtube.png" alt="Screenshot des Powershell Tools">
                    <figcaption>Screenshot des Powershell Tools.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/youtube_downloader" target="_blank" class="button-projekt">Code auf GitHub</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">März 2025</p>
                <h2>System Info Tool mit Powershell</h2>
                <p>
                    Dieses Projekt wurde im Rahmen des Informatikunterrichts als Gruppenarbeit von mir und zwei Mitschülern entwickelt.
                    Das PowerShell-Skript zeigt grundlegende Systeminformationen in einem GUI-Fenster an.
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/system_info_tool_powershell.png" alt="Screenshot des Powershell Tools">
                    <figcaption>Screenshot des Powershell Tools.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/system_info_tool" target="_blank" class="button-projekt">Code auf GitHub</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">Januar 2025</p>
                <h2>Erste Portfolio-Seite</h2>
                <p>
                    Bei diesem Projekt handelt es sich um meine persönliche Seite, auf der ich meine Projekte präsentieren kann.
                    Für die Umsetzung habe ich HTML und CSS verwendet.
                </p>
                <p>
                    Obwohl ich für dieses Projekt aufgrund fehlender Kenntnisse noch nicht vollständig bereit war,
                    habe ich die Website trotzdem erstellt, um einen Ausgangspunkt für zukünftige Projekte zu schaffen.
                    Ich habe viel durch Online-Ressourcen und Tools wie ChatGPT gelernt.
                </p>

                <figure class="projekt-bild">
                    <img src="./images/projekte/portfolio-seite.jpg" alt="Screenshot der Portfolio-Seite">
                    <figcaption>Screenshot der Portfolio-Seite.</figcaption>
                </figure>

                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/portfolio" target="_blank" class="button-projekt">Code auf GitHub</a>
                    <a href="https://masterkreb.github.io/portfolio/" target="_blank" class="button-projekt">Live-Demo</a>
                </div>
            </article>

            <article class="projekt">
                <p class="date-box">Dezember 2024</p>
                <h2>Erstes Projekt</h2>
                <p>Mein erstes Projekt war eine Rezept-Seite mit einer Hauptseite und 3 Unterseiten für jeweils ein Rezept.</p>
                <p>Das Projekt war Teil eines Lernprogramms von <a href="https://www.theodinproject.com/about" target="_blank" rel="noopener noreferrer">The Odin Project</a>.</p>
                <p>Die Seite wurde nur mit HTML geschrieben.</p>
                <figure class="projekt-bild">
                    <img src="./images/projekte/odin-recipes.png" alt="Screenshot der Rezept-Seite">
                    <figcaption>Screenshot der Rezept-Seite.</figcaption>
                </figure>
                <div class="projekt-links">
                    <a href="https://github.com/masterkreb/odin-recipes" target="_blank" class="button-projekt">Code auf GitHub</a>
                    <a href="https://masterkreb.github.io/odin-recipes/" target="_blank" class="button-projekt">Live-Demo</a>
                </div>
            </article>
        </section>

        <section id="contact">
            <h1><i class="fa-solid fa-envelope"></i> Kontakt</h1>

            <p>Du hast eine Frage oder ein Anliegen? Schreib mir einfach über das Formular!</p>

            <form id="contact-form" action="process_form.php" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Betreff</label>
                    <input type="text" id="subject" name="subject" required maxlength="200">
                </div>

                <div class="form-group">
                    <label for="message">Nachricht</label>
                    <textarea id="message" name="message" rows="5" required maxlength="2000"></textarea>
                </div>

                <!-- Honeypot gegen Bots -->
                <div class="form-group honeypot">
                    <label for="website">Bitte dieses Feld leer lassen</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <!-- Verstecktes Feld für das reCAPTCHA Token -->
                <input type="hidden" id="recaptchaResponse" name="g-recaptcha-response">

                <button type="submit">Nachricht senden</button>
            </form>
        </section>

    </main>

    <footer>
        <p>&copy; 2025<?php if(date('Y') > 2025) echo ' - ' . date('Y'); ?> Imad Chatila. Alle Rechte vorbehalten.</p>
    </footer>

    <script src="./js/script.js"></script>

</body>

</html>