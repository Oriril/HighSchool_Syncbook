# Syncbook
![Syncbook Logo](http://i.imgur.com/oONGOVT.png "Syncbook Logo")

## Indice

[TOC]

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
# Necessario per evitare problemi nel caso in cui si usi un controller chiamato "index" avendo un file root index.php
# http://httpd.apache.org/docs/2.2/content-negotiation.html
Options -MultiViews

# Attivazione URL rewriting (ES.: myproject.com/controller/action/1/2/3)
RewriteEngine On

# Impedisce che si possa navigare direttamente nelle cartelle
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
    /** @var mixed instanza del controller */
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
        // crea array con i parametri in URL in $url
        $this->splitUrl();

        // esegue controllo sul controller: non è stato dato un controller ? allora setta ontroller = default controller (dalla configurazione)
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


### ![Sabre Logo](http://i.imgur.com/tSCEawe.png "Sabre Logo") Sabre.io

Framework PHP, creato con lo scopo di dare la possibilità ai programmatori di sviluppare applicazioni Web completamente basate sui più recenti RFC di vCard e vCalendar nel modo più veloce e semplice possibile.

==@TO-DO More description needed==

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
    if ($databaseUsername == '') {die();}
}

?>
```

###### Creazione di una vCard
```php
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
```

###### Esempio di interfacciamento tra SabreDAV e HUGE

```php
/**
 * Function to Retrieve an AddressBook from an AddressBooksList for a specific User
 *
 * @param PDO $connectionPDO
 * @param string $webDAVUsername
 * @param string $addressBookUri
 * @return bool|\Sabre\CardDAV\AddressBook
 */
function cardDAVAddressBookRetrieve(PDO $connectionPDO, $webDAVUsername, $addressBookUri) {
    try {
        // Retrieving AddressBooksList for User
        $addressBooksList = cardDAVAddressBooksList($connectionPDO, $webDAVUsername);
        // Checking if Retrieving operation went good
        if ($addressBooksList !== FALSE) {
            foreach ($addressBooksList as $addressBookInfo) {
                // Checking if addressBookUri is found in List
                if ($addressBookInfo['uri'] == $addressBookUri) {
                    // Building CardDAV Backend
                    $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);
                    // Retrieving AddressBook
                    if ($addressBook = new Sabre\CardDAV\AddressBook($cardDAVBackend, $addressBookInfo)) {return $addressBook;}
                }
            }
        }
    } catch (Exception $exceptionError) {}
return FALSE;
}
```

### ![Bootstrap Logo](http://i.imgur.com/pGBc45r.png "Bootstrap Logo") Bootstrap

==@TO-DO==

#### Material Design

==@TO-DO==

### ![jQuery Logo](http://i.imgur.com/iyMmW9C.png "jQuery Logo") jQuery

==@TO-DO==

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
- Gratuito, per chiunque desideri pubblicare il proprio lavoro con il resto del mondo, avendo quindi la possibilità di esssere aiutati in caso di bisogno;
- A pagamento, per coloro che vogliono che i propri Repository rimangano privati e che solo alcune persone possano accedere ad essi.

Queste due versioni presentano uguali capacità di gestione del codice, complete di statistiche e informazioni in tempo reale riguardanti il proprio lavoro.

###### Repository Home
