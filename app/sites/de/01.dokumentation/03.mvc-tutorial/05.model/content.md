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

Models müssen von _\hubert\extension\db\model_ erben. Des Weiteren muss in einer statischen Variable _$table_ die Datenbanktabelle zum Model und in einer statischen Funktion _fields()_ die Felder dieser Tabelle definiert werden. Die dabei im Array angegebenen Typen sind nur Informativ und werden derzeit nicht genutzt.

## Arbeiten mit Models

```php
$user = src\model\user::selectOne(["id" => 1]);
$user->name = "hubert";
$user->update(["name]);
print_r($user->getRoleIds());
```

Dadurch, dass Models von _\hubert\extension\db\model_ erben, stehen die statischen Funktionen _selectOne($where)_ und _selectAll($where)_ zur Verfügung. Im Beispiel wurde noch ein Update-Funktion definiert, um bestimmte Attribute in der Datenbank updaten zu können.