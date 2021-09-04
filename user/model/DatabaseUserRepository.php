<?php

namespace App\user\model;

use App\user\classes as classes;
use App\services as serv;

class DatabaseUserRepository implements UserRepository
{
    private $dbService;

    private static $nomTable = 'utilisateur';
    
    public function __construct(){
        try
        {
            $this->dbService = serv\DatabaseService::getInstance();
        }
        catch (\Exception $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    public function addUser(classes\User $user, string $username, string $password): bool{
        try
        {
            $query = 'insert into ' . self::$nomTable . '(Unom, Uprenom, Uemail, UmotDePasse, Urole)'.'values(?, ?, ?, ?, ?)';
            $req = $this->dbService->prepare($query);
            $req->execute([
                $user->getNom(),
                $user->getPrenom(),
                $username,
                $password,
                'user'
            ]);
            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function getUser(string $username, string $password): ?classes\User {
        $query = 'select * from ' . self::$nomTable . ' where Uemail = ?';
        $options = [$username];

        $req = $this->dbService->prepare($query);
        $req->execute($options);

        $userData = $req->fetch();

        if (!$userData)
            return null;

        if ($userData['Urole'] === 'admin')
        {
            if (strcmp($password, $userData['UmotDePasse']) !== 0)
            {
                return null; 
            }
        }
        else
        {
            if (!password_verify($password, $userData['UmotDePasse']))
                return null;
        }

        $user = new classes\User($userData['Unom'], $userData['Uprenom'], $username);

        if ($userData['Urole'] === 'admin')
            $user->asAdmin();

        return $user;
    }

    public function getUsers(): array{
        $query = 'select * from ' . self::$nomTable;

        $req = $this->dbService->prepare($query);
        $usersData = $req->fetchAll();
        
        
        if (!$usersData)
            return [];
        
        $usersArr = [];
        foreach ($usersData as $userData)
        {
            $usersArr[] = new classes\User($userData['Unom'], $userData['Uprenom'], $userData['Uemail']);
        }

        return $usersArr;
    }
}