<?php


use Phinx\Seed\AbstractSeed;

class RoleSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
        [
            'title' => 'Administrateur',
            'slug' => 'admin',
            'level' => 10
        ],
            [
                'title' => 'Technicien',
                'slug' => 'technician',
                'level' => 8
            ]
        ];
        $this->insert('roles', $data);
    }
}
