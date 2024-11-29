<?php

class User extends link_sql{
    protected $id;
    protected $psedo;
    protected $password;
    protected $inscription_date;

    public function __construct($id = NULL){
        parent::__construct();
        if($id){
            $this->get_user($id);
        }
    }

    public function get_user($id){
        $param = ['psedo' => $id];
        $users = $this->get("Users", "psedo = :psedo", $param, "id", "DESC");
        if($users){
            $user = $users[0];
            $this->id = $user['id'];
            $this->psedo = $user['psedo'];
            $this->password = $user['password'];
            $this->inscription_date = $user['inscription_date'];
        } else {
            throw new Exception("Aucun utilisateur trouvé pour le pseudo : {$id}");
        }
    }
    public function set_user($user_data) {
        if (!is_array($user_data)) {
            throw new InvalidArgumentException("Les données utilisateur doivent être un tableau.");
        }
    
        foreach ($user_data as $key => $value) {
            echo $value;
            // Vérifie que la propriété existe avant de l'affecter
            if (property_exists($this, $key)) {
                switch ($key) {
                    case "password":
                        $this->$key = $value;
                        $this->hash_Password();
                        break;
                    default:
                        $this->$key = $value;
                        break;
                }
            } else {
                // Gère les clés inconnues, optionnellement en journalisant ou en lançant une exception
                error_log("La clé '{$key}' ne correspond pas à une propriété existante de la classe.");
            }
        }
    }
    
    public function persist() {	
		$user_data = [
			"psedo" => $this->psedo,
            "password" =>$this->password,
            "inscription_date" => $this->inscription_date
		];

		if (is_null($this->id)) {
			$this->set("Users", $user_data);

			$this->id = $this->get_last_id();
			if ( ! $this->id) {
				return false; 
			}
		} else {
			$key = ["name" => "id", "value" => $this->id];
			$this->modification("Users", $user_data, $key);
		}
	
		return true; 
	}

    public function hash_Password(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function get_id(){
        return $this->id;
    }
    public function set_id($new){
        $this->id = $new;
    }
    public function get_psedo(){
        return $this->psedo;
    }
    public function set_psedo($new){
        $this->psedo = $new;
    }
    public function get_password(){
        return $this->password;
    }
    public function set_password($new){
        $this->password = $new;
    }
    public function get_inscription_date(){
        return $this->inscription_date;
    }
    public function set_inscription_date($new){
        $this->inscription_date = $new;
    }
}