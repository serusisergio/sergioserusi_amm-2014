<?php

include_once 'User.php';

/**
* @author SergioSerusi
* Classe rappresetnate Gestore
*/
class Gestore extends User {

    /**
* Costruttore
*/
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Gestore);
    }

}

?>
