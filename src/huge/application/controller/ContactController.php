<?php

class ContactController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (LoginModel::isUserLoggedIn()) {
            $this->View->render('contact/index');
        } else {
            Redirect::home();
        }
    }
} 