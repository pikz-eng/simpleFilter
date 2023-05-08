<?php

namespace App\Controller;

class HomeController extends AppController
{
    public function initialize():void
    {
        parent::initialize();
        $this->loadModel('Countries');
    }
    public function index()
    {
    }


    public function getAllCountries()
    {


    }
}
