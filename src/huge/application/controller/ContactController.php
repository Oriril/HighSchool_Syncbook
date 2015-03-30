<?php

class ContactController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (LoginModel::isUserLoggedIn()) {
            Redirect::home();
        } else {
            $this->View->render('contact/index');
        }
    }
} 