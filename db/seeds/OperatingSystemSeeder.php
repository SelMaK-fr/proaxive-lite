<?php


use Phinx\Seed\AbstractSeed;

class OperatingSystemSeeder extends AbstractSeed
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
                'os_name' => 'Windows 10 Home',
                'os_release' => '1909',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 10 Home - 1909 - x64'
            ],
            [
                'os_name' => 'Windows 10 Pro',
                'os_release' => '1909',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 10 Pro - 1909 - x64'
            ],
            [
                'os_name' => 'Windows 10 Home',
                'os_release' => '2004',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 10 Home - 2004 - x64'
            ],
            [
                'os_name' => 'Windows 10 Pro',
                'os_release' => '2004',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 10 Pro - 2004 - x64'
            ],
            [
                'os_name' => 'Windows 8.1',
                'os_release' => '8.1',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 8.1 - 8.1 - x64'
            ],
            [
                'os_name' => 'Windows 7 Pro',
                'os_release' => 'SP1',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 7 Pro - SP1 - x64'
            ],
            [
                'os_name' => 'Windows 7 Édition Familiale Basique',
                'os_release' => 'SP1',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 7 Édition Familiale Basique - SP1 - x64'
            ],
            [
                'os_name' => 'Windows 7 Édition Starter',
                'os_release' => 'SP1',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 7 Édition Starter - SP1 - x64'
            ],
            [
                'os_name' => 'Windows 7 Édition Intégrale',
                'os_release' => 'SP1',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows 7 Édition Intégrale - SP1 - x64'
            ],
            [
                'os_name' => 'Windows XP Professionnel',
                'os_release' => 'SP3',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows XP Professionnel - SP3 - x64'
            ],
            [
                'os_name' => 'Windows XP Professionnel',
                'os_release' => 'SP3',
                'os_architecture' => 'x86',
                'os_about' => 'N/C',
                'os_full' => 'Windows XP Professionnel - SP3 - x86'
            ],
            [
                'os_name' => 'Windows XP Familiale',
                'os_release' => 'SP3',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Windows XP Familiale - SP3 - x64'
            ],
            [
                'os_name' => 'Windows XP Familiale',
                'os_release' => 'SP3',
                'os_architecture' => 'x86',
                'os_about' => 'N/C',
                'os_full' => 'Windows XP Familiale - SP3 - x86'
            ],
            [
                'os_name' => 'Linux Mint',
                'os_release' => '20 (Ulyana)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Linux Mint - 20 (Ulyana) - x64'
            ],
            [
                'os_name' => 'Elementary OS',
                'os_release' => '5.1.6 (Hera)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Elementary OS - 5.1.6 (Hera) - x64'
            ],
            [
                'os_name' => 'Ubuntu',
                'os_release' => '20.04 (Focal)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Ubuntu - 20.04 (Focal) - x64'
            ],
            [
                'os_name' => 'Xubuntu',
                'os_release' => '20.04 (Focal Fossa)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Xubuntu - 20.04 (Focal Fossa) - x64'
            ],
            [
                'os_name' => 'Xubuntu Eoan',
                'os_release' => '19.10 (Eoan Ermine)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Xubuntu - 19.10 (Eoan Ermine) - x64'
            ],
            [
                'os_name' => 'Pop!_OS',
                'os_release' => '20.04',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Pop!_OS - 20.04 - x64'
            ],
            [
                'os_name' => 'Manjaro',
                'os_release' => '20.0 (Lysia)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Manjaro - 20.0 (Lysia) - x64'
            ],
            [
                'os_name' => 'Arch Linux',
                'os_release' => '2020.08.01',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Arch Linux - 2020.08.01 - x64'
            ],
            [
                'os_name' => 'Debian',
                'os_release' => '10.5 (Buster)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Debian - 10.5 (Buster) - x64'
            ],
            [
                'os_name' => 'Fedora',
                'os_release' => '33',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Fedora - 33 - x64'
            ],
            [
                'os_name' => 'macOS',
                'os_release' => '10.15.6',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'macOS - 10.15.6 - x64'
            ],
            [
                'os_name' => 'Android',
                'os_release' => '5.0.x (Lollipop)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Android - 5.0.x (Lollipop) - x64'
            ],
            [
                'os_name' => 'Android 9',
                'os_release' => '9.0.x (Pie)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Android 9 - 9.0.x (Pie) - x64'
            ],
            [
                'os_name' => 'Android 10',
                'os_release' => '10 (Android 10)',
                'os_architecture' => 'x64',
                'os_about' => 'N/C',
                'os_full' => 'Android 10 - 10 (Android 10) - x64'
            ]
        ];
        $this->insert('operating_systems', $data);
    }
}
