<?php

use Phinx\Migration\AbstractMigration;

class CreateInterventionsTable extends AbstractMigration
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
        $this->table('interventions')
            ->addColumn('title', 'string')
            ->addColumn('received', 'date', ['null' => true])
            ->addColumn('number', 'string')
            ->addColumn('ref_number', 'string', ['null' => true])
            ->addColumn('price', 'string', ['null' => true])
            ->addColumn('pmad', 'integer')
            ->addColumn('number_link', 'string', ['null' => true])
            ->addColumn('rapport_bao', 'string', ['null' => true])
            ->addColumn('closed', 'boolean', ['null' => true])
            ->addColumn('steps', 'boolean', ['null' => true])
            ->addColumn('back_home', 'datetime', ['null' => true])
            ->addColumn('cancel_inter', 'datetime', ['null' => true])
            ->addColumn('start', 'datetime', ['null' => true])
            ->addColumn('close_date', 'datetime', ['null' => true])
            ->addColumn('description', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('report', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('observation', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('details', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('note_tech', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('status_id', 'integer', ['null' => true])
            ->addForeignKey('status_id', 'status', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('equipment_id', 'integer', ['null' => true])
            ->addForeignKey('equipment_id', 'equipments', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('client_id', 'integer', ['null' => true])
            ->addForeignKey('client_id', 'clients', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('auser_id', 'integer', ['null' => true])
            ->addForeignKey('auser_id', 'ausers', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
