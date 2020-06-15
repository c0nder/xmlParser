<?php

    class InterChangeAbility {
        public $mark;
        public $model;
        public $category;

        public function __toString()
        {
            return $this->mark . "-" . $this->model . "-" . $this->category;
        }
    }