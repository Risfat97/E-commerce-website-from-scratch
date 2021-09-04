<?php
    namespace App\filter\view;

    class FilterComponent{

        public static function render($categories, $prices){
            $component = <<<HTML
                <div class="filter-container col-2 mt-1">
                    <div class="row bg-light">
                        <h5 class="bg-dark text-light text-center col-12 my-0 py-2"><i class="fas fa-filter"></i> Filtres</h5>
                        <button type="button" class="col-12 bg-danger my-0 text-dark" 
                                    data-toggle="collapse" 
                                    data-target="#collapseCategory"
                                    aria-expanded="false" 
                                    aria-controls="collapseCategory">Catégorie</button>
                        <div class="collapse col-12 px-0" id="collapseCategory">
                            <div class="list-group list-group-flush">
HTML;
            foreach($categories as $category){
                $categoryName = $category['categorie'];
                $checkbox = 
                "<input type=\"checkbox\" id=\"{$categoryName}\" name=\"{$categoryName}\" class=\"form-check-input\"";
                if ($category['isChecked'])
                    $checkbox = "$checkbox checked>";
                else
                    $checkbox = "{$checkbox}>";
                $temp = <<<HTML
                <div class="form-check">
                    $checkbox
                    <label for="{$categoryName}" class="form-check-label">
                        $categoryName <span class="badge badge-primary badge-pill"> {$category['nombre']} </span>
                    </label>
                 </div>
HTML;
                $component = $component . $temp;
            }
            $suite = <<<HTML
                            </div>
                        </div>
                        <button type="button" class="col-12 bg-warning mb-2 text-dark" 
                                    data-toggle="collapse" 
                                    data-target="#collapsePrice" 
                                    aria-expanded="false" 
                                    aria-controls="collapsePrice">Prix</button>
                        <div class="collapse col-12" id="collapsePrice">
                            <div class="form-group">
                                <label for="min-price">Prix minimum</label>
                                <div class="price-container">
                                    <input type="number" class="form-control price-input pr-5" min="0" id="min-price" placeholder="prix€" value="{$prices['min']}">
                                    <span class="text-euro px-3">€</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="max-price">Prix maximum</label>
                                <div class="price-container">
                                    <input type="number" class="form-control price-input pr-5" min="0" id="max-price" placeholder="prix€" value="{$prices['max']}">
                                    <span class="text-euro px-3">€</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="button" class="col-5 mr-1 btn btn-dark btn-clear" id="filter-effacer-btn">Effacer</button>
                            <button type="button" class="col-5 btn btn-primary btn-apply" id="filter-apply-btn">Terminer</button>
                        </div>
                    </div>
                </div>
HTML;
            return $component . $suite;
        }
    }
?>