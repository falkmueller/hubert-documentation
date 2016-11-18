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

Die Hubert Erweiterung beinhaltet unter Anderem noch ein Struktur für Models. Zum Beispiel kann man eine Datei _model/user.php_ anlegen:
```php
<?php

namespace model;

class user extends \hubert\extension\db\model {
    
    protected static $table = "user";
     
    public static function fields(){
        return array(
            "id" => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
            "name" => array('type' => 'string', "default" => ""),
            "password" => array('type' => 'string', "default" => "")
        );
    }

    public function update($rows = array()){
        $update = array();
        foreach ($rows as $row){
            $update[$row] = $this->$row;
        }
        return static::tableGateway()->update($update, ["id" => $this->id]);
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

Alle Modelle haben als Standard die statischen Funktionen _selectOne($where)_ und _selectAll($where)_:
```php
print_r(json_encode(\model\user::selectOne(["id" => 1])));
print_r(json_encode(\model\user::selectAll()));
```

Im nächsten Beispiel sieht man, wie man Werte bei eines Users in der Datenbank ändern kann oder sich einen Array mit seinen Rollen-Ids holen kann.
```php
$user = \model\user::selectOne(["id" => 1]);
$user->name = "hubert";
$user->update(["name]);
print_r($user->getRoleIds());
```

