# Syncbook
![Syncbook Logo](http://i.imgur.com/oONGOVT.png "Syncbook Logo")

## Indice

+ [Introduzione](#introduzione)
	- [vCard](#vcard)
	- [CardDAV](#carddav)
+ [Problema](#problema)
	- [Dati da salvare](#dati-da-salvare)
	- [Dati salvati secondo standard](#dati-salvati-secondo-standard)
	- [Dati salvati in Apple Contacts](#dati-salvati-in-apple-contacts)
	- [Dati salvati in Google Contacts](#dati-salvati-in-google-contacts)
+ [Finalità del progetto](#finalità-del-progetto)
+ [Obiettivo del progetto](#obiettivo-del-progetto)
+ [Perchè un'applicazione web?](#perchè-unapplicazione-web)
+ [Strumenti](#strumenti)
	- [HUGE](#huge)
		+ [Struttura e funzionamento](#struttura-e-funzionamento)
			- [Il file .htaccess della cartella public](#il-file-htaccess-della-cartella-public)
			- [La classe Application.php](#la-classe-applicationphp)
        + [Il database](#il-database)
        + [Da HUGE a Syncbook](#da-huge-a-syncbook)
        	- [Come si mostra l'app](#come-si-mostra-lapp)
        	- [Inserimento di un contatto](#inserimento-di-un-contatto)
        	- [Visualizzazione di un contatto](#visualizzazione-di-un-contatto)
        	- [Modifica di un contatto](#modifica-di-un-contatto)
    - [Sabre.io](#-sabreio)
    	+ [Creazione di una vCard](#creazione-di-una-vcard)
    	+ [Esempio di interfacciamento tra SabreDAV e HUGE](#esempio-di-interfacciamento-tra-sabredav-e-huge)
    - [Bootstrap](#-bootstrap)
    	+ [Esempio di utilizzo di Bootstrap: finestra di dialogo di log-in](#esempio-di-utilizzo-di-bootstrap-finestra-di-dialogo-di-log-in)
    		- [Il risultato](#il-risultato)
    - [jQuery](#-jquery)
    	+ [Esempio di utilizzo della funzione $.ajax()](#esempio-di-utilizzo-della-funzione-ajax)
    - [RedBean PHP](#redbean-php)
    	+ [ORM](#orm)
    		- [Tabella "persona"](#tabella-persona)
    		- [Interfacciamento attraverso ORM](#interfacciamento-attraverso-orm)
    - [Git](#-git)
    	+ [Commit](#commit)
    	+ [Branch](#branch)
    	+ [GitHub](#-github)
    		- [Repository "Home"](#repository-home)
    		- [Repository "Graphs"](#repository-graphs)
    		- [Repository "Commits"](#repository-commits)
    		- [Esempio di "Commit"](#esempio-di-commit)
    - [Server](#server)
+ [Conclusioni](#conclusioni)
	- [Problematiche](#problematiche)
		+ [Utilizzo di Syncbook, dal dispositivo desiderato, prima di aver confermato l'indirizzo e-mail](#utilizzo-di-syncbook-dal-dispositivo-desiderato-prima-di-aver-confermato-lindirizzo-e-mail)
    - [Implementazioni future](#implementazioni-future)
    	+ [Gestione di più rubriche](#gestione-di-più-rubriche)
    	+ [Importazione ed esportazione di vCard](#importazione-ed-esportazione-di-vcard)
+ [Bibliografia](#bibliografia)
	- [Documentazione tecnica](#documentazione-tecnica)
	- [Siti di riferimento](#siti-di-riferimento)
+ [Ringraziamenti](#ringraziamenti)

## Introduzione

Da sempre il grande problema delle rubriche in formato digitale è la loro condivisione ed esportazione tra dispositivi diversi tra loro, questo perchè le grandi aziende non si sono mai preoccupate di utilizzare uno standard comune durante il salvataggio dei contatti pensando solo ai propri interessi. In realtà degli standard per la formattazione dei dati esistono ma non sono implementati nei più comuni applicativi.

### vCard
Il formato più utilizzato per rappresentare un contatto sotto forma digitale è  la vCard, giunta alla sua quarta versione.
Lo standard di rappresentazione dei dati presenti all'interno di questo file di testo è descritto nell'[RFC 6350](http://tools.ietf.org/html/rfc6350). Resta, però, quasi impossibile, trovare online un servizio che rispetti le regole che vengono definite.

### CardDAV
Il protocollo più utilizzato per la gestione di contatti all'interno del web è  il CardDAV. Essendo basato sulla sintassi specifica delle vCard, CardDAV permette un semplice scambio di informazioni tra server e client durante tutte le operazioni di creazione, modifica ed eliminazione di un file vCard.

## Problema

### Dati da salvare
```
Jhon Smith
smith.jhon@gmail.com
+44 20 1234 5678
1 Trafalgar Square, WC2N London, United Kingdom
Web: http://jhonsmith.com
Skype: jhon.smith
Twitter: @jhonsmith
```

### Dati salvati secondo standard
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

Per quanto strano possa sembrare, nonostante la loro quarta versione, le vCard non supportano quelli che sono oramai diventati degli strumenti alla base delle società moderna, i social network.
Questi campi vengono quindi definiti come *non-standard* e vanno rappresentati da una lettera `X`, seguita dal simbolo `-` e dal nome del campo stesso. I campi così descritti possono non essere supportati da tutte le applicazioni client attraverso le quali viene poi data la possibilità all'utente di gestire la propria rubrica.

### Dati salvati in Apple Contacts
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

Utilizzando un formato non più supportato nel mondo delle vCard, la Apple riesce a rappresentare una serie di semplici dati in un modo molto differente rispetto al precedente rendendo complessa e laboriosa l'esportazione di questa vCard in un dispositivo non appartenente alla famosa azienda statunitense.
Le differenze più evidenti si possono notare nella rappresentazione del campo `URL` che viene ora raggrupato con la proprietà non-standard `X-ABLabel`. Questo metodo viene utilizzato per risolvere il problema di mostrare all'utente un sito web come proprio del contatto che egli sta visualizzando.

### Dati salvati in Google Contacts
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

Google Contacts non da la possibilità all'utente di salvare all'interno delle informazioni di un contatto quelle riguardanti i social network, è necessario utilizzare la proprietà `URL` per gestirli. L'utilizzo di questa peculiare formattazione, unita a degli inutili caratteri di *escape* usati per rappresentare gli indirizzi *HTTP*, rende impossibile mantenere i medesimi dati in fase di importazione della vCard in un dispositivo che non possieda un sistema operativo Android.

## Finalità del progetto

In seguito a un'analisi approfondita della situazione attuale del non utilizzo degli standard vCard, appare evidente che l'importazione ed esportazione di contatti tra dispositivi diversi non può avvenire, se non in modo incompleto o corrotto. Per questo motivo si è deciso di sviluppare un progetto per dimostrare come sia possibile utilizzare gli Standard per la formattazione di una vCard traendone vantaggio durante il processo di gestione di una rubrica.

## Obiettivo del progetto

Realizzare un'applicazione web che permetta, all'utente correttamente registrato, di creare delle rubriche secondo gli standard vCard. L'applicativo dovrà essere in grado di salvare i dati inseriti dall'utente e di metterli a disposizione anche ad altri dispositivi che si interfacciano tramite il protocollo WebDAV. Risulta dunque necessaria la configurazione di un server per sostenere tutte le tipologie di richieste: dal salvataggio dei dati tramite database, alla sicurezza delle comunicazioni con il client.

## Perchè un'applicazione web?

La scelta di sviluppare un'applicazione web è stata effettuata per diversi motivi.
Il primo è legato alla natura della libreria Sabre.io: essa infatti è sviluppata totalmente in linguaggio PHP e per questa ragione è sembrato ovvio continuare con questa tecnologia integrando nuovi servizi e funzionalità.
Il secondo motivo si basa sulla portabilità dell'applicazione: se da un lato sarebbe stato possibile progettare un'applicazione rivolta alle funzionalità lato client, come un'applet Java od un'app Android, dall'altro si è capito che un'applicazione web avrebbe avuto un maggior bacino di utenza rispetto alle altre alternative. Questo perché una piattaforma web non ha bisogno di essere installata fisicamente nel dispositivo essendo, quindi, vincolata al software del sistema operativo ospitante.

## Strumenti

### HUGE
Per realizzare le funzionalità di log-in e gestione degli utenti è stato necessario scegliere un framework PHP che implementasse già questi algoritmi in modo da concentrare lo sviluppo su quello che effettivamente veniva richiesto dagli obiettivi del progetto. Per questo motivo la scelta è ricaduta su HUGE.
A differenza di altri famosi framework, come ad esempio Symfony, HUGE è una soluzione più semplice, sia a livello di comprensione del codice, che a livello di struttura e usabilità.
HUGE è l'ultima versione di una serie di progetti PHP sviluppati da *Panique* che hanno come finalità quella di fornire un container per la fase di avvio di nuove applicazioni, cioè preparare degli strumenti funzionanti "out of the box" come la gestione degli utenti (ad esempio: registrazione e log-in) e il motore grafico.

Alcune delle funzionalità più importanti di HUGE sono:
* gli utenti possono registrarsi ed effettuare log-in e log-out;
* salvataggio password secondo gli standard ufficiali PHP (algoritmo *bcrypt*);
* password dimenticata e conseguente possibilità di reset;
* verifica dell'account via e-mail;
* supporto nativo all'invio delle e-mail (tramite PHP Mailer);
* URL rewriting.

#### Struttura e funzionamento
HUGE presenta una struttura MVC, anche se i metodi utilizzati sono per lo più statici. La programmazione Model-View-Controller viene sfruttata appieno dalla configurazione di un file .htaccess e dal file Application.php. Tutte le richieste HTTP vengono reindirizzate da Apache nella cartella *public* in cui è presente il file index.php il cui scopo è creare una nuova istanza della classe Application.

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

Il file .htaccess appena descritto è presente nella cartella *public* di HUGE, allo stesso livello del file index.php. Questo file permette il funzionamento dello *url rewriting* e dell'esecuzione di controller/metodi tramite determinati parametri presenti nelle richieste HTTP.

##### La classe *Application.php*
```php
<?php

class Application
{
    /** @var mixed Istanza del controller. */
    private $controller;

    private $parameters = array();

    /** @var string Nome del controller. */
    private $controller_name;

    /** @var string Nome del metodo del controller. */
    private $action_name;

    /**
     * Esegue lo start dell'applicazione, analizza gli elementi della URL, 
     * esegue il controller e metodo corrispondenti o reindirizza a index.
     */
    public function __construct()
    {
        // Crea array con i parametri in URL in $url.
        $this->splitUrl();

        // Esegue controllo sul controller: non è stato dato un controller ? 
        // allora setta ontroller = default controller (dalla configurazione).
        if (!$this->controller_name) {
            $this->controller_name = Config::get('DEFAULT_CONTROLLER');
        }

        // Controllo per action (metodo): non è stato dato una action ? 
        // allora setta action = default action (dalla configurazione).
        if (!$this->action_name OR (strlen($this->action_name) == 0)) {
            $this->action_name = Config::get('DEFAULT_ACTION');
        }

        // Rinomina controller_name al reale nome controller class/file (da "index" a "IndexController").
        $this->controller_name = ucwords($this->controller_name) . 'Controller';

        // Il controller selezionato esiste?
        if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {

            // Carica questo file e crea il controller.
            // Esempio: se il controlelr fosse "car", allora si tradurrebbe in: $this->car = new car();
            require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
            $this->controller = new $this->controller_name();

            // Controllo per il metodo: esiste all'interno del controller?
            if (method_exists($this->controller, $this->action_name)) {
                if (!empty($this->parameters)) {
                    // Chiama il metodo e gli passa i parametri.
                    call_user_func_array(array($this->controller, $this->action_name), $this->parameters);
                } else {
                    // Se non ci sono parametri, richiama il metodo senza parametri, 
                    // ad esempio $this->index->index().
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
     * Get and split the URL.
     */
    private function splitUrl()
    {
        if (Request::get('url')) {

            // Split URL.
            $url = trim(Request::get('url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Mette i parametri URL nei rispettivi attributi di classe.
            $this->controller_name = isset($url[0]) ? $url[0] : null;
            $this->action_name = isset($url[1]) ? $url[1] : null;

            // Rimuove controller_name e action_name dall'array.
            unset($url[0], $url[1]);

            // Salva i parametri URL nell'attributo.
            $this->parameters = array_values($url);
        }
    }
}

?>
```

La classe Application.php sta alla base di tutto il funzionamento dell'applicazione. Tutte le richieste al server vengono effettuate attraverso lo schema < dominiuo >/controller/metodo e il protocollo HTTP aggiunge gli eventuali parametri provenienti dal form. In questo modo il file .htaccess può effettuare l'operazione di *url rewriting* mostrando la stringa sopra citata e non il il file che viene eseguito (in questo caso index.php).
La prima operazione effettuata nel costruttore della classe Application è l'esecuzione del metodo *splitUrl()* che setta a dei valori iniziali gli attributi della classe *controller_name*, *action_name* e *parameters*, che rispettivamente sono il controller e il metodo (più i parametri) che andranno poi eseguiti.
In seguito si effettuano dei controlli se esistono o meno il controller e il metodo selezionati, nel caso contrario vengono settati a valori di default (ad esempio un configurazione di default potrebbe essere *index/index*, cioè effettuare il redirect alla pagina iniziale). Una volta effettuata la convalida si procede con la creazione dell'instanza del controller selezionato e si richiama il metodo associato passando i parametri ricavati (se ce ne sono).

#### Il database
Per la memorizzazione dei dati degli utenti, HUGE presenta una base di dati con una tabella *users* e una tabella *notes*. La prima contiene tutte le informazioni degli utenti registrati, mentre la seconda serve solo per eseguire delle dimostrazioni di utilizzo di HUGE e non verrà utilizzata in Syncbook. La tabella users è stata modificata inserendo anche i campi *first_name* e *last_name*, necessari al completamento delle credenziali per la tabella relativa al salvataggio dell'utente in Sabre.

```sql
CREATE DATABASE IF NOT EXISTS `syncbook_users`;

CREATE TABLE IF NOT EXISTS `syncbook_users`.`users` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
 `user_firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s first name, unique',
 `user_lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s last name',
 `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
 `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
 `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
 `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
 `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
 `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
 `user_remember_me_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
 `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
 `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
 `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
 `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
 `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
 `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
 `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
 `user_provider_type` text COLLATE utf8_unicode_ci,
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `user_name` (`user_name`),
 UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';
```

#### Da HUGE a Syncbook
Per la realizzazione del progetto, HUGE é stato riadattato a quelle che sono le esigenze di Syncbook:
* la veste grafica è stata affidata a Bootstrap;
* la navigazione è stata organizzata in modo tale da avere una homepage (index) che fa da pagina introduttiva al progetto e una dashboard per il controllo delle funzionalità di Syncbook;
* sono state create due classi (ContactController e ContactModel) per la raccogliere i metodi atti alla manipolazione dei contatti;
* al momento della registrazione è stato reso obbligatorio l'inserimento di nome e cognome da parte dell'utente;
* eliminazione della tabella "notes" dal database.

##### Come si mostra l'app
![Dashboard](http://i.imgur.com/1kwNcVa.png)

##### Inserimento di un contatto
![Inserimento](http://i.imgur.com/4PtPTUk.png)

##### Visualizzazione di un contatto
![Visualizzazione](http://i.imgur.com/OZoYLT2.png)

##### Modifica di un contatto
![Modifica](http://i.imgur.com/WIV6h4R.png)

### ![Sabre Logo](http://i.imgur.com/tSCEawe.png "Sabre Logo") Sabre.io

Framework PHP, creato con lo scopo di dare la possibilità ai programmatori di sviluppare applicazioni web completamente basate sui più recenti RFC di vCard e vCalendar nel modo più veloce e semplice possibile. Gestendo, inoltre, complessi protocolli come CardDAV, CalDAV e WebDAV attraverso il solo uso di istruzioni in linguaggio PHP.
Data la peculiare strutturazione della base di dati che viene utilizzata all'interno di Sabre/DAV è necessario creare un nuovo database per ogni utente che desidera creare un account all'interno di Syncbook.
Alla base di questo problema sta il fatto che, secondo i creatori del framework ogni utente dovrebbe essere gestito da un utente di livello più alto rispetto al proprio rendendo così più semplici, per gli amministratori d'azienda, le operazioni riguardanti la gestione dei server.
Se l'applicazione fosse gestita in questo modo sarebbe impossibile per i singoli utenti svolgere alcune fondamentali operazioni sulle loro rubriche, rendendo il servizio offerto, da alcuni punti di vista, peggiore rispetto a molte altre alternative che si possono trovare sul web.
Entra quindi in gioco il codice PHP che si può leggere sotto, utilizzato all'interno del file che si occupa della gestione degli accessi da dispositivi mobili, per reindirizzare l'utente all'interno della base di dati corretta durante il login.

```php
<?php

// Controllo che il nome utente non sia già stato individuato in precedenza.
if (!isset($databaseUsername)) {

	// Viene ricavato l'URI utilizzato per accedere alla pagina Web corrente.
    $serverUri = $_SERVER["REQUEST_URI"];

    // Viene ricavato il path assoluto dello Script corrente all'interno del Server.
    $serverName = $_SERVER["SCRIPT_NAME"];

	/*
    	Algoritmo utilizzato per ricavare l'username della persona che sta effettuando 
    	l'operazione di Login.
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

	// Nel caso in cui un Username non venga individuato per il Login è necessario 
	// chiudere la connessione.
    if ($databaseUsername == '') {
    	error_log("Error in SabreDAV Login Algorithm");
    	die("Unknown Error");
    }
}

?>
```

#### Creazione di una vCard
```php
<?php

/**
 * Funzione utilizzata per creare una vCard dai dati forniti dall'utente durante il processo 
 * di creazione di un contatto.
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

    // Mappatura dei dati relativi agli indirizzi di posta elettronica.
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

#### Esempio di interfacciamento tra SabreDAV e HUGE

```php
<?php

/**
 * Funzione utilizzata per interfacciare il sistema delle vCard con gli algoritmi peculiari di HUGE.
 * Algoritmo che ha lo scopo di ritornare una lista di Nomi-Cognomi di tutte le vCard di una certa rubrica.
 *
 * Struttura dell'Array di ritorno dalla funzione.
 * $returnArray = array(
 *   'UID' => array(
 *   	'contactFirstName' => "",
 *   	'contactLastName' => ""
 * 	  )
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

Per quel che riguarda l'interfaccia grafica dell'applicazione è stato utilizzato Boostrap, uno dei più famosi *front-end framework*. Al di là della sua fama, Boostrap è stato scelto soprattutto per la sua vocazione *mobile first* e il numero di risorse di ogni genere disponibili online.
Le principali caratteristiche di questo framework sono: il layout a griglie e la serie di classi CSS *preconfezionate* che possono essere implementate rapidamente nell'applicazione, dando fin da subito un risultato funzionale.
La struttura a colonne di Bootstrap permette di creare layout grafici in grado di adattarsi dinamicamente a qualunque display realizzando quello che viene definito *responsive design*.
Proprio per la sua natura esso è un framework da utilizzarsi solo nelle prime fasi di un progetto (da qui il nome), Bootstrap non fornisce un'ampia gamma di componenti aggiuntivi avendo uno stile grafico in sè povero. Per questo motivo si ha deciso di implementare una libreria CSS e JS in stile [material design](http://fezvrasta.github.io/bootstrap-material-design/bootstrap-elements.html): la quale, oltre a fornire una formattazione molto simile allo stile di Google, offre anche alcune componenti aggiuntive come le *floating labels* e finestre di dialogo.

#### Esempio di utilizzo di Bootstrap: finestra di dialogo di log-in
Una parte di codice HTML utilizzata per realizzare la finestra di login dell'applicazione.

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
##### Il risultato
![Imgur](http://i.imgur.com/YMwCKiQ.png)

### ![jQuery Logo](http://i.imgur.com/iyMmW9C.png "jQuery Logo") jQuery

jQuery è un framework JavaScript che ha come intento quello di snellire la programmazione semplificando la manipolazione degli elementi HTML e la gestione degli eventi del DOM (Document Object Model). Per un'applicazione che nasce in quello che viene definito il *web 2.0*, non è pensabile il non utilizzo di JS: sia dal punto di vista grafico, che dal punto di vista delle funzionalità.
Oltre alla semplificazione del codice, un'altra importante caratteristica di jQuery è che è sviluppato per funzionare allo stesso modo su più browser possibili, permettendo al programmatore di concentrarsi più sull'effettivo sviluppo dell'applicazione che sul funzionamento multi-piattaforma.
Se si vuole rendere un'applicazione più dinamica e veloce, dal punto di vista dell'utilizzo, è necessaria l'implementazione delle richieste asincrone. Questa tecnologia è implementata in jQuery con il nome AJAX e il metodo $.ajax() relativo. Questo metodo permette l'esecuzione di uno script nel server (nel nostro caso un controller/metodo specifico di HUGE) per poter fornire nuovi dati all'utente senza dover eseguire il refresh della pagina.
In Syncbook tutte le interazioni tra utente e database sono state eseguite attraversi chiamate AJAX.
Qui di seguito viene riportata la parte di codice che eseguita nel momento in cui l'utente salva delle modifiche a un contatto.

#### Esempio di utilizzo della funzione $.ajax()
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

Frmework PHP utilizzato per implementare il paradigma di programmazione ORM (object-relational mapping) all'interno dei sorgenti di SabreDAV.
Si è presa la decisione di aggiungere questa funzionalità al progetto in modo tale da diminuire la quantità di codice scritto in fase di programmazione rendendo più semplici e lineari operazioni che sarebbero state molto complesse utilizzando mero linguaggio PHP.

#### ORM

L'Object-relation mapping è una tecnica di pragrammazione ampiamente utilizzata all'interno dei linguaggi di programmazione orientati all'utilizzo di strutture dati come gli oggetti. L'utilizzo di framework che implementano questo paradigma è spesso presente nel momento in cui è necessario interfacciare l'applicativo con uno specifico DBMS.
Nel caso del linguaggio PHP vengono implementati una serie di algoritmi con lo scopo di ampliare le funzionalità dell'estensione PDO rendendo più semplice per il programmatore la realizzazione di algoritmi che si appoggiano su Database altamente complessi e ramificati. Utilizzare l'ORM permette anche di risparmiare al programmatore molti controlli dovuti alla struttura di una base di dati.

##### Tabella "persona"
![Table persona](http://i.imgur.com/NnAE4p1.png?2 "Table persona")

##### Interfacciamento attraverso ORM

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
    // Nel caso in cui qualunque di questi dati non rispetti i vincoli descritti nella definizione
    // degli attributi, verrà generata un'eccezione. Opportunamente catturata attraverso 
    // il costrutto "try-catch".
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
Diventata il leader nella sua categoria con il passare del tempo, questa piattaforma ha fatto della velocità e dell'integrità dei dati i suoi punti di forza.
Ogni directory di lavoro creata attraverso Git identifica un repository cioè una struttura dati che contiene dei metadati che permettono di tracciare tutte le azioni che sono compiute in fase di progettazione.

#### Commit

All'interno di un repository ogni modifica al codice sorgente è possibile soltanto attraverso un'operazione di commit: un insieme di metadati a cui è possibile dare una descrizione. Attraverso questa metodologia, ogni membro del repository ha la possibilità di conoscere le differenze che sono state apportate all'interno dei file a cui un commit fa riferimento.

#### Branch

Attraverso una particolare tipologia di commit è possibile creare un branch all'interno di un repository, differente dal *master branch* che identifica la root directory e che viene creato attraverso il processo di inizializzazione di un repository.
Un branch è un insieme di metadati che permette l'identificazione di un insieme di file/cartelle all'interno di un repository. I branch vengono, molto spesso, utilizzati per differenziare le varie aree di lavoro dei membri del repo o, più semplicemente, per separare vari componenti di un progetto non collegati tra loro.

#### ![GitHub Logo](http://i.imgur.com/TRmTY2v.png "GitHub Logo") GitHub

Dato il fatto che Git nasce, principalmente, come una piattaforma per lavorare in gruppi di progetto composti da più persone, che molte volte vivono in luoghi distanti tra loro, è necessaria una piattaforma Server dove tutti possano accedere per apportare delle modifiche al Repository.
Viene fondato, quindi, nel 2008 GitHub. Sito web pubblico con lo scopo di fornire una completa piattaforma di hosting per i propri Repository. Esistono due versioni principali di questo servizio:
* Gratuito, per chiunque desideri pubblicare il proprio lavoro con il resto del mondo, avendo quindi la possibilità di esssere aiutati in caso di bisogno.
* A pagamento, per coloro che vogliono che i propri repository rimangano privati e che solo alcune persone possano accedere ad essi.
Queste due versioni presentano uguali capacità di gestione del codice, complete di statistiche e informazioni in tempo reale riguardanti il proprio lavoro.

##### Repository "Home"

![Repository Home](http://i.imgur.com/x2jxGiF.png "Repository Home")

L'immagine mostra la struttura della pagina iniziale di un repository all'interno di GitHub, vengono presentate le seguenti funzioni:
* fondatore del Repository e nome dello stesso (Nildric/Syncbook);
* numero di commit attualmente presenti all'interno del repository (451 commits);
* numero di branches attualmente presenti all'interno del repository (2 branches);
* numero di release attualmente presenti all'interno del repository (1 release);
* numero di contributors attualmente presenti all'interno del repository (2 contributors);
* struttura della Root directorry del repository;
* numero di issues attualmente presenti all'interno del repository (2 issues);
* numero di pull requests attualmente presenti all'interno del repository (2 pull requests);
* link alla wiki del repository;
* link ai grafici del repository, descritti nella sezione sottostante.

##### Repository "Graphs"

![Repository Graphs](http://i.imgur.com/UEQmwmy.png "Repository Graphs")

L'immagine mostra il portale attraverso il quale è possibile vedere:
* la data del primo commit del repository e la data dell'ultimo (Jan 18, 2015 - Jun 3, 2015);
* un grafico riassuntivo della frequenza dei commit compiuti durante il periodo sopra citato;
* la frequenza dei commit di ogni membro del repository nel tempo;
* il numero di righe di codice aggiunte e rimosse da ogni membro nel tempo.

##### Repository "Commits"

![Repository Commits](http://i.imgur.com/uCVUzD5.png "Repository Commits")

L'immagine mostra una parte della lista di Commit compiuti durante il ciclo di vita del Repository.
Per ogni Commit è possibile vedere:
* l'autore (Xooline/Nildric);
* la data in cui è stato fatto (May 27, 2015);
* la descrizione scritta dall'autore a riguardo;
* quanto tempo è trascorso tra la data di creazione e la data corrente (7 days ago);
* il codice identificativo (2cfc22a).

##### Esempio di "Commit"

![Esempio di Commit](http://i.imgur.com/fenzXku.png "Esempio di Commit")

In questa immagine vengono mostrate le modifiche al File a cui uno specifico Commit fa riferimento.

### Server

Tutti i servizi di Syncbook sono ospitati in un server cloud su [digitalocean.com](https://digitalocean.com).
Inoltre è stato registrato il dominio *syncbook.me* configurando i DNS della macchina virtuale, in aggiunta è stata installata una certificazione SSL, ormai diventata indispensabile per le applicazioni web.
Il server si basa su Ubuntu 14.04 LTS, per i servizi HTTP è stato installato Apache 2, PHP e MySQL. Per sfruttare appieno il dominio, e per fornire la funzione di registrazione agli utenti di Syncbook, è stato installato un mail server, nel particolare Postfix. La configurazione del mail server ha conseguito il seguente risultato su [mail-tester.com](https://www.mail-tester.com/):

![mail-tester.com](http://i.imgur.com/ARUvWfV.png)

## Conclusioni

Allo stato attuale del progetto possiamo dire di aver raggiunto in modo soddisfacente gli obbiettivi prefissati: Syncbook permette di organizzare una rubrica di contatti rispettando le regole dettate dagli standard vCard e mette a disposizione i dati inseriti dall'utente anche su altri dispositivi sincronizzati tramite WebDAV. Allo stesso tempo non sono state ancora implementate delle funzioni che potrebbero allargare l'utilizzo di Syncbook anche a gruppi di lavoro, oltre che al singolo utente: ad esempio la possibilità di creare più rubriche e di condividerle con delle persone selezionate. In ogni caso, grazie ai vari framework utilizzati, il progetto è stato sviluppato in modo tale da poter accogliere nuove modifiche senza dover stravolgere tutto il lavoro fatto in precedenza.
Per la realizzazione del progetto, abbiamo avuto modo di conoscere ed utilizzare strumenti che stanno alla base dello sviluppo di applicazioni, in questo caso web, all'interno del mondo del lavoro. Lo studio di questi applicativi, svolto da autodidatti ci ha permesso di sviluppare l'applicazione obiettivo del progetto in modo professionale e spendibile nel mondo reale.

### Problematiche

#### Utilizzo di Syncbook, dal dispositivo desiderato, prima di aver confermato l'indirizzo e-mail
L'unica problematica degna di nota, riguarda la creazione di un Database inattivo fino alla conferma dell'indirizzo e-mail da parte dell'utente. Visto che una base di dati viene creata in corrispondenza con la registrazione di un nuovo utente, voleva essere trovata una modalità attraverso la quale l'utente non potesse utilizzare le credenziali immesse durante la registrazione, dal dispositivo mobile, senza aver confermato il proprio indirizzo e-mail.

```sql
-- Creazione di un Database inattivo, non gestito dagli algoritmi dell'applicazione.
CREATE DATABASE IF NOT EXISTS sabredav_<username>_unactive;

-- Creazione delle varie tabelle del Database.

CREATE TABLE IF NOT EXISTS addressbooks (
    id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    principaluri VARCHAR(255),
    displayname VARCHAR(255),
    uri VARCHAR(200),
    description TEXT,
    synctoken INT(11) UNSIGNED NOT NULL DEFAULT '1',
    UNIQUE(principaluri(100), uri(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS cards (
    id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    addressbookid INT(11) UNSIGNED NOT NULL,
    carddata MEDIUMBLOB,
    uri VARCHAR(200),
    lastmodified INT(11) UNSIGNED,
    etag VARBINARY(32),
    size INT(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS addressbookchanges (
    id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    uri VARCHAR(200) NOT NULL,
    synctoken INT(11) UNSIGNED NOT NULL,
    addressbookid INT(11) UNSIGNED NOT NULL,
    operation TINYINT(1) NOT NULL,
    INDEX addressbookid_synctoken (addressbookid, synctoken)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS locks (
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    owner VARCHAR(100),
    timeout INTEGER UNSIGNED,
    created INTEGER,
    token VARBINARY(100),
    scope TINYINT,
    depth TINYINT,
    uri VARBINARY(1000),
    INDEX(token),
    INDEX(uri(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS principals (
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    uri VARCHAR(200) NOT NULL,
    email VARCHAR(80),
    displayname VARCHAR(80),
    vcardurl VARCHAR(255),
    UNIQUE(uri)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS groupmembers (
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    principal_id INTEGER UNSIGNED NOT NULL,
    member_id INTEGER UNSIGNED NOT NULL,
    UNIQUE(principal_id, member_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS propertystorage (
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    path VARBINARY(1024) NOT NULL,
    name VARBINARY(100) NOT NULL,
    value MEDIUMBLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE UNIQUE INDEX path_property ON propertystorage (path(600), name(100));

CREATE TABLE IF NOT EXISTS users (
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    digesta1 VARCHAR(32),
    UNIQUE(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Nel caso in cui l'indirizzo mail venga confermato dall'utente, viene eseguito la seguente serie di istruzioni.
-- Creazione di un Database gestito dall'applicazione
CREATE DATABASE IF NOT EXISTS sabredav_<username>;
-- Spostamento delle tabelle e del loro contenuto dal Database inattivo a quello attivo.
RENAME TABLE sabredav_<username>_unactive.addressbookchanges TO sabredav_<username>.addressbookchanges;
RENAME TABLE sabredav_<username>_unactive.addressbooks TO sabredav_<username>.addressbooks;
RENAME TABLE sabredav_<username>_unactive.cards TO sabredav_<username>.cards;
RENAME TABLE sabredav_<username>_unactive.groupmembers TO sabredav_<username>.groupmembers;
RENAME TABLE sabredav_<username>_unactive.locks TO sabredav_<username>.locks;
RENAME TABLE sabredav_<username>_unactive.principals TO sabredav_<username>.principals;
RENAME TABLE sabredav_<username>_unactive.propertystorage TO sabredav_<username>.propertystorage;
RENAME TABLE sabredav_<username>_unactive.users TO sabredav_<username>.users;
-- Cancellazione del Database inattivo.
DROP DATABASE sabredav_<username>_unactive;
```

### Implementazioni future

#### Gestione di più rubriche

Gestire più di una rubrica rispetto a quella offerta di default dalla piattaforma potrebbe essere, per molte persone, una funzionalità importante per poter gestire al meglio la propria lista di contatti, dividendola in categorie. Questa tipologia di gestione è supportata dal protocdollo CardDAV ma non è stata implementata perchè con la differente gestione della base di dati, necessaria per il corretto funzionamento di Syncbook, SabreDAV non permette di creare, modificare e cancellare più rubriche.

#### Importazione ed esportazione di vCard

Durante l'utilizzo della piattaforma potrebbe essere necessaria, per l'utente, la capacità di importare ed esportare i propri contatti da/a dispositivi che non utilizzano correttamente la formattazione standard.
Si è deciso di non implementare questa funzionalità principalmente per due motivi:
1. Il fattore di esportazione sta alla base della finalità di questo progetto, configurando il proprio dispositivo per poter utilizzare il protocollo CardDAV riuscendo ad avere contatti standardizzati ovunque si desideri.
Per quanto riguarda l'esportazione della vCard sotto la forma di file questa funzione non è stata implementata a causa di problemi dovuti dalle modifiche fatte alla base di dati utilizzata da SabreDAV.
2. Il fattore importazione, data la politica delle grandi aziende a riguardo l'uso degli RFC, sarebbe stato molto complesso da implementare perchè avere un algoritmo di mappatura per ogni tipologia di servizio offerto per la gestione dei propri contatti è quasi impossibile.
Un team di programmatori avrebbe dovuto essere incaricato solo di occuparsi delle varie sfaccettature di questo problema.

## Bibliografia

* [Articolo](http://alessandrorossini.org/2012/11/15/the-sad-story-of-the-vcard-format-and-its-lack-of-interoperability/) sulle problematiche riguardanti l'interoperabilità del formato vCard.

### Documentazione tecnica
* [HUGE](https://github.com/panique/huge);
* [Sabre.io](http://sabre.io/dav/);
* [Bootstrap](http://getbootstrap.com/);
* [Material Design](http://fezvrasta.github.io/bootstrap-material-design/bootstrap-elements.html)
* [jQuery](http://api.jquery.com/);
* [RedBean PHP](http://www.redbeanphp.com/);
* [Git](https://git-scm.com/doc);
* [GitHub](https://help.github.com/).

### Siti di riferimento
* [DigitalOcean](https://www.digitalocean.com/);
* [DNSimple](https://dnsimple.com/);
* [Namecheap](https://www.namecheap.com/);
* [StackOverflow](http://stackoverflow.com/);
* [BootSnip](http://bootsnipp.com/);

## Ringraziamenti

Si ringraziano:
* Callegari Filippo, per il lavoro svolto nella gestione della parte server del progetto;
* Sponchiado Francesco, peril lavoro svolto durante alcune fasi dello sviluppo di Syncbook.
