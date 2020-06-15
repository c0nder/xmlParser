<?php

    require_once __DIR__ . "/../Entity/Product.php";

    interface IProductRepository {
        public function put(Product $product);

        public function get($product_code);

        public function exists($product_code);

        public function getAll();
    }