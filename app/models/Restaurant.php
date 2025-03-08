<?php

namespace app\models;

use app\services\jsonloader; // Importer JsonLoader

class Restaurant
{
    private ?int $restaurant_id;
    private ?string $name;
    private ?string $type;
    private ?bool $vegetarian;
    private ?bool $vegan;
    private ?bool $delivery;
    private ?bool $takeaway;
    private ?string $phone;
    private ?string $website;
    private ?string $address;
    private ?float $latitude;
    private ?float $longitude;
    private ?string $opening_hours;
    private ?bool $wheelchair_accessibility;
    private ?string $internet_access;
    private ?bool $smoking_allowed;
    private ?int $capacity;
    private ?bool $drive_through;
    private ?string $facebook;
    private ?string $siret;
    private ?string $department;
    private ?string $region;
    private ?string $brand;
    private ?string $wikidata;
    private ?string $brand_wikidata;
    private ?int $com_insee;
    private ?int $code_region;
    private ?int $code_departement;
    private ?string $commune;
    private ?string $com_nom;
    private ?int $code_commune;
    private ?string $osm_edit;
    private ?string $osm_id;
    private ?string $operator;
    private array $cuisines;

    // Constructeur pour initialiser les propriétés
    public function __construct($data = [], $cuisines = [])
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Argument $data must be of type array.');
        }

        $this->cuisines = $cuisines;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        

    }

    // Getters
    public function getRestaurantId()
    {
        return $this->restaurant_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isVegetarian()
    {
        return $this->vegetarian;
    }

    public function isVegan()
    {
        return $this->vegan;
    }

    public function hasDelivery()
    {
        return $this->delivery;
    }

    public function hasTakeaway()
    {
        return $this->takeaway;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getOpeningHours()
    {
        return $this->opening_hours;
    }

    public function hasWheelchairAccessibility()
    {
        return $this->wheelchair_accessibility;
    }

    public function getInternetAccess()
    {
        return $this->internet_access;
    }

    public function isSmokingAllowed()
    {
        return $this->smoking_allowed;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function hasDriveThrough()
    {
        return $this->drive_through;
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function getSiret()
    {
        return $this->siret;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getWikidata()
    {
        return $this->wikidata;
    }

    public function getBrandWikidata()
    {
        return $this->brand_wikidata;
    }

    public function getComInsee()
    {
        return $this->com_insee;
    }

    public function getCodeRegion()
    {
        return $this->code_region;
    }

    public function getCodeDepartement()
    {
        return $this->code_departement;
    }

    public function getCommune()
    {
        return $this->commune;
    }

    public function getComNom()
    {
        return $this->com_nom;
    }

    public function getCodeCommune()
    {
        return $this->code_commune;
    }

    public function getOsmEdit()
    {
        return $this->osm_edit;
    }

    public function getOsmId()
    {
        return $this->osm_id;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getCuisines()
    {
        return $this->cuisines;
    }
}
