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
    
        // Vérifier si l'email existe déjà
        if (self::findByEmail($this->email) !== null) {
            return false; // Éviter l'insertion si l'utilisateur existe
        }
    
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
    

    /**
     * Récupère un utilisateur par son email.
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail(string $email): ?User {
        $pdo = Database::getConnection();

        $sql = 'SELECT user_id, nom, email, password_hash, prenom
                FROM "Utilisateur"
                WHERE email = :email
                LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // On retourne une instance de User
            return new User(
                $data['user_id'],
                $data['prenom'],
                $data['email'],
                $data['password_hash'],
                $data['nom']
            );
        } else {
            return null;
        }
    }
}
