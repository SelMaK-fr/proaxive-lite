<?php

use Phinx\Migration\AbstractMigration;

class CreateEquipmentsTable extends AbstractMigration
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
        $this->table('equipments')
            ->addColumn('name', 'string')
            ->addColumn('content', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('serialnumber', 'string', ['null' => true])
            ->addColumn('numberproduct', 'string', ['null' => true])
            ->addColumn('licence_os', 'string', ['null' => true])
            ->addColumn('year', 'string', ['null' => true])
            ->addColumn('inworkshop', 'boolean')
            ->addColumn('status', 'boolean')
            ->addColumn('category_equipment_id', 'integer', ['null' => true])
            ->addForeignKey('category_equipment_id', 'category_equipments', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('client_id', 'integer', ['null' => true])
            ->addForeignKey('client_id', 'clients', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
