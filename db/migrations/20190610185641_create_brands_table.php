<?php

use Phinx\Migration\AbstractMigration;

class CreateBrandsTable extends AbstractMigration
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
        $this->table('brands')
            ->addColumn('b_title', 'string')
            ->addColumn('b_slug', 'string', ['null' => true])
            ->addColumn('b_about', 'text', ['null' => true])
            ->addColumn('b_logo', 'text', ['null' => true])
            ->create();

        $this->table('equipments')
            ->addColumn('brand_id', 'integer', ['null' => true])
            ->addForeignKey('brand_id', 'brands', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->update();
    }
}
