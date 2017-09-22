<?php
namespace App;

class UserController
{
    public function index()
    {
        $offset = !empty($_GET['start']) ? (int)$_GET['start'] : 0;
        $rows = !empty($_GET['len']) ? (int)$_GET['len'] : 10;
        $created_at = time() - 86400;//24 hours before
        //测试发现：limit后面的数字不能使用预处理的'?'
        $sql = 'select * from users where created_at > ? order by id desc limit ' . $offset . ',' . $rows;
        $conditions = [$created_at];
        $result = User::get($sql, $conditions);
        var_dump($result);
    }

    public function store()
    {
        $name = !empty($_POST['name']) ? $_POST['name'] : 0;
        $pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : '123456';
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "insert users(`name`,`pwd`) values(?,?)";
        $conditions = [$name, $pwd];
        $result = User::insert($sql, $conditions);
        var_dump($result);
    }

    public function show($id)
    {
        $sql = "select * from users where id = ?";
        $conditions = [$id];
        $result = User::first($sql, $conditions);
        var_dump($result);
    }

    public function update()
    {
        $_PUT = array();
        if ('put' == strtolower($_SERVER['REQUEST_METHOD'])) {
            parse_str(file_get_contents('php://input'), $_PUT);
        }
        $id = !empty($_PUT['id']) ? $_PUT['id'] : 0;
        $pwd = !empty($_PUT['pwd']) ? $_PUT['pwd'] : '123456';
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "update users set `pwd` = ? where id = ?";
        $conditions = [$pwd, $id];
        $result = User::update($sql, $conditions);
        var_dump($result);
    }

    public function destroy($id)
    {
        $sql = "delete from users where id = ?";
        $conditions = [$id];
        $result = User::delete($sql, $conditions);
        var_dump($result);
    }
}
