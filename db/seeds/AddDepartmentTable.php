<?php


use Phinx\Seed\AbstractSeed;

class AddDepartmentTable extends AbstractSeed
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
              'code' => '01',
              'name' => 'Ain',
              'slug' => 'ain',
              'soundex' => 'A500'
          ],
            [
                'code' => '02',
                'name' => 'Aisne',
                'slug' => 'aisne',
                'soundex' => 'A250'
            ],
            [
                'code' => '03',
                'name' => 'Allier',
                'slug' => 'allier',
                'soundex' => 'A460'
            ],
            [
                'code' => '04',
                'name' => 'Alpes-de-Haute-Provence',
                'slug' => 'alpes-de-haute-provence',
                'soundex' => 'A412316152'
            ],
            [
                'code' => '05',
                'name' => 'Hautes-Alpes',
                'slug' => 'hautes-alpes',
                'soundex' => 'H32412'
            ],
            [
                'code' => '06',
                'name' => 'Alpes-Maritimes',
                'slug' => 'alpes-maritimes',
                'soundex' => 'A41256352'
            ],
            [
                'code' => '07',
                'name' => 'Ardèche',
                'slug' => 'ardeche',
                'soundex' => 'A632'
            ],
            [
                'code' => '08',
                'name' => 'Ardennes',
                'slug' => 'ardennes',
                'soundex' => 'A6352'
            ],
            [
                'code' => '09',
                'name' => 'Ariège',
                'slug' => 'ariege',
                'soundex' => 'A620'
            ],
            [
                'code' => '10',
                'name' => 'Aube',
                'slug' => 'aube',
                'soundex' => 'A100'
            ],
            [
                'code' => '11',
                'name' => 'Aude',
                'slug' => 'aude',
                'soundex' => 'A300'
            ],
            [
                'code' => '12',
                'name' => 'Aveyron',
                'slug' => 'aveyron',
                'soundex' => 'A165'
            ],
            [
                'code' => '13',
                'name' => 'Bouches-du-Rhône',
                'slug' => 'bouches-du-rhone',
                'soundex' => 'B2365'
            ],
            [
                'code' => '14',
                'name' => 'Calvados',
                'slug' => 'calvados',
                'soundex' => 'C4132'
            ],
            [
                'code' => '15',
                'name' => 'Cantal',
                'slug' => 'cantal',
                'soundex' => 'C534'
            ],
            [
                'code' => '16',
                'name' => 'Charente',
                'slug' => 'charente',
                'soundex' => 'C653'
            ],
            [
                'code' => '17',
                'name' => 'Charente-Maritime',
                'slug' => 'charente-maritime',
                'soundex' => 'C6535635'
            ],
            [
                'code' => '18',
                'name' => 'Cher',
                'slug' => 'cher',
                'soundex' => 'C600'
            ],
            [
                'code' => '19',
                'name' => 'Corrèze',
                'slug' => 'correze',
                'soundex' => 'C620'
            ],
            [
                'code' => '2a',
                'name' => 'Corse-du-sud',
                'slug' => 'corse-du-sud',
                'soundex' => 'C62323'
            ],
            [
                'code' => '2b',
                'name' => 'Haute-corse',
                'slug' => 'haute-corse',
                'soundex' => 'H3262'
            ],
            [
                'code' => '21',
                'name' => 'Côte-d\'or',
                'slug' => 'cote-dor',
                'soundex' => 'C360'
            ],
            [
                'code' => '22',
                'name' => 'Côtes-d\'armor',
                'slug' => 'cotes-darmor',
                'soundex' => 'C323656'
            ],
            [
                'code' => '23',
                'name' => 'Creuse',
                'slug' => 'creuse',
                'soundex' => 'C620'
            ],
            [
                'code' => '24',
                'name' => 'Dordogne',
                'slug' => 'dordogne',
                'soundex' => 'D6325'
            ],
            [
                'code' => '25',
                'name' => 'Doubs',
                'slug' => 'doubs',
                'soundex' => 'D120'
            ],
            [
                'code' => '26',
                'name' => 'Drôme',
                'slug' => 'drome',
                'soundex' => 'D650'
            ],
            [
                'code' => '27',
                'name' => 'Eure',
                'slug' => 'eure',
                'soundex' => 'E600'
            ],
            [
                'code' => '28',
                'name' => 'Eure-et-Loir',
                'slug' => 'eure-et-loir',
                'soundex' => 'E6346'
            ],
            [
                'code' => '29',
                'name' => 'Finistère',
                'slug' => 'finistere',
                'soundex' => 'F5236'
            ],
            [
                'code' => '30',
                'name' => 'Gard',
                'slug' => 'gard',
                'soundex' => 'G630'
            ],
            [
                'code' => '31',
                'name' => 'Haute-Garonne',
                'slug' => 'haute-garonne',
                'soundex' => 'H3265'
            ],
            [
                'code' => '32',
                'name' => 'Gers',
                'slug' => 'gers',
                'soundex' => 'G620'
            ],
            [
                'code' => '33',
                'name' => 'Gironde',
                'slug' => 'gironde',
                'soundex' => 'G653'
            ],
            [
                'code' => '34',
                'name' => 'Hérault',
                'slug' => 'herault',
                'soundex' => 'H643'
            ],
            [
                'code' => '35',
                'name' => 'Ile-et-Vilaine',
                'slug' => 'ile-et-vilaine',
                'soundex' => 'I43145'
            ],
            [
                'code' => '36',
                'name' => 'Indre',
                'slug' => 'indre',
                'soundex' => 'I536'
            ],
            [
                'code' => '37',
                'name' => 'Indre-et-Loire',
                'slug' => 'indre-et-loire',
                'soundex' => 'I536346'
            ],
            [
                'code' => '38',
                'name' => 'Isère',
                'slug' => 'isere',
                'soundex' => 'I260'
            ],
            [
                'code' => '39',
                'name' => 'Jura',
                'slug' => 'jura',
                'soundex' => 'J600'
            ],
            [
                'code' => '40',
                'name' => 'Landes',
                'slug' => 'landes',
                'soundex' => 'L532'
            ],
            [
                'code' => '41',
                'name' => 'Loir-et-Cher',
                'slug' => 'loir-et-cher',
                'soundex' => 'L6326'
            ],
            [
                'code' => '42',
                'name' => 'Loire',
                'slug' => 'loire',
                'soundex' => 'L600'
            ],
            [
                'code' => '43',
                'name' => 'Haute-Loire',
                'slug' => 'haute-loire',
                'soundex' => 'H346'
            ],
            [
                'code' => '44',
                'name' => 'Loire-Atlantique',
                'slug' => 'loire-atlantique',
                'soundex' => 'L634532'
            ],
            [
                'code' => '45',
                'name' => 'Loiret',
                'slug' => 'loiret',
                'soundex' => 'L630'
            ],
            [
                'code' => '46',
                'name' => 'Lot',
                'slug' => 'lot',
                'soundex' => 'L300'
            ],
            [
                'code' => '47',
                'name' => 'Lot-et-Garonne',
                'slug' => 'lot-et-garonne',
                'soundex' => 'L3265'
            ],
            [
                'code' => '48',
                'name' => 'Lozère',
                'slug' => 'lozere',
                'soundex' => 'L260'
            ],
            [
                'code' => '49',
                'name' => 'Maine-et-Loire',
                'slug' => 'maine-et-loire',
                'soundex' => 'M346'
            ],
            [
                'code' => '50',
                'name' => 'Manche',
                'slug' => 'manche',
                'soundex' => 'M200'
            ],
            [
                'code' => '51',
                'name' => 'Marne',
                'slug' => 'marne',
                'soundex' => 'M650'
            ],
            [
                'code' => '52',
                'name' => 'Haute-Marne',
                'slug' => 'haute-marne',
                'soundex' => 'H3565'
            ],
            [
                'code' => '53',
                'name' => 'Mayenne',
                'slug' => 'mayenne',
                'soundex' => 'M000'
            ],
            [
                'code' => '54',
                'name' => 'Meurthe-et-Moselle',
                'slug' => 'meurthe-et-moselle',
                'soundex' => 'M63524'
            ],
            [
                'code' => '55',
                'name' => 'Meuse',
                'slug' => 'meuse',
                'soundex' => 'M200'
            ],
            [
                'code' => '56',
                'name' => 'Morbihan',
                'slug' => 'morbihan',
                'soundex' => 'M615'
            ],
            [
                'code' => '57',
                'name' => 'Moselle',
                'slug' => 'moselle',
                'soundex' => 'M240'
            ],
            [
                'code' => '58',
                'name' => 'Nièvre',
                'slug' => 'nievre',
                'soundex' => 'N160'
            ],
            [
                'code' => '59',
                'name' => 'Nord',
                'slug' => 'nord',
                'soundex' => 'N630'
            ],
            [
                'code' => '60',
                'name' => 'Oise',
                'slug' => 'oise',
                'soundex' => 'O200'
            ],
            [
                'code' => '61',
                'name' => 'Orne',
                'slug' => 'orne',
                'soundex' => 'O650'
            ],
            [
                'code' => '62',
                'name' => 'Pas-de-Calais',
                'slug' => 'pas-de-calais',
                'soundex' => 'P23242'
            ],
            [
                'code' => '63',
                'name' => 'Puy-de-Dôme',
                'slug' => 'puy-de-dome',
                'soundex' => 'P350'
            ],
            [
                'code' => '64',
                'name' => 'Pyrénées-Atlantiques',
                'slug' => 'pyrenees-atlantiques',
                'soundex' => 'P65234532'
            ],
            [
                'code' => '65',
                'name' => 'Hautes-Pyrénées',
                'slug' => 'hautes-pyrenees',
                'soundex' => 'H321652'
            ],
            [
                'code' => '66',
                'name' => 'Pyrénées-Orientales',
                'slug' => 'pyrenees-orientales',
                'soundex' => 'P65265342'
            ],
            [
                'code' => '67',
                'name' => 'Bas-Rhin',
                'slug' => 'bas-rhin',
                'soundex' => 'B265'
            ],
            [
                'code' => '68',
                'name' => 'Haut-Rhin',
                'slug' => 'haut-rhin',
                'soundex' => 'H365'
            ],
            [
                'code' => '69',
                'name' => 'Rhône',
                'slug' => 'rhone',
                'soundex' => 'R500'
            ],
            [
                'code' => '70',
                'name' => 'Haute-Saône',
                'slug' => 'haute-saone',
                'soundex' => 'H325'
            ],
            [
                'code' => '71',
                'name' => 'Saône-et-Loire',
                'slug' => 'saone-et-loire',
                'soundex' => 'S5346'
            ],
            [
                'code' => '72',
                'name' => 'Sarthe',
                'slug' => 'sarthe',
                'soundex' => 'S630'
            ],
            [
                'code' => '73',
                'name' => 'Savoie',
                'slug' => 'savoie',
                'soundex' => 'S100'
            ],
            [
                'code' => '74',
                'name' => 'Haute-Savoie',
                'slug' => 'haute-savoie',
                'soundex' => 'H321'
            ],
            [
                'code' => '75',
                'name' => 'Paris',
                'slug' => 'paris',
                'soundex' => 'P620'
            ],
            [
                'code' => '76',
                'name' => 'Seine-Maritime',
                'slug' => 'seine-maritime',
                'soundex' => 'S5635'
            ],
            [
                'code' => '77',
                'name' => 'Seine-et-Marne',
                'slug' => 'seine-et-marne',
                'soundex' => 'S53565'
            ],
            [
                'code' => '78',
                'name' => 'Yvelines',
                'slug' => 'yvelines',
                'soundex' => 'Y1452'
            ],
            [
                'code' => '79',
                'name' => 'Deux-Sèvres',
                'slug' => 'deux-sevres',
                'soundex' => 'D2162'
            ],
            [
                'code' => '80',
                'name' => 'Somme',
                'slug' => 'somme',
                'soundex' => 'S500'
            ],
            [
                'code' => '81',
                'name' => 'Tarn',
                'slug' => 'tarn',
                'soundex' => 'T650'
            ],
            [
                'code' => '82',
                'name' => 'Tarn-et-Garonne',
                'slug' => 'tarn-et-garonne',
                'soundex' => 'T653265'
            ],
            [
                'code' => '83',
                'name' => 'Var',
                'slug' => 'var',
                'soundex' => 'V600'
            ],
            [
                'code' => '84',
                'name' => 'Vaucluse',
                'slug' => 'vaucluse',
                'soundex' => 'V242'
            ],
            [
                'code' => '85',
                'name' => 'Vendée',
                'slug' => 'vendee',
                'soundex' => 'V530'
            ],
            [
                'code' => '86',
                'name' => 'Vienne',
                'slug' => 'vienne',
                'soundex' => 'V500'
            ],
            [
                'code' => '87',
                'name' => 'Haute-Vienne',
                'slug' => 'haute-vienne',
                'soundex' => 'H315'
            ],
            [
                'code' => '88',
                'name' => 'Vosges',
                'slug' => 'vosges',
                'soundex' => 'V200'
            ],
            [
                'code' => '89',
                'name' => 'Yonne',
                'slug' => 'yonne',
                'soundex' => 'Y500'
            ],
            [
                'code' => '90',
                'name' => 'Territoire de Belfort',
                'slug' => 'territoire-de-belfort',
                'soundex' => 'T636314163'
            ],
            [
                'code' => '91',
                'name' => 'Essonne',
                'slug' => 'essonne',
                'soundex' => 'E250'
            ],
            [
                'code' => '92',
                'name' => 'Hauts-de-Seine',
                'slug' => 'hauts-de-seine',
                'soundex' => 'H32325'
            ],
            [
                'code' => '93',
                'name' => 'Seine-Saint-Denis',
                'slug' => 'seine-saint-denis',
                'soundex' => 'S525352'
            ],
            [
                'code' => '94',
                'name' => 'Val-de-Marne',
                'slug' => 'val-de-marne',
                'soundex' => 'V43565'
            ],
            [
                'code' => '95',
                'name' => 'Val-d\'oise',
                'slug' => 'val-doise',
                'soundex' => 'V432'
            ],
            [
                'code' => '95',
                'name' => 'Val-d\'oise',
                'slug' => 'val-doise',
                'soundex' => 'V432'
            ],
            [
                'code' => '976',
                'name' => 'Mayotte',
                'slug' => 'mayotte',
                'soundex' => 'M300'
            ],
            [
                'code' => '971',
                'name' => 'Guadeloupe',
                'slug' => 'guadeloupe',
                'soundex' => 'G341'
            ],
            [
                'code' => '973',
                'name' => 'Guyane',
                'slug' => 'guyane',
                'soundex' => 'G500'
            ],
            [
                'code' => '972',
                'name' => 'Martinique',
                'slug' => 'martinique',
                'soundex' => 'M6352'
            ],
            [
                'code' => '974',
                'name' => 'Réunion',
                'slug' => 'reunion',
                'soundex' => 'R500'
            ]

        ];
        $this->insert('departments', $data);
    }
}
