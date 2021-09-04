<?php
    namespace App\item\model;

    class Item{
        private $name;
        private $category;
        private $image;
        private $quantity;
        private $price;

        public function __construct(string $name, string $category, string $image, int $quantity, float $price){
            $this->name = $name;
            $this->category = $category;
            $this->image = $image;
            $this->quantity = $quantity;
            $this->price = $price;
        }

        public function getName(): string{
            return $this->name;
        }

        public function getCategory(): string{
            return $this->category;
        }

        public function getImage(): string{
            return $this->image;
        }

        public function getQuantity(): float{
            return $this->quantity;
        }

        public function setQuantity($newQuantity){
            if($newQuantity <= 0)
                throw new \Exception("Quantité négative");
            $this->quantity = $newQuantity;
        }

        public function getPrice(): float{
            return $this->price;
        }
    }
?>