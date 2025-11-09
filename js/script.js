// Mobile Navigation Toggle
document.querySelector('.hamburger').addEventListener('click', function() {
    document.querySelector('.nav-links').classList.toggle('active');
});

// Smooth Scrolling für Navigation Links mit Offset
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const target = document.querySelector(targetId);

        if (target) {
            // Header-Offset: 120px für den fixen Header
            const headerOffset = 120;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });

            // Mobile-Menü schließen nach Klick
            document.querySelector('.nav-links').classList.remove('active');
        }
    });
});

// reCAPTCHA v3 Integration für das Kontaktformular
const contactForm = document.getElementById('contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Verhindert das sofortige Absenden

        const siteKey = '6LfnRQcsAAAAALioZagT869ZEeZmtc-l-5_0UUYF';

        // Prüfen, ob reCAPTCHA geladen ist
        if (typeof grecaptcha === 'undefined' || !grecaptcha.execute) {
            console.error('reCAPTCHA script not loaded');
            alert('Der reCAPTCHA-Dienst konnte nicht geladen werden. Bitte überprüfen Sie Ihre Internetverbindung und versuchen Sie es erneut.');
            return;
        }

        grecaptcha.ready(function() {
            grecaptcha.execute(siteKey, {action: 'submit'}).then(function(token) {
                // Fügt das Token zum versteckten Feld hinzu
                const recaptchaResponse = document.getElementById('recaptchaResponse');
                if (recaptchaResponse) {
                    recaptchaResponse.value = token;
                    // Sendet das Formular ab
                    contactForm.submit();
                } else {
                    console.error('reCAPTCHA response field not found');
                    alert('Ein interner Fehler ist aufgetreten. Das Formular konnte nicht gesendet werden.');
                }
            }).catch(function(error) {
                console.error('Error executing reCAPTCHA:', error);
                alert('Bei der reCAPTCHA-Überprüfung ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
            });
        });
    });
}