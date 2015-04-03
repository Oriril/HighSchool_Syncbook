<?php

class ContactController extends Controller {

    public function __construct()
    {
        parent::__construct();

        Auth::checkAuthentication();
    }

    public function index()
    {
        if (LoginModel::isUserLoggedIn()) {
            $this->View->render('contact/index');
        } else {
            Redirect::home();
        }
    }

    public function addContact() {
        if (LoginModel::isUserLoggedIn()) {
            $this->View->render('contact/addcontact');
        } else {
            Redirect::home();
        }
    }

    public function insertContact() {
        $insertion_successfull = ContactModel::insertNewContact();

    }
} 