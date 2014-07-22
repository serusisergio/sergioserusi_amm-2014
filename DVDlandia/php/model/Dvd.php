<?php

/**
 * @author SerusiSergio
 * Classe DVD
 */
class Dvd {

    /**
     * Categoria del film
     * @var categoria
     */
    private $categoria;

    /**
     * Anno in cui è stato girato il film
     * @var int
     */
    private $anno;


    /**
     * Titolo del fim
     * @var String
     */
    private $titolo;
    
    private $prezzo;

    /**
     * Costruttore
     */
    public function __costruct() {
        
    }

    /**
     * restituisce un id unico per il dvd
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Imposta un id unico per il dvd
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

    public function setAnno($anno) {
        $intVal = filter_var($anno, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            if ($intVal > 1769 && $intVal <= date("Y")) {//prima auto al mondo risale al 1769
                $this->anno = $intVal;
                return true;
            }
        }
        return false;
    }

    public function getAnno() {
        return $this->anno;
    }


    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getTitolo() {
        return $this->titolo;
    }

    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }

    public function getPrezzo() {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }

}

?>
