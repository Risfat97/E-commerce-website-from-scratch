<?php
    namespace App\ListItemContainer\view;

    use App\filter\view as vw1;

    class ListItemContainerComponent{

        public static function render($filter, $listItems, $currentPage, $totalPages){
            $disabled = $currentPage === 1 ? 'disabled' : '';
            $prevPage = $currentPage - 1;
            $nextPage = $currentPage < $totalPages ? $currentPage + 1 : 1;
            $component = <<<HTML
                <div class="col-12 list-item-container">
                    <div class="row d-flex justify-content-end">
                        <div class="col-4 form-group search-item-container">
                            <input type="text" class="form-control" id="search-item" placeholder="Rechercher un article">
                            <button type="button" class="btn btn-search bg-warning circle" id="search-item-btn"><i class="fas fa-search text-white"></i></button>
                        </div>
                    </div>
                    <div class="row mt-4 mb-1">
                        <h3 class="col-9 offset-3">Votre sélection $currentPage/$totalPages</h3>
                    </div>
                    <div class="row d-flex justify-content-around">
                        $filter
                        $listItems
                    </div>
                    
                    <div class="row my-3 d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item $disabled mr-2"><a class="page-link" href="index.php?page=$prevPage" tabindex="-1">Précédent</a></li>
HTML;
            for($i = 1; $i <= $totalPages; $i++){
                $active = $currentPage === $i ? 'active' : '';
                $component = $component . '<li class="page-item mr-2 ' . $active .'"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
            }
            $suite = <<<HTML
                            <li class="page-item"><a class="page-link" href="index.php?page=$nextPage">Suivant</a></li>
                        </ul>
                    </div>
                </div>
HTML;
            return $component . $suite;
        }
    }
?>