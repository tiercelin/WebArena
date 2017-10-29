<?php

namespace App\Controller;

use App\Controller\AppController;

class HoFController extends AppController {
    
    public function initialize()
    {
        $this->loadModel('Fighters');
        $this->loadModel('Events');
    }
        
     public function drawCharts(){   
         
          $fighters = $this->Fighters->find('all');
          $events = $this->Events->find('all');
          
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
         
         
         // Third charts : default charts with dates axis showing when users last connexion
         // We need to store the name of the users and their last connexion date, thanks to the events table
         $arrayConnexionUsers = array();
         foreach($events as $event)
         {
             // If the given event is a connexion acknowledgment event
             if (strpos($event->name, 'connected') == true)
             {
                 $nameUserEvent = explode(" ",$event->name)[0];
                 $nameUserConnected = $nameUserEvent.' connected';
                 $nameUserLogOut = $nameUserEvent.' log out';
                 // Find the approriated disconnexion acknowledgment event
                $login = $this->Events->find()->where(['name' => $nameUserConnected])->order(['date' => 'DESC'])->first();
                $logout = $this->Events->find()->where(['name' => $nameUserLogOut])->order(['date' => 'DESC'])->first();

                 if($logout->date != $login->date)
                 {
                   array_push ($arrayConnexionUsers, array (['nameUser' => $nameUserEvent, 'dateLastConnexion' => strtotime($login->date), 'dateLastDisconnexion' => strtotime($logout->date)]));               
                 }
              
             }
          }
         $this->set('eventsConnexionArray', $arrayConnexionUsers);
     
     }
     
    
}
