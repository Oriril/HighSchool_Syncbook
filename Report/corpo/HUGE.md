##Huge
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

HUGE presenta una struttura MCV, ma i metodi utilizzati sono per lo più statici. La struttura MCV viene sfruttata appieno dalla configurazione del file .htcaccess.


# Il file .htcaccess
```
Options -MultiViews

RewriteEngine On

Options -Indexes

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
```

