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
     * @param type $idPlayer1 : integer value, the ID of the player which attacks
     * @param type $idPlayer2 : integer value, the ID of the player which is attacked
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
            $fighter1->xp ++;
            $this->Fighters->save($fighter1);
            $this->Fighters->save($fighter2);

            // If the attacked fighter current health is at 0, delete it and create new fighter. Fighter 1 wins XP equals to fighter 2 level.
            if($fighter2->current_health == 0)
            {
                $fighter1->xp += $fighter2->level;
                $this->deleteFighter($idPlayer2);
            }
             
             
        }
        
       
        return $doAttackSucceed;
    }
    
    public function test()
    {
        /*
        // Retrieve the rigth file name to display the avatar
                    $avatarFilenameTest = count(glob(WWW_ROOT . '/img/avatar/df92817e-59c4-4098-8123-487fac1d8299' . '.*')) ;
     
                    if($avatarFilenameTest != 0)
                    {
                        $avatarFilename = 'df92817e-59c4-4098-8123-487fac1d8299.jpg';  
                    }
                    else
                    {
                        $avatarFilename = 'kittenWarrior.jpg';
                    }
                    
                    $this->set('test4', $avatarFilename);
        */
        
        
        
        
        
        
        $idPlayer = 'df92817e-59c4-4098-8123-487fac1d8299';
        
        // If the request is not null -> if an image has been selected
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['upload']['name'])) {   
                // Put the image into a variable
                $file = $this->request->data['upload']; 
                
                // Get the image extension
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); 
                
                // Set allowed extensions
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); 
                
                // Set name of image
                $setNewFileName = $idPlayer;
                
                // If the extension is valid
                if (in_array($ext, $arr_ext)) {
                    // Upload the file from local repertory to webroot/upload/avatar repertory
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/avatar/' . $setNewFileName . '.' . $ext);
                    
                    // Retrieve (common) name of the image
                    $imageFileName = $setNewFileName . '.' . $ext;
    }
}
   
   
}

                
    }
    
}
