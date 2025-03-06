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

    // Constructeur pour initialiser les propriétés
    public function __construct(
        ?int $restaurant_id = null,
        ?string $name = null,
        ?string $type = null,
        ?bool $vegetarian = null,
        ?bool $vegan = null,
        ?bool $delivery = null,
        ?bool $takeaway = null,
        ?string $phone = null,
        ?string $website = null,
        ?string $address = null,
        ?float $latitude = null,
        ?float $longitude = null,
        ?string $opening_hours = null,
        ?bool $wheelchair_accessibility = null,
        ?string $internet_access = null,
        ?bool $smoking_allowed = null,
        ?int $capacity = null,
        ?bool $drive_through = null,
        ?string $facebook = null,
        ?string $siret = null,
        ?string $department = null,
        ?string $region = null,
        ?string $brand = null,
        ?string $wikidata = null,
        ?string $brand_wikidata = null,
        ?int $com_insee = null,
        ?int $code_region = null,
        ?int $code_departement = null,
        ?string $commune = null,
        ?string $com_nom = null,
        ?int $code_commune = null,
        ?string $osm_edit = null,
        ?string $osm_id = null,
        ?string $operator = null
    ) {
        $this->restaurant_id = $restaurant_id;
        $this->name = $name;
        $this->type = $type;
        $this->vegetarian = $vegetarian;
        $this->vegan = $vegan;
        $this->delivery = $delivery;
        $this->takeaway = $takeaway;
        $this->phone = $phone;
        $this->website = $website;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->opening_hours = $opening_hours;
        $this->wheelchair_accessibility = $wheelchair_accessibility;
        $this->internet_access = $internet_access;
        $this->smoking_allowed = $smoking_allowed;
        $this->capacity = $capacity;
        $this->drive_through = $drive_through;
        $this->facebook = $facebook;
        $this->siret = $siret;
        $this->department = $department;
        $this->region = $region;
        $this->brand = $brand;
        $this->wikidata = $wikidata;
        $this->brand_wikidata = $brand_wikidata;
        $this->com_insee = $com_insee;
        $this->code_region = $code_region;
        $this->code_departement = $code_departement;
        $this->commune = $commune;
        $this->com_nom = $com_nom;
        $this->code_commune = $code_commune;
        $this->osm_edit = $osm_edit;
        $this->osm_id = $osm_id;
        $this->operator = $operator;



        $this->address = JsonLoader::getAddressFromCoordinates($latitude, $longitude);

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
}