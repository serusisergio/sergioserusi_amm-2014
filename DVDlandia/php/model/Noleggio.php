<?php

/**
*classe noleggio film
*/

class Noleggio {
    
    private $datainizio;    
    private $datafine;     
    private $id;    
    private $cliente;    
    private $dvd;    
    private $costoPrenot;

  

    public function getDvd() {
        return $this->dvd;
    }

    public function setDvd($idDvd) {
        $this->dvd = $idDvd;
    }   
   
   
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($idCliente) {
        $this->cliente = $idCliente;
    }


    public function getDatainizio() {
        return $this->datainizio;
    }

    public function setDatainizio($datainizio) {
        $this->datainizio = $datainizio;
    }

    public function getDatafine() {
        return $this->datafine;
    }

    public function setDatafine($datafine) {
        $this->datafine = $datafine;
    }

    public function getCosto() {
        return $this->costoPrenot;
    }

    public function setCosto($costo) {
        $this->costoPrenot = $costo;
    }

    
}

?>
