<?php

include_once 'User.php';

/**
* @author SerusiSergio
* Classe rappresentante il cliente
*/
class Cliente extends User {

    /**
* Costruttore
*/
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Cliente);
        
    }

}

?>


