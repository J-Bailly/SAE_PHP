<?php

namespace app\models;

class User {
    private $id;
    private $email;
    private $password;
    private $nom;
    private $prenom;
    private $cuisines_favorites;
    // Ajoute d'autres propriétés et méthodes nécessaires

    public function __construct($id, $prenom, $email, $password, $nom, $cuisines_favorites = []) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->cuisines_favorites = $cuisines_favorites;
    }

    // Getters et setters
    public function getId() {
        return $this->id;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getNom() {
        return $this->nom;
    }
}