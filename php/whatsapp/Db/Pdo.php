<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 23:14
 */

namespace Thomblin\Whatsapp\Db;

class Pdo extends \PDO
{

    /**
     * (PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.1.0)<br/>
     * Creates a PDO instance representing a connection to a database
     * @link http://php.net/manual/en/pdo.construct.php
     * @param $dsn
     * @param $username [optional]
     * @param $passwd [optional]
     * @param $options [optional]
     */
    public function __construct($dsn = "mysql:dbname=whatsapp;host=localhost", $username = "root", $passwd = "123", $options = array())
    {
        parent::__construct($dsn, $username, $passwd, $options);
    }

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return \PDOStatement
     */
    public function execute($sql, $parameters = array())
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($parameters);

        return $stmt;
    }

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return array
     */
    public function fetchAll($sql, $parameters = array())
    {
        $stmt = $this->execute($sql, $parameters);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}