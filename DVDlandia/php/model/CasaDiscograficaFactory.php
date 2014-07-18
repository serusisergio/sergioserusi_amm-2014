<?php

include_once 'CasaDiscografica.php';
include_once 'Db.php';

class CasaDiscograficaFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
* Restiuisce un singleton per creare la CasaDiscografica
* @return CasaDiscograficaFactory
*/
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CasaDiscograficaFactory();
        }

        return self::$singleton;
    }

    public function &getCasaDiscograficaPerId($id) {
        $casadiscografica = new CasaDiscografica();
        $query = "select * from casediscografiche where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCasaDiscograficaPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $casadiscografica;
        }


        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCasaDiscograficaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $casadiscografica;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getCasaDiscograficaPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $casadiscografica;
        }

        if (!$stmt->execute()) {
            error_log("[getCasaDiscograficaPerId] impossibile" .
                    " eseguire lo statement");
            return $casadiscografica;
        }

        $id = 0;
        $nome = "";

        if (!$stmt->bind_result($id, $nome)) {
            error_log("[getCasaDiscograficaPerId] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $casadiscografica->setId($id);
            $casadiscografica->setNome($nome);
        }
        

        $mysqli->close();
        return $casadiscografica;
    }

    /**
* Restituisce la lista di case discografiche
* @return array|\Costruttore
*/
    public function &getCaseDiscografiche() {

        $casediscografiche = array();
        $query = "select * from casediscografiche";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCaseDiscografiche] impossibile inizializzare il database");
            $mysqli->close();
            return $casediscografiche;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getCaseDiscografiche] impossibile eseguire la query");
            $mysqli->close();
            return $casediscografiche;
        }

        while ($row = $result->fetch_array()) {
            $casediscografiche[] = self::getCaseDiscografiche($row);
        }

        $mysqli->close();
        return $casediscografiche;
    }

    /**
* Crea un oggetto di tipo Costruttore a partire da una riga del DB
* @param type $row
* @return \Costruttore
*/
    private function getCasaDiscografica($row) {
        $casadiscografica = new CasaDiscografica();
        $casadiscografica->setId($row['id']);
        $casadiscografica->setNome($row['nomecasadiscografica']);
        return $casadiscografica;
    }

}

?>
