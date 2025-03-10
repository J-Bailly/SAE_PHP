<?php 

require_once 'vendor/autoload.php';
require_once 'app/autoload.php';

use PHPUnit\Framework\TestCase;
use app\models\User;

class UserTest extends TestCase {
    public function testGetUserId() {
        $user = new User(1, 'prenom', 'email@example.com', 'password', 'nom');
        $this->assertEquals(1, $user->getId());
    }

    public function testGetPrenom() {
        $user = new User(1, 'prenom', 'email@example.com', 'password', 'nom');
        $this->assertEquals('prenom', $user->getPrenom());
    }

    public function testGetEmail() {
        $user = new User(1, 'prenom', 'email@example.com', 'password', 'nom');
        $this->assertEquals('email@example.com', $user->getEmail());
    }

    public function testGetPassword() {
        $user = new User(1, 'prenom', 'email@example.com', 'password', 'nom');
        $this->assertEquals('password', $user->getPassword());
    }

    public function testGetNom() {
        $user = new User(1, 'prenom', 'email@example.com', 'password', 'nom');
        $this->assertEquals('nom', $user->getNom());
    }
}