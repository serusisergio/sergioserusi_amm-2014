<?php

/**
* Classe che contiene una lista di variabili di configurazione
*
* @author Davide Spano
*/
class Settings {

    // variabili di accesso per il database
    public static $db_host = 'localhost';
    public static $db_user = 'serusiSergio';
    public static $db_password = 'pernice272';
    public static $db_name='amm14_serusiSergio';
    
    private static $appPath;

    /**
* Restituisce il path relativo nel server corrente dell'applicazione
* Lo uso perche' la mia configurazione locale e' ovviamente diversa da quella
* pubblica. Gestisco il problema una volta per tutte in questo script
*/
    public static function getApplicationPath() {
        if (!isset(self::$appPath)) {
            // restituisce il server corrente
            switch ($_SERVER['HTTP_HOST']) {
                case 'localhost':
                    // configurazione locale
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/sergioserusi_amm-2014/DVDlandia/';
                    break;
                case 'spano.sc.unica.it':
                    // configurazione pubblica
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/amm2014/serusiSergio/DVDlandia/';
                    break;

                default:
                    self::$appPath = '';
                    break;
            }
        }
        
        return self::$appPath;
    }

}

?>
