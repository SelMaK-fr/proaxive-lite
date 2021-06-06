<?php

/*
.---------------------------------------------------------------------------.
|  Software: NaoNaK Web - Content Management System                         |
|   Version: 1.0                                                            |
|   Contact: via divrezstudio.fr support pages                              |
|      Info: http://www.divrezstudio.fr/app/6-naonak-web                    |
|   Support: http://www.divrezstudio.fr/forums                              |
| ------------------------------------------------------------------------- |
|     Admin: SelMaK  (project admininistrator)                              |
|   Authors: SelMaK (Yann Cario)                                            |
|                                                                           |
|   Founder: SelMaK (Yann Cario) (original founder)                         |
| Copyright (c) 2010-2018, Divrezstudio. All Rights Reserved.               |
|                                                                           |
| ------------------------------------------------------------------------- |
|   License: Distributed under the GNU/GPLv3 License                        |
|            https://www.gnu.org/licenses/gpl-3.0.fr.html                   |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |

*/
namespace App\Model;

use src\Model\Model;

/**
 * Description of StatusTable
 *
 * @author SelMaK
 */
class StatusModel extends Model{

     protected $model = 'pl15x_status';
     
    /**
    *
    */

    public function last(){

        return $this->query("SELECT *
            FROM ".$this->model."
            ORDER BY title DESC");

    }

    /**
     * Permet de scanner le titre du status
     *
     * @param $name
     * @return mixed
     */
    public function scanTitle($name){

        return $this->queryscan("SELECT id FROM " . $this->model . " WHERE title = ?", [$name]);

    }
    
}
