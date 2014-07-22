<?php

/**
* Classe CasaDiscografica
* Considero la classe CasaDiscografica come se fosse una "specie" di etichetta, si lega con la categoria di film.
* quindi una CasaDiscografica crea determinate categorie di film
*/
class CasaDiscografica {
    
    private $id;
    
    private $nome;
    
    public function setId($id){
        $this->id=$id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setNome($nome){
        $this->nome=$nome;
    }
    
    public function getNome(){
        return $this->nome;
    }
}

?>
