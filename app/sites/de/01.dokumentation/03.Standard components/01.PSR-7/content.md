# PSR-7

## Installation

Its a standard component. Its always be installed.

## Configuration

No configuration gequired.

## Usage

The component contains the [PSR-7 implementation vrom zend](https://zendframework.github.io/zend-diactoros/).    
It aviable a container "request". Over this Container you have access to alle request variables. 

## Example

You can use this in route-target to get access to the request-Variables and header:
```php
...
    "target" => function($request, $response, $args){
        /*get Post variables*/
        print_r($request->getParsedBody());
        /*get Query Params*/
        print_r($request->getQueryParams());
    }
...
```