<?php

    require_once __DIR__ . "/Config.php";

    class DB {
        private $connection;

        public function __construct()
        {
            $config = new Config;

            $this->connect([
                'user' => $config->get('DB_USER'),
                'pass' => $config->get('DB_PASSWORD'),
                'host' => $config->get('DB_HOST'),
                'port' => $config->get('DB_PORT'),
                'dbName' => $config->get('DB_NAME'),
                'dbType' => $config->get('DB_TYPE')
            ]);
        }

        private function connect($config) {
            try {
                $dsn = $config['dbType'] . ':host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbName'];
                $this->connection = new PDO($dsn, $config['user'], $config['pass']);
            } catch (PDOException $e) {
                exit("Can't connect to database: " . $e->getMessage());
            }
        }

        public function query($sql) {
            try {
                $query = $this->connection->query($sql);
                return $query;
            } catch (Exception $e) {
                exit($e->getMessage());
            }
        }
    }
