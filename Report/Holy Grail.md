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

## Finalità di progetto
In seguito a un'analisi approfondita della situazione attuale del non utilizzo degli standard vCard, appare evidente che l'importazione ed esportazione di contatti tra dispositivi diversi non può avvenire, se non in modo incompleto.
(Dato il risultato di questo studio approfondito sui vari esempi di vCard diventa evidente che il motivo per il quale quando si importa un contatto da una tipologia di dispositivo ad un'altra il prodotto finito risulta spesso incompleto o corrotto.)

Per questo motivo si ha deciso di sviluppare un progetto per dimostrare come è possibile utilizzare gli Standard per la formattazione di una vCard e trarne vantaggio durante il processo di gestione di una rubrica.
(Entra quindi in gioco il frutto di ore e ore passate a programmare per poter presentare un progetto che vuole dimostrare come è possibile utilizzare gli Standard per la formattazione di una vCard e trarne vantaggio durante il processo di gestione di una rubrica.)

Syncbook è orientato principalmente a persone il quale uso di una rubrica va fuori dell'ordinario e a cui è necessario condividere i propri contatti frequentamente attraverso persone il quale dispositivo di visualizzazione principale è differente dal proprio.
Questo per il semplice motivo che tutte le informazioni basilari riguardanti un contatto vengono rappresentate dai vari gestori in modo molto simile permettendo l'interoperabilità tra dispositivi.

## Perchè un'applicazione Web?
La scelta di sviluppare un'applicazione web è stata effettuata per diversi motivi. Il primo è legato alla natura della libreria sabre.io: essa infatti è sviluppata totalmente in linguaggio PHP e per questa ragione è sembrato ovvio continuare con questa tecnologia a integrare nuovi servizi e funzionalità. Il secondo motivo ha come centralità la portabilità dell'applicazione: se da un lato sarebbe stato possibile progettare un'applicazione più rivolta al funzionamento lato client, come una applet Java o una app Android, dall'altro si ha riconosciuto che un'applicazione web avrebbe avuto un maggior bacino di utenza rispetto alle altre alternative. Questo perché un'applicazione web non ha bisogno di essere installata fisicamente nel dispositivo (e quindi essere anche vincolata al software del sistema operativo ospitante), in più gli ultimi layout grafici responsive permettono la visualizzazione delle stessa pagina in modo efficiente su un range di dispositivi molto più ampio rispetto agli anni passati.
==@TO-DO==

## Strumenti

#### Huge

==@TO-DO==

#### Sabre.io

Framework PHP, creato con lo scopo di dare la possibilità ai programmatori di sviluppare applicazioni Web completamente basate sui più recenti RFC di vCard e vCalendar nel modo più veloce e semplice possibile.

==@TO-DO More description needed==

Data la peculiare strutturazione della base di dati che viene utilizzata all'interno di Sabre/DAV è necessario creare un nuovo Database per ogni utente che desidera creare un account all'interno di Syncbook.

Alla base di questo problema sta il fatto che, secondo i creatori del Framework ogni utente dovrebbe essere gestito da un utente di livello più alto rispetto al proprio rendendo così più semplici per gli amministratori d'azienda le operazioni riguardanti la gestione dei Server.

Se l'applicazione fosse gestita in questo modo sarebbe impossibile per gli utenti svolgere alcune fondamentali operazioni sulle loro rubriche, rendendo il servizio offerto, da alcuni punti di vista, peggiore rispetto a molte altre alternative che si possono trovare sul Web.

Entra quindi in gioco il frammento di codice PHP che si può leggere sotto, utilizzato all'interno del file che si occupa della gestione degli accessi da dispositivi mobili per reindirizzare l'utente all'interno della base di dati corretta durante il login.

```php
<?php

// Algoritmo necessario solo nel caso in cui il nome utente non sia già stato individuato in precedenza.
if (!isset($databaseUsername)) {

	// Viene ricavato l'URI utilizzato per accedere alla pagina Web corrente
    $serverUri = $_SERVER["REQUEST_URI"];

    // Viene ricavato il path assoluto dello Script corrente all'interno del Server
    $serverName = $_SERVER["SCRIPT_NAME"];

	/*
    	Algoritmo utilizzato per ricavare l'username della persona che sta effettuando l'operazione di Login.
        Il nome utente viene poi salvato all'interno della variabile $databaseUsername.
        La variabile $databaseUsername sarà usata per indirizzare la persona al proprio database.

        Identificatore di un Database :
        sabredav_<username>
    */

    if (strpos($serverUri, '/principals/') !== false) {
        $databaseUsername = str_replace($serverName . "/principals/", "", $serverUri);
    } else if (strpos($serverUri, '/calendars/') !== false) {
        $databaseUsername = str_replace($serverName . "/calendars/", "", $serverUri);
    } else if (strpos($serverUri, '/addressbooks/') !== false) {
        $databaseUsername = str_replace($serverName . "/addressbooks/", "", $serverUri);
    } else {
        $databaseUsername = '';
    }

	// Nel caso in cui un Username non venga individuato per il Login è necessario chiudere la connessione.
    if ($databaseUsername === '') {die();}
}

?>
```

#### Bootstrap

==@TO-DO==

#### Material Design

==@TO-DO==

#### jQuery

==@TO-DO==

#### RedBean PHP

```php
<?php

/*
	Algoritmo utilizzato per creare un utente all'interno della base di 	dati dedicata a SabreDAV.
*/

function webDAVUserPrincipalCreate($webDAVUsername, $webDAVPassword, $webDAVEMail, $webDAVDisplayname, $webDAVvCardUrl = NULL) {
    $configurationClass = new configurationClass();

    if (databaseSabreDAVConnectRedBean($webDAVUsername, $configurationClass, TRUE)) {
        try {
            // Avvio di una transazione
            R::begin();

            // Creazione di un utente non amministratore all'interno del Database
            $beanUser = R::dispense('users');
            $beanUser = webDAVUserBuild($beanUser, $webDAVUsername, $webDAVPassword);
            $beanUserID = R::store($beanUser);

            // Creazione di un utente amministratore all'interno del Database
            $beanPrincipal = R::dispense('principals');
            $beanPrincipal = webDAVPrincipalBuild($beanPrincipal, $webDAVUsername, $webDAVEMail, $webDAVDisplayname, $webDAVvCardUrl);
            $beanPrincipalID = R::store($beanPrincipal);

            // Adding Instance to "addressbooks" Table for AddressBook creation purpose
            $beanAddressBook = R::dispense('addressbooks');
            $beanAddressBook = webDAVAddressBookBuild($beanAddressBook, $webDAVUsername);
            $beanAddressBookID = R::store($beanAddressBook);

            // Closing Transaction (Success)
            R::commit();
            return TRUE;
        } catch (Exception $exceptionError) {
            // Closing Transaction (Failure)
            R::rollback();
        }
    }
return FALSE;
}

?>
```
