# Database

Hubert uses [zend-db](https://docs.zendframework.com/zend-db/) as database adapter.

## Installation

At first you have to extend the configuration of composer:
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

## Configuration

Afterwards you have to extend the configuration of Hubert or create a new _config/database.global.php_ file. In this configuration you have to define the database connection.

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
This example shows how to request some data from a database and return the frst row. More descriptions on database usage can be found at [docs.zendframework.com/zend-db/](https://docs.zendframework.com/zend-db/).

## Models

The Hubert extension also contains a structure for models. For instance you can create a _model/user.php_ file:
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

All models contain the static functions _selectOne($where)_ and _selectAll($where)_ by default:
```php
print_r(json_encode(\model\user::selectOne(["id" => 1])));
print_r(json_encode(\model\user::selectAll()));
```

The next example shows how to change values of a user in a databse or how to get an array with its role id's:
```php
$user = \model\user::selectOne(["id" => 1]);
$user->name = "hubert";
$user->update(["name]);
print_r($user->getRoleIds());
```

