<?php

namespace App\Controller;
use App\Controller\AppController;


class FightersController extends AppController {
    
    /**
     * This function computes if an attempted attack succeeds, or fails
     * @param type $fighter1Level : level of the fighter which attacks
     * @param type $fighter2Level : level of the fighter which is attacked
     * @return boolean : true if the attack succeeded, else false
     */
    public function doAttackSucceed($fighter1Level, $fighter2Level) {
        $doAttackSucceed = null;

        if (is_int($fighter1Level) && is_int($fighter2Level)) {
            // Pick a random number between 1 and 20
            $randomValue = rand(1, 20);

            // Use the formula to find the computed value
            $computedValue = 10 + $fighter2Level - $fighter1Level;

            // If the random value is more than the computed value, the attack succeeds. Else, it fails.
            if ($randomValue > $computedValue) {
                $doAttackSucceed = true;
            } else {
                $doAttackSucceed = false;
            }
        }

        return $doAttackSucceed;
    }

    /**
     * Deal with fighters attacks matters
     * @param type $idFighter1 : integer value, represents the ID of the player which attacks
     * @param type $idFighter2 : integer value, represents the ID of the player which is attacked
     */
    public function attackFighter($idPlayer1, $idPlayer2) {
        // Retrieve the two fighters entities thanks to the players IDs
        $fighter1 = $this->Fighters->getFighter($idPlayer1);
        $fighter2 = $this->Fighters->getFighter($idPlayer2);

        // Determine if the attack succeed, according to the given formula
        $doAttackSucceed = $this->doAttackSucceed($fighter1->level, $fighter2->level);
        $this->set('test4', $doAttackSucceed);
        
        // If the attack succeeds, decrement health of fighter injured
        if($doAttackSucceed == true)
        {
            $fighter2->current_health -= $fighter1->skill_strength;
        }
        
        $this->Fighters->save($fighter2);
        return $doAttackSucceed;
    }
    
    public function test()
    {
        $test = $this->attackFighter('545f827c-576c-4dc5-ab6d-27c33186dc3e', 'df92817e-59c4-4098-8123-487fac1d8299');
        
        $this->set('test4', $test);
    }
    
}
