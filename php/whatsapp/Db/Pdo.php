<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 23:14
 */

namespace Thomblin\Whatsapp\Db;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

class Pdo extends \PDO
{
    /**
     * @param string $environment
     * @return Pdo
     */
    public static function createInstance($environment = 'production')
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/../../phinx.yml'));

        if (!isset($config['environments'][$environment])) {
            throw new InvalidArgumentException("unkown environment '$environment'");
        }

        $login = $config['environments'][$environment];

        return new PDO(
            "{$login['adapter']}:dbname={$login['name']};host={$login['host']}",
            $login['user'],
            $login['pass']
        );
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