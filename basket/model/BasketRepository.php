<?php
    namespace App\basket\model;

    use App\services as srv;
    use App\item\model as mdl;

    class BasketRepository{
        private $sessionService;
        private $ITEMS_ADDED_KEY = 'itemsAdded';

        public function __construct(){
            $this->sessionService = srv\SessionService::getInstance();
        }

        public function addItem(mdl\Item $item){
            $items = $this->getItems();
            $continuer = true;
            $i = 0;
            while($continuer && $i < count($items)){
                if($items[$i]->getImage() === $item->getImage()){
                    $items[$i]->setQuantity($items[$i]->getQuantity() + $item->getQuantity());
                    $continuer = false;
                }
                $i++;
            }
            if($continuer)
                $items[] = $item;
            $this->sessionService->set($this->ITEMS_ADDED_KEY, $items);
        }

        public function removeItem(mdl\Item $item){
            $items = $this->getItems();
            $continuer = true;
            $i = 0;
            $length = count($items);
            while($continuer && $i < $length){
                if($items[$i]->getImage() === $item->getImage()){
                    $tmp = $items[$length - 1];
                    $items[$length - 1] = $items[$i];
                    $items[$i] = $tmp;
                    $continuer = false;
                }
                $i++;
            }
            if(!$continuer)
                array_pop($items);
            $this->sessionService->set($this->ITEMS_ADDED_KEY, $items);
        }

        public function getItems(){
            if($this->sessionService->exists($this->ITEMS_ADDED_KEY))
                return $this->sessionService->get($this->ITEMS_ADDED_KEY);
            return [];
        }

        public function getNbItems(){
            $items = $this->getItems();
            $nbItems = 0;
            foreach($items as $item)
                $nbItems += $item->getQuantity();
            return $nbItems;
        }
        
        public function isEmpty(){
            $items = $this->getItems();
            return empty($items);
        }

        public function clean(){
            $this->sessionService->delete('itemsAdded');
            $this->sessionService->set('itemsAdded', []);
        }
    }
?>