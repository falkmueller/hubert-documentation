# Datenbank

Als Datenbank-Adapter wird [zend-db](https://docs.zendframework.com/zend-db/) verwendet.

## Installation

Zuerst muss die Configuration des Composers erweitert werden
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die konfiguration oder legt eine neue Datei _config/database.global.php_ an:
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
);
```

in der Konfiguration wird die Datenbank-Verbindung angegeben.

## Verwendung

```php
    $result = hubert()->dbAdapter->query('SELECT * FROM `db_test` WHERE `id` = :id', ['id' => 1]);
    print_r($result->current());;
```
Im oberen Beispiel wird eine Zeile aus einer Tabelle abgefragt und die erste Zeile ausgegeben.
Beschreibungen zur Verwendung, kann unter [docs.zendframework.com/zend-db/](https://docs.zendframework.com/zend-db/) nachgelesen werden.

## Models

Die hubert-Erweiterung beinhaltet unter anderen noch ein Struktur für Models.
zum Beispiel kann man eine Datei _model/user.php_ anlegen:
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

alle Modelle haben als Standard die statischen Funktionen _selectOne($where)_ und _selectAll($where)_:
```php
    print_r(json_encode(\model\user::selectOne(["id" => 1])));
    print_r(json_encode(\model\user::selectAll()));
```

Im Beispiel wurden weitere Funktionen definiert.
```php
    $user = \model\user::selectOne(["id" => 1]);
    $user->name = "hubert";
    $user->update(["name]);

    print_r($user->getRoleIds());
```
Im Beispiel sieht man, wie man Werte bei einem User in der Datenbank ändern kann oder sich einen Array mit seinen Rollen-Ids holen kann.
