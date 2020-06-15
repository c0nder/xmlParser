<?php

    class Config {
        private $variables = [];

        public function __construct() {
            $this->setVariables();
        }

        private function setVariables() {
            $envFile = @fopen(__DIR__ . '/.env', 'r');

            if ($envFile) {
                while (($line = fgets($envFile)) !== false) {
                    $lineData = explode('=', $line);
                    $lineData = array_filter($lineData, function($value) {
                        return !empty(trim($value));
                    });

                    if (!empty($lineData)) {
                        $this->variables[$lineData[0]] = trim($lineData[1]);
                    }
                }

                fclose($envFile);
            } else {
                exit('Env file not found');
            }
        }

        public function get($variable_name) {
            if (array_key_exists($variable_name, $this->variables)) {
                return $this->variables[$variable_name];
            }

            exit('Variable ' . $variable_name . ' not found in config file.');
        }
    }

    $cnf = new Config();