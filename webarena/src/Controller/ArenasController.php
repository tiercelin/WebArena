<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Surroundings;

/**
 * Personal Controller
 * User personal interface
 *
 */
class ArenasController extends AppController {

    const WIDTH = 15;
    const LENGTH = 10;

    /**
     * Initialize function : load all models
     */
    public function initialize() {
        $this->loadModel('Players');
        $this->loadModel('Fighters');
        $this->loadModel('Surroundings');
        $this->loadModel('Events');
    }

    /**
     * Check if a user is currently connected
     * @return boolean : true if user is connected, else redirect to login page
     */
    public function isUserConnected() {
        if ($this->request->session()->check('playerId')) {
            return true;
        } else {
            return $this->redirect(['controller' => 'players', 'action' => 'loginPlayer']);
        }
    }

    public function logout() {
        $this->request->session()->destroy();
        return $this->redirect(['controller' => 'players', 'action' => 'loginPlayer']);
    }

    ////////// ********** INDEX PART **********\\\\\\\\\\

    /**
     * Index page of the player -> display rules of game and other info
     */
    public function index() {
        if ($this->isUserConnected()) {
            // Put code here
        }
    }

    ////////// ********** FIGHTER PART **********\\\\\\\\\\

    /**
     * This function proposes to the user to create a fighter. Display this page if the user is connected and if he has no fighter
     */
    public function createFighter() {
        $session = $this->request->session();

        // Verify that the user is connected
        if ($this->isUserConnected()) {
            // Retrieve the ID of the current player
            $idPlayer = $session->read('playerId');

            // Find if this user has fighter(s)          
            $fighters = $this->Fighters->find()->where(['player_id = ' => $idPlayer]);

            // If the user has no fighter created 
            if ($fighters->count() == 0) {
                if ($this->request->is('post')) {
                    // Create a new fighter
                    $fightersTable = TableRegistry::get('Fighters');
                    $newFighter = $fightersTable->newEntity();

                    // Initialize its default parameters
                    $newFighter->initFighterParameters();

                    // Initialize other parameters with the form data
                    $newFighter->setName($this->request->getData('name'));
                    $newFighter->setPlayerId($idPlayer);

                    // Save the new fighter into the database and redirect user to fighter stats page
                    $fightersTable->save($newFighter);
                    return $this->redirect(['controller' => 'arenas', 'action' => 'fighter']);
                }
            } else {
                return $this->redirect(['controller' => 'arenas', 'action' => 'fighter']);
            }
        }
    }

    /**
     * This function delete a fighter with this one is dead, and redirect the user to the fighter creation page
     */
    public function deleteFighter() {
        $session = $this->request->session();
        // Verify that the user is connected
        if ($this->isUserConnected()) {
            // Retrieve the ID of the current player
            $idPlayer = $session->read('playerId');

            // Retrieve the fighter entity to be deleted
            $fighterToDelete = $this->Fighters->getFighter($idPlayer);

            // Delete this fighter          
            $this->Fighters->delete($fighterToDelete);

            // Redirect the user to the fighter creation page
            return $this->redirect(['controller' => 'arenas', 'action' => 'createFighter']);
        }
    }

    /**
     * This function shows the fighter page : fighter ID card, actual stats, (potential) possibility to upgrade stats, ...
     */
    public function fighter() {
        if ($this->isUserConnected()) {
            $this->initialize();
            // Get ID of current player
            $session = $this->request->session();
            $idPlayer = $session->read('playerId');
            
            // This part is used to upgrade the fighter stats. If the value $upgrade is not 0,
            //the function upgrade is called
              $upgrade = 0;
              $upgrade = $this->request->getData('upgrade');
              if($upgrade != 0){
              $this->Upgrade($upgrade);
              } 

          
              

            // Get his fighter
            $entity = $this->Fighters->getFighter($idPlayer);
            if (!is_null($entity)) {
                // Display fighter data
                $this->set('id_f', $entity->id);
                $this->set('name_f', $entity->name);
                $this->set('lvl_f', $entity->level);
                $this->set('exp_f', $entity->xp);

                $this->set('sight_f', $entity->skill_sight);
                $this->set('str_f', $entity->skill_strength);
                $this->set('health_f', $entity->skill_health);
                
                //Display the levels available for the fighter, rounded down
              $this->set('levelsavailable', floor($entity->xp/4));

                
            }
        }
    }
    
    /**
     * This function upgrades the fighters stats
     * @param type $upgrade: The value of $upgrade corresponds to the stat the user wants to upgrade
     * There is no need for a return
     */
    public function Upgrade($upgrade)
    { 
        //Get the session and id of player.
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');

        //Get the fighter of the player
        $fighter = $this->Fighters->getFighter($idPlayer);
        
        //Upgrade = 1 corresponds to sight
        if ($upgrade == 1)
                {
                //The fighter gains a level, his exp is decreased by 4 (exp needed for a level)
                $fighter->level++;
                $fighter->xp-=4;
                //Then we upgrade his sight by 1, and send the whole to the database to save the changes.
                $fighter->skill_sight++;
                $this->Fighters->save($fighter);
                }
        //Upgrade = 2 corresponds to strength
        if ($upgrade == 2)
                { 
                //The fighter gains a level, his exp is decreased by 4 (exp needed for a level)
                $fighter->level++;
                $fighter->xp-=4;
                //Then we upgrade his strength by 1, and send the whole to the database to save the changes.
                $fighter->skill_strength++;
                $this->Fighters->save($fighter);
                }
        //Upgrade = 3 corresponds to health
        if ($upgrade == 3)
                { 
                //The fighter gains a level, his exp is decreased by 4 (exp needed for a level)
                $fighter->level++;
                $fighter->xp-=4;
                //Then we upgrade his health by 3
                $fighter->skill_health+=3;
                //Then we heal the fighter up to his new maximum health
                $fighter->current_health = $fighter->skill_health;
                //Then we send the whole to the database to save the changes.
                $this->Fighters->save($fighter);
                }
        
    }

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
        $doAttackSucceed = doAttackSucceed($fighter1->level, $fighter2->level);
        $this->set('test4', $doAttackSucceed);
    }

    ////////// ********** SIGHT PART **********\\\\\\\\\\

    /**
     * Display the matrix game with all elements
     */
    public function sight() {
        if ($this->isUserConnected()) {
            $mov = $this->request->getData('movement');
            $attack = $this->request->getData('attack');
            
              $regenerate = false;
              $regenerate = $this->request->getData('regenerate');
              if($regenerate==true){
              $this->regenerateMap();
              } 
            
              
            if (!is_null($mov)) {
                $this->move($mov);
            }
            if(!is_null($attack)) {
                $this->handleAttack($attack);
            }
            $length = self::WIDTH;
            $width = self::LENGTH;
            $this->set('length', $length);
            $this->set('width', $width);

            $fighter = $this->Fighters->getFighter($this->request->session()->read('playerId'));
            $this->set('fighter', $fighter);

            $mytable = $this->Surroundings->getSurroundings();
            $this->set('entities', $mytable);
            $this->set('controller', $this);
        }
    }

    /**
     * Updates fighter coordinates on the database
     * @param type $mov : string giving the direction of the movement
     */
    public function move($mov) {
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');

        $fighter = $this->Fighters->getFighter($idPlayer);

        //si le joueur monte
        if ($mov == 'top' && $fighter->coordinate_x > 0) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x-1, $fighter->coordinate_y);

            if (is_null($content)) {
                $fighter->coordinate_x--;
                $this->Fighters->save($fighter);
            }
            else if(($content->type == 'T') || ($content->type == 'W')){
                $this->deleteFighter();
            }
        }
        //si le joueur descend
        else if ($mov == 'left' && $fighter->coordinate_y > 0) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y-1);

            if (is_null($content)) {
                $fighter->coordinate_y--;
                $this->Fighters->save($fighter);
            }
            else if(($content->type == 'T') || ($content->type == 'W')){
                $this->deleteFighter();
            }
        }
        //si le joueur va à droite
        else if ($mov == 'right' && $fighter->coordinate_y < self::WIDTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y+1);

            if (is_null($content)) {
                $fighter->coordinate_y++;
                $this->Fighters->save($fighter);
            }
            else if(($content->type == 'T') || ($content->type == 'W')){
                $this->deleteFighter();
            }
        }
        //si le joueur va a gauche
        else if ($mov == 'bottom' && $fighter->coordinate_x < self::LENGTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x+1, $fighter->coordinate_y);

            if (is_null($content)) {
                $fighter->coordinate_x++;
                $this->Fighters->save($fighter);
            }
            else if(($content->type == 'T') || ($content->type == 'W')){
                $this->deleteFighter();
            }
        }
    }
    
    public function handleAttack($attack){
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');

        $fighter = $this->Fighters->getFighter($idPlayer);
        
        if($attack == 'attacktop' && $fighter->coordinate_x > 0){
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x-1, $fighter->coordinate_y);
            $fighter2 = $this->Fighters->getFighterByCoord($fighter->coordinate_x-1, $fighter->coordinate_y);
            
            //si on trouve un monstre
            if(!is_null($content) && $content->type == 'W'){
                $this->Surroundings->delete($content);
            }
            else if(!is_null($fighter2)){
                //THOMAS
            }
        }
        if($attack == 'attackleft' && $fighter->coordinate_y > 0){
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y-1);
            $fighter2 = $this->Fighters->getFighterByCoord($fighter->coordinate_x, $fighter->coordinate_y-1);

            //si on trouve un monstre
            if(!is_null($content) && $content->type == 'W'){
                $this->Surroundings->delete($content);
            }
            else if(!is_null($fighter2)){
                //THOMAS
            }
            
        }
        if($attack == 'attackright' && $fighter->coordinate_y < self::WIDTH - 1){
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y+1);
            $fighter2 = $this->Fighters->getFighterByCoord($fighter->coordinate_x, $fighter->coordinate_y+1);

            //si on trouve un monstre
            if(!is_null($content) && !is_null($content) && $content->type == 'W'){
                $this->Surroundings->delete($content);
            }
            else if(!is_null($fighter2)){
                //THOMAS
            }
        }
        if($attack == 'attackbottom' && $fighter->coordinate_x < self::LENGTH - 1){
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x+1, $fighter->coordinate_y);
            $fighter2 = $this->Fighters->getFighterByCoord($fighter->coordinate_x+1, $fighter->coordinate_y);
            //si on trouve un monstre
            if(!is_null($content) && $content->type == 'W'){
                $this->Surroundings->delete($content);
            }
            else if(!is_null($fighter2)){
                //THOMAS
            }
        }
    }

    /**
     * Find a free square inside the matrix game
     */
    public function findFreeSquare($x, $y) {

        $content = $this->Surroundings->getSurrounding($x, $y);

        // If the square is free, the condition becomes true
        if (is_null($content)) {
            $isFree = true;
            return $isFree;
        }
        return false;
    }

    public function regenerateMap() {

        //$this->loadModel('Surroundings');
        $this->Surroundings->deleteAllSurroundings();
        $this->generationPillars();
        $this->generationTraps();
        $this->generationMonster();
    }

    /**
     * Generate pillars
     * @global type $WIDTH
     * @global type $LENGTH
     */
    public function generationPillars() {
        $nb_cases = self::WIDTH * self::LENGTH;
        $nb = $nb_cases % 10;
        // Pillars generation
        for ($i = 0; $i < ($nb_cases - $nb) / 10; $i++) {
            $isFree = false;

            // While we don't find a free square
            while ($isFree == false) {
                $x = rand(0, self::LENGTH-1);
                $y = rand(0, self::WIDTH-1);
                $isFree= $this->findFreeSquare($x, $y);
            }

            $entity = new Surroundings([
                'type' => 'P',
                'coordinate_x' => $x,
                'coordinate_y' => $y]);
            $this->Surroundings->save($entity);
        }
    }

    /**
     * Traps generation
     * @global type $WIDTH
     * @global type $LENGTH
     */
    public function generationTraps() {
        $nb_cases = self::WIDTH * self::LENGTH;
        $nb = $nb_cases % 10;
        // Traps generation
        for ($i = 0; $i < ($nb_cases - $nb) / 10; $i++) {
            $isFree = false;

            // While we don't find a free square
            while ($isFree == false) {
                $x = rand(0, self::LENGTH-1);
                $y = rand(0, self::WIDTH-1);
                $isFree= $this->findFreeSquare($x, $y);
            }

            $entity = new Surroundings([
                'type' => 'T',
                'coordinate_x' => $x,
                'coordinate_y' => $y]);
            $this->Surroundings->save($entity);
        }
    }

    /**
     * Monster (wumpus) generation
     * @global type $WIDTH
     * @global type $LENGTH
     */
    public function generationMonster() {
        $isFree = false;
        
        // While we don't find a free square
        while ($isFree == false) {
            $x = rand(0, self::LENGTH-1);
            $y = rand(0, self::WIDTH-1);
            $isFree= $this->findFreeSquare($x, $y);
        }

        $entity = new Surroundings([
            'type' => 'W',
            'coordinate_x' => $x,
            'coordinate_y' => $y]);
        $this->Surroundings->save($entity);
    }

    /**
     * Random generation for player coordinates
     */
    public function generationPlayer() {
        if ($this->isUserConnected()) {
            $session = $this->request->session();
            $idPlayer = $session->read('playerId');
            $isFree = false;

            // While we don't find a free square
            while ($isFree == false) {
                $x = rand(0, self::LENGTH-1);
                $y = rand(0, self::WIDTH-1);
                $isFree= $this->findFreeSquare($x, $y);
            }

            $fighter = $this->Fighters->getFighter($idPlayer);
            $fighter->coordinate_x = $x;
            $fighter->coordinate_y = $y;

            $this->Fighters->save($fighter);
        }
    }

    /**
     * 
     * @param type $decor : surroundings entity
     * @param type $fighter : fighters entity
     * @return type false if the fighter cannot see the surrounding, else true
     */
    public function canISeeIt($decor, $fighter) {
        if (abs($decor->coordinate_x - $fighter->coordinate_x) + abs($decor->coordinate_y - $fighter->coordinate_y) <= $fighter->skill_sight) {
            return true;
        } else {
            return false;
        }
    }

    ////////// ********** DIARY PART **********\\\\\\\\\\

    /**
     * This function display the event messages (diary)
     */
    public function diary() {
        if ($this->isUserConnected()) {
            // Put code here
        }
    }

}
