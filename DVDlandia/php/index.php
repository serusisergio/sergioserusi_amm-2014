<?php
include_once 'controller/BaseController.php';
include_once 'controller/ClienteController.php';
include_once 'controller/GestoreController.php';

date_default_timezone_set("Europe/Rome");
// punto unico di accesso all'applicazione
FrontController::dispatch($_REQUEST);

/**
* Classe che controlla il punto unico di accesso all'applicazione
* @author Davide Spano
*/
class FrontController {

    /**
* Gestore delle richieste al punto unico di accesso all'applicazione
* @param array $request i parametri della richiesta
*/
    public static function dispatch(&$request) {
        // inizializziamo la sessione
        session_start();
        if (isset($request["page"])) {

            switch ($request["page"]) {
                case "login":
                	echo "Stampa da dentro Switch case login";
                    // la pagina di login e' accessibile a tutti,
                    // la facciamo gestire al BaseController
                    $controller = new BaseController();
                    $controller->handleInput($request);
                    break;

                // studente
                case 'cliente':
               		echo "Stampa da dentro Switch case cliente";
                    // la pagina degli studenti e' accessibile solo agli studenti
                    // agli studenti ed agli amminstratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new ClienteController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Cliente) {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;

                // docente
                case 'gestore':
                	echo "Stampa da dentro Switch case gestore";
                    // la pagina dei docenti e' accessibile solo
                    // ai docenti ed agli amminstratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new GestoreController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Gestore) {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;

                default:
                	echo "Stampa da dentro Switch dafault";
                    self::write404();
                    break;
            }
        } else {
        	echo "Stampa da dentro else()pagina non esistente";
            self::write404();
        }
    }

    /**
* Crea una pagina di errore quando il path specificato non esiste
*/
    public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');
        exit();
    }

    /**
* Crea una pagina di errore quando l'utente non ha i privilegi
* per accedere alla pagina
*/
    public static function write403() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('error.php');
        exit();
    }

}

?>
