<?php

namespace App\assetsHandle\view;

class AssetsHandlerForm
{
    public static function render($errorMsg, $succesMsg)
    {
        $errorMsgDisplay = '';
        $succesMsgDisplay = '';

        if (!empty($succesMsg))
        {
            $succesMsgDisplay = <<<HTML
            <div class="alert alert-success" role="alert">
                $succesMsg
            </div>
HTML;
        }

        if (!empty($errorMsg))
        {
            $errorMsgDisplay = <<<HTML

            <div class="modal" tabindex="-1" role="dialog" id="errorModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Erreur : saisie invalide </h5>
                        </div>
                        <div class="modal-body">
                            <p> $errorMsg </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Fermer </button>
                        </div>
                    </div>
                </div>
            </div>

HTML;
        }
        return <<<HTML
        $errorMsgDisplay

        <div class="container auth-container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            $succesMsgDisplay
                            <h2 class="card-title text-center"> Insertion des articles </h2>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="itemName"> Le nom de l'article : </label>
                                    <input type="text" name="itemName" id="itemName" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="itemCategory"> Catégorie : </label>
                                    <input type="text" name="itemCategory" id="itemCategory" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="itemImage"> Image de l'article: </label>
                                    <input type="file" name="itemImage" id="itemImage" class="form-control">

                                </div>
                                <div class="form-group">
                                    <label for="itemQuantity"> Quantité : </label>
                                    <input type="number" name="itemQuantity" id="itemQuantity" min="0" step="0.01" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="itemPrice"> Prix de l'article : </label>
                                    <input type="number" name="itemPrice" id="itemPrice" min="0" step="0.01" class="form-control">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary"> Ajouter l'article </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }
}