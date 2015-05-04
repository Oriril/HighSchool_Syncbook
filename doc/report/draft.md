# Syncbook
* Introduzione al progetto
  * Presentazione del problema
  * [Articolo](http://alessandrorossini.org/2012/11/15/the-sad-story-of-the-vcard-format-and-its-lack-of-interoperability/)
  * Esempi di vCard vs Google & co
  * Risoluzione (abbiamo deciso di svolgere questo ecc ecc)

* Corpo
  * Perchè è stata scelta un'applicazione web
  * Strumenti utilizzati (con spiegazione e motivazioni)
    * Applicazione
      * huge
        * anche segmenti significativi del codice (es.: classe Application.php, htacces)
      * sabre
      * bootstrap (e material...)
      * jQuery
      * RedBean
    * Server
      * server mail(postfix, roudcube, ...)
      * stack lamp (apache, php, ...)
      * SSL
      * dnsSimple
    * Altro
      * GitHub
      * namecheap
      * digital ocean
  * // descrizione di come abbiamo adattato huge e sabre ai nostri scopi?
  * Problematiche
    * "Access denied" json 
    * Creazione utente da huge anche dentro sabre
    * ...
  * Segmenti significativi del codice
    * esempio di chiamata ajax
    * mapper vCard
    * un metodo di ContactController.php
