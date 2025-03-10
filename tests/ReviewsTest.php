<?php 

require_once 'vendor/autoload.php';
require_once 'app/autoload.php';

use PHPUnit\Framework\TestCase;
use app\models\Reviews;


class ReviewsTest extends TestCase {
    public function testGetAndSetReviewId() {
        $review = new Reviews(1, 1, 1, 5, 'Good', '2023-01-01');
        $this->assertEquals(1, $review->getId());
    }

    public function testGetAndSetRestaurantId() {
        $review = new Reviews(1, 1, 1, 5, 'Good', '2023-01-01');
        $this->assertEquals(1, $review->getRestaurant());
    }

    public function testGetAndSetUserId() {
        $review = new Reviews(1, 1, 1, 5, 'Good', '2023-01-01');
        $this->assertEquals(1, $review->getUser());
    }

    public function testGetAndSetRating() {
        $review = new Reviews(1, 1, 1, 5, 'Good', '2023-01-01');
        $review->setRating(4);
        $this->assertEquals(4, $review->getRating());
    }

    public function testGetAndSetComment() {
        $review = new Reviews(1, 1, 1, 5, 'Old comment', '2023-01-01');
        $review->setComment('New comment');
        $this->assertEquals('New comment', $review->getComment());
    }

    public function testGetDate() {
        $review = new Reviews(1, 1, 1, 5, 'Good', '2023-01-01');
        $this->assertEquals('2023-01-01', $review->getDate());
    }
}