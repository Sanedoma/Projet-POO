<?php

class link_sql{

    private $pdo;

    public function __construct()
    {
        $server = "localhost";
        $database = "psedo_cours_poo";
        $user = "root";
        $pass ="";
        $this->connect($server, $database, $user, $pass);
    }

    private function connect($server, $database, $user, $pass) {
        //Create PDO instance
        try {
          $this->pdo = new PDO("mysql:host=$server;dbname=$database", $user, $pass);
          
        } catch (PDOException $e) {
          die ('Connection failed: ' . $e->getMessage());
        }
    }
    public function get($table, $filter, $params = NULL, $orderby = "id", $order = "ASC") {
        // Construction de la requête SQL
        $SQL = "SELECT * FROM {$table} WHERE {$filter} ORDER BY {$orderby} {$order}";
        $prep = $this->pdo->prepare($SQL);
    
        // Exécution avec les paramètres sécurisés
        $prep->execute($params);
    
        // Retourner les résultats
        $res = $prep->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    
      
    
    public function set($table, $values) {
        $SQL1 = "INSERT INTO `$table` (";
        $SQL2 = ") VALUES (";
        $first = true;
    
        foreach ($values as $key => $value) {
            if ($first) { 
                $first = false;
                $SQL1 .= "`$key`";
                $SQL2 .= ":$key";
            } else { 
                $SQL1 .= ", `$key`";
                $SQL2 .= ", :$key";
            }
        }
    
        $SQL = $SQL1 . $SQL2 . ");";
        // Préparer la requête SQL$
    
        $request = $this->pdo->prepare($SQL);
        // Lier les paramètres à leurs valeurs respectives
        foreach ($values as $key => $value) {
            $request->bindValue(":$key", $value);
        }
    
        // Exécuter la requête
        $success = $request->execute();
        if (!$success) {
          echo "Erreur SQL : " . implode(", ", $this->pdo->errorInfo());
      }
        return $success ? TRUE : $this->pdo->errorInfo();
    }
    
    public function modification($table, $values, $keyvals) {
        $first = true;
        $SQL = "UPDATE `$table` SET";
    
        foreach ($values as $key => $value) {
            if ($first) {
                $first = false;
                $SQL .= " `$key` = :$key";
            } else { 
                $SQL .= ", `$key` = :$key";
            }
        }
    
        $SQL .= " WHERE `" . $keyvals["name"] . "` = :" . $keyvals["name"];
    
        // Préparer la requête SQL
        $request = $this->pdo->prepare($SQL);
    
        // Lier les paramètres à leurs valeurs respectives
        foreach ($values as $key => $value) {
            $request->bindValue(":$key", $value);
        }
        // Lier également la valeur de la clé de recherche
        $request->bindValue(":" . $keyvals["name"], $keyvals["value"]);
        // Exécuter la requête
        $request->execute();
    }
    
    
    public function del($table, $condition) {
        $sql = "DELETE FROM `$table` WHERE $condition LIMIT 1";
        $step = $this->pdo->prepare($sql);
        return ($step->execute()) ? "success" : $this->pdo->errorInfo();
    }
    
    public function get_last_id() {
        return $this->pdo->lastInsertId();
    }

}