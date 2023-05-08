<?php

namespace App\Controller;

class CountriesController extends AppController
{

    public function index()
    {
    }

    public function getCountries()
    {
        $this->autoRender = false;
        $countries = $this->Countries->find('all')->toArray();
        $this->response = $this->response->withType('json');
        $this->response->getBody()->write(json_encode($countries));
        return $this->response;
    }
}
