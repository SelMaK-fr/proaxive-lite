<?php

namespace src\MyClass;

use src\Database\MysqlDatabase;


class Validator{

	private $data;
	private $errors = [];

	public function __construct($data){

		$this->data = $data;

	}

	private function getField($field){

		if(!isset($this->data[$field])){

			return null;
		}

		return $this->data[$field];

	}

	public function isAlpha($field, $errorMsg){
		if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){

			$this->errors[$field] = $errorMsg;
		}


	}

	/**
	* Vérifie si unique
	*/
	public function isUniq($id, $field, $db, $table, $errorMsg){

		$record = $db->prepare("SELECT $id FROM $table WHERE $field = ?", [$this->getField($field)], null, true);
		if($record){
			$this->errors[$field] = $errorMsg;
		}

	}

	/**
	* Vérifie si l'email n'est pas dans la liste noir
	*/
	public function isMailBan($id, $field, $db, $table, $errorMsg){

		//$pos1 = stripos($_POST['mail'], "@monnom.fr");
		$record = $db->prepare("SELECT $id FROM $table WHERE mail_ban = ?", [$this->getField($field)], null, true);
		if($record){
			$this->errors[$field] = $errorMsg;
		}

	}

	/**
	* Vérifie si l'ip n'est pas dans la liste noir
	*/
	public function isIpBan($id, $field, $db, $table, $errorMsg){

		$record = $db->prepare("SELECT $id FROM $table WHERE ip_ban = ?", [$this->getField($field)], null, true);
		if($record){
			$this->errors[$field] = $errorMsg;
		}

	}


	/**
	* Vérifie si c'est bien en format EMAIL
	*/
	public function isEmail($field, $errorMsg){
		if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
			$this->errors[$field] = $errorMsg;
		}

	}

	public function isConfirmed($field, $errorMsg){
		$value = $this->getField($field);
		if(empty($value) || $value != $this->getField($field . '_confirm')){
			$this->errors[$field] = $errorMsg;	
		}
	}

	

	public function isValid(){
		return empty($this->errors);
	}


	public function getErrors(){
		return $this->errors;
	}

}