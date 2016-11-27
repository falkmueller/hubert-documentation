# Model

Bevor man mit den Models beginnt, muss man die DB-Extension per Composer laden:
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

Anschließend legen wir eine _config/database.global.php_ Datei an:
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
    )
);
```

Weitere Infos zur Konfiguration findest du unter [docs.zendframework.com/zend-db](https://docs.zendframework.com/zend-db/)

## Model definieren

Für unser Beispiel legen wir in der Datei _src/model/user.php_ ein Model "user" an:

```php
<?php

namespace src\model;

class user extends \hubert\extension\db\model {
    
    protected static $table = "user";
     
    public static function fields(){
        return array(
            "id" => array('type' => 'int(11)', 'primary' => true, 'autoincrement' => true),
            "login_name" => array('type' => 'varchar(30)', "default" => ""),
            "password" => array('type' => 'varchar(50)'),
            "comment" => array('type' => 'text', 'null' => true),
        );
    }
    
    public function getRoleIds(){
        $role_ids = array(1);
        $query = "SELECT role_id FROM user_role_mapping WHERE user_id = :user_id";
        $result = hubert()->dbAdapter->query($query, array("user_id" => $this->id));
        foreach ($result as $res){
            $role_ids[] = $res["role_id"];
        }
        return $role_ids;
    }
    
}
```

Models müssen von _\hubert\extension\db\model_ erben. Des Weiteren muss in einer statischen Variable _$table_ die Datenbanktabelle zum Model und in einer statischen Funktion _fields()_ die Felder dieser Tabelle definiert werden.    

Die Funktion _fields()_ muss einen Array zurückgeben, bei dem die namen der Elemente den Namen der Datenbank-Felder entsprechen und als Wert einen Array mit der Configuration des Feldes.   
Möglich optionen sind:
- _'type' => 'int(11)'_: (Pflichtfeld) Dieser Wert wird zum Erstellen der Tabelle benutzt und definiert den MySql Datentyp der Spalte in der Datenbank.
- _primary => true_: Alle Felder, welche den Primärschlüssel der Tabelle bilden müssen dieses Attrebut haben.
- _'autoincrement' => true_:  Wird beim erstellen der Datenbanktabelle genutzt und gibt bei Id feldern an, dass diese automatisch fortlaufend durchnummeriert werden.
- _null => true_: Wird beim erstellen der Datenbanktabelle genutzt und gibt an, ob das Feld NULL als Wert an nimmt.
- _"default" => ""_: Das "default"-Attrebut ist der Standardwert beim neu erstellen eines Modells dieses Types. Dies kann auch ein Leerstring sein.

## Tabellen anlegen

```php
$factory = new \hubert\extension\db\factory();
$factory->createTableByModel(\src\model\user::class);
```
Die Funktion _createTableByModel($modelClass)_ der  Klasse "factory" erstellt eine DatenbankTabelle anhand der Feld-Definition eines Modells.
Sollte die Tabelle schon existieren, werden die Felder abgeglichen und Felder angelegt, welche im Modell definiert sind, aber nicht in der Tabelle existieren.

## Arbeiten mit Models

```php
$user = src\model\user::selectOne(["id" => 1]);
$user->name = "hubert";
$user->update(["name]);
print_r($user->getRoleIds());

$new_user = new src\model\user();
$new_user->name = "hubert2";
$new_user->password = "test";
$new_user->insert();
echo "new Users Id: ".$new_user->id;

$all_users = src\model\user::selectAll();
print_r(json_encode($all_users));
```

Dadurch, dass Models von _\hubert\extension\db\model_ erben, stehen die statischen Funktionen _selectOne($where)_ und _selectAll($where, $limit = 0, $offset = 0, $sort = null)_ zur Verfügung. Im Beispiel wurde noch ein _getRoleIds()_-Funktion definiert, um bestimmte Werte aus einer anderen Tabelle ab zu rufen.
Des weiteren stehen die Funtion _insert()_ zum einfügen und _update($rows = array())_ zum Update eines Models zur verfügung. bei der Update-Funktion kann optional auch ein Array mit Spalten-Namen übergeben werden, wenn man nicht alle Spalten des Models updaten möchte.