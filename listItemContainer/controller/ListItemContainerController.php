<?php
    namespace App\listItemContainer\controller;

    use App\listItem\model as mdl;
    use App\listItem\view as vw1;
    use App\listItemContainer\view as vw;
    use App\filter\controller as ctrl2;
    use App\filter\model as md2;

    class ListItemContainerController{
        private $listItemRepo;

        public function __construct(mdl\ListItemRepository $listItemRepo){
            $this->listItemRepo = $listItemRepo;
        }

        public function action(){


            $query = "select * from articles";
            $items = $this->listItemRepo->getItems($query, []);
            $items = ctrl2\FilterManager::getInstance()->filterArticles($items);
            $itemsCount = count($items);

            $currentPage = 1;
            $numPage = 0;
            $offset = 0;
            $totalPages = max(ceil($itemsCount / 10), 1);
            if(isset($_GET['page']))
                $numPage = (int) $_GET['page'];
            if(0 < $numPage && $numPage <= $totalPages){
                $currentPage = $numPage;
                $offset = ($currentPage - 1) * 10;
            }

            $data = [];
            $count = min(10 + $offset, $itemsCount);
            for ($i = $offset; $i < $count; $i++)
            {
                $data[] = $items[$i];
            }


            $filterController = null;
            try {
                $filterController = new ctrl2\FilterController(new md2\DatabaseFilterRepository());
            } catch (\Exception $e) {
                throw $e;
            }
            return vw\ListItemContainerComponent::render($filterController->action(), vw1\ListItemComponent::render($data), $currentPage, $totalPages);
        }
    }
?>