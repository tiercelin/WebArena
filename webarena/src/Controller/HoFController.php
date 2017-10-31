<?php

namespace App\Controller;

use App\Controller\AppController;

class HoFController extends AppController {

    public function initialize() {
        $this->loadModel('Fighters');
        $this->loadModel('Events');
    }

    public function drawCharts() {

        $fighters = $this->Fighters->find('all');
        $events = $this->Events->find('all');

        // First chart : bar chart showing each fighter with their level
        // So we need to store the name and the level of fighters
        $arrayFighters = array();
        if (!is_null($fighters) && !empty($fighters)) {
            foreach ($fighters as $fighter) {
                if (!is_null($fighter)) {
                    array_push($arrayFighters, array(['name' => $fighter->name, 'level' => $fighter->level]));
                }
            };
        }
        $this->set('FightersArray', $arrayFighters);


        // Second chart : pie charts showing health, sight and strength skills
        // So we need to store the health, sight skill and strength skill of fighters (with their name for sub-pies calling)
        $arraySkillsFighters = array();
        if (!is_null($fighters) && !empty($fighters)) {
            foreach ($fighters as $fighter) {
                if (!is_null($fighter)) {
                    array_push($arraySkillsFighters, array(['name' => $fighter->name, 'health' => $fighter->skill_health, 'sight' => $fighter->skill_sight, 'strength' => $fighter->skill_strength, 'playerId' => $fighter->player_id]));
                }
            }
        }

        $this->set('FightersSkillsArray', $arraySkillsFighters);
        
    }
    
    public function drawCharts2()
    {
        $fighters = $this->Fighters->find('all');
        $events = $this->Events->find('all');
        
        // Third charts : default charts with dates axis showing when users last connexion
        // We need to store the name of the users and their last connexion date, thanks to the events table
        $arrayConnexionUsers = array();
        if (!is_null($events) && !empty($events)) {
            foreach ($events as $event) {
                if (!is_null($event)) {
                    // If the given event is a connexion acknowledgment event
                    if (strpos($event->name, 'connected') == true) {
                        $nameUserEvent = explode(" ", $event->name)[0];
                        $nameUserConnected = $nameUserEvent . ' connected';
                        $nameUserLogOut = $nameUserEvent . ' log out';
                        // Find the approriated disconnexion acknowledgment event
                        $login = $this->Events->find()->where(['name' => $nameUserConnected])->order(['date' => 'DESC'])->first();
                        $logout = $this->Events->find()->where(['name' => $nameUserLogOut])->order(['date' => 'DESC'])->first();
                        if (!is_null($login) && !is_null($logout)) {
                            if ($logout->date != $login->date) {
                                array_push($arrayConnexionUsers, array(['nameUser' => $nameUserEvent, 'dateLastConnexion' => strtotime($login->date), 'dateLastDisconnexion' => strtotime($logout->date)]));
                            }
                        }
                    }
                }
            }
        }

        $this->set('eventsConnexionArray', $arrayConnexionUsers);

        // Fourth chart : meter jauge charts showing victorious attacks
        // So we need to store the level and XP of fighters (with their name for sub-charts calling)
        $arrayXPFighters = array();
        if (!is_null($fighters) && !empty($fighters)) {
            foreach ($fighters as $fighter) {
                if(!is_null($fighter)){
                    array_push($arrayXPFighters, array(['name' => $fighter->name, 'level' => $fighter->level, 'XP' => $fighter->xp, 'playerId' => $fighter->player_id]));
                }
            }
        }
        $this->set('FightersXPArray', $arrayXPFighters);
        
    }

}
