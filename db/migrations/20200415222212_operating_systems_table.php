<?php

use Phinx\Migration\AbstractMigration;

class OperatingSystemsTable extends AbstractMigration
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
        $this->table('operating_systems')
            ->addColumn('os_name', 'string')
            ->addColumn('os_release', 'string', ['null' => true])
            ->addColumn('os_architecture', 'string', ['null' => true])
            ->addColumn('os_about', 'text', ['null' => true])
            ->addColumn('os_full', 'string', ['null' => true])
            ->create();

        $this->table('equipments')
            ->addColumn('operating_systems_id', 'integer', ['null' => true])
            ->addForeignKey('operating_systems_id', 'operating_systems', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->update();
    }
}
