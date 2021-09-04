<?php

namespace App\user\controller;

use App\user\view as uv;
use App\user\model as mdl;
use App\user\classes as classes;
use App\services as srv;

class SigninController
{
    private $usersRepo;
    private $authService;

    public function __construct(mdl\UserRepository $usersRepo, srv\AuthService $authService){
        $this->usersRepo = $usersRepo;
        $this->authService = $authService;
    }

    public function action(){
        if ($this->authService->isUserConnected()){
            $this->gotoItems();
        }

        $errors = [
            'lastName' => false,
            'firstName' => false,
            'username' => false,
            'password' => false,
            'error' => false
        ];
        $values = [
            'lastName' => '',
            'firstName' => '',
            'username' => '',
        ];
        $ok = true;

        if($this->isFormFieldsFulfilled()){
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            if (!$this->validateName($nom)){
                $errors['lastName'] = true;
                $ok = false;
            }
            if (!$this->validateName($prenom)){
                $errors['firstName'] = true;
                $ok = false;
            }
            if (!$this->validateUsername($username)){
                    $errors['username'] = true;
                    $ok = false;
            }
            if (!$this->validatePassword($password)){
                $errors['password'] = true;
                $ok = false;
            }
            if($ok){
                $user = new classes\User($nom, $prenom, $username);
                $password = $this->crypterMotDePasse($password);
                if($this->usersRepo->addUser($user, $username, $password)){
                    $this->authService->connectUser($user);
                    $this->gotoItems();
                } else
                    $errors['error'] = true;
            } else{
                $values['lastName'] = $nom;
                $values['firstName'] = $prenom;
                $values['username'] = $username;
                return uv\SigninForm::render($errors, $values);
            }
        }
        return uv\SigninForm::render($errors, $values);
    }

    private function isFormFieldsFulfilled(){
        return isset($_POST['nom'], $_POST['prenom'], $_POST['username'], $_POST['password'])
            && ($_POST['nom'] !== '')
            && ($_POST['prenom'] !== '')
            && ($_POST['username'] !== '')
            && ($_POST['password'] !== '');
    }

    private function gotoItems(){
        header('Location: index.php');
        exit();
    }
    
    private function validateName($name){
        $namePattern = "/[A-Za-z]{2,}/";
        return preg_match($namePattern, $name);
    }

    private function validatePassword($password){
        return strlen($password) >= 6;
    }

    private function validateUsername($username){
        $emailPattern = "/[a-z][_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z]+(\.[a-z]{2,})/";
        return preg_match($emailPattern, $username);
    }

    private function crypterMotDePasse($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
}