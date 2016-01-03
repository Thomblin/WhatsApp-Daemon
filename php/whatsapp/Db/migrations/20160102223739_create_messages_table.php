<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateMessagesTable extends AbstractMigration
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
        $this->table('messages')
            ->addColumn('protocol', 'integer', array('limit' => MysqlAdapter::INT_TINY))
            ->addColumn('msg_id', 'string', array('limit' => 25, 'null' => true))
            ->addColumn('from', 'string', array('limit' => 50))
            ->addColumn('nickname', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('to', 'string', array('limit' => 50))
            ->addColumn('time', 'timestamp', array('update' => false, 'default' => null, 'null' => true))
            ->addColumn('type', 'string', array('limit' => 10))
            ->addColumn('body', 'string')
            ->addColumn('new', 'boolean', array('default' => 1))
            ->addIndex(array('new', 'from', 'protocol'), array('unique' => false))
            ->addIndex(array('new', 'to', 'protocol'), array('unique' => false))
            ->addIndex(array('msg_id'), array('unique' => true))
            ->create();
    }
}
