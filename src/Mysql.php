<?php
namespace Bee\PDO;

/**
 * simple Pdo for CRUD
 * Class Mysql
 * @package Bee\PDO
 */
class Mysql
{
    private static $_write = null;
    private static $_read = null;

    private static function pdo($config)
    {
        $dbname = $config['dbname'];
        $host = !empty($config['host']) ? $config['host'] : '127.0.0.1';
        $port = !empty($config['port']) ? $config['port'] : '3306';
        $options = !empty($config['options']) ? $config['options'] : null;
        return new \PDO(
            "mysql:dbname={$dbname};host={$host};port={$port}",
            $config['username'],
            $config['password'],
            $options
        );
    }

    /**
     * 读写分离，只支持每台数据服务器为全量数据
     * @param $config
     */
    public static function getInstance($config)
    {
        $write = !empty($config['write']) ? $config['write'] : [];
        $read = !empty($config['read']) ? $config['read'] : [];

        self::$_write = self::pdo($config);
        self::$_read = self::pdo($config);

        if (empty($write) || empty($read)) {
            if (!self::$_write) {
                self::$_write = self::pdo($config);
            }
            if (!self::$_read) {
                self::$_read = self::pdo($config);
            }
        } else {
            $config = $write[mt_rand(0, count($write) - 1)];
            if (!self::$_write) {
                self::$_write = self::pdo($config);
            }

            $config = $read[mt_rand(0, count($read) - 1)];
            if (!self::$_read) {
                self::$_read = self::pdo($config);
            }
        }
    }

    /**
     * @param $statement = "insert users(`name`,`pwd`) values(?,?)"
     * @param array|null $input_parameters = [$name, $pwd]
     * @return mixed
     */
    public static function insert($statement, array $input_parameters = null)
    {
        $stmt = self::$_write->prepare($statement);
        $stmt->execute($input_parameters);
        return self::$_write->lastInsertId();
    }

    /**
     * @param $statement = "update users set `pwd` = ? where id = ?"
     * @param array|null $input_parameters = [$pwd, $id]
     * @return mixed
     */
    public static function update($statement, array $input_parameters = null)
    {
        $stmt = self::$_write->prepare($statement);
        $stmt->execute($input_parameters);
        return $stmt->rowCount();
    }

    /**
     * @param $statement = 'SELECT * FROM tbl WHERE id = ?'
     * @param $input_parameters = [$id]
     * @param array $driver_options
     * @return mixed
     */
    public static function first($statement, $input_parameters, array $driver_options = [])
    {
        $stmt = self::$_read->prepare($statement, $driver_options);
        $stmt->execute($input_parameters);
        return $stmt->fetch();
    }

    /**
     * @param $statement = "SELECT * FROM tbl WHERE condition1 < ? AND condition2 = ?"
     * @param $input_parameters = [$condition1, $condition2]
     * @param array $driver_options
     * @return array
     */
    public static function get($statement, $input_parameters, array $driver_options = [])
    {
        $stmt = self::$_read->prepare($statement, $driver_options);
        $stmt->execute($input_parameters);
        return $stmt->fetchAll();
    }

    /**
     * @param $statement = "delete from users where id = ?"
     * @param array|null $input_parameters = [$id]
     * @return mixed
     */
    public static function delete($statement, array $input_parameters = null)
    {
        $stmt = self::$_write->prepare($statement);
        $stmt->execute($input_parameters);
        return $stmt->rowCount();
    }
}
