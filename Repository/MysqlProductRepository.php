<?php

    require_once __DIR__ . "/../DB.php";

    class MysqlProductRepository
    {
        public static function addProducts($products) {
            $db = new DB;

            foreach ($products as $product) {
                echo "Добавление товара: " . $product->code . "\n";

                $product_sql = "REPLACE INTO products (`name`, `code`, `weight`,`" . implode("`,`", array_keys($product->quantities));
                $product_sql .= "`,`";
                $product_sql .= implode("`,`", array_keys($product->prices));
                $product_sql .= "`, `usage`) VALUES ('" . $product->name . "', '" . $product->code . "', '" . $product->weight . "','" .
                    implode("','", $product->quantities) . "','" .
                    implode("','", $product->prices) . "','" .
                    implode("|", $product->interchangeability). "');";

                $db->query($product_sql);
            }

            echo "Все товары добавлены.";
        }
    }