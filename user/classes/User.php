<?php

namespace App\user\classes;


class User
{
    private $nom;
    private $prenom;
    private $email;
    private $role;

    public function __construct(string $nom, string $prenom, string $email)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = 'user';
    }

    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }

    public function getNomComplet() { return $this->prenom . " " . $this->nom; }

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function asAdmin(){
        $this->role = 'admin';
    }


}