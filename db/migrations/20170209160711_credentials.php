<?php

use Phinx\Migration\AbstractMigration;

class Credentials extends AbstractMigration
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
        $credentials = $this->table('credentials');
        $credentials->addColumn('username', 'string', array('limit' => 50))
            ->addColumn('password', 'string', array('limit' => 256))
            ->addColumn('login_url', 'string', array('limit' => 2083))
            ->create();
    }
}
