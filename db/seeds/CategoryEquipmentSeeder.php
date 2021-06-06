<?php


use Phinx\Seed\AbstractSeed;

class CategoryEquipmentSeeder extends AbstractSeed
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
                'title' => 'PC Portable',
                'slug' => 'laptop',
                'icon' => 'laptop',
                'color' => 'dbdbdb'
            ],
            [
                'title' => 'PC de bureau',
                'slug' => 'desktop',
                'icon' => 'computer',
                'color' => 'dbdbdb'
            ],
            [
                'title' => 'Imprimante',
                'slug' => 'printer',
                'icon' => 'print',
                'color' => 'dbdbdb'
            ],
            [
                'title' => 'Tablette/PC Tablette',
                'slug' => 'tablet',
                'icon' => 'ipad',
                'color' => 'dbdbdb'
            ],
            [
                'title' => 'Smartphone',
                'slug' => 'smartphone',
                'icon' => 'smart-phone',
                'color' => 'dbdbdb'
            ],
            [
                'title' => 'Serveur',
                'slug' => 'server',
                'icon' => 'server',
                'color' => 'dbdbdb'
            ]
        ];
        $this->insert('category_equipments', $data);
    }
}
