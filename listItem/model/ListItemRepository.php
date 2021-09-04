<?php
    namespace App\listItem\model;

    interface ListItemRepository{

        public function getItems($query, $options);

        public function getItem($query, $option);

        public function getNbItems();

        public function addItem($query, $options);

        public function deleteItem($query, $options);
    }
?>