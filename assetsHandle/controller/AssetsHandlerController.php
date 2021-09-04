<?php

namespace App\assetsHandle\controller;

use App\assetsHandle\view as av;
use App\listItem\model as imdl;

class AssetsHandlerController
{

    private $listItemRepo;

    public function __construct(imdl\ListItemRepository $listItemRepo)
    {
        $this->listItemRepo = $listItemRepo;
    }

    public function action()
    {
        $error = $this->checkFields();

        $sucess = '';

        if ($error === '')
        {
            $imageFullName = $_FILES['itemImage']['name']; 

            if (!$this->uplodadFile($_FILES['itemImage']['tmp_name'], 'assets/items', $imageFullName))
                $error = 'Erreur lors du chargement de l\'image de l\'article.
                 <br>Vérifiez bien que cet article n\'est pas déjà enregistré.';
            else
            {
                $query = 'insert into articles(nom, categorie, image, quantite, prix) values (?, ?, ?, ?, ?)';
                try
                {
                    $this->listItemRepo->addItem($query, [
                        $_POST['itemName'],
                        $_POST['itemCategory'],
                        $imageFullName,
                        $_POST['itemQuantity'],
                        $_POST['itemPrice']
                    ]);

                    $sucess = 'L\'ajout de l\'article ' . $_POST['itemName'] . ' est terminé avec succès';
                }
                catch (\Exception $e)
                {
                    $error = $e->getMessage();
                }
            }
        }

        return av\AssetsHandlerForm::render($error, $sucess);
    }

    private function checkFields()
    {
        $msg = '';


        if (!$this->isAllSet())
            return false;

        if (empty($_POST['itemName']))
        {
            $msg = $msg . '<br>- Le nom de l\'article';
        }

        if (empty($_POST['itemCategory']))
        {
            $msg = $msg . '<br>- Le nom de la catégorie';
        }
        $fileType = $_FILES['itemImage']['type'];
        $fileError = $_FILES['itemImage']['error'];
        if (($fileError != 0) || (strpos($fileType, 'image') === false))
            $msg = $msg . '<br>- L\'image de l\'article';


        if (empty($_POST['itemQuantity']))
        {
            $msg = $msg . '<br>- La quantité de l\'article';
        }

        if (empty($_POST['itemPrice']))
        {
            $msg = $msg . '<br>- Le prix de l\'article';

        }

        if ($msg !== '')
            $msg = "Les champs suivants sont invalide : " . $msg;

        return $msg;
    }

    private function isAllSet()
    {
        $isSetNom=isset($_POST['itemName']);
        $isSetCategorie=isset($_POST['itemCategory']);
        $isSetImage=isset($_FILES['itemImage']);
        $isSetQuantite=isset($_POST['itemQuantity']);
        $isSetPrix=isset($_POST['itemPrice']);

        return $isSetNom && $isSetCategorie && $isSetImage && $isSetQuantite && $isSetPrix;
    }

    private function uplodadFile($src, $dir, $fileName)
    {
        $files = glob($dir. '/*');
       
        $fullFileName = $dir .'/' . $fileName;
        foreach ($files as $file)
        {
            if (strcmp($file, $fullFileName) === 0)
                return true;
        }
        return move_uploaded_file($src, $fullFileName);
    }
}


?>