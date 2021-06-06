<?php

namespace App\Model;

use src\Model\Model;

class UserModel extends Model
{
    protected $model = 'pl15x_ausers';

    public function allWithRoles(){
        return $this->query('SELECT 
        u.id u_id,fullname,pseudo,mail,u.created_at u_created,lastvisite,updated_at,
        r.title r_title, r.level r_level
        FROM ' . $this->model . ' as u
        LEFT JOIN pl15x_roles as r ON u.roles_id = r.id
        ORDER BY u.created_at DESC');
    }

    /**
     * Récupère tous les utilisateurs avec leur rôles et une limite d'affichage
     *
     * @param $limit
     * @return mixed
     */
    public function allByLimit($limit) {
        return $this->query('SELECT *
        FROM ' . $this->model . ' as u
        LEFT JOIN pl15x_roles as r ON u.role_id = r.id
        ORDER BY u.created_at DESC LIMIT 0,' . $limit);
    }


    /**
     * Permet de récupérer un utilisateur avec son rôle
     *
     * @param int $id
     * @param bool $idParent
     * @return mixed
     */
    public function findUserWithRoles(int $id, $idParent = false ) {
        return $this->query("SELECT 
        u.id as uid, pseudo, created_at, lastvisit, lastname, firstname,mail,
        r.id as rid, r.title as r_title, r.level as r_level
        FROM " . $this->model ." as u 
        LEFT JOIN pl15x_roles as r ON u.role_id = r.id
        WHERE u.id = ?", [$id], true);
    }

    /**
     * Recherche un pseudo dans la table utilisateur
     *
     * @param $pseudo
     * @return mixed
     */
    public function scanPseudo($pseudo) {
        return $this->queryscan("SELECT id FROM " . $this->model . " WHERE pseudo = ? ", [$pseudo]);
    }

    /**
     * Recherche un mail dans la table utilisateur
     *
     * @param $mail
     * @return mixed
     */
    public function scanMail($mail) {
        return $this->queryscan("SELECT id FROM " . $this->model . " WHERE mail = ? ", [$mail], true);
    }

    /**
     * Vérifie le token de réinitialisation de password
     */

    public function scanToken($id, $token){

        return $this->queryscan("SELECT * FROM " . $this->model ." "
            . "WHERE id = ? "
            . "AND token IS NOT NULL "
            . "AND token = ?"
            . "AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)", [$id, $token], true);

    }

}