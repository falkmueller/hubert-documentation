# Datenbank

Als Datenbank-Adapter wird [zend-db](https://docs.zendframework.com/zend-db/) verwendet.

## Installation

Zuerst muss die Configuration von Composer erweitert werden:
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration von Hubert oder legt eine neue Datei _config/database.global.php_ an. In der Konfiguration wird die Datenbank-Verbindung angegeben.

```php
<?php
return array(
    "factories" => array(
         "dbAdapter" => array(hubert\extension\db\factory::class, 'get')
    ),
    "config" => array(
        "db" => array(
            'driver'   => 'Pdo_Mysql',
            'database' => 'db_test',
            'username' => 'user',
            'password' => 'pass',
        ),
    ),
);
```

## Verwendung

```php
$result = hubert()->dbAdapter->query('SELECT * FROM `db_test` WHERE `id` = :id', ['id' => 1]);
print_r($result->current());
```
Im oberen Beispiel werden Daten aus einer Tabelle abgefragt und die erste Zeile ausgegeben. Beschreibungen zur Verwendung können auch unter [docs.zendframework.com/zend-db/](https://docs.zendframework.com/zend-db/) nachgelesen werden.

## Models

Die Hubert Erweiterung beinhaltet unter Anderem noch eins Struktur für Models. Zum Beispiel kann man eine Datei _model/user.php_ anlegen:
```php
<?php

namespace model;

class user extends \hubert\extension\db\model {
    
    protected static $table = "user";
     
    public static function fields(){
        return array(
            "id" => array('type' => 'int(11)', 'primary' => true, 'autoincrement' => true),
            "name" => array('type' => 'varchar(30)', "default" => ""),
            "password" => array('type' => 'varchar(50)', "default" => "")
        );
    }

    public function getRoleIds(){
        $query = "SELECT role_id FROM user_role_mapping WHERE user_id = :user_id";
        $result = hubert()->dbAdapter->query($query, array("user_id" => $this->id));
        $role_ids = array();
        foreach ($result as $res){
            $role_ids[] = $res["role_id"];
        }
        return $role_ids;
    }

}
```

Informationen zur Verwendung von Models findest du [hier](/de/dokumentation/mvc-tutorial/model) 