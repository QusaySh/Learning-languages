<?php

define("SESSIONS_PATH", __DIR__ . DIRECTORY_SEPARATOR . "sessions");

define("DOMAIN", $_SERVER['HTTP_HOST']);

class Sessions extends SessionHandler{
    
    private $sessionName        = "Learn";
    private $sessionMaxLive     = 0;
    private $sessionSSL         = false;
    private $sessionHTTPOnly    = true;
    private $sessionPath        = "/";
    private $sessionDomain      = DOMAIN;
    private $sessionSavePath    = SESSIONS_PATH;
    private $sessionTimeEnd     = 1;
    
    public function __construct() {
        ini_set('session.use_cookie', 1);
        ini_set('session.use_only_cookie', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');
        session_name($this->sessionName);
        session_save_path($this->sessionSavePath);
        session_set_cookie_params($this->sessionMaxLive, $this->sessionPath, $this->sessionDomain,
                                  $this->sessionSSL, $this->sessionHTTPOnly);
        session_set_save_handler($this, true);
    }
    
    public function __get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }
    
    public function __isset($name) {
         return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }
    
    public function __set($name, $value) {
        $_SESSION[$name] = $value;        
    }
    
    public function read($session_id) {
        return base64_decode(parent::read($session_id));
    }
    
    public function write($session_id, $session_data) {
        return parent::write($session_id, base64_encode($session_data));
    }       
    
    private function startTime() {
        if ( !isset($this->startTime) ) {
            $this->startTime = time();
        }
        return true;
    }
    
    private function renewSession() {
        $this->startTime = time();
        return session_regenerate_id(true);
    }
    
    private function checkValid() {
        if ( (time() - $this->startTime ) > ($this->sessionTimeEnd * 60) ) {
            $this->renewSession();
        }
    }
    
    public function start(){
        if ( session_id() === '' ) {
            if ( session_start() ) {
                $this->startTime();
                $this->checkValid();
            }
        }
    }
    
    public function kill($name = null){
        session_unset();
        if ( $name === null ) {
            setcookie(
               $this->sessionName, '', time() - 1000,
               $this->sessionPath, $this->sessionDomain,
               $this->sessionSSL, $this->sessionHTTPOnly
           );
        }
        session_destroy();
    }
    
}