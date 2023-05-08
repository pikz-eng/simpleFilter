<?php

namespace App\Model\Entity;

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Region extends Entity
{
    protected $_accessible = [
        '*' => true,
        'user' => true,
        'country' => true,
        'id' => false
    ];
}
