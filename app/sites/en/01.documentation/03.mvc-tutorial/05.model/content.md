# Model

Before getting started with models you have to load the db extension using composer:
```json
{
    "require": {
        "falkm/hubert-db": "1.*"
    }
}
```

Afterward you create a _config/database.global.php_ file:
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

More instructions on configuring can be found at [docs.zendframework.com/zend-db](https://docs.zendframework.com/zend-db/)

## Defining models

In the following example you create a model "user" at _src/model/user.php_:

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

Models must inherit from _\hubert\extension\db\model_. Furthermore you have to define the database table for the model in a static variable _$table_ and the fields of that tabel in a static function _fields()_. The types defined in this array are just informative and are not supported right now.

## Working with models

```php
$user = src\model\user::selectOne(["id" => 1]);
$user->name = "hubert";
$user->update(["name]);
print_r($user->getRoleIds());
```

Because of the models inheriting from _\hubert\extension\db\model_ the functions _selectOne($where)_ und _selectAll($where)_ are available. In the example there is also an update function for updating some attributes in the database.
