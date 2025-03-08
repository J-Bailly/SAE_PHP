<?php

namespace app\models;

class User {
    private $id;
    private $username;
    private $email;
    // Ajoute d'autres propriétés et méthodes nécessaires

    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    // Getters et setters
}