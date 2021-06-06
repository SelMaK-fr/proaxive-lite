<?php

use Phinx\Migration\AbstractMigration;

class CreateAusersTable extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('ausers')
            ->addColumn('pseudo', 'string')
            ->addColumn('mail', 'string', ['null' => true])
            ->addColumn('fullname', 'string', ['null' => true])
            ->addColumn('password', 'string')
            ->addColumn('key_totp', 'string', ['null' => true])
            ->addColumn('lastvisite', 'date')
            ->addColumn('resetpassword', 'string')
            ->addColumn('confirm_at', 'string', ['null' => true])
            ->addColumn('token', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_REGULAR,
                'null' => true
            ])
            ->addColumn('roles_id', 'integer', ['null' => true])
            ->addForeignKey('roles_id', 'roles', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('reset_at', 'datetime', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
