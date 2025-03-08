<?php

namespace app\models;

use app\config\Database;
use PDO;

class User {
    private $id;
    private $email;
    private $password;
    private $nom;
    private $prenom;

    public function __construct($id, $prenom, $email, $password, $nom) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getNom() { return $this->nom; }

    /**
     * Sauvegarde l'utilisateur dans la table Utilisateur.
     *
     * @return bool
     */
    public function save(): bool {
        $pdo = Database::getConnection();
        $sql = 'INSERT INTO "Utilisateur" (email, password_hash, nom, prenom)
                VALUES (:email, :password_hash, :nom, :prenom)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':password_hash', $this->password);
        $stmt->bindValue(':nom', $this->nom);
        $stmt->bindValue(':prenom', $this->prenom);

        $result = $stmt->execute();
        if ($result) {
            $this->id = $pdo->lastInsertId();
        }
        return $result;
    }
}
