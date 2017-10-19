<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Surroundings extends Entity {
    
    /**
     * Prevent id to be mass-assigned or assigned by the user (auto incrementation has to be respected)
     */
     protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
