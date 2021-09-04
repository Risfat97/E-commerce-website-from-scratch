<?php

namespace App\user\controller;

use App\user\view as uv;
use App\services as auth;
use App\user\model as mdl;
use App\user\classes as classes;

class LoginController
{
    private $usersRepo;

    public function __construct(mdl\UserRepository $usersRepo)
    {
        $this->usersRepo = $usersRepo;
    }

    public function action()
    {
        $authService = new auth\AuthService();
        if ($authService->isUserConnected())
        {
            $this->gotoItems();
        }
        $error = $this->generateError();

        $ok = ($error === '') && isset($_POST['username']) && isset($_POST['password']);
        if ($ok)
        {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $user = $this->usersRepo->getUser($username, $password);
            if (is_null($user))
            {
                $error = "Utilisateur introuvable ou mot de passe incorrect !!!";
            }
            else
            {
                $authService->connectUser($user);
                $this->gotoItems();
            }
        }
        return uv\LoginForm::render($error);
    }

    private function generateError()
    {
        $msg = '';
        if ($this->checkField('username') === false)
        {
            $msg = "Le nom d'utilisateur n'est pas renseigné";
        }

        if ($this->checkField('password') === false)
        {
            $msg = $msg . '<br> Merci de saisir le mot de passe';
        }

        return $msg;
    }

    private function checkField($fieldName)
    {
        return (isset($_POST[$fieldName]) && ($_POST[$fieldName] !== '')) || (!isset($_POST[$fieldName]));
    }

    private function gotoItems()
    {
        header('Location:index.php');
        die();
    }
}