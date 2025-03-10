<?php
require_once 'vendor/autoload.php';
require_once 'app/autoload.php';

use PHPUnit\Framework\TestCase;
use app\models\Restaurant;
use app\models\Reviews;
use app\models\User;

class RestaurantTest extends TestCase {
    public function testGetAndSetName() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'name' => 'Old Name'], []);
        $this->assertEquals('Old Name', $restaurant->getName());
    }

    public function testGetAndSetType() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'type' => 'French'], []);
        $this->assertEquals('French', $restaurant->getType());
    }

    public function testGetAndSetRestaurantId() {
        $restaurant = new Restaurant(['restaurant_id' => 1], []);
        $this->assertEquals(1, $restaurant->getRestaurantId());
    }

    public function testGetAndSetVegetarian() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'vegetarian' => true], []);
        $this->assertTrue($restaurant->isVegetarian());
    }

    public function testGetAndSetVegan() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'vegan' => true], []);
        $this->assertTrue($restaurant->isVegan());
    }

    public function testGetAndSetDelivery() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'delivery' => true], []);
        $this->assertTrue($restaurant->hasDelivery());
    }

    public function testGetAndSetTakeaway() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'takeaway' => true], []);
        $this->assertTrue($restaurant->hasTakeaway());
    }

    public function testGetAndSetPhone() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'phone' => '1234567890'], []);
        $this->assertEquals('1234567890', $restaurant->getPhone());
    }

    public function testGetAndSetWebsite() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'website' => 'http://example.com'], []);
        $this->assertEquals('http://example.com', $restaurant->getWebsite());
    }

    public function testGetAndSetAddress() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'address' => '123 Main St'], []);
        $this->assertEquals('123 Main St', $restaurant->getAddress());
    }

    public function testGetAndSetLatitude() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'latitude' => 40.7128], []);
        $this->assertEquals(40.7128, $restaurant->getLatitude());
    }

    public function testGetAndSetLongitude() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'longitude' => -74.0060], []);
        $this->assertEquals(-74.0060, $restaurant->getLongitude());
    }

    public function testGetAndSetOpeningHours() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'opening_hours' => '9 AM - 9 PM'], []);
        $this->assertEquals('9 AM - 9 PM', $restaurant->getOpeningHours());
    }

    public function testGetAndSetWheelchairAccessibility() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'wheelchair_accessibility' => true], []);
        $this->assertTrue($restaurant->hasWheelchairAccessibility());
    }

    public function testGetAndSetInternetAccess() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'internet_access' => 'WiFi'], []);
        $this->assertEquals('WiFi', $restaurant->getInternetAccess());
    }

    public function testGetAndSetSmokingAllowed() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'smoking_allowed' => true], []);
        $this->assertTrue($restaurant->isSmokingAllowed());
    }

    public function testGetAndSetCapacity() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'capacity' => 100], []);
        $this->assertEquals(100, $restaurant->getCapacity());
    }

    public function testGetAndSetDriveThrough() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'drive_through' => true], []);
        $this->assertTrue($restaurant->hasDriveThrough());
    }

    public function testGetAndSetFacebook() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'facebook' => 'http://facebook.com/restaurant'], []);
        $this->assertEquals('http://facebook.com/restaurant', $restaurant->getFacebook());
    }

    public function testGetAndSetSiret() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'siret' => '12345678901234'], []);
        $this->assertEquals('12345678901234', $restaurant->getSiret());
    }

    public function testGetAndSetDepartment() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'department' => 'Department'], []);
        $this->assertEquals('Department', $restaurant->getDepartment());
    }

    public function testGetAndSetRegion() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'region' => 'Region'], []);
        $this->assertEquals('Region', $restaurant->getRegion());
    }

    public function testGetAndSetBrand() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'brand' => 'Brand'], []);
        $this->assertEquals('Brand', $restaurant->getBrand());
    }

    public function testGetAndSetWikidata() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'wikidata' => 'Q12345'], []);
        $this->assertEquals('Q12345', $restaurant->getWikidata());
    }

    public function testGetAndSetBrandWikidata() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'brand_wikidata' => 'Q67890'], []);
        $this->assertEquals('Q67890', $restaurant->getBrandWikidata());
    }

    public function testGetAndSetComInsee() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'com_insee' => 12345], []);
        $this->assertEquals(12345, $restaurant->getComInsee());
    }

    public function testGetAndSetCodeRegion() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'code_region' => 12], []);
        $this->assertEquals(12, $restaurant->getCodeRegion());
    }

    public function testGetAndSetCodeDepartement() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'code_departement' => 34], []);
        $this->assertEquals(34, $restaurant->getCodeDepartement());
    }

    public function testGetAndSetCommune() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'commune' => 'Commune'], []);
        $this->assertEquals('Commune', $restaurant->getCommune());
    }

    public function testGetAndSetComNom() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'com_nom' => 'ComNom'], []);
        $this->assertEquals('ComNom', $restaurant->getComNom());
    }

    public function testGetAndSetCodeCommune() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'code_commune' => 56789], []);
        $this->assertEquals(56789, $restaurant->getCodeCommune());
    }

    public function testGetAndSetOsmEdit() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'osm_edit' => 'Edit'], []);
        $this->assertEquals('Edit', $restaurant->getOsmEdit());
    }

    public function testGetAndSetOsmId() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'osm_id' => '123456'], []);
        $this->assertEquals('123456', $restaurant->getOsmId());
    }

    public function testGetAndSetOperator() {
        $restaurant = new Restaurant(['restaurant_id' => 1, 'operator' => 'Operator'], []);
        $this->assertEquals('Operator', $restaurant->getOperator());
    }

    public function testGetAndSetCuisines() {
        $restaurant = new Restaurant(['restaurant_id' => 1], ['Italian', 'French']);
        $this->assertEquals(['Italian', 'French'], $restaurant->getCuisines());
    }
}
