# Konfiguration

Hubtert wird komplett über einen Array Konfiguriert. 

## Konfigurations-Komponenten

es gibt vier Bereiche, welche Konfiguriert werden können.

### Namespaces

In diesem Bereich definiert man Namespaces mit dem dazugehörigen Order für den Autoloader.

```php
...
 "namespace" => array(
         "app" => "app/"
    ),
...
```

In diesem Beispiel wird der Namespace "app" für einen gleichnamigen Ordner definiert.    
Zum Beispiel könnte in der Datei _app/bootstrap.php_ eine PHP-Klasse liegen mit dem namen "bootstrap" und dem Namespace "app".    
Wenn man nun im Code, zum Beispiel den Routen die Klasse verwendet (_$bootstrap = new \app\bootstrap()_) wird diese Datei automatisch per include geladen.
Dies wird später im Bereich "MVC" dieser Dokumentation.

### Factories

Factories sind statische Funktionen, welche einen Servide initialisieren.
```php
...
 "factories" => array(
         "router" => array(\hubert\service\router::class, 'factory'),
    ),
...
```
Dies ist ein Beispiel aus der Standardkonfiguration von Hubert (und muss desshalb nicht in der eigenen Konfiguration angegeben werden).
Hier wird in der Klasse "router", welche im Namespace "hubert\service" liegt die statische Funktion "factory" als Initiator für den Router gefiniert.
Diese Funktion gibt also den Router als Objekt zurück.
Der definierte Service ist dann über _hubert()->router_ global verfügbar und wird erst bei seiner erstmaligen verwendung initialisiert.
im Bereich "Erweiterungen" dieser Dokumentation wird beschrieben, wie man eigene services definiert.

### Einstellungen

Einstellungen wind zum Beispiel Stings oder Bool-Werte, welche in Services zu dessen Konfiguration genutz werden.

```php
...
 "config" => array(
         "logger" => array(
            "path" => "logs/"
        )
    ),
...
```
Die hier im Beispiel definierte Einstellung wäre global über "hubert()->config->logger['path']" verfügbar.

### Routen

In diesem Konfigurationsbereich werden die Routen definiert. Merh zu Routen findest du im Bereich "Routing" dieser Dokumentation.
```php
...
 "routes" => array(
        "home" => array(
             "route" => "/", 
             "method" => "GET|POST", 
             "target" => function(){
                            echo "Hello World";
                        }
         ),
    ),
...
```


## laden der Konfiguration

die Konfiguration muss immer beim erstmaligen Aufruf der hubert-Funktion übergeben werden.

### Konfiguration in einem Array

Im "Hello Wolrd"-Beispiel wurde die Konfiguration als Array definiert.
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
Dies ist für sehr kleine Anwendungen gedacht.

### Konfiguration in Datei
Diesen Array kann man auch in eine seperate Datei auslagern.
Zum Beispiel eine _config.php_-Datei
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

Bei der initialisierung kann man nun diese Datei statt einem Array übergeben
```php
hubert("config.php");
```


### Konfiguration über einen Ordner

Dies ist der beste Weg zur Konfiguration von hubert.    
Dabei wird ein Ordner _/config_ angelegt und die Konfigurationen werden nach Theme sortiert in verschiedenen Datein abgelegt.

geladen Werden die Konfigurationen in dem man hubtert beim initialisieren den Pfad zu diesem Ordner gibt:
```php
$app->loadConfig('config/');
```    

Dabei gibt es drei verschiedenen Endungen für die Konfigurations-Datein in diesen Ordner.
Wenn verschiedene Datein die gleiche konfiguration beinhalten, entscheidet die Endung, welche Konfiguration gilt.
- _.default.php_: in dieser werden Standard-Konfigurationen eingestellt.
- _.global.php_: in dieser werden Konfigurationen eingestellt, welche für deine Anwendung gelten, wir Routen zum Beispiel.
- _.local.php_: in Konfigurationsdatein mit dieser Endung definiert man zum Beispiel die Datenbank-Verbindung, da diese nur lokal gilt und andere Entwickler an der Anwedung zum beispiel andere Einstellungen verwenden.

Hier ein kleines Bespiel zur verdeutlichung:
Wir haben eine Datei _config/general.global.php_ in welcher wir eine Route definieren und eine Einstellung, dass Fehler nicht angezeigt werden sollen:
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

in deiner lokalen Entwicklungsumgebung legst du noch eine Datei _config/general.local.php_ an, in welcher du definierst, dass du Fehlermeldungen sehen möchtest:
```php
<?php
return array(
    "config" => array(
        "display_errors" => true
    )
);
```

die Einstellung "display_errors" ist nun also in beiden Dateien enthalten. 
Beim initialisieren von hubert werden nun die Arrays zusammengeführt.
Da die Einstellung "display_errors" in der Datei, welche auf ".local.php" endet auf "true" steht, gilt dieser Wert.

## Cache

Bei der Konfiguration über Order können es schnell sehr viele Konfigurations-Dateien werden.    
routes.global.php, database.global.php, database.local.php, template.global.php, ...    
Hubtert kann diese in einer cache-Datei zusammenführen und lädt dann bei jedem weiteren Request die Konfiguration aus diesem Cache.
Damit die Konfiguration gecached werden kann ist es wichtig, dass diese serialisierbar ist.
Dies bedeutet, dass zum Beispiel routen nicht mehr als anonyme funktion definiert werden, sondern über Referenzen.
im MVC-Bespiel soht man eine solche Konfiguration.
Wenn du dues unsicher bist, dann cache die Konfiguration lieber nicht.
Zum cachen übergibt man als zweiten Parameter in der initialisierung den Pfad zu einer Cache-Datei.
Für diese Datei müssen schreibrechte gesetzt sein.

```php
$app->loadConfig('config/', 'cache/config.php');
```   