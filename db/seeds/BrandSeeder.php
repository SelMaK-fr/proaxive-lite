<?php


use Phinx\Seed\AbstractSeed;

class BrandSeeder extends AbstractSeed
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
                'b_title' => 'Acer',
                'b_slug' => 'acer',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Asus',
                'b_slug' => 'asus',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Compaq',
                'b_slug' => 'compaq',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Brother',
                'b_slug' => 'brother',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Epson',
                'b_slug' => 'epson',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'HP',
                'b_slug' => 'hp',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Dell',
                'b_slug' => 'dell',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Sony',
                'b_slug' => 'sony',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Packard Bell',
                'b_slug' => 'packard_bell',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Canon',
                'b_slug' => 'canon',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Samsung',
                'b_slug' => 'samsung',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Xiaomi',
                'b_slug' => 'xiaomi',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'LG',
                'b_slug' => 'lg',
                'b_about' => null,
                'b_logo' => null
            ],
            [
                'b_title' => 'Apple',
                'b_slug' => 'apple',
                'b_about' => null,
                'b_logo' => null
            ]
        ];
        $this->insert('brands', $data);
    }
}
