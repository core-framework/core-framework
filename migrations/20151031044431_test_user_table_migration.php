<?php

use Phinx\Migration\AbstractMigration;

class TestUserTableMigration extends AbstractMigration
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
        $table = $this->table('user');
        $table->addColumn('fname', 'string')
            ->addColumn('lname', 'string')
            ->addColumn('name', 'string')
            ->addColumn('userId', 'string')
            ->addColumn('email', 'string')
            ->addColumn('email_hash', 'binary', array('null' => true))
            ->addColumn('pass_hash', 'binary', array('limit' => 60))
            ->addColumn('salt', 'string')
            ->addColumn('created_at', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('modified_at', 'datetime', array('default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'))
            ->addIndex(array('email', 'userId'), array('unique' => true))
            ->save();
    }
}
