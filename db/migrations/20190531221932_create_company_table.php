<?php

use Phinx\Migration\AbstractMigration;

class CreateCompanyTable extends AbstractMigration
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
        $this->table('company')
            ->addColumn('cname', 'string', ['null' => true])
            ->addColumn('about', 'text', ['null' => true])
            ->addColumn('type', 'string', ['null' => true])
            ->addColumn('adress', 'string', ['null' => true])
            ->addColumn('city', 'string', ['null' => true])
            ->addColumn('country', 'string', ['null' => true])
            ->addColumn('zipcode', 'string', ['null' => true])
            ->addColumn('department_id', 'integer', ['null' => true])
            ->addForeignKey('department_id', 'departments', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION'
            ])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('mobile', 'string', ['null' => true])
            ->addColumn('fax', 'string', ['null' => true])
            ->addColumn('phone_indicatif', 'string', ['null' => true])
            ->addColumn('director', 'string', ['null' => true])
            ->addColumn('website', 'string', ['null' => true])
            ->addColumn('mail', 'string', ['null' => true])
            ->addColumn('siret', 'string', ['null' => true])
            ->addColumn('ape', 'string', ['null' => true])
            ->addColumn('aprm', 'string', ['null' => true])
            ->addColumn('rm', 'string', ['null' => true])
            ->addColumn('rcs', 'string', ['null' => true])
            ->addColumn('rc_pro', 'string', ['null' => true])
            ->addColumn('tva', 'string', ['null' => true])
            ->addColumn('facebook', 'string', ['null' => true])
            ->addColumn('twitter', 'string', ['null' => true])
            ->addColumn('instagram', 'string', ['null' => true])
            ->addColumn('linkedin', 'string', ['null' => true])
            ->addColumn('logo', 'string', ['null' => true])
            ->addColumn('isdefault', 'integer', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
