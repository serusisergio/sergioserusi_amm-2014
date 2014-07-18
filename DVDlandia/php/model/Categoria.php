<?php

/**
* @author SerusiSergio
* Classe Categoria di film
*/

class Categoria {
    /**
* Identificatore unico del veicolo
* @var int
*/
    private $id;

    /**
* Nome della casa discografica
* @var CasaDiscografica
*/
    private $costruttore;

    /**
* Nome della cattegoria di film
* @var String
*/
    private $nome;

    
    /**
* Prezzo
* @var double
*/
    private $prezzo;
    
    /**
* Restituisce identificatore unico per la classe
* @return int
*/
    public function getId() {
        return $this->id;
    }

    /**
* Imposta un identificatore unico pe la classe
* @param int $id
* @return boolean true se il valore e' stato aggiornato correttamente,
* false altrimenti
*/
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id = $intVal;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setCasaDiscografica($casadiscografica) {
        $this->casadiscografica = $casadiscografica;
        return true;
    }

    public function getCasaDiscografica() {
        return $this->casadiscografica;
    }


    
    public function getPrezzo() {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }


}

?>
