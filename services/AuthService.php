<?php
    namespace App\services;

    use App\user\classes as classes;

    class AuthService{
        private $sessionService;
        private $IS_CONNECTED_KEY = 'isConnected';
        private $USER_DATA_KEY = 'userData';

        public function __construct(){
            $this->sessionService = SessionService::getInstance();
        }

        public function isUserConnected(): bool{
            return $this->sessionService->exists($this->IS_CONNECTED_KEY) &&
                $this->sessionService->get($this->IS_CONNECTED_KEY);
        }

        public function connectUser(classes\User $user){
            $this->sessionService->set($this->IS_CONNECTED_KEY, true);
            $this->sessionService->set($this->USER_DATA_KEY, $user);
        }

        public function logout(){
            $this->sessionService->delete($this->IS_CONNECTED_KEY);
            $this->sessionService->delete($this->USER_DATA_KEY);
        }

        public function getUserData(){
            if (!$this->isUserConnected())
                return null;
            
            return $this->sessionService->get($this->USER_DATA_KEY);
        }
    }
?>