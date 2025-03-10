<?php 

require_once 'vendor/autoload.php';
require_once 'app/autoload.php';

use PHPUnit\Framework\TestCase;
use app\models\User;



class UserTest extends TestCase {
    public function testGetAndSetUserId() {
        $user = new User(1, 'username', 'email@example.com', 'password', 'role');
        $this->assertEquals(1, $user->getId());
    }

    public function testGetAndSetUsername() {
        $user = new User(1, 'old_username', 'email@example.com', 'password', 'role');
        $user->username = 'new_username';
        $this->assertEquals('new_username', $user->username);
    }

    public function testGetAndSetEmail() {
        $user = new User(1, 'username', 'old@example.com', 'password', 'role');
        $user->setEmail('new@example.com');
        $this->assertEquals('new@example.com', $user->getEmail());
    }

    public function testGetAndSetPassword() {
        $user = new User(1, 'username', 'email@example.com', 'old_password', 'role');
        $user->setPassword('new_password');
        $this->assertEquals('new_password', $user->getPassword());
    }
}