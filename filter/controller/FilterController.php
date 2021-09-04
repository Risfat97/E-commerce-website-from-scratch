<?php
    namespace App\filter\controller;

    use App\filter\model as md;
    use App\filter\view as vw;

    class FilterController{
        private $filterRepo;

        private $filterMgr;

        public function __construct(md\FilterRepository $filterRepo){
            $this->filterRepo = $filterRepo;

            $this->filterMgr = FilterManager::getInstance();
        }

        public function action(){
            $categories = $this->filterRepo->getCategory();
            $categoriesTab = [];
            foreach ($categories as $category)
            {
                $categoryElems = [];
                $categoryElems['categorie'] = $category['categorie'];
                $categoryElems['nombre'] =  $category['nombre'];
                if ($this->filterMgr->isCategorySelected($category['categorie']))
                {
                    $categoryElems['isChecked'] = true;
                }

                $categoriesTab[] = $categoryElems;
            }

            return vw\FilterComponent::render($categoriesTab, $this->filterMgr->getPricesTab());
        }
    }
?>