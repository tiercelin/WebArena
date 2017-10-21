<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Fighters extends Entity{
    
    /**
     * Initalize fighter parameters
     */
      public function initFighterParameters(){
      $this->coordinate_x = 0;
      $this->coordinate_y = 0;
      $this->level = 1;
      $this->xp = 0;
      $this->skill_sight = 2;
      $this->skill_health = 5;
      $this->skill_strength = 1;
      $this->current_health = 5;
      // add next action time if time limit implemented
    }
    
    
    // Define setters to complete the creation of the entity (other setter -> simple set() function / getters : SELECT get () function)
    public function _setName($name){
      $this->__set('name',$name);
    }
    
    public function setPlayerId($player_id){
      $this->__set('guild_id',$player_id);
    }

    public function setGuildId($guild_id){
      $this->__set('guild_id',$guild_id);
    }    
    
    /**
     * Prevent id to be mass-assigned or assigned by the user (auto incrementation has to be respected)
     */
     protected $_accessible = [
        '*' => true,
        //'id' => false
    ];

   

  
    
}
