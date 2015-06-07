# Syncbook
![Syncbook Logo](http://i.imgur.com/oONGOVT.png "Syncbook Logo")

## Indice

## Introduzione

Per molti anni le persone che utilizzano le Rubriche per scopi che vanno al di fuori del comune uso quotidiano si sono chieste se fosse possibile avere un mezzo attraverso il quale poter gestire la propria lista di contatti attraverso qualunque piattaforma.

Fino ad ora la risposta a questa domanda è sempre stata negativa a causa del desiderio delle grandi aziende che, con lo scopo di fare sempre più soldi, rendono quasi impossibile la sincronizzazione dei contatti tra dispositivi diversi tra loro.

###### vCard
Il formato più utilizzato per rappresentare un contatto sotto forma digitale è tuttora la vCard.
Giunta alla sua quarta versione lo Standard di rappresentazione dei dati presenti all'interno di questo mezzo elettronico è descritto all'interno dell'[RFC 6350](http://tools.ietf.org/html/rfc6350) è per quasi impossibile trovare online un file che rispetti le regole che vengono descritte.

###### CardDAV
Il protocollo più utilizzato per sincronizzare i contatti all'interno del Web è tuttora il CardDAV.
Essendo basato sulla sintassi specifica delle vCard, CardDAV permette un semplice scambio di informazioni tra Server e Client durante tutte le operazioni di creazione, modifica ed eliminazione di un file vCard.

## Problema

###### Dati da salvare
```
Jhon Smith
smith.jhon@gmail.com
+44 20 1234 5678
1 Trafalgar Square, WC2N London, United Kingdom
Web: http://jhonsmith.com
Skype: jhon.smith
Twitter: @jhonsmith
```

###### Dati salvati secondo Standard
```
BEGIN:VCARD
VERSION:4.0
N:Smith;Jhon;;;
FN:Jhon Smith
EMAIL;TYPE=HOME;PREF=1:smith.jhon@gmail.com
TEL;TYPE="CELL,HOME";PREF=1:tel:+44 20 1234 5678
ADR;TYPE=HOME;PREF=1:;;1 Trafalgar Square;London;;WC2N;United Kingdom
URL;TYPE=HOME;PREF=1:http://jhonsmith.com
IMPP;TYPE=HOME;PREF=1:SKYPE:jhon.smith
X-SOCIALPROFILE;TYPE=HOME;PREF=1:TWITTER:http://twitter.com/jhonsmith
END:VCARD
```

Per quanto strano possa sembrare, nonostante la loro quarta versione, le vCard non supportano quelli che sono oramai diventati degli strumenti alla base delle società moderna: i Social Network.

Questi campi sono vengono quindi descritti come non-standard e vanno rappresentati da una lettera `X`, seguita dal simbolo `-` e dal nome del campo. I campi così definiti possono non essere supportati da tutte le applicazioni attraverso le quali viene poi data la possibilità all'utente di gestire la propria rubrica.

###### Dati salvati in Apple Contacts
```
BEGIN:VCARD
VERSION:3.0
N:Smith;Jhon;;;
FN:Jhon Smith
EMAIL;type=INTERNET;type=HOME;type=pref:smith.jhon@gmail.com
TEL;type=CELL;type=VOICE;type=pref:+44 20 1234 5678
ADR;type=HOME;type=pref:;;1 Trafalgar Square;London;;WC2N;United Kingdom
item1.URL;type=pref:http://jhonsmith.com
item1.X-ABLabel:_$!<HomePage>!$_
IMPP;X-SERVICE-TYPE=Skype;type=HOME;type=pref:skype:jhon.smith
X-SOCIALPROFILE;type=twitter:http://twitter.com/jhonsmith
END:VCARD
```

Utilizzando un formato non più supportato nel mondo delle vCard, la Apple riesce a rappresentare una serie di dati in un modo molto differente rispetto al precedente rendendo complessa e laboriosa l'esportazione di questa vCard in un dispositivo non appartenente alla famosa azienda della mela.

Le differenze più evidenti si possono notare nella rappresentazione del campo `URL` che viene ora raggrupato con la proprietà non-standard `X-ABLabel`. Questo metodo viene utilizzato per risolvere il problema di mostrare all'utente un sito web come proprio del contatto che egli sta visualizzando.

###### Dati salvati in Google Contacts
```
BEGIN:VCARD
VERSION:3.0
N:Smith;Jhon;;;
FN:Jhon Smith
EMAIL;TYPE=INTERNET;TYPE=HOME:smith.jhon@gmail.com
TEL;TYPE=CELL:+44 20 1234 5678
ADR;TYPE=HOME:;;1 Trafalgar Square;London;;WC2N;United Kingdom
item1.URL:http\://jhonsmith.com
item1.X-ABLabel:_$!<HomePage>!$_
X-SKYPE:jhon.smith
item2.URL:http\://twitter.com/jhonsmith
item2.X-ABLabel:Twitter
END:VCARD
```

Dato il fatto che Google Contacts non da la possibilità all'utente di salvare all'interno delle informazioni di un contatto quelle riguardanti i Social Network è necessario utilizzare la proprietà `URL` per gestire gli stessi. L'utilizzo di questo metodo di formattazione, unita a degli inutili caratteri di *escape* per rappresentare gli indirizzi *http*, rende impossibile mantenere i medesimi dati in fase di importazione della vCard in un dispositivo che non possieda un sistema operativo Android.

## Finalità del progetto
In seguito a un'analisi approfondita della situazione attuale del non utilizzo degli standard vCard, appare evidente che l'importazione ed esportazione di contatti tra dispositivi diversi non può avvenire, se non in modo incompleto.
(Dato il risultato di questo studio approfondito sui vari esempi di vCard diventa evidente che il motivo per il quale quando si importa un contatto da una tipologia di dispositivo ad un'altra il prodotto finito risulta spesso incompleto o corrotto.)

Per questo motivo si è deciso di sviluppare un progetto per dimostrare come sia possibile utilizzare gli Standard per la formattazione di una vCard e trarne vantaggio durante il processo di gestione di una rubrica.
(Entra quindi in gioco il frutto di ore e ore passate a programmare per poter presentare un progetto che vuole dimostrare come è possibile utilizzare gli Standard per la formattazione di una vCard e trarne vantaggio durante il processo di gestione di una rubrica.)

## Obbiettivi del progetto
Realizzare un'applicazione web che permetta all'utente registrato di creare delle rubriche secondo gli standard delle vCard. L'applicazione dovrà essere in grado di salvare i dati inseriti dall'utente e di metterli a disposizione anche ad altri dispositivi che si interfacciano tramite il protocollo WebDAV. Sarà dunque necessaria la configurazione di un server per sostenere tutte le tipologie di richieste: dal salvataggio dei dati tramite database, alla sicurezza delle comunicazioni client-server.

## Perchè un'applicazione Web?

La scelta di sviluppare un'applicazione web è stata effettuata per diversi motivi. Il primo è legato alla natura della libreria sabre.io: essa infatti è sviluppata totalmente in linguaggio PHP e per questa ragione è sembrato ovvio continuare con questa tecnologia a integrare nuovi servizi e funzionalità. Il secondo motivo ha come centralità la portabilità dell'applicazione: se da un lato sarebbe stato possibile progettare un'applicazione più rivolta al funzionamento lato client, come una applet Java o una app Android, dall'altro si ha riconosciuto che un'applicazione web avrebbe avuto un maggior bacino di utenza rispetto alle altre alternative. Questo perché un'applicazione web non ha bisogno di essere installata fisicamente nel dispositivo (e quindi essere anche vincolata al software del sistema operativo ospitante), in più gli ultimi layout grafici responsive permettono la visualizzazione delle stessa pagina in modo efficiente su un range di dispositivi molto più ampio rispetto agli anni passati.

## Strumenti

### HUGE
Per realizzare le funzionalità di "log-in" e gestione degli utenti è stato necessario scegliere un framework PHP che implementasse già queste funzioni in modo da concentrare lo sviluppo su quello che effettivamente veniva richiesto dagli obbiettivi del progetto. Per questo motivo la scelta è ricaduta su "HUGE".
A differenza di altri famosi framework PHP, come ad esempio Symfony, HUGE è una soluzione più semplice: sia a livello di comprensione del codice, che a livello di struttura e usabilità. 
HUGE è l'ultima versione di una serie di progetti PHP sviluppati da *panique* che hanno come finalità quella di fornire un container per la fase di avvio di nuove applicazioni, cioè preparare degli strumenti funzionanti "out of the box" in grado di assolvere i compiti essenziali di un'applicazione web: quindi gestione degli utenti (registrazione, log-in, gestione dei dati utente) e motore grafico.
Alcune delle funzioni più importanti sono:
* gli utenti possono registrarsi, effettuare log-in e log-out;
* salvataggio password secondo gli standard ufficiali PHP (algoritmo *bcrypt*);
* password dimenticata e reset password;
* "ricordami" (login via cookies);
* verificazione account via email;
* supporto nativo all'invio delle email (tramite PHP Mailer e altre librerie);
* URL rewriting.

#### Struttura e funzionamento
HUGE presenta una struttura MCV, ma i metodi utilizzati sono per lo più statici. La struttura MCV viene sfruttata appieno dalla configurazione di un file .htaccess e dal file Application.php. Tutte le richieste http vengono dirottate da apache nella cartella public in cui è presente il file index.php che non fa altro che creare una nuova istanza della classe Application.

##### Il file .htaccess della cartella *public*
```apache
# Necessario per evitare problemi nel caso in cui si usi un controller chiamato "index" avendo un file root index.php.
# http://httpd.apache.org/docs/2.2/content-negotiation.html
Options -MultiViews

# Attivazione URL rewriting (ES.: myproject.com/controller/action/1/2/3).
RewriteEngine On

# Impedisce che si possa navigare direttamente nelle cartelle.
Options -Indexes

# Se le seguenti condizioni sono vere, allora riscrive la URL:
# Se il file richiesto non è una directory,
RewriteCond %{REQUEST_FILENAME} !-d
# e se il file richiesto non è un file esistente,
RewriteCond %{REQUEST_FILENAME} !-f
# e se il file richiesto non è un link simbolico,
RewriteCond %{REQUEST_FILENAME} !-l
# allora riscrivi la URL nel modo seguente:
# Prende l'intero nome del file richiesto e lo ritorna come valore di
# parametro "url" a index.php. Aggiunge in coda le rimanenti query string
# dell'URL orginale come parametri successivi (QSA), ferma l'esecuzione di 
# questo file .htaccess (L).
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
```

Il file .htacces appena descritto è presente nella cartella public i HUGE, allo stesso livello del file index.php. Questo file permette il funzionamento dello "url rewriting" e dell'esecuzione di controller/metodi tramite determinati parametri presenti nelle richieste http.

##### La classe *Application.php*
```php
<?php

class Application
{
    /** @var mixed Instanza del controller */
    private $controller;

    private $parameters = array();

    /** @var string Nome del controller */
    private $controller_name;

    /** @var string Nome del metodo del controller */
    private $action_name;

    /**
     * Esegue lo start dell'applicazione, analizza gli elementi della URL, esegue il controller e metodo corrispondenti o reindirizza a index.
     */
    public function __construct()
    {
        // Crea array con i parametri in URL in $url.
        $this->splitUrl();

        // Esegue controllo sul controller: non è stato dato un controller ? allora setta ontroller = default controller (dalla configurazione).
        if (!$this->controller_name) {
            $this->controller_name = Config::get('DEFAULT_CONTROLLER');
        }

        // controllo per action (metodo): non è stato dato una action? allora setta action = default action (dalla configurazione)
        if (!$this->action_name OR (strlen($this->action_name) == 0)) {
            $this->action_name = Config::get('DEFAULT_ACTION');
        }

        // rinomina controller_name al reale nome controller class/file (da "index" a "IndexController")
        $this->controller_name = ucwords($this->controller_name) . 'Controller';

        // il controller selezionato esiste ?
        if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {

            // carica questo file e crea il controller
            // esempo: se il controlelr fosse "car", allora si tradurrebbe in: $this->car = new car();
            require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
            $this->controller = new $this->controller_name();

            // controllo per il metodo: esiste all'interno del controller ?
            if (method_exists($this->controller, $this->action_name)) {
                if (!empty($this->parameters)) {
                    // chiama il metodo e gli passa i parametri
                    call_user_func_array(array($this->controller, $this->action_name), $this->parameters);
                } else {
                    // se non ci sono parametri, richiama il metodo senza parametri, ad esempio $this->index->index();
                    $this->controller->{$this->action_name}();
                }
            } else {
                header('location: ' . Config::get('URL') . 'error');
            }
        } else {
            header('location: ' . Config::get('URL') . 'error');
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (Request::get('url')) {

            // split URL
            $url = trim(Request::get('url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // mette i parametri URL nei rispettivi attributi di classe
            $this->controller_name = isset($url[0]) ? $url[0] : null;
            $this->action_name = isset($url[1]) ? $url[1] : null;

            // rimuove controller_name e action_name dall'array
            unset($url[0], $url[1]);

            // salva i parametri URL nell'attributo.
            $this->parameters = array_values($url);
        }
    }
}
?>

```
La classe Application.php sta alla base di tutto il funzionamento dell'applicazione. Tutte le richieste al server vengono effettuate con lo schema "dominio.com/controller/metodo" e il protocollo http aggiunge gli eventuali parametri provenienti da form. In questo modo il file .htaccess può effettuare *url rewriting* mostrando appunto la stringa "dominio.com/controller/metodo" e non il il file che viene eseguito (in questo caso index.php).
La prima operazione effettuata nel costruttore della classe Application è l'esecuzione del metodo *splitUrl()* che setta a dei valori iniziali gli attributi della classe *controller_name*, *action_name* e *parameters*, che rispettivamente sono il controller e il metodo (più i parametri) che andranno poi eseguiti.
In seguito si effettuano dei controlli se esistono o meno il controller e il metodo selezionati, nel caso contrario vengono settati a valori di default (ad esempio un configurazione di default potrebbe essere *index/index*, cioè effettuare il redirect alla pagina iniziale). Una volta effettuata la convalida si procede con la creazione dell'instanza del controller selezionato e si richiama il metodo associato passando i parametri ricavati (se ce ne sono).

#### Il database
Per la memorizzazione dei dati degli utenti HUGE ha un database con una tabella *users* e una tabella *notes*. La prima contiene tutte le informazioni degli utenti registrati, mentre la seconda serve solo per eseguire delle dimostrazioni di utilizzo per HUGE e non verrà utilizzata in Syncbook. La tabella users è stata modificata inserendo anche i campi "first_name" e "last_name", necessari al completamento delle credenziali per il database relativo all'utente in sabre.

!!!!!!!!!!! codice sql della tabella e spiegazione campi !!!!!!!!!!!!!!!!!!

#### Da HUGE a Syncbook
Per la realizzazione del progetto HUGE é stato riadattato a quelle che erano le esigenze del progetto:
- tutta la parte grafica è stata affidata a Bootstrap;
- la navigazione è stata organizzata in modo tale da avere una homepage (index) che fa da pagina introduttiva al progetto e una dashboard, ovvero il pannello di controllo delle funzionalità di Syncbook;
- sono state create due classi (ContactController e ContactModel) per la raccogliere i metodi atti alla manipolazione dei contatti e della rubrica;
- sono state tolte delle funzionalità come il cambio dello username perché avrebbe causato problemi tra la corrispondenza tra database di HUGE e quello personale dell'utente;
- al momento della registrazione è stato reso obbligatorio l'inserimento di nome e cognome da parte dell'utente (prima bastava immettere soltanto lo username);
- eliminazione della tabella "notes" dal database.

####### Come si mostra l'app
![Dashboard](http://i.imgur.com/1kwNcVa.png)

####### Inserimento contatto
![Inserimento](http://i.imgur.com/4PtPTUk.png)

####### Visualizzazione contatto
![Visualizzazione](http://i.imgur.com/OZoYLT2.png)

####### Modifica contatto
![Modifica](http://i.imgur.com/WIV6h4R.png)

### ![Sabre Logo](http://i.imgur.com/tSCEawe.png "Sabre Logo") Sabre.io

Framework PHP, creato con lo scopo di dare la possibilità ai programmatori di sviluppare applicazioni Web completamente basate sui più recenti RFC di vCard e vCalendar nel modo più veloce e semplice possibile.

==@TO-DO More description needed?==

Data la peculiare strutturazione della base di dati che viene utilizzata all'interno di Sabre/DAV è necessario creare un nuovo Database per ogni utente che desidera creare un account all'interno di Syncbook.

Alla base di questo problema sta il fatto che, secondo i creatori del Framework ogni utente dovrebbe essere gestito da un utente di livello più alto rispetto al proprio rendendo così più semplici per gli amministratori d'azienda le operazioni riguardanti la gestione dei Server.

Se l'applicazione fosse gestita in questo modo sarebbe impossibile per gli utenti svolgere alcune fondamentali operazioni sulle loro rubriche, rendendo il servizio offerto, da alcuni punti di vista, peggiore rispetto a molte altre alternative che si possono trovare sul Web.

Entra quindi in gioco il frammento di codice PHP che si può leggere sotto, utilizzato all'interno del file che si occupa della gestione degli accessi da dispositivi mobili per reindirizzare l'utente all'interno della base di dati corretta durante il login.

###### Gestione della multiplicità dei Database

```php
<?php

// Controllo che il nome utente non sia già stato individuato in precedenza.
if (!isset($databaseUsername)) {

	// Viene ricavato l'URI utilizzato per accedere alla pagina Web corrente.
    $serverUri = $_SERVER["REQUEST_URI"];

    // Viene ricavato il path assoluto dello Script corrente all'interno del Server.
    $serverName = $_SERVER["SCRIPT_NAME"];

	/*
    	Algoritmo utilizzato per ricavare l'username della persona che sta effettuando l'operazione di Login.
        Il nome utente viene poi salvato all'interno della variabile $databaseUsername.
        La variabile $databaseUsername sarà usata per indirizzare la persona al proprio database.

        Identificatore di un Database :
        sabredav_<username>
    */

    if (strpos($serverUri, '/principals/') != false) {
        $databaseUsername = str_replace($serverName . "/principals/", "", $serverUri);
    } else if (strpos($serverUri, '/calendars/') != false) {
        $databaseUsername = str_replace($serverName . "/calendars/", "", $serverUri);
    } else if (strpos($serverUri, '/addressbooks/') != false) {
        $databaseUsername = str_replace($serverName . "/addressbooks/", "", $serverUri);
    } else {
        $databaseUsername = '';
    }

	// Nel caso in cui un Username non venga individuato per il Login è necessario chiudere la connessione.
    if ($databaseUsername == '') {
    	error_log("Error in SabreDAV Login Algorithm");
    	die("Unknown Error");
    }
}

?>
```

###### Creazione di una vCard
```php
<?php

/**
 * Funzione utilizzata per creare una vCard dai dati forniti dall'utente durante il processo di creazione di un contatto.
 *
 * @param $vCardObject
 * @return VObject\Component\VCard
 */
function mapperObjectCard($vCardObject) {

    // Mappatura del parametro UID.
    $vCard = new Sabre\VObject\Component\VCard([
        'UID' => ($vCardObject->UID !== "") ? $vCardObject->UID : Sabre\DAV\UUIDUtil::getUUID()
    ]);

    // Mappatura delle informazioni Standard.
    $contactDefault = $vCardObject->contactDefault;

    $string = NULL;

	// Serie di controlli per la presenza di nome/cognome e l'assenza "Prefix"/"Middle-Name"/"Suffix".
    if (!empty($contactDefault->contactPrefix)) {
        $string = $contactDefault->contactPrefix . " ";
    } else {$string = "";}

    if (!empty($contactDefault->contactMiddleName)) {
        $string = $string . $contactDefault->contactFirstName . " " . $contactDefault->contactMiddleName . " ";
    } else {$string = $string . $contactDefault->contactFirstName . " ";}

    if (!empty($contactDefault->contactSuffiz)) {
        $string = $string . $contactDefault->contactLastName . " " . $contactDefault->contactSuffix;
    } else {$string = $string . $contactDefault->contactLastName;}

	// Operazioni di mappatura.
    $vCard->add('FN', $string);
    $vCard->add('N', [
        $contactDefault->contactLastName,
        $contactDefault->contactFirstName,
        $contactDefault->contactMiddleName,
        $contactDefault->contactPrefix,
        $contactDefault->contactSuffix
    ]);

    // Mappatura della data di nascita.
    $contactCompany = $vCardObject->contactCompany;

    if ($contactCompany !== NULL) {
        $dateTime = new \DateTime($contactCompany->contactBirthDate);
        $dateTime = $dateTime->format('Y-m-d\TH:i:s\Z');
        $vCard->add('BDAY', $dateTime);
    }

    // Mappatura dei dati relativi ai numeri di telefono.
    $contactPhone = $vCardObject->contactPhone;

    if ($contactPhone !== NULL) {
        foreach($contactPhone as $phoneContainer) {
            $vCard->add('TEL', $phoneContainer->phoneValue, [
                'TYPE' => [
                    $phoneContainer->phoneType,
                    ($phoneContainer->phoneIsCell === "TRUE") ? 'CELL' : NULL,
                    ($phoneContainer->phoneIsFax === "TRUE") ?  'FAX' : NULL,
                    ($phoneContainer->phoneIsVoice === "TRUE") ? 'VOICE' : NULL
                ]
            ]);
        }
    }

    // Mappatura dei dati rellativi agli indirizzi di posta elettronica.
    $contactMail = $vCardObject->contactMail;

    if ($contactMail !== NULL) {
        foreach($contactMail as $mailContainer) {
            $vCard->add('EMAIL', $mailContainer->mailValue, [
                'TYPE' => [
                    'INTERNET',
                    $mailContainer->mailType
                ]
            ]);
        }
    }

    // Mappatura dei dati relativi agli indirizzi di abitazione/lavoro.
    $contactAddress = $vCardObject->contactAddress;

    if($contactAddress !== NULL) {
        foreach($contactAddress as $addressContainer) {
            $vCard->add('ADR', [
                "",
                "",
                $addressContainer->addressStreet,
                $addressContainer->addressCity,
                $addressContainer->addressRegion,
                $addressContainer->addressPostalCode,
                $addressContainer->addressCountry,
            ], ['TYPE' => $addressContainer->addressType]);
        }
    }

    // Mappatura di dati relativi agli indirizzi web.
    $contactInternet = $vCardObject->contactInternet;

    if ($contactInternet !== NULL) {
        foreach($contactInternet as $internetContainer) {
            $vCard->add('URL', $internetContainer->internetValue, 
            			['TYPE' => $internetContainer->internetType]);
        }
    }

    // Mappatura dei dati relativi alle note.
    if ($vCardObject->contactNotes !== NULL) {
        $vCard->add('NOTE', $vCardObject->contactNotes);
    }
return $vCard;
}

?>
```

###### Esempio di interfacciamento tra SabreDAV e HUGE

```php
<?php
/**
 * Funzione utilizzata per interfacciare il sistema delle vCard con gli algoritmi peculiari di HUGE.
 * Algoritmo che ha lo scopo di ritornare una lista di Nomi-Cognomi di tutte le vCard di una certa rubrica.
 *
 * Struttura dell'Array di ritorno dalla funzione.
 * $returnArray = array(
 *   'UID' => array(
 *   'contactFirstName' => "",
 *   'contactLastName' => ""
 * )
 *
 * @param \Sabre\CardDAV\AddressBook $addressBook
 * @param array $arrayUID
 * @return array|bool
 */
function vCardListRetrieve(Sabre\CardDAV\AddressBook $addressBook, $arrayUID) {
    try {
        $returnArray = array();

		// Iterazione per tutti gli UID (attributo identificativo di una vCard) presenti all'interno del Database.
        foreach($arrayUID as $singleUID) {
            // Acquisizione dei dati presenti all'interno di una vCard, sotto dorma di Object, attraverso l'UID.
            $vCardData = $addressBook->getChild($singleUID);
            // Acquisizione dei dati presenti all'interno di una vCard, sotto forma di vCard-Data.
            $vCardData = \Sabre\VObject\Reader::read($vCardData->get());
			// Utilizzo del mapper inverso a quello mostrato sopra con lo scopo di creare un Object
            // Partendo da un formato di tipo vCard-Data.
            $vCardObject = mapperCardObject($vCardData);

			// Popolazione dell'array di ritorno con i dati desiderati.
            $returnArray[$vCardObject->UID] = array(
                'contactFirstName' => $vCardObject->contactDefault->contactFirstName,
                'contactLastName' => $vCardObject->contactDefault->contactLastName
            );
        }

        return $returnArray;
    } catch (Exception $exceptionError) {
    	error_log("Error in vCardListRetrieve Function - " . $exceptionError);
    }
return FALSE;
}

?>
```

### ![Bootstrap Logo](http://i.imgur.com/pGBc45r.png "Bootstrap Logo") Bootstrap

Per quel che riguarda l'interfaccia grafica dell'applicazione è stato utilizzato Boostrap, uno dei più famosi "front-end framework". Al di là della sua fama, Boostrap è stato scelto soprattutto per la sua vocazione "mobile first" e il numero di risorse di ogni genere disponibili online.
Le principali caratteristiche di questo framework sono il layout a griglie e la serie di classi css "preconfezionate" che permettono una rapida implementazione nell'applicazione, dando fin da subito un risultato funzionale. La struttura a colonne di Bootstrap permette di creare layout grafici in grado di adattarsi dinamicamente a un cambio di display realizzando quello che viene definito "responsive design".

Proprio per la sua natura di framework da utilizzarsi solo nelle prime fasi di un progetto (da qui il nome), Bootstrap non fornisce un'ampia gamma di componenti aggiuntivi ed ha uno stile grafico in sè povero. Per questo motivo si ha deciso di implementare una libreria css e javascript in stile [material design](http://fezvrasta.github.io/bootstrap-material-design/bootstrap-elements.html): la quale, oltre a fornire una formattazione molto simile allo stile di Google, offre anche alcuni componenti aggiuntive come le *floating labels* e finestre di dialogo.

###### Esempio di utilizzo di Bootstrap: finestra di dialogo di log-in.
Qui di seguito una parte di codice HTML utilizzata per realizzare la finestra di login della pagina iniziale dell'applicazione.

```html
<div id="log-in-dialog" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" id="user_name" name="user_name" placeholder="Username or E-Mail" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="password" class="form-control floating-label" id="user_password" name="user_password" placeholder="Password" required />
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="set_remember_me_cookie">Remember me for 2 weeks
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary" value="Log in"/>
                                No account Yet? <a href="<?php echo Config::get('URL'); ?>login/register">Register!</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="link-forgot-my-password">
                    <a href="<?php echo Config::get('URL'); ?>login/requestPasswordReset">I forgot my password</a>
                </div>
            </div>
        </div>
    </div>
</div>
```
###### Il risultato
![Imgur](http://i.imgur.com/YMwCKiQ.png)

### ![jQuery Logo](http://i.imgur.com/iyMmW9C.png "jQuery Logo") jQuery

jQuery è un framework javascript che ha come intento quello di snellire la programmazione semplificando la selezione, la manipolazione degli elementi HTML e la gestione degli eventi del DOM (Document Object Model). Per un'applicazione che nasce in quello che viene definito "web 2.0", non è pensabile il non utilizzo di javascript: sia dal punto di vista grafico, che dal punto di vista delle funzionalità (ad esempio le richieste asincrone).
Oltre alla semplificazione del codice, un'altra importante carattaristica di jQuery è che è testato per funzionare allo stesso modo su più browser possibili: quindi il programmatore può concentrarsi di più sull'effettivo sviluppo dell'applicazione che sul funzionamento multi-piattaforma.
Come accennato in precedenza, se si vuole rendere un'applicazione più dinamica e veloce, dal punto di vista dell'utilizzo, è necessaria l'implementazione delle richieste asincrone. Questa tecnologia è implementata in jQuery con il nome AJAX e il metodo $.ajax() relativo. Questo metodo permette l'esecuzione di uno script sul server (nel nostro caso un metodo specifico di HUGE) per poter fornire dei all'utente all'utente senza eseguire il refresh della pagina.
In Syncbook tutte le interazioni tra utente e il database di SabreDav sono state eseguite con chiamate AJAX, qui di seguito viene riportata la parte di codice che viene eseguita nel momento in cui l'utente salva delle modifiche a un contatto.

###### Esempio di utilizzo della funzione $.ajax()
```javascript
// Gestione dell'evento 'click' sul bottone 'Salva'.
$(document).on('click', '#btn_save_changes', function () {
	// Recupero dei dati dal form e costruzione dell'oggeto vCard.
	var vCard = getFormFields();
	vCard['UID'] = $(this).attr('data-uid');

	// Controllo sugli input.
	var control = inputControl(vCard);
	switch(control) {
		// Tutti i controlli sono stati rispettati, si procede con il salvataggio dei dati.
		case 0:
        	// Preparazione ed esecuzione del metodo AJAX, vengono stabiliti:
			// - url del metodo da eseguire;
			// - parametri (data);
			// - metodo di passaggio dei parametri (POST);
			// - tipo di dati di ritorno (HTML);
			// - gestione degli errori;
			// - stampa a video di messaggi a operazione conclusa con successo.
			$.ajax({
				url : URL + 'contact/applychangestocontact',
				data : vCard,
				method : 'POST',
				dataType: 'html',
				error: function () {
					// La richiesta non è andata a buon fine.
					addNegativeFeedback("Internal error.");
				},
				success: function () {
					$('#mainContainer').html("");
					// Si mostra un feedback positivo che indica che l'operazione è andata a buon fine.
					addSuccessFeedback("Contact modified.");

					// Viene aggiornata la lista contatti.
					loadContactList();
				}
			});
			break;

		case 1:
			// Non sono stati inseriti 'nome' e 'cognome'.
			alert("First name and last name fields are required!");
			break;

		case 2:
			// Tutti i campi 'address' devono essere riempiti.
			alert("Complete all the address fields!");
			break;
	}
});
```

### RedBean PHP

Frmework PHP utilizzato per implementare il paradigma di programmazione ORM (Object-relational mapping) all'interno dei sorgenti di SabreDAV.

Si è presa la decisione di aggiungere questa funzionalità al progetto in modo tale da diminuire la quantità di codice scritto in fase di programmazione rendendo più semplici e lineari operazioni che sarebbero state molto complesse utilizzando mero linguaggio PHP.
Il paradigma ORM risulta fondamentale nelle fasi di sviluppo

##### ORM

L'Object-relation mapping è una tecnica di pragrammazione ampiamente utilizzata all'interno dei linguaggi di programmazione orientati all'utilizzo di strutture dati come gli oggetti. L'utilizzo di framework che implementano questo paradigma è spesso presente nel momento in cui è necessario interfacciare l'applicativo con uno specifico DBMS.

Nel caso del linguaggio PHP vengono implementati una serie di algoritmi con lo scopo di ampliare le funzionalità dell'estensione PDO rendendo più semplice per il programmatore la realizzazione di algoritmi che si appoggiano su Database altamente complessi e ramificati. Utilizzare l'ORM permette anche di risparmiare al programmatore molti controlli dovuti alla struttura di una base di dati.

###### Tabella "persona"
![Table persona](http://i.imgur.com/NnAE4p1.png?2 "Table persona")

###### Interfacciamento attraverso ORM

```php
<?php

try {
	// Connnessione ad un Database di nome "example" situato in LocalHost.
    // Username: "root" - Password: "".
	R::setup('mysql:host=127.0.0.1;dbname=example', 'root', '');

	/*
		Non utilizzando il metodo sottostante RedBeanPHP utilizzerà gli schemi del Database in modo
        dinamico permettendo al programmatore di modificare la base di dati senza preoccuparsi delle
        possibili conseguenze nell'applicazione.

        Questa tecnica è molto utile in fase di sviluppo, in compenso le prestazioni diminuiscono,
        per questo motivo è quindi giusto utilizzare il metodo sottostante per bloccare gli schemi del
        Database permettendo le massime prestazioni.
        Tecnica che viene implementata solitamente alla pubblicazione dell'applicazione.
	*/
    R::freeze(true);

	// Inizio di una transazione
	R::begin();

	// Acquisizione di un oggetto che presenta tutte le caratteristiche peculiari della tabella "persona".
    $beanPersona = R::dispense('persona');

	// Fase di popolzione dell'oggetto $beanPersona con i dati desiderati.
    // Nel caso in cui qualunque di questi dati non rispetti i vincoli descritti nella definizione degli attributi,
    // verrà generata un'eccezione. Opportunamente catturata attraverso il costrutto "try-catch".
	$beanPersona->nome = "Pippo";
    $beanPersona->cognome = "Pluto";
    $beanPersona->dataNascita = 21/05/1953;

	// Crezione di un'istanza all'interno della tabella "persona", con i dati prima inseriti.
    // Il ritorno di questo metodo è il valore della chiave primaria che identifica la tupla.
	$beanPersonaID = R::store($beanPersona);

	// Chiusura della transazione precedentemente avviata in caso di successo dell'algoritmo.
    R::commit();

	// Chiusura della connessione con il Database
    R::close();
} catch (Exception $exceptionError) {
	// Chiusura della transazione precedentemente avviata in caso di insuccesso dell'algoritmo.
    R::rollback();

    // Chiusura dello script corrente
	die("Error: $exceptionError");
}

?>
```

### ![Git Logo](http://i.imgur.com/FqHRvKB.png "Git Logo") Git

Sistema software di controllo di versione distribuito, creato da Linus Torvalds nel 2005.
Diventato il leader nella sua categoria con il passare del tempo questa piattaforma è incentrata sulla velocità e sull'integrità dei dati.
Ogni directory di lavoro creata attraverso Git identifica un Repository cioè una struttura dati che contiene dei metadati che permettono di tracciare tutte le azioni che sono compiute in fase di progettazione.

#### ![GitHub Logo](http://i.imgur.com/TRmTY2v.png "GitHub Logo") GitHub

Dato il fatto che Git nasce, principalmente, come una piattaforma per lavorare in gruppi di progetto composti da più persone, che molte volte vivono in luoghi distanti tra loro, è necessaria una piattaforma Server dove tutti possano accedere per apportare delle modifiche al Repository.

Viene fondato, quindi, nel 2008 GitHub. Sito web pubblico con lo scopo di fornire una completa piattaforma di hosting per i propri Repository. Esistono due versioni principali di questo servizio:
* Gratuito, per chiunque desideri pubblicare il proprio lavoro con il resto del mondo, avendo quindi la possibilità di esssere aiutati in caso di bisogno;
* A pagamento, per coloro che vogliono che i propri Repository rimangano privati e che solo alcune persone possano accedere ad essi.

Queste due versioni presentano uguali capacità di gestione del codice, complete di statistiche e informazioni in tempo reale riguardanti il proprio lavoro.

##### Commit

All'interno di un Repository ogni modifica al codice sorgente è possibile soltanto attraverso un Commit, un insieme di metadati a cui è possibile dare una descrizione. Attraverso questa metodologia, ogni membro del Repository ha la possibilità di conoscere le differenze che sono state apportate all'interno dei File a cui un Commit fa riferimento.

##### Branch

Attraverso una particolare tipologia di Commit è possibile creare un Branch all'interno di un Repository, differente dal "Master Branch" che identifica la root directory e che viene creato attraverso il processo di creazione di un Repository.
Un Branch è un insieme di metadati che permette l'identificazione di un insieme di file/cartelle all'interno di un Repository. I Branch vengono, molto spesso, utilizzati per differenziare le varie aree di lavoro dei membri del Repository o, più semplicemente, per separare vari componenti non collegati tra loro di un progetto.

###### Repository "Home"

![Repository Home](http://i.imgur.com/x2jxGiF.png "Repository Home")

L'immagine mostra la struttura della pagina iniziale di un repository all'interno di GitHub, vengono presentate le seguenti funzioni:
* Fondatore del Repository e nome dello stesso (Nildric/Syncbook);
* Numero di commit attualmente presenti all'interno del Repository (451 commits);
* Numero di branches attualmente presenti all'interno del Repository (2 branches);
* Numero di release attualmente presenti all'interno del Repository (1 release);
* Numero di contributors attualmente presenti all'interno del Repository (2 contributors);
* Struttura della Root Directorry del Repository;
* Numero di issues attualmente presenti all'interno del Repository (2 issues);
* Numero di pull requests attualmente presenti all'interno del Repository (2 pull requests);
* Link alla Wiki del Repository;
* Link alle statistiche di pulse del Repository (==@TO-DO Description or Screen?==);
* Link ai grafici del Repository, descritti nella sezione sottostante.

###### Repository "Graphs"

![Repository Graphs](http://i.imgur.com/UEQmwmy.png "Repository Graphs")

L'immagine mostra il portale attraverso il quale è possibile vedere:
* La data del primo Commit del Repository e la data dell'ultimo (Jan 18, 2015 - Jun 3, 2015);
* Un grafico riassuntivo della frequenza dei commit compiuti durante il periodo sopra citato;
* La frequenza dei Commit di ogni membro del Repository nel tempo;
* Il numero di righe di codice aggiunte e rimosse da ogni membro nel tempo.

###### Repository "Commits"

![Repository Commits](http://i.imgur.com/uCVUzD5.png "Repository Commits")

L'immagine mostra una parte della lista di Commit compiuti durante il ciclo di vita del Repository.
Per ogni Commit è possibile vedere:
* L'autore (Xooline/Nildric);
* La data in cui è stato fatto (May 27, 2015);
* La descrizione scritta dall'autore a riguardo;
* Quanto tempo è trascorso tra la data di creazione e la data corrente (7 days ago);
* Il codice identificativo (2cfc22a).

###### Esempio di "Commit"

![Esempio di Commit](http://i.imgur.com/fenzXku.png "Esempio di Commit")

In questa immagine vengono mostrate le modifiche al File a cui uno specifico Commit fa riferimento.

### Server

Tutti i servizi di Syncbook sono ospitati in un server cloud su [digitalocean.com](https://digitalocean.com). È stato registrato il dominio *syncbook.me* e associato ai DNS della macchina virtuale e inoltre è stata installata una certificazione SSL ormai diventata indispensabile per le applicazioni di questo tipo.

Il server monta Ubuntu 14.04 LTS, per i servizi HTTP è stato installato Apache 2, PHP 5.5, MySQL 5.5. Per sfruttare appieno il dominio registrato e per fornire la funzione di registrazione agli utenti di Syncbook è stato installato un mail server, nel particolare Postfix. La configurazione del mail server ha raggiunto il seguente risultato su [mail-tester.com](https://www.mail-tester.com/):

![mail-tester.com](http://i.imgur.com/ARUvWfV.png)

## Conclusioni
Allo stato attuale del progetto possiamo dire di aver raggiunto in modo soddisfacente gli obbiettivi prefissati: Syncbook permette di organizzare una rubrica di contatti rispettando le regole dettate dagli standard vCard e mette a disposizione i dati inseriti dall'utente anche su altri dispositivi sincronizzati tramite webDav (longhin boh). Allo stesso tempo non sono state ancora implementate delle funzioni che potrebbero allargare l'utilizzo di Syncbook anche a gruppi di lavoro, oltre che al singolo utilizzatore: ad esempio la possibilità di creare più rubriche e di condividerle con delle persone selezionate. In ogni caso, grazie ai vari framework utilizzati, il progetto è stato sviluppato in modo tale da accogliere nuove modifiche senza però dover stravolgere tutto il lavoro fatto in precedenza.

### Implementazioni future

#### Condvisione delle risorse

Attraverso il completo uso degli Standard viene sì persa la possibilità di gestire delle informazioni che per alcuni potrebbero essere importanti, ma questa metodologia di formattazione rende molto più semplice ed efficace l'uso dei seguenti metodi di condivisione della propria rubrica. Queste funzionalità vengono offerte già dai client con cui si utilizzerà la piattaforma all'interno del dispositivo ma non sono state implementate in Syncbook.

#### Gestione di più rubriche

Gestire più di una rubrica rispetto a quella offerta di default dalla piattaforma potrebbe essere, per molte persone, una funzionalità importante per poter gestire al meglio la propria lista di contatti, dividendola in categorie. Questa tipologia di gestione è supportata dal protocdollo CardDAV ma non è stata implementata perchè con la differente gestione della base di dati, necessaria per il corretto funzionamento di Syncbook, SabreDAV non permette di creare, modificare e cancellare più rubriche.

#### Importazione ed Esportazione di vCard

Durante l'utilizzo della piattaforma potrebbe essere necessaria, per l'utente, la capacità di importare ed esportare i propri contatti da/a dispositivi che non utilizzano correttamente la formattazione standard.

Si è deciso di non implementare questa funzionalità principalmente per due motivi:
1. Il fattore di esportazione sta alla base della finalità di questo progetto, configurando il proprio dispositivo per poter utilizzare il protocollo CardDAV riuscendo ad avere contatti standardizzati ovunque si desideri.
Per quanto riguarda l'esportazione della vCard sotto la forma di file questa funzione non è stata implementata a causa di problemi dovuti dalle modifiche fatte alla base di dati utilizzata da SabreDAV.
2. Il fattore importazione, data la politica delle grandi aziende a riguardo l'uso degli RFC, sarebbe stato molto complesso da implementare perchè avere un algoritmo di mappatura per ogni tipologia di servizio offerto per la gestione dei propri contatti è quasi impossibile.
Un team di programmatori avrebbe dovuto essere incaricato solo di occuparsi delle varie sfaccettature di questo problema.
