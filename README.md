# Persönliche Portfolio-Seite

Dies ist meine persönliche Portfolio-Website. Sie zeigt Informationen zu meiner Ausbildung, meinem beruflichen Weg, meinen Projekten und bietet eine Kontaktmöglichkeit.

Live: [https://www.imadchatila.ch/](https://www.imadchatila.ch/)

## Technologien

- HTML
- CSS
- JavaScript
- PHP
- GitHub Actions
- cyon Webhosting

## Funktionen

- One-Page-Portfolio
- Projektübersicht
- Bildergalerien
- Kontaktformular mit CSRF-Schutz
- reCAPTCHA-Integration
- Rate Limiting für Formularanfragen
- Automatisches Deployment zu cyon über GitHub Actions

## Deployment

Die Website wird bei einem Push auf den `main`-Branch automatisch über GitHub Actions validiert und anschliessend auf das cyon-Webhosting deployed.

Der Workflow prüft zuerst die PHP-Dateien auf Syntaxfehler. Nur wenn diese Prüfung erfolgreich ist, werden die Dateien auf den Webserver hochgeladen.
