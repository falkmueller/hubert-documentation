# Dokumentation

## Was ist Hubert?

Hubert ist ein PHP Micro Framework. Es lädt die Konfiguration und steuert den Ablauf von der Server-Anfrage bis zur Antwort.

## Wie funktioniert das?

Hubert wird mit einem Array initialisiert, der die Konfiguration, Service-Container und Routen beinhaltet.
Beim Ausführen von _hubert()->core()->run()_ wird die zur Anfrage passende Route herausgesucht, ausgeführt und die Antwort an den Browser gesendet.
Das ist die Grundfunktion von Hubert.
Darüber hinaus kann Hubert natürlich auch ein Bootstrap-Script ausführen, MVC-Routen verarbeiten, Templates rendern, Daten speichern, und noch mehr.
All das wird in dieser Dokumentation genauer beschrieben.
