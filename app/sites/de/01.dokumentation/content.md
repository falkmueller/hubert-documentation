# Dokumentation

## Was ist Hubert?

Hubert ist ein PHP mirco framework. Es lädt die Konfiguration und steuert den Ablauf von der Server-Anfrage bis zur Antwort.

## Wie funktioniert das?

Hubert wird mit einem Array initialisiert, der die Konfiguratin, Service-Container und Routen beinhaltet.
Beim Aufführen von "hubert()->core()->run()" wird die zur Anfrage passende Route heraus gesucht, ausgeführt und die Antwort an den Browser gesendet.
Das ist die Grund-Funktion von Hubert.
Darüber hinaus kann Hubert natürlich auch ein Bootstrap-Script ausführen, MVC-Routen verarbeiten, Templates rendern, daten speichern, ... 
Dies wird in dieser Dokumentation genauer beschrieben.
