<?php

namespace App\Controller;

use App\Controller\AppController;

class HoFController extends AppController {
    
    public function initialize()
    {
        $this->loadModel('Fighters');
    }
        
     public function drawCharts(){   
         
          $fighters = $this->Fighters->find('all');
          
         // First chart : bar chart showing each fighter with their level
         // So we need to store the name and the level of fighters
         $arrayFighters = array();
         foreach($fighters as $fighter) {
             array_push ($arrayFighters, array (['name' => $fighter->name, 'level' => $fighter->level]));
         };
         $this->set('FightersArray', $arrayFighters);
         
         // Second chart : pie charts showing health, sight and strength skills
         // So we need to store the health, sight skill and strength skill of fighters (with their name for sub-pies calling)
         $arraySkillsFighters = array();
         foreach($fighters as $fighter) {
             array_push ($arraySkillsFighters, array (['name' => $fighter->name, 'health' => $fighter->skill_health, 'sight' => $fighter->skill_sight, 'strength' => $fighter->skill_strength, 'playerId' => $fighter->player_id]));
         };
         $this->set('FightersSkillsArray', $arraySkillsFighters);
         
         
         
     }
    
}
