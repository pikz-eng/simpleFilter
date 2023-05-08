<?php

namespace App\Controller;

class RegionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Regions');
    }

    public function index()
    {

    }

    public function getRegionsByCountry()
    {
        $countryId = $this->request->getQuery('country_id');
        $this->autoRender = false;
        if ($countryId !== null) {
            $regions = $this->Regions->find()->where(['country_id' => $countryId])->toArray();
            $this->response = $this->response->withType('application/json')->withStringBody(json_encode($regions));
        } else {
            $this->response = $this->response->withType('application/json')->withStringBody(json_encode([]));
        }
        return $this->response;
    }
//
//        public function getUsersByRegion()
//    {
//        $regionId = $this->request->getQuery('region_id');
//        $this->autoRender = false;
//        if ($regionId !== null) {
//            $users = $this->Users->find()->where(['region_id' => $regionId])->toArray();
//            $this->response = $this->response->withType('application/json')->withStringBody(json_encode($users));
//       } else {
//           $this->response = $this->response->withType('application/json')->withStringBody(json_encode([]));
//        }
//     return $this->response;
//
//   }
}
