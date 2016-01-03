<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateCredentials extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('credentials')
            ->addColumn('protocol', 'integer', array('limit' => MysqlAdapter::INT_TINY))
            ->addColumn('username', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('nickname', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('password', 'string', array('limit' => 50, 'null' => true))
            ->addIndex(array('username'), array('unique' => true))
            ->create();
    }
}
