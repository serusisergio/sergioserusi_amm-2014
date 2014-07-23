<?php

include_once 'Gestore.php';
include_once 'User.php';
include_once 'Cliente.php';
include_once 'Db.php';

/**
 * Classe per la creazione degli utenti del sistema
 */
class UserFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare utenti
     * @return \UserFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserFactory();
        }

        return self::$singleton;
    }

    /**
     * Carica un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return \User|\Gestore|\Cliente
     */
    public function caricaUtente($username, $password) {


        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUser] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        // cerco prima nella tabella dei clienti
        $query = "select * from clienti where username = ? and password = ?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $cliente = self::caricaClienteDaStmt($stmt);
        if (isset($cliente)) {
            // ho trovato un cliente
            $mysqli->close();
            return $cliente;
        }

        // Ricerca gestore
        $query = "select * from gestori where username = ? and password = ?";

        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }

        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }

        $gestore = self::caricaGestoreDaStmt($stmt);
        if (isset($gestore)) {
            $mysqli->close();
            return $gestore;
        }
    }

    /**
     * Restituisce la lista dei clienti presenti nel sistema
     * @return array
     */
    public function &getListaClienti() {
        $clienti = array();
        $query = "SELECT
                  id as clienti_id,
                  nome as clienti_nome,
                  cognome as clienti_cognome,
                  citta as clienti_citta,
                  via as clienti_via,
                  email as clienti_email,
                  numero_civico as clienti_numero_civico,
                  username as clienti_username,
                  password as clienti_password
                  FROM `clienti` ";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaClienti] impossibile inizializzare il database");
            $mysqli->close();
            return $clienti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaClienti] impossibile eseguire la query");
            $mysqli->close();
            return $clienti;
        }
        while ($row = $result->fetch_array()) {
            $clienti[] = self::creaClienteDaArray($row);
        }
        return $clienti;
    }

    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }

        switch ($role) {
            case User::Cliente:
                $query = "select * from clienti where id = ?";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                return self::caricaClienteDaStmt($stmt);
                break;

            case User::Gestore:
                $query = "select * from gestori where id = ?";

                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }

                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[loadUser] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }

                $toRet = self::caricaGestoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;

            default: return null;
        }
    }

    /**
     * Crea un cliente da una riga del db
     * @param type $row
     * @return \cliente
     */
    public function creaClienteDaArray($row) {
        $cliente = new Cliente();
        $cliente->setId($row['clienti_id']);
        $cliente->setNome($row['clienti_nome']);
        $cliente->setCognome($row['clienti_cognome']);
        $cliente->setEmail($row['clienti_email']);
        $cliente->setCitta($row['clienti_citta']);
        $cliente->setVia($row['clienti_via']);
        $cliente->setNumeroCivico($row['clienti_numero_civico']);
        $cliente->setRuolo(User::Cliente);
        $cliente->setUsername($row['clienti_username']);
        $cliente->setPassword($row['clienti_password']);
        return $cliente;
    }

    /**
     * Crea un gestore da riga del db
     * @param type $row
     * @return \Gestore
     */
    public function creaGestoreDaArray($row) {
        $gestore = new Gestore();
        $gestore->setId($row['gestori_id']);
        $gestore->setNome($row['gestori_nome']);
        $gestore->setCognome($row['gestori_cognome']);
        $gestore->setEmail($row['gestori_email']);
        $gestore->setCitta($row['gestori_citta']);
        $gestore->setVia($row['gestori_via']);
        $gestore->setNumeroCivico($row['gestori_numero_civico']);
        $gestore->setRuolo(User::Gestore);
        $gestore->setUsername($row['gestori_username']);
        $gestore->setPassword($row['gestori_password']);
        return $gestore;
    }

    /**
     * Salva i dati relativi ad un utente sul db
     * @param User $user
     * @return il numero di righe modificate
     */
    public function salva(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }

        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            case User::Cliente:
                $count = $this->salvaCliente($user, $stmt);
                break;
            case User::Gestore:
                $count = $this->salvaGestore($user, $stmt);
                break;
        }
        $stmt->close();
        $mysqli->close();
        return $count;
    }

    /**
     * Rende persistenti le modifiche all'anagrafica di un cliente sul db
     * @param Cliente $c il cliente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaCliente(Cliente $c, mysqli_stmt $stmt) {
        $query = " update clienti set
					password = ?,
					nome = ?,
					cognome = ?,
					email = ?,
					numero_civico = ?,
					citta = ?,
					via = ?
					where clienti.id = ?
					";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('ssssissi', $c->getPassword(), $c->getNome(), $c->getCognome(), $c->getEmail(), $c->getNumeroCivico(), $c->getCitta(), $c->getVia(), $c->getId())) {
            error_log("[salvaGestore] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[salvaGestore] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    /**
     * Rende persistenti le modifiche all'anagrafica di un gestore sul db
     * @param Gestore $d il gestore considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaGestore(Gestore $d, mysqli_stmt $stmt) {
        $query = " update gestori set
					password = ?,
					nome = ?,
					cognome = ?,
					email = ?,
					numero_civico = ?,
					citta = ?,
					via = ?
					where gestori.id = ?
					";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaGestore] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }

        if (!$stmt->bind_param('ssssissi', $d->getPassword(), $d->getNome(), $d->getCognome(), $d->getEmail(), $d->getNumeroCivico(), $d->getCitta(), $d->getVia(), $d->getId())) {
            error_log("[salvaGestore] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }

        if (!$stmt->execute()) {
            error_log("[salvaGestore] impossibile" .
                    " eseguire lo statement");
            return 0;
        }

        return $stmt->affected_rows;
    }

    /**
     * Carica un gestore eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaGestoreDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaGestoreDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['gestori_id'], $row['gestori_nome'], $row['gestori_cognome'], $row['gestori_email'], $row['gestori_via'], $row['gestori_numero_civico'], $row['gestori_citta'], $row['gestori_username'], $row['gestori_password']);

        if (!$bind) {
            error_log("[caricaGestoreDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaGestoreDaArray($row);
    }

    /**
     * Carica un cliente eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaClienteDaStmt(mysqli_stmt $stmt) {

        if (!$stmt->execute()) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }

        $row = array();
        $bind = $stmt->bind_result(
                $row['clienti_id'], $row['clienti_nome'], $row['clienti_cognome'], $row['clienti_email'], $row['clienti_via'], $row['clienti_numero_civico'], $row['clienti_citta'], $row['clienti_username'], $row['clienti_password']);
        if (!$bind) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }

        if (!$stmt->fetch()) {
            return null;
        }

        $stmt->close();

        return self::creaClienteDaArray($row);
    }

}
?>


