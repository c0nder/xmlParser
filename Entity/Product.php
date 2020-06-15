<?php

    class Product {
        public $code;
        public $name;
        public $weight;
        public $interchangeability = [];
        public $quantities = [];
        public $prices = [];

        public function addInterchangeability (InterChangeAbility $ability) {
            $this->interchangeability[] = $ability;
        }

        public function addCityInfo ($city_code, $city_quantity, $city_price) {
            $this->quantities['quantity_' . $city_code] = $city_quantity;
            $this->prices['price_' . $city_code] = $city_price;
        }
    }