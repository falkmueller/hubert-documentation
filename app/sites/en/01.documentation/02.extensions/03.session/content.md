# Session

Hubert uses [zend-session](https://docs.zendframework.com/zend-session/) as session container.

## Installation

At first you have to extend the configuration of composer:
```json
{
    "require": {
        "falkm/hubert-session": "1.*"
    }
}
```

## Configuration

Afterwards you have to extend the configuration of Hubert or create a new _config/session.global.php_ file. In the following example we define for instance how long the sessin is valid in seconds and if the session must be validated for security reasons.
```php
<?php
return array(
    "factories" => array(
        "session" => array(hubert\extension\session\factory::class, 'get')
    ),
    "config" => array(
        "session" => array(
            'remember_me_seconds'   => 1800,
            'validate_user_agend'   => false,
            'validate_remote_addr'  => false
        ),
    ),
);
```


## Usage

```php
 hubert()->session()->name = "name without namespace";
 hubert()->session('user')->name = "hubert (name at namespace 'user')";
 echo hubert()->session('user')->name;
```

You can see in the example that on a session call you can define a namespace for the variables. After that you can assign call values.

