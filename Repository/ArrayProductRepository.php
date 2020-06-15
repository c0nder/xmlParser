<?php
    require_once __DIR__ . "/../Entity/Product.php";
    require_once __DIR__ . "/IProductRepository.php";

    class ArrayProductRepository implements IProductRepository {
        private $products = [];

        public function put(Product $product)
        {
            $this->products[$product->code] = $product;
        }

        public function get($product_code)
        {
            if (array_key_exists($product_code, $this->products)) {
                return $this->products[$product_code];
            }

            return null;
        }

        public function exists($product_code)
        {
            if (array_key_exists($product_code, $this->products)) {
                return true;
            }

            return false;
        }

        public function getAll()
        {
            return $this->products;
        }
    }