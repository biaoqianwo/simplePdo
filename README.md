# simplePdo
A simple Pdo library for micro PHP framework.  
It can be done for CRUD. It support write and read are separation.

##How to use

### import the package
`composer require biaoqianwo/simplePdo:dev-master`

###Add below code in your bootstrap file (e.g. index.php):
```
use \Bee\PDO\Model;

Model::config(require_once __DIR__ . '/app/config/db.php');
```

The config file db.php like:
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
Please note that the write and read are existing meanly.  If you use write,you must use read.  The write and read can be same.  
可以读写分离，只是必须读和写的节点必须同时存在，可以相同。


##Add a model file (e.g. Users.php)   
The model should and only inherit Bee\PDO\Model.
You do not need to code anything more. So it is simple.
```
namespace App;
use Bee\PDO\Model;
/**
 * Class User
 * @package App
 */
class User extends Model
{
}
```
And then your controller can use the user model.
You can see the demo/UserController.php. e.g.  
```
$sql = "select * from users where id = ?";
$conditions = [$id];
$result = User::first($sql, $conditions);
var_dump($result);
```
