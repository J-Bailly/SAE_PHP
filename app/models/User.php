<?php

class Utilisateur {
    public $user_id;
    public $username;
    public $email;
    public $password_hash;

    public function __construct($user_id, $username, $email, $password_hash) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
    }

    // Méthode pour créer un nouvel utilisateur
    public static function create($username, $email, $password_hash, $pdo) {
        $sql = "INSERT INTO public.\"Utilisateur\" (username, email, password_hash) VALUES (:username, :email, :password_hash)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash]);
        return new Utilisateur($pdo->lastInsertId(), $username, $email, $password_hash);
    }

    // Méthode pour récupérer un utilisateur par son ID
    public static function findById($user_id, $pdo) {
        $sql = "SELECT * FROM public.\"Utilisateur\" WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $row = $stmt->fetch();
        return new Utilisateur($row['user_id'], $row['username'], $row['email'], $row['password_hash']);
    }
}