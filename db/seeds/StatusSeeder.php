<?php


use Phinx\Seed\AbstractSeed;

class StatusSeeder extends AbstractSeed
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
                'title' => 'En traitement',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'En attente',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'Livraison en cours',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'En attente d\'expédition',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'Transféré(e)',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'Assemblage',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'Annulé(e)',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'Terminé(e)',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ],
            [
                'title' => 'En attente de retour',
                'not_delete' => true,
                'bgcolor' => 'dbdbdb'
            ]
        ];
        $this->insert('status', $data);
    }
}
