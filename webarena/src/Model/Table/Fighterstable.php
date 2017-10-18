<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table {

    function test() {
        return "ok";
    }

    function getBestFighter() {
       $bestfighter = $this->find("all")->max("level");
        return $bestfighter;
    }
    
    /**
     * 
     * @param type $name
     * @param type $playerid
     * @return boolean true = success, false = echec (combattant existe déjà)
     */
    function newFighter($playerid, $name){
        if(is_string($name) && strlen($playerid) == 36){

            //on vérifie que le combattant n'existe pas dans la base
            $query = $this->find()->where(['player_id =' => $playerid, 'name =' => $name])->count();

            //si le joueur n'existe pas en base
            if($query == 0){

                $query = $this->query()
                    ->insert(['name', 'player_id', 'coordinate_x ', 'coordinate_y', 'level', 'xp', 'skill_sight', 'skill_strength',
                        'skill_health', 'current_health'])
                    ->values([
                        'name' => $name,
                        'player_id' => $playerid,
                        'coordinate_x' => rand(0, 15),
                        'coordinate_y' => rand(0, 10),
                        'level' => 1,
                        'xp' => 0,
                        'skill_sight' => 2,
                        'skill_strength' => 1,
                        'skill_health' => 5,
                        'current_health' => 5
                    ])
                    ->execute();
                
                if($query == false){
                    return false;}
                else{
                    return true;}
            }
        }    
        return strlen($playerid);
    }    
}

