<?php
namespace app\models;

class Reviews {

    private $id;
    private $restaurant;
    private $user;
    private $rating;
    private $comment;
    private $date;

    public function __construct($id, $restaurant, $user, $rating, $comment, $date) {
        $this->id = $id;
        $this->restaurant = $restaurant;
        $this->user = $user;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->date = $date;
    }

    // Getters et setters
    public function getId() {
        return $this->id;
    }

    public function getRestaurant() {
        return $this->restaurant;
    }

    public function getUser() {
        return $this->user;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getDate() {
        return $this->date;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }
    

}