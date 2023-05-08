<?php

namespace App\Controller;

use Cake\ORM\Query;

class UsersController extends AppController
{

    public function index()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $users = $this->Users->find()->toArray();
        $this->set("title", "Users");
        $this->set("users", $users);
        $this->set(compact('users'));

    }

    public function getUsersInfo()
    {

        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $query = $this->Users->find()
            ->leftJoinWith('Regions')
            ->leftJoinWith('Countries');
        $region = $this->request->getQuery('region');

        $users = $query->select([
            'id',
            'name',
            'region' => 'Regions.name',
            'country' => 'Countries.name',
        ])->toArray();
        $start = $this->request->getQuery('start', 0);
        $length = $this->request->getQuery('length', 10);
        $query->limit($length)->offset($start);

        $orderBy = '';
        $orderDir = '';
        if (array_key_exists('order', $this->request->getQuery())) {
            $orderBy = $this->request->getQuery('order')[0]['column'];
            $orderDir = $this->request->getQuery('order')[0]['dir'];
            if (!empty($orderBy) && !empty($orderDir)) {
                $columns = $this->Users->schema()->columns();
                $query->order([$columns[$orderBy] => $orderDir]);
            }
        }

        $users = $query->toArray();
        $filteredRecords = $this->Users->find()->count();
        $totalRecords = $this->Users->find()->count();

        $data = array('data' => $users, 'length' => count($users));

        $jsonData = [
            'draw' => intval($this->request->getQuery('draw')),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($filteredRecords),
            'data' => $users
        ];

        $this->response = $this->response->withStringBody(json_encode($jsonData));
        return $this->response;

    }

    public function getUsersByRegion()
    {

        $this->autoRender = false;
        $regionId = $this->request->getQuery('region_id');
        $countryId = $this->request->getQuery('country_id');

        $regionData = $this->Users->Regions->find()
            ->contain(['Countries'])
            ->select(['Regions.name', 'Countries.name'])
            ->where(['Regions.id' => $regionId])
            ->first();

        $query = $this->Users->find()->where(['region_id' => $regionId]);
        if (empty($regionData)) {
            $regionData = $this->Users->Regions->find()
                ->contain(['Countries'])
                ->select(['Regions.name', 'Countries.name'])
                ->where(['Countries.id' => $countryId])
                ->first();
            if (!empty($regionData)) {
                $query->matching('Regions', function ($q) use ($regionData) {
                    return $q->where(['Regions.id' => $regionData->id]);
                });
            }
        }

        $response = [
            'draw' => $this->request->getQuery('draw'),
            'recordsTotal' => $query->count(),
            'recordsFiltered' => $query->count(),
            'data' => []
        ];

        $start = $this->request->getQuery('start') ?? 0;
        $length = $this->request->getQuery('length') ?? 10;
        $order = $this->request->getQuery('order');
        $search = $this->request->getQuery('search')['value'];

        if (!empty($search)) {
            $query->andWhere(['name LIKE' => '%' . $search . '%']);
            $response['recordsFiltered'] = $query->count();
        }

        if (!empty($order)) {
            $column = $this->request->getQuery('columns')[$order[0]['column']]['data'];
            $direction = $order[0]['dir'];
            $query->order([$column => $direction]);
        }

        $query->limit($length)->offset($start);

        foreach ($query as $user) {
            $response['data'][] = [
                'name' => $user->name,
                'region_name' => $regionData->name,
                'country_name' => $regionData->country->name
            ];
        }

        $this->response = $this->response->withType('application/json')->withStringBody(json_encode($response));
        return $this->response;
    }
}
