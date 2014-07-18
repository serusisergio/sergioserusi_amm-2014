<?php

include_once 'CasaDiscografica.php';
include_once 'CasaDiscograficaFactory.php';
include_once 'Categoria.php';
include_once 'Db.php';

class CategoriaFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
* Restiuisce un singleton per creare Categorie
* @return ModelloFactory
*/
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CategoriaFactory();
        }

        return self::$singleton;
    }

    /**
* Restituisce la categoria che ha l'identificatore passato
* @param int $id
* @return \Categoria
*/
    public function &getCategoriaPerId($id) {
        $categoria = new Categoria();
        $query = "select * from categorie where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCategoriaPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $categoria;
        }


        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCategoriaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $categoria;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getcategoriaPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $categoria;
        }

        if (!$stmt->execute()) {
            error_log("[getCategoriaPerId] impossibile" .
                    " eseguire lo statement");
            return $categoria;
        }

        $id = 0;
        $nomecategoria = "";
        $idcasadiscografica = 0;
        $prezzo = 0;

        if (!$stmt->bind_result($id, $nomecategoria, $idcasadiscografica, $prezzo)) {
            error_log("[getCategoriaPerId] impossibile" .
                    " effettuare il binding in output");
            return $categoria;
        }
        while ($stmt->fetch()) {
            $categoria->setId($id);
            $categoria->setNome($nomecategoria);
            $categoria->setCasaDiscografica(CasaDiscograficaFactory::instance()->getCasaDiscograficaPerId($idcasadiscografica));
            $categoria->setPrezzo($prezzo);
        }


        $mysqli->close();
        return $categoria;
    }

    /**
* Restituisce la lista delle categorie di film
* @return array|\Categoria
*/
    public function &getCategorie() {

        $categorie = array();
        $query = "select * from categorie";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getcategorie] impossibile inizializzare il database");
            $mysqli->close();
            return $categorie;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getCategorie] impossibile eseguire la query");
            $mysqli->close();
            return $categorie;
        }

        while ($row = $result->fetch_array()) {
            $categorie[] = self::getCategoria($row);
        }

        $mysqli->close();
        return $categorie;
    }

    /**
* Crea un oggetto di tipo Categoria a partire da una riga del DB
* @param type $row
* @return \Categoria
*/
    private function getCategoria($row) {
        $categoria = new Categoria();
        $categoria->setId($row['id']);
        $categoria->setNome($row['nomecategoria']);
        $categoria->setCasaDiscografica(CostruttoreFactory::instance()->getCasaDiscograficaPerId($row['idcasadiscografica']));
        $categoria->setPrezzo($row['prezzo']);
        return $categoria;
    }

}

?>
