<?php

class User {

    public $id;
    public $login;
    public $sault;
    public $role_id;
    public $password_hash;
    public $data;

    function __construct() {
        $this->sault = bin2hex($this->sault);
        $this->password_hash = bin2hex($this->password_hash);
        $this->data = json_decode($this->data);
    }
}

?>