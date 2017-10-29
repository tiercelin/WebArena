<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Surroundings;
use App\Model\Entity\Events;
use App\Model\Table\Players;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;


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

        $this->loadComponent('Flash');

        //To regenerate the map each time we connect
        //$this->regenerateMap();
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
        if ($this->isUserConnected()) {
            $event = $this->Events->getEvent($this->request->session()->read('playerId'));
            $players = $this->Players->find()->where(['id = ' => $this->request->session()->read('playerId')])->first();
            $this->addDeconnection($this->request->session()->read('playerId'),$players->email );
            $this->Events->delete($event);
            $this->request->session()->destroy();
            $this->Flash->success(__('You have been disconnected !'));
            return $this->redirect(['controller' => 'players', 'action' => 'loginPlayer']);
        }
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
                if ($fightersTable->save($newFighter)) {
                    $this->Flash->success(__('New fighter "' . $newFighter->name . '" has been created !'));
                } else {
                    $this->Flash->error(__('Fighter creation process failed'));
                }
                //Add the event to the table
                $this->addEventToDiary($newFighter, 'Create new fighter');
                return $this->redirect(['controller' => 'arenas', 'action' => 'fighter']);
            }
        }
    }

    /**
     * This function delete a fighter with this one is dead, and redirect the user to the fighter creation page
     * @param type $idPlayer : ID of the player whose fighter has to be deleted
     */
    public function deleteFighter($idPlayer) {

        // Verify that the user is connected
        if ($this->isUserConnected()) {
            if ($idPlayer == $this->request->session()->read('playerId')) {
                // Retrieve the fighter entity to be deleted
                $fighterToDelete = $this->Fighters->getFighter($idPlayer);
                $fighterToDeleteName = $fighterToDelete->name;

                // Delete this fighter          
                $this->Fighters->delete($fighterToDelete);
                $this->Flash->success(__('Fighter "' . $fighterToDeleteName . '" has been correctly deleted !'));
                //Add this event to the table
                $this->addEventToDiary($fighterToDelete, ' Fighter Dead');
                // Redirect the user to the fighter creation page
                return $this->redirect(['controller' => 'arenas', 'action' => 'createFighter']);
            }
        }
    }

    /**
     * This function shows the fighter page : fighter ID card, actual stats, (potential) possibility to upgrade stats, ...
     */
    public function fighter() {
        $avatarFilename = 'kittenWarrior.jpg';

        if ($this->isUserConnected()) {

            // Get ID of current player
            $session = $this->request->session();
            $idPlayer = $session->read('playerId');
            $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
            $avfilecount = count($totfile);

            if ($avfilecount == 1) {
                foreach ($totfile as $fileAlredyUploaded) {
                    $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                    $avatarFilename = $idPlayer . '.' . $ext;
                }
            }

            if ($this->request->is('post')) {
                //request for the avatar upload ! 
                $test = $this->request->getData('upload');
                if ($test['name'] != "") {
                    $ext = substr(strtolower(strrchr($test['name'], '.')), 1);
                    $te = $this->uploadAvatarByName($test, $idPlayer);
                    if ($te == true) {
                        $avatarFilename = $idPlayer . '.' . $ext;
                    } else
                        $this->Flash->error(__('Your file has not been uploaded'));
                } else
                    $this->Flash->error(__('You did not enter a file'));
            }
            // Find if this user has fighter(s)          
            $fighters = $this->Fighters->find()->where(['player_id = ' => $idPlayer]);

            // If the player has no fighter, redirect him to the fighter creation page. Else, display fighter's stats.
            if ($fighters->count() == 0) {
                return $this->redirect(['controller' => 'arenas', 'action' => 'createFighter']);
            } else {
                // This part is used to upgrade the fighter stats. If the value $upgrade is not 0, the function upgrade is called
                $upgrade = 0;
                $upgrade = $this->request->getData('upgrade');
                if ($upgrade != 0) {
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

                    // Display the levels available for the fighter, rounded down
                    $this->set('levelsavailable', floor($entity->xp / 4));


                    // Send the controller (for avatar display matter)
                    $this->set('controller', $this);
                }
            }
            $this->set('imageFileName', $avatarFilename);
        }
    }

    /**
     * This function upgrades the fighters stats
     * @param type $upgrade: The value of $upgrade corresponds to the stat the user wants to upgrade
     * There is no need for a return
     */
    public function Upgrade($upgrade) {
        //Get the session and id of player.
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');

        //Get the fighter of the player
        $fighter = $this->Fighters->getFighter($idPlayer);

        //Upgrade = 1 corresponds to sight
        if ($upgrade == 1 && $fighter->xp >= 4) {
            //The fighter gains a level, his exp is decreased by 4 (exp needed for a level)
            $fighter->level++;
            $fighter->xp-=4;
            //Then we upgrade his sight by 1, and send the whole to the database to save the changes.
            $fighter->skill_sight++;
            $this->Fighters->save($fighter);
        }
        //Upgrade = 2 corresponds to strength
        if ($upgrade == 2 && $fighter->xp >= 4) {
            //The fighter gains a level, his exp is decreased by 4 (exp needed for a level)
            $fighter->level++;
            $fighter->xp-=4;
            //Then we upgrade his strength by 1, and send the whole to the database to save the changes.
            $fighter->skill_strength++;
            $this->Fighters->save($fighter);
        }
        //Upgrade = 3 corresponds to health
        if ($upgrade == 3 && $fighter->xp >= 4) {
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
        //Add the event to the table
        $this->addEventToDiary($fighter, 'Upgrade level');
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
            echo $randomValue = rand(1, 20);

            // Use the formula to find the computed value
            echo $computedValue = 10 + $fighter2Level - $fighter1Level;

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
     * @param type $idPlayer1 : the ID of the player which attacks
     * @param type $idPlayer2 : the ID of the player which is attacked
     */
    public function attackFighter($idPlayer1, $idPlayer2) {
        //echo 'ATTACK';
        // Retrieve the two fighters entities thanks to the players IDs
        $fighter1 = $this->Fighters->getFighter($idPlayer1);
        $fighter2 = $this->Fighters->getFighter($idPlayer2);

        // Determine if the attack succeed, according to the given formula
        $doAttackSucceed = $this->doAttackSucceed($fighter1->level, $fighter2->level);

        // If the attack succeeds, decrement health of fighter injured
        if ($doAttackSucceed == true) {
            $this->Flash->success(__('Your attack succeeded on "' . $fighter2->name . '"'));
            $fighter2->current_health -= $fighter1->skill_strength;
            $fighter1->xp ++;
            $this->Fighters->save($fighter1);
            $this->Fighters->save($fighter2);
            $this->addEventToDiary($fighter1, $fighter2->name . ' have been attacked by');

            // If the attacked fighter current health is at 0, delete it and create new fighter. Fighter 1 wins XP equals to fighter 2 level.
            if ($fighter2->current_health == 0) {
                $this->Flash->success(__('Your attack killed "' . $fighter2->name . '"'));

                $this->addEventToDiary($fighter1, $fighter2->name . ' have been killed by');

                $fighter1->xp += $fighter2->level;
                $this->Fighters->save($fighter1);
                $this->deleteFighter($idPlayer2);
            }
        } else {
            //Add the event to the table
            $this->addEventToDiary($fighter1, $fighter2->name . ' escaped attack by');
            $this->Flash->error(__('Your attack failed on "' . $fighter2->name . '"'));
        }
    }

    public function getFighterByCoord($x, $y) {
        $entity = $this->Fighters->find()->where(['coordinate_x =' => $x, 'coordinate_y =' => $y])->first();
        return $entity;
    }

    public function getFighter($playerid) {

        $entity = $this->Fighters->find()->where(['player_id =' => $playerid])->first();
        return $entity;
    }

    /**
     * Handle attack between one fighter and another entity, the monster or a second fighter
     * @param type $attack : attack direction
     */
    public function handleAttack($attack) {
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');

        $fighter = $this->Fighters->getFighter($idPlayer);

        if ($attack == 'attacktop' && $fighter->coordinate_x > 0) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x - 1, $fighter->coordinate_y);
            $fighter2 = $this->getFighterByCoord($fighter->coordinate_x - 1, $fighter->coordinate_y);

            // If we find a monster
            if (!is_null($content) && $content->type == 'W') {
                $this->Surroundings->delete($content);
                //Add the event to the table
                $this->Flash->success(__('You killed the wumpus !'));
                $this->addEventToDiary($fighter, ' Monster attacked and killed by');
            } else if (!is_null($fighter2) && $fighter2->player_id != $fighter->player_id) {
                // Fighter1 attacks Fighter2
                // Find the player which is potentially attacked
                $player2 = $this->Players->find()->where(['id = ' => $fighter2->player_id])->first();
                pr($player2);
                $this->attackFighter($idPlayer, $player2->id);
            }
        }

        if ($attack == 'attackleft' && $fighter->coordinate_y > 0) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y - 1);
            $fighter2 = $this->getFighterByCoord($fighter->coordinate_x, $fighter->coordinate_y - 1);

            // If we find a monster
            if (!is_null($content) && $content->type == 'W') {
                $this->Surroundings->delete($content);
                //Add the event to the table
                $this->Flash->success(__('You killed the wumpus !'));
                $this->addEventToDiary($fighter, 'Monster attacked and killed by');
            } else if (!is_null($fighter2) && $fighter2->player_id != $fighter->player_id) {
                // Fighter1 attacks Fighter2
                // Find the player which is potentially attacked
                $player2 = $this->Players->find()->where(['id = ' => $fighter2->player_id])->first();
                pr($player2);
                $this->attackFighter($idPlayer, $player2->id);
            }
        }

        if ($attack == 'attackright' && $fighter->coordinate_y < self::WIDTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y + 1);
            $fighter2 = $this->getFighterByCoord($fighter->coordinate_x, $fighter->coordinate_y + 1);


            // If we find a monster
            if (!is_null($content) && !is_null($content) && $content->type == 'W') {
                $this->Surroundings->delete($content);
                //Add the event to the table
                $this->Flash->success(__('You killed the wumpus !'));
                $this->addEventToDiary($fighter, 'Monster attacked and killed by');
            } else if (!is_null($fighter2)) {
                // Fighter1 attacks Fighter2
                // Find the player which is potentially attacked
                $player2 = $this->Players->find()->where(['id = ' => $fighter2->player_id])->first();
                pr($player2);
                $this->attackFighter($idPlayer, $player2->id);
            }
        }

        if ($attack == 'attackbottom' && $fighter->coordinate_x < self::LENGTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x + 1, $fighter->coordinate_y);
            $fighter2 = $this->getFighterByCoord($fighter->coordinate_x + 1, $fighter->coordinate_y);

            // If we find a monster
            if (!is_null($content) && $content->type == 'W') {
                $this->Surroundings->delete($content);
                //Add the event to the table
                $this->Flash->success(__('You killed the wumpus !'));
                $this->addEventToDiary($fighter, 'Monster attacked and killed by');
            } else if (!is_null($fighter2) && $fighter2->player_id != $fighter->player_id) {
                // Fighter1 attacks Fighter2
                // Find the player which is potentially attacked
                $player2 = $this->Players->find()->where(['id = ' => $fighter2->player_id])->first();
                $this->attackFighter($idPlayer, $player2->id);
            }
        }
    }

    /**
     * Propose to the user to upload an image as an avatar
     */
    public function uploadAvatarByName($file, $playersID) {
        if (!is_null($file)) {
            $file_extension = substr(strtolower(strrchr($file['name'], '.')), 1);
            $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
            if (count(glob(WWW_ROOT . '/img/avatar/' . $playersID . '.*')) > 0) {
                $totfile = glob(WWW_ROOT . '/img/avatar/' . $playersID . '.*');
                foreach ($totfile as $fileAlredyUploaded) {
                    unlink($fileAlredyUploaded);
                }
            }
            if (in_array($file_extension, $arr_ext)) {
                $return = move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/avatar/' . $playersID . '.' . $file_extension);
                return $return;
            }
        }
    }

    ////////// ********** SIGHT PART **********\\\\\\\\\\

    /**
     * Display the matrix game with all elements
     */
    public function sight() {
        $length = self::WIDTH;
        $width = self::LENGTH;
        $this->set('length', $length);
        $this->set('width', $width);

        if ($this->isUserConnected()) {


<<<<<<< HEAD
            $regenerate = false;
            $regenerate = $this->request->getData('regenerate');
            if ($regenerate == true) {
                $this->regenerateMap();
            }

            
            if(!is_null($this->Fighters->getFighter($this->request->session()->read('playerId')))){
            
=======
            if (!is_null($this->Fighters->getFighter($this->request->session()->read('playerId')))) {

>>>>>>> 2ec81cd921f088ab693e66e10bfa8de8abf89825
                $mov = $this->request->getData('movement');
                $attack = $this->request->getData('attack');

                $regenerate = false;
                $regenerate = $this->request->getData('regenerate');
                if ($regenerate == true) {
                    $this->regenerateMap();
                }
                if (!is_null($mov)) {
                    $this->move($mov);
                }
                if (!is_null($attack)) {
                    $this->handleAttack($attack);
                }

                $fighter = $this->Fighters->getFighter($this->request->session()->read('playerId'));
                $this->set('fighter', $fighter);
<<<<<<< HEAD

=======
>>>>>>> 2ec81cd921f088ab693e66e10bfa8de8abf89825

                //get users connected
                $newconnection = $this->Events->getConnexions();
                foreach ($newconnection as $nc) {
                    $conn[] = $nc->name;
                }

                $fighters = array();
                foreach ($conn as $stillconnected) {
                    if ($this->getFighter($stillconnected) != $fighter) {
                        $fighters[] = $this->getFighter($stillconnected);
                    }
                }
                $mytable = $this->Surroundings->getSurroundings();
                $this->set('fighters', $fighters);
                $this->set('entities', $mytable);
                $this->set('controller', $this);
            } else {
                return $this->redirect(['controller' => 'arenas', 'action' => 'createFighter']);
            }
<<<<<<< HEAD

            $fighter = $this->Fighters->getFighter($this->request->session()->read('playerId'));
            $this->set('fighter', $fighter);

            $mytable = $this->Surroundings->getSurroundings();
            $this->set('entities', $mytable);
            $this->set('controller', $this);

=======
>>>>>>> 2ec81cd921f088ab693e66e10bfa8de8abf89825
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
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x - 1, $fighter->coordinate_y);

            if (is_null($content)) {
                $fighter->coordinate_x--;
                $this->Fighters->save($fighter);
                //Add the event to the table
                $this->addEventToDiary($fighter, 'Move by');
            } else if (($content->type == 'T') || ($content->type == 'W')) {
                if ($content->type == 'T') {
                    $this->Flash->error(__('You have been killed by a trap !'));
                } else {
                    $this->Flash->error(__('You have been killed by the wumpus !'));
                }
                $this->deleteFighter($idPlayer);
            }
        }
        //si le joueur descend
        else if ($mov == 'left' && $fighter->coordinate_y > 0) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y - 1);

            if (is_null($content)) {
                $fighter->coordinate_y--;
                $this->Fighters->save($fighter);
                //Add the event to the table
                $this->addEventToDiary($fighter, 'Move by');
            } else if (($content->type == 'T') || ($content->type == 'W')) {
                if ($content->type == 'T') {
                    $this->Flash->error(__('You have been killed by a trap !'));
                } else {
                    $this->Flash->error(__('You have been killed by the wumpus !'));
                }
                $this->deleteFighter($idPlayer);
            }
        }
        //si le joueur va à droite
        else if ($mov == 'right' && $fighter->coordinate_y < self::WIDTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x, $fighter->coordinate_y + 1);

            if (is_null($content)) {
                $fighter->coordinate_y++;
                $this->Fighters->save($fighter);
                //Add the event to the table
                $this->addEventToDiary($fighter, 'Move by');
            } else if (($content->type == 'T') || ($content->type == 'W')) {
                if ($content->type == 'T') {
                    $this->Flash->error(__('You have been killed by a trap !'));
                } else {
                    $this->Flash->error(__('You have been killed by the wumpus !'));
                }
                $this->deleteFighter($idPlayer);
            }
        }
        //si le joueur va a gauche
        else if ($mov == 'bottom' && $fighter->coordinate_x < self::LENGTH - 1) {
            $content = $this->Surroundings->getSurrounding($fighter->coordinate_x + 1, $fighter->coordinate_y);

            if (is_null($content)) {
                $fighter->coordinate_x++;
                $this->Fighters->save($fighter);
                //Add the event to the table
                $this->addEventToDiary($fighter, 'Move by');
            } else if (($content->type == 'T') || ($content->type == 'W')) {
                if ($content->type == 'T') {
                    $this->Flash->error(__('You have been killed by a trap !'));
                } else {
                    $this->Flash->error(__('You have been killed by the wumpus !'));
                }
                $this->deleteFighter($idPlayer);
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

        $this->Surroundings->deleteAllSurroundings();
        $this->generationPillars();
        $this->generationTraps();
        $this->generationMonster();
        $this->generationPlayer();
        $this->Flash->success(__('A new arena has been generated !'));
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
                $x = rand(0, self::LENGTH - 1);
                $y = rand(0, self::WIDTH - 1);
                $isFree = $this->findFreeSquare($x, $y);
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
                $x = rand(0, self::LENGTH - 1);
                $y = rand(0, self::WIDTH - 1);
                $isFree = $this->findFreeSquare($x, $y);
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
            $x = rand(0, self::LENGTH - 1);
            $y = rand(0, self::WIDTH - 1);
            $isFree = $this->findFreeSquare($x, $y);
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
                $x = rand(0, self::LENGTH - 1);
                $y = rand(0, self::WIDTH - 1);
                $isFree = $this->findFreeSquare($x, $y);
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

    /**
     * 
     * @param type $decor
     * @param type $fighter
     * @return boolean
     */
    public function doIdisplayMessage($decor, $fighter) {
        if (((abs($decor->coordinate_x - $fighter->coordinate_x) == 1) && (abs($decor->coordinate_y - $fighter->coordinate_y) == 0)) || ((abs($decor->coordinate_y - $fighter->coordinate_y) == 1) && (abs($decor->coordinate_x - $fighter->coordinate_x) == 0))) {
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
            $entities = $this->Events->getEvents();

            $date = Time::now();
            $date->modify('-24 hours');

            $this->set('entities', $entities);
            $this->set('date', $date);
        }
    }

    public function addEventToDiary($fighter, $eventName) {

        $myNewEvent = new Events([
            'name' => $eventName . ' ' . $fighter->name,
            'date' => Time::now(),
            'coordinate_x' => $fighter->coordinate_x,
            'coordinate_y' => $fighter->coordinate_y]);
        $this->Events->save($myNewEvent);
    }

    public function addDeconnection($playerid, $playeremail) {
        //get its fighter's id ton add the event
        $playersfighter = $this->Fighters->getFighter($playerid);
        //take the part before the @ in its email address to find the players name
        $playersname = Text::tokenize($playeremail, '@');
        $myNewEvent = new Events([
            'name' => $playersname[0] . ' disconnected',
            'date' => Time::now(),
            'coordinate_x' => $playersfighter->coordinate_x,
            'coordinate_y' => $playersfighter->coordinate_y]);
        $this->Events->save($myNewEvent);
    }

}
