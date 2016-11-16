# Model

Befor man mit den Models beginnt muss man die DB-Extension per composer laden:
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

Anschließend legen wir eine "config/database.global.php" Datei an:
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
Infos zur Konfiguration und findest du unter [docs.zendframework.com/zend-db](https://docs.zendframework.com/zend-db/)

## model definieren

Für unser beispiel legen wir ein Model "user" an in der Datei "src/model/user.php"
```php
<?php

namespace src\model;

class user extends \hubert\extension\db\model {
    
    protected static $table = "user";
     
     public static function fields(){
        return array(
            "id" => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
            "login_name" => array('type' => 'string', "default" => ""),
            "password" => array('type' => 'string'),
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

Modles müssen von "\hubert\extension\db\model" erben.
Des weiteren muss in einer statischen Variable $table die Datenbanktabelle zu dem Model definiert werden
und in einer statischen funktion "fields" die Felder dieser Tabelle.
Die dabei im Array angegebenen Typen sind nur Informativ und werdne derzeit nicht genutzt.

## Arbeiten mit models

```php
    $user = src\model\user::selectOne(["id" => 1]);
    $user->name = "hubert";
    $user->update(["name]);

    print_r($user->getRoleIds());
```

Dadurch, dass models von '\hubert\extension\db\model' erben, stehen die statischen funtionen "selectOne($selectors)" und "selectAll($selectors)" zur verfügung.
Im Beispiel haben wir noch ein Update-Funktion definiert um bestimmte Attrebute in der Datenbank updaten zu können.