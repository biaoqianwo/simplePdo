# simplePdo
A simple Pdo library for micro PHP framework.

##How to use

`composer require biaoqianwo/simplePdo:dev-master`

Add below code in your file (example index.php):
```
use \Bee\PDO\Model;

Model::config(require_once __DIR__ . '/app/config/db.php');
```
The db.php like:
```
return [
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'mysql_test',
    'options' => null,
    'username' => 'root',
    'password' => '',
];

```
If your write and read database is different.You can config like:  
可以读写分离，只是必须读和写的节点必须同时存在，可以相同。配置如下：
```
return [
    'read' => [
        [
            'host' => '127.0.0.1',
            'port' => 3307,
            'dbname' => 'mysql_test',
            'options' => null,
            'username' => 'root',
            'password' => '',
        ],
        [
            'host' => '127.0.0.1',
            'port' => 3308,
            'dbname' => 'mysql_test',
            'options' => null,
            'username' => 'root',
            'password' => '',
        ]
    ],
    'write' => [
        [
            'host' => '127.0.0.1',
            'port' => 3306,
            'dbname' => 'mysql_test',
            'options' => null,
            'username' => 'root',
            'password' => '',
        ]
    ]
];
```
Please note that the write and read are existing meanly.  
If you use write,you must use read.  
The write and read can be same.
