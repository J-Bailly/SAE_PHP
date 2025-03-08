<?php

namespace app\models;

class User {
    private $id;
    private $email;
    private $password;
    private $nom;
    private $prenom;
    // Ajoute d'autres propriétés et méthodes nécessaires

    public function __construct($id, $prenom, $email, $password, $nom) {
        $this->id = $id;
        $this->pernom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
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