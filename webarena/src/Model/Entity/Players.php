<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Players extends Entity {
    
    /**
     * Prevent id to be mass-assigned or assigned by the user (auto incrementation has to be respected)
     */
    protected $_accessible = [
        '*' => true,
        //'id' => true
    ];
    public function getID(){
        return $this->id;
    }
     
    /**
     * Do not show hash passowrds to any one !!
     */
  // protected $_hidden = ['password'];
   
}
