<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOutlayModel extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('outlay')
            ->addColumn('number', 'string', ['null' => true])
            ->addColumn('amount', 'string', ['null' => true])
            ->addColumn('refund', 'date', ['null' => true])
            ->addColumn('payment', 'string', ['null' => true])
            ->addColumn('ref_propal', 'string', ['null' => true])
            ->addColumn('toclosed', 'boolean', ['null' => true])
            ->addColumn('signature', 'boolean')
            ->addColumn('seller', 'string', ['null' => true])
            ->addColumn('products', 'text', [
                'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG,
                'null' => true
            ])
            ->addColumn('status_id', 'integer', ['null' => true])
            ->addForeignKey('status_id', 'status', 'id', [
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
