# Konfiguration

Hubert wird komplett über einen Array Konfiguriert.

## Konfigurations-Komponenten

es gibt vier Bereiche, welche konfiguriert werden können:
- Namespaces
- Factories
- Einstellungen
- Routen

### Namespaces

In diesem Bereich definiert man Namespaces mit dem dazugehörigen Ordner für den Autoloader:
```php
"namespace" => array(
    "app" => "app/"
),
```

In diesem Beispiel wird der Namespace "app" für einen gleichnamigen Ordner definiert. Zum Beispiel könnte in der Datei _app/bootstrap.php_ eine PHP-Klasse mit dem Namen "bootstrap" und dem Namespace "app" liegen. Wenn nun beispielsweise in den Routen die Klasse _$bootstrap = new \app\bootstrap()_ verwendet wird, wird diese Datei automatisch per include geladen. Dies wird später im Bereich [MVC](/de/dokumentation/mvc-tutorial/start) dieser Dokumentation verwendet.

### Factories

Factories sind statische Funktionen, welche einen Service initialisieren.
```php
"factories" => array(
    "router" => array(\hubert\service\router::class, 'factory'),
),
```
Dies ist ein Beispiel aus der Standardkonfiguration von Hubert (und muss deshalb nicht in der eigenen Konfiguration angegeben werden). Hier wird in der Klasse "router", welche im Namespace "hubert\service" liegt, die statische Funktion "factory" als Initiator für den Router definiert. Diese Funktion gibt also den Router als Objekt zurück. Der definierte Service ist dann über _hubert()->router_ global verfügbar und wird erst bei seiner erstmaligen Verwendung initialisiert. Genauso können eigene Services eingebunden werden.

### Einstellungen

Einstellungen sind zum Beispiel Strings oder Booleans, welche in Services zu dessen Konfiguration genutzt werden. Die hier im Beispiel definierte Einstellung wäre global über _hubert()->config->logger['path']_ verfügbar.
```php
"config" => array(
    "logger" => array(
        "path" => "logs/"
    )
),
```

### Routen

In diesem Konfigurationsbereich werden die Routen definiert. Mehr zu Routen findest du im Bereich [Routing](/de/dokumentation/mvc-tutorial/routing) dieser Dokumentation.
```php
"routes" => array(
    "home" => array(
        "route" => "/",
        "method" => "GET|POST",
        "target" => function(){
            echo "Hello World";
        }
    ),
),
```

## Laden der Konfiguration

Die Konfiguration muss immer beim erstmaligen Aufruf der _hubert()_ Funktion übergeben werden. Dazu gibt mehrere Möglichkeiten:
- Array
- Datei
- Ordner

### Konfiguration in einem Array

Im "Hello World"-Beispiel wurde die Konfiguration als Array definiert – dies ist vor Allem für sehr kleine Anwendungen gedacht.
```php
$config = array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);

hubert($config);
```


### Konfiguration in Datei
Diesen Array kann man auch in eine seperate Datei auslagern. Zum Beispiel eine _config.php_ Datei.
```php
return array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);
```

Bei der initialisierung kann man nun diese Datei statt einem Array übergeben:
```php
hubert("config.php");
```


### Konfiguration über einen Ordner

Dies ist der beste Weg zur Konfiguration von Hubert. Dabei wird ein Ordner _/config_ angelegt und die Konfigurationen werden nach Thema sortiert in verschiedenen Dateien abgelegt. Geladen werden die Konfigurationen indem man Hubert beim initialisieren den Pfad zu diesem Ordner gibt:
```php
$app->loadConfig('config/');
```    

Dabei gibt es drei verschiedene Endungen für die Konfigurationsdatein in diesen Ordner. Wenn verschiedene Dateien die gleiche Konfiguration beinhalten, entscheidet die Endung, welche Konfiguration gilt:
- _.default.php_ in dieser werden Standardkonfigurationen eingestellt
- _.global.php_ in dieser werden Konfigurationen eingestellt, welche für deine Anwendung gelten, wie beispielsweise Routen
- _.local.php_ in Konfigurationsdateien mit dieser Endung definiert man zum Beispiel die Datenbankverbindung, da diese nur lokal gilt und andere Entwickler in ihrer Anwedung andere Einstellungen verwenden

Hier ein kleines Beispiel zur Verdeutlichung: Wir haben eine Datei _config/general.global.php_ in welcher wir eine Route definieren und eine Einstellung, dass Fehler nicht angezeigt werden sollen:
```php
<?php
return array(
    "config" => array(
        "display_errors" => false
    ),
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);
```

In Deiner lokalen Entwicklungsumgebung legst Du noch eine Datei _config/general.local.php_ an, in welcher Du definierst, dass Du Fehlermeldungen sehen möchtest:
```php
<?php
return array(
    "config" => array(
        "display_errors" => true
    )
);
```

Die Einstellung _display\_errors_ ist nun also in beiden Dateien enthalten. Beim initialisieren von Hubert werden nun die Arrays zusammengeführt. Da die Einstellung _display\_errors_ in der Datei, welche auf _.local.php_ endet auf _true_ steht, gilt dieser Wert, denn die lokale Konfiguration hat vor allen anderen Einstellungen Vorrang.

## Cache

Bei der Konfiguration über Ordner können schnell sehr viele Konfigurations-Dateien entstehen. routes.global.php, database.global.php, database.local.php, template.global.php sind nur einige Beispiele. Hubert kann diese in einer Cache-Datei zusammenführen und lädt dann bei jedem weiteren Request die Konfiguration aus diesem Cache. Damit die Konfiguration gecached werden kann, ist es wichtig, dass diese serialisierbar ist. Dies bedeutet, dass zum Beispiel Routen nicht mehr als anonyme Funktion definiert werden, sondern über Referenzen.

Im MVC-Tutorial sieht man eine solche Konfiguration. Wenn du dir unsicher bist, dann cache die Konfiguration lieber nicht. Zum cachen übergibt man als zweiten Parameter in der Initialisierung den Pfad zu einer Cache-Datei. Für diese Datei müssen schreibrechte gesetzt sein.

```php
$app->loadConfig('config/', 'cache/config.php');
```   