<?php

use Phinx\Migration\AbstractMigration;

class CreateClientsTable extends AbstractMigration
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
        $this->table('clients')
            ->addColumn('lastname', 'string', ['null' => true])
            ->addColumn('firstname', 'string', ['null' => true])
            ->addColumn('civility', 'string', ['null' => true])
            ->addColumn('mail', 'string', ['null' => true])
            ->addColumn('validated', 'integer')
            ->addColumn('activated', 'integer')
            ->addColumn('sleeping', 'integer')
            ->addColumn('fullname', 'string', ['null' => true])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('mobile', 'string', ['null' => true])
            ->addColumn('phone_indicatif', 'string', ['null' => true])
            ->addColumn('adress', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_MEDIUM,
                'null' => true
            ])
            ->addColumn('zipcode', 'string', ['null' => true])
            ->addColumn('city', 'string', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
