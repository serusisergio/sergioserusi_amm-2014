<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/Dvd.php';
include_once basename(__DIR__) . '/../model/DvdFactory.php';

/**
 * Controller gestore
 * @author Davide Spano
 */
class GestoreController extends BaseController {

    const elenco = 'elenco';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente.
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {

        // creo il descrittore della vista
        $vd = new ViewDescriptor();

        // imposto la pagina
        $vd->setPagina($request['page']);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);

            // verifico quale sia la sottopagina della categoria
            // Dipendete da servire ed imposto il descrittore
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        break;

                    //visualizza elenco noleggi
                    case 'noleggi':
                        $dvdi = DvdFactory::instance()->getDvdi();
                        $clienti = UserFactory::instance()->getListaClienti();
                        $vd->setSottoPagina('noleggi');

                        $vd->addScript("../js/jquery-2.1.1.min.js");
                        $vd->addScript("../js/elencoNoleggi.js");
                        break;

                    // gestione della richiesta ajax di filtro noleggi
                    case 'filtra_noleggi':
                        $vd->toggleJson();
                        $vd->setSottoPagina('noleggi_json');
                        $errori = array();

                        if (isset($request['dvd']) && ($request['dvd'] != '')) {
                            $dvd_id = filter_var($request['dvd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($dvd_id == null) {
                                $errori['dvd'] = "Specificare un identificatore valido";
                            }
                        } else {
                            $dvd_id = null;
                        }

                        if (isset($request['cliente']) && ($request['cliente'] != '')) {
                            $cliente_id = filter_var($request['cliente'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if ($cliente_id == null) {
                                $errori['cliente'] = "Specificare una matricola valida";
                            }
                        } else {
                            $cliente_id = null;
                        }

                        if (isset($request['datainizio'])) {
                            $datainizio = $request['datainizio'];
                        } else {
                            $datainizio = null;
                        }

                        if (isset($request['datafine'])) {
                            $datafine = $request['datafine'];
                        } else {
                            $datafine = null;
                        }

                        $noleggi = NoleggioFactory::instance()->ricercaNoleggi(
                                $user, $dvd_id, $cliente_id, $datainizio, $datafine);


                        break;

                    //visual film
                    case 'film':
                        $dvdi = DvdFactory::instance()->getDvdi();
                        //var_dump($dvdi);
                        $vd->setSottoPagina('elencoFilm');
                        break;



                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }


            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;

                    // cambio email
                    case 'email':
                        // in questo array inserisco i messaggi di
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // aggiornamento indirizzo
                    case 'indirizzo':

                        // in questo array inserisco i messaggi di
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;

                    // modifica della password
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;


                    // l'utente non vuole modificare l'appello selezionato
                    case 'dvdi_annulla':
                        $vd->setSottoPagina('elencoFilm');
                        $this->showHomeUtente($vd);
                        break;


                    //form per la creazione di un dvd
                    case 'new_dvd':
                        $categorie = CategoriaFactory::instance()->getCategorie();
                        $vd->setSottoPagina('crea_dvd');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo film
                    case 'dvd_nuovo':
                        $vd->setSottoPagina('elencoFilm');
                        $msg = array();
                        $nuovo = new Dvd();
                        $nuovo->setId(-1);
                        $nuovo->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($request['categoria']));

                        if ($request['anno'] != "") {
                            $nuovo->setAnno($request['anno']);
                        } else {
                            $msg[] = '<li> Inserire un anno valido </li>';
                        }
                        if ($request['titolo'] != "") {
                            $nuovo->setTitolo($request['titolo']);
                        } else {
                            $msg[] = '<li> Inserire una titolo valido </li>';
                        }

                        if (count($msg) == 0) {
                            $vd->setSottoPagina('elencoFilm');
                            if (DvdFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile creare il film </li>';
                            }
                        }

                        $this->creaFeedbackUtente($msg, $vd, "Film creato");

                        $dvd = DvdFactory::instance()->getDvdi();
                        $this->showHomeUtente($vd);
                        break;

                    // cancella un film
                    case 'cancella_dvd':
                        if (isset($request['dvd'])) {
                            $intVal = filter_var($request['dvd'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {

                                if (DvdFactory::instance()->cancellaPerId($intVal) != 1) {
                                    $msg[] = '<li> Impossibile cancellare il film </li>';
                                }


                                $this->creaFeedbackUtente($msg, $vd, "Film eliminato");
                            }
                        }
                        $dvd = DvdFactory::instance()->getDvdi();
                        $this->showHomeUtente($vd);
                        break;

                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare
                // la vista
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }


        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

    /**
     * Aggiorna i dati relativi ad un appello in base ai parametri specificati
     * dall'utente
     * @param Appello $mod_appello l'appello da modificare
     * @param array $request la richiesta da gestire
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function updateAppello($mod_appello, &$request, &$msg) {
        if (isset($request['insegnamento'])) {
            $insegnamento = InsegnamentoFactory::instance()->creaInsegnamentoDaCodice($request['insegnamento']);
            if (isset($insegnamento)) {
                $mod_appello->setInsegnamento($insegnamento);
            } else {
                $msg[] = "<li>Insegnamento non trovato</li>";
            }
        }
        if (isset($request['data'])) {
            $data = DateTime::createFromFormat("d/m/Y", $request['data']);
            if (isset($data) && $data != false) {
                $mod_appello->setData($data);
            } else {
                $msg[] = "<li>La data specificata non &egrave; corretta</li>";
            }
        }
        if (isset($request['posti'])) {
            if (!$mod_appello->setCapienza($request['posti'])) {
                $msg[] = "<li>La capienza specificata non &egrave; corretta</li>";
            }
        }
    }

    /**
     * Ricerca un apperllo per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $appelli un array di appelli
     * @return Appello l'appello con l'id specificato se presente nella lista,
     * null altrimenti
     */
    private function cercaAppelloPerId($id, &$appelli) {
        foreach ($appelli as $appello) {
            if ($appello->getId() == $id) {
                return $appello;
            }
        }

        return null;
    }

    /**
     * Calcola l'id per un nuovo appello
     * @param array $appelli una lista di appelli
     * @return int il prossimo id degli appelli
     */
    private function prossimoIdAppelli(&$appelli) {
        $max = -1;
        foreach ($appelli as $a) {
            if ($a->getId() > $max) {
                $max = $a->getId();
            }
        }
        return $max + 1;
    }

    /**
     * Restituisce il prossimo id per gli elenchi degli esami
     * @param array $elenco un elenco di esami
     * @return int il prossimo identificatore
     */
    private function prossimoIndiceElencoListe(&$elenco) {
        if (!isset($elenco)) {
            return 0;
        }

        if (count($elenco) == 0) {
            return 0;
        }

        return max(array_keys($elenco)) + 1;
    }

    /**
     * Restituisce l'identificatore dell'elenco specificato in una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array per inserire eventuali messaggi d'errore
     * @return l'identificatore dell'elenco selezionato
     */
    private function getIdElenco(&$request, &$msg) {
        if (!isset($request['elenco'])) {
            $msg[] = "<li> Non &egrave; stato selezionato un elenco</li>";
        } else {
            // recuperiamo l'elenco dalla sessione
            $elenco_id = filter_var($request['elenco'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (!isset($elenco_id) || !array_key_exists($elenco_id, $_SESSION[self::elenco])
                    || $elenco_id < 0) {
                $msg[] = "L'elenco selezionato non &egrave; corretto</li>";
                return null;
            }
            return $elenco_id;
        }
        return null;
    }

    /**
     * Restituisce l'appello specificato dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Appello l'appello selezionato, null se non e' stato trovato
     */
    private function getAppello(&$request, &$msg) {
        if (isset($request['appello'])) {
            $appello_id = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $appello = AppelloFactory::instance()->cercaAppelloPerId($appello_id);
            if ($appello == null) {
                $msg[] = "L'appello selezionato non &egrave; corretto</li>";
            }
            return $appello;
        } else {
            return null;
        }
    }

}

?>
