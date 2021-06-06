<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        $password = password_hash('admin', PASSWORD_BCRYPT);
        $data = [
            'pseudo' => 'admin',
            'mail' => 'mymail@domain.tld',
            'fullname' => 'John Doe',
            'password' => $password,
            'lastvisite' => date('Y-m-d'),
            'resetpassword' => '',
            'reset_at' => null,
            'confirm_at' => '115447365781',
            'token' => 'f0yoGQyEWRbqPNjpPIFTkjYDB8Ohat4f',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'roles_id' => 1
        ];
        $this->insert('ausers', $data);
    }
}
