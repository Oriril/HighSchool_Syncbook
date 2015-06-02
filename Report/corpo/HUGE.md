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

## Struttura e funzionamento
HUGE presenta una struttura MCV, ma i metodi utilizzati sono per lo più statici. La struttura MCV viene sfruttata appieno dalla configurazione di un file .htaccess e dal file Application.php. Tutte le richieste http vengono dirottate da apache nella cartella public in cui è presente il file index.php che non fa altro che creare una nuova istanza della classe Application.


### Il file .htaccess della cartella *public*
```.htaccess
# Necessary to prevent problems when using a controller named "index" and having a root index.php
# more here: http://httpd.apache.org/docs/2.2/content-negotiation.html
Options -MultiViews

# Activates URL rewriting (like myproject.com/controller/action/1/2/3)
RewriteEngine On

# Prevent people from looking directly into folders
Options -Indexes

# If the following conditions are true, then rewrite the URL:
# If the requested filename is not a directory,
RewriteCond %{REQUEST_FILENAME} !-d
# and if the requested filename is not a regular file that exists,
RewriteCond %{REQUEST_FILENAME} !-f
# and if the requested filename is not a symbolic link,
RewriteCond %{REQUEST_FILENAME} !-l
# then rewrite the URL in the following way:
# Take the whole request filename and provide it as the value of a
# "url" query parameter to index.php. Append any query string from
# the original URL as further query parameters (QSA), and stop
# processing this .htaccess file (L).
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
```

Il file .htacces appena descritto è presente nella cartella public i HUGE, allo stesso livello del file index.php. Questo file permette il funzionamento dello "url rewriting" e dell'esecuzione di controller/metodi tramite determinati parametri presenti nelle richieste http.

### La classe *Application.php*
```php
<?php
class Application
{
    /** @var mixed Instance of the controller */
    private $controller;

    /** @var array URL parameters, will be passed to used controller-method */
    private $parameters = array();

    /** @var string Just the name of the controller, useful for checks inside the view ("where am I ?") */
    private $controller_name;

    /** @var string Just the name of the controller's method, useful for checks inside the view ("where am I ?") */
    private $action_name;

    /**
     * Start the application, analyze URL elements, call according controller/method or relocate to fallback location
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        // check for controller: no controller given ? then make controller = default controller (from config)
        if (!$this->controller_name) {
            $this->controller_name = Config::get('DEFAULT_CONTROLLER');
        }

        // check for action: no action given ? then make action = default action (from config)
        if (!$this->action_name OR (strlen($this->action_name) == 0)) {
            $this->action_name = Config::get('DEFAULT_ACTION');
        }

        // rename controller name to real controller class/file name ("index" to "IndexController")
        $this->controller_name = ucwords($this->controller_name) . 'Controller';

        // does such a controller exist ?
        if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {

            // load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
            $this->controller = new $this->controller_name();

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->controller, $this->action_name)) {
                if (!empty($this->parameters)) {
                    // call the method and pass arguments to it
                    call_user_func_array(array($this->controller, $this->action_name), $this->parameters);
                } else {
                    // if no parameters are given, just call the method without parameters, like $this->index->index();
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

            // put URL parts into according properties
            $this->controller_name = isset($url[0]) ? $url[0] : null;
            $this->action_name = isset($url[1]) ? $url[1] : null;

            // remove controller name and action name from the split URL
            unset($url[0], $url[1]);

            // rebase array keys and store the URL parameters
            $this->parameters = array_values($url);
        }
    }
}
?>

```
La classe Application.php sta alla base di tutto il funzionamento dell'applicazione. Tutte le richieste al server vengono effettuate con lo schema "dominio.com/controller/metodo" e il protocollo http aggiunge gli eventuali parametri provenienti da form. In questo modo il file .htaccess può effettuare *url rewriting* mostrando appunto la stringa "dominio.com/controller/metodo" e non il il file che viene eseguito (in questo caso index.php).
La prima operazione effettuata nel costruttore della classe Application è l'esecuzione del metodo *splitUrl()* che setta a dei valori iniziali gli attributi della classe *controller_name*, *action_name* e *parameters*, che rispettivamente sono il controller e il metodo (più i parametri) che andranno poi eseguiti.
In seguito si effettuano dei controlli se esistono o meno il controller e il metodo selezionati, nel caso contrario vengono settati a valori di default (ad esempio un configurazione di default potrebbe essere *index/index*, cioè effettuare il redirect alla pagina iniziale). Una volta effettuata la convalida si procede con la creazione dell'instanza del controller selezionato e si richiama il metodo associato passando i parametri ricavati (se ce ne sono).
