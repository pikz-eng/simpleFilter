<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Regions');
        $this->hasOne('Regions.Countries', [
            'className' => 'Countries',
            'foreignKey' => false,
            'conditions' => ['Regions.country_id = Countries.id']
        ]);
    }
}
