<?php

include_once 'Db.php';
include_once 'Dvd.php';
include_once 'CategoriaFactory.php';
include_once 'NoleggioFactory.php';

class DvdFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
* Restiuisce un singleton per creare i film
* @return \VeicoloFactory
*/
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new DvdFactory();
        }

        return self::$singleton;
    }

    /**
* restituisce i film presenti
* @return array|\Dvd
*/
    public function &getDvdi() {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getDvdi] impossibile inizializzare il database");
            return array();
        }

        $query = "SELECT * from dvdi";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getDvdi] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return array();
        }

        $toRet = self::inizializzaListaDvdi($stmt);
        $mysqli->close();
        return $toRet;
    }

    /**
* riempie una lista di dvd con una query variabile
* @param mysqli_stmt $stmt
* @return array|\Dvd
*/
    private function &inizializzaListaDvdi(mysqli_stmt $stmt) {
        $veicoli = array();

        if (!$stmt->execute()) {
            error_log("[inizializzaListaDvd] impossibile" .
                    " eseguire lo statement");
            return $dvdi;
        }

        $id = 0;
        $idcategoria = 0;
        $anno = 0;
        $titolo = "";



        if (!$stmt->bind_result($id, $idcategoria, $anno, $titolo)) {
            error_log("[inizializzaListaDvd] impossibile" .
                    " effettuare il binding in output");
            return array();
        }
        while ($stmt->fetch()) {
            $dvd = new Dvd();
            $dvd->setId($id);
            $dvd->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($idcategoria));
            $dvd->setAnno($anno);
            $dvd->setTitolo($titolo);
            $dvd->setIsPrenotabile(NoleggioFactory::instance()->isDvdPrenotabile($id, "now"));
            $dvdi[] = $dvd;
        }
        return $dvdi;
    }

    public function creaDvdDaArray($row) {
        $dvd = new Dvd();
        $dvd->setId($row['dvdi_id']);
        $dvd->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($row['dvdi_idcategoria']));
        $dvd->setAnno($row['dvdi_anno']);
        $dvd->setTitolo($row['dvdi_titolo']);
        $dvd->setIsPrenotabile(NoleggioFactory::instance()->isDvdPrenotabile($row['dvd_id'], "now"));
        return $dvd;
    }
    
    /**
* Salva il film nel DB
* @param Dvd $dvd
* @return true se è stato salvato
*/
    public function nuovo($dvd) {
        $query = "insert into dvdi (idcategoria, anno, titolo)
values (?, ?, ?)";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[nuovo] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[nuovo] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('iis', $dvd->getCategoria()->getId(), $dvd->getAnno(), $dvd->getTitolo())){
        error_log("[nuovo] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[nuovo] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
* Cancella il film con per un id specifico
* @param int $id
* @return true se è stato cancellato
*/
    public function cancellaPerId($id) {
        $query = "delete from dvdi where id = ?";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cancellaPerId] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cancellaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('i', $id)){
        error_log("[cancellaPerId] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[cancellaPerId] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
* Dato un id viene restituito il film
* @param int $id Identificatore
* @return \Dvd
*/
    public function &getDvdPerId($id){
        $dvd = new Dvd();
        $query = "select * from dvdi where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getDvdPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $dvd;
        }


        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getDvdPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $dvd;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getDvdPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $dvd;
        }

        if (!$stmt->execute()) {
            error_log("[getDvdPerId] impossibile" .
                    " eseguire lo statement");
            return $dvd;
        }

        $id = 0;
        $idcategoria = 0;
        $anno = 0;
        $titolo = "";

        if (!$stmt->bind_result($id, $idcategoria, $anno, $titolo)) {
            error_log("[getDvdPerId] impossibile" .
                    " effettuare il binding in output");
            return $dvd;
        }
        while ($stmt->fetch()) {
            $dvd->setId($id);
            $dvd->setAnno($anno);
            $dvd->setTitolo($titolo);
            $dvd->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($idcategoria));
            $dvd->setIsPrenotabile(NoleggioFactory::instance()->isDvdPrenotabile($id, "now"));
          }


        $mysqli->close();
        return $dvd;
    }
}

?>
