<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Events;
use Cake\I18n\Time;
use Cake\Utility\Text;

class PlayersController extends AppController {

    //Constant to define the lenght of the reseted password
    const PASSLENGTH = 7;

    // Initialization 
    public function initialize() {
        $this->loadComponent('Flash');
        $this->loadModel('Events');
        $this->loadModel('Players');
        $this->loadModel('Fighters');
    }

    public function passwordHash($pwd) {
        $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);
        return $pwdhash;
    }

    /**
     * Add a new player in database -> sign up function !
     */
    public function newPlayer() {
        // Declare a new player entity
        $playersTable = TableRegistry::get('Players');
        $newPlayer = $playersTable->newEntity();

        // Verify that this new player is unique, thanks to its email
        // First, retrieve all players with THIS email
        $players = $this->Players->find()->where(['email = ' => $this->request->getData('email')]);

        // If the count equals 0, so there is no player in the database with this email
        if ($players->count() == 0) {
            if ($this->request->is('post')) {
                // Merge form data with the new (enmpty) entity
                //$newPlayer = $this->Players->patchEntity($newPlayer, $this->request->getData());
                $newPlayer->email = $this->request->getData('email');
                $pwdtemp = $this->request->getData('password');
                $newPlayer->password = $this->passwordHash($pwdtemp);

                // Then we save the new player in the database
                // If it works, redirect the user to the login page. If not, display an error message.
                if ($playersTable->save($newPlayer)) {
                    $this->Flash->success(__('Your account has been created !'));
                    return $this->redirect(['controller' => 'players', 'action' => 'loginPlayer']);
                }
                $this->Flash->error(__('Account creation failure !'));
            }
        } else {
            $this->Flash->error(__('This account already exists !'));
        }
    }

    /**
     * This function verify email + password of the user in order to log in him if the data are correct
     * If so, set up session variable. If not, display an error message.
     */
    public function loginPlayer() {
        if ($this->request->is('post')) {

//change pwd
            if ($this->request->getData('type') == "changePwd") {
                $this->changePassword($this->request->getData('emailchange'), $this->request->getData('oldpassword'), $this->request->getData('newpassword'), $this->request->getData('checkpassword'));
            }
            //reset pwd
            if ($this->request->getData('type') == "resetPwd") {
                $resetemail = $this->request->getData('emailreset');
                $player = $this->Players->find()->where(['email = ' => $resetemail])->first();
                if (!is_null($player)) {
                    $resetpwd = $this->resetPassword($resetemail);
                    $hashedPwd = $this->passwordHash($resetpwd);
                    $player->password = $hashedPwd;
                    $this->Players->save($player);
                    $this->Flash->success(__('Your new password is: ' . $resetpwd));
                } else
                    $this->Flash->error(__('Wrong email, please try again'));
            }
//sign in
            if ($this->request->getData('type') == "signIn") {
                // Retrieve all the players with the combinaison email + password entered (theoretically, only one result)
                $players = $this->Players->find()->where(['email = ' => $this->request->getData('email')]);

                // If the player has been found in the database
                if ($players->count() == 1) {

                    //We check the password
                    if (password_verify($this->request->getData('password'), $players->first()->password)) {
                        // Secondary check
                        $currentPlayer = $players->first();
                        if (!$this->isAlreadyConnected($currentPlayer)) {
                            // Set session variable with the ID of the current player
                            $session = $this->request->session();
                            $session->write('playerId', $currentPlayer->id);
                            $this->addConnexionMultiplayer($this->request->session()->read('playerId'));
                            $this->addConnection($this->request->session()->read('playerId'), $currentPlayer->email);
                            // Redirect the user to the index page
                            return $this->redirect(['controller' => 'arenas', 'action' => 'index']);
                        } $this->Flash->error(__('This user is already connected, try with another account!'));
                    } else {
                        $this->Flash->error(__('Wrong password, please try again'));
                    }
                } else {
                    $this->Flash->error(__('Authentification failed, please try again'));
                }
            }
        }
    }

    //Code from stackoverflow to generate a random password, with a variable lentgh(here we use a constant)
    public function resetPassword() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, self::PASSLENGTH);
        return $password;
    }

    public function changePassword($email, $oldPwd, $newPwd, $checkPWd) {
        $players = $this->Players->find()->where(['email = ' => $email])->first();
        if (!is_null($players)) {
            if (password_verify($oldPwd, $players->password)) {
                if ($newPwd == $checkPWd) {
                    $hashedPwd = $this->passwordHash($newPwd);
                    $players->password = $hashedPwd;
                    $this->Players->save($players);
                    $this->Flash->success(__('Password changed, please connect with your new password! '));
                } else
                    $this->Flash->error(__('Your two new password don\'t match. Please enter the same password!'));
            } else
                $this->Flash->error(__('Wrong old password, please try again! '));
        } else
            $this->Flash->error(__('Wrong email, please try again'));
    }

    /**
     * Add an event to the Events table when someone is connected
     * The Events will be used to know which user is connected to display it on the sight page !
     * @param type $idPlayer
     */
    public function addConnexionMultiplayer($idPlayer) {
        $myNewEvent = new Events([
            'name' => $idPlayer,
            'date' => Time::now(),
            'coordinate_x' => -1,
            'coordinate_y' => -2]);
        $this->Events->save($myNewEvent);
    }

    public function addConnection($playerid, $playeremail) {
        $playersname = Text::tokenize($playeremail, '@');
        //get its fighter's id ton add the event
        $playersfighter = $this->Fighters->getFighter($playerid);
        if (!is_null($playersfighter)) {
            $myNewEvent = new Events([
                'name' => $playersname[0] . ' connected',
                'date' => Time::now(),
                'coordinate_x' => $playersfighter->coordinate_x,
                'coordinate_y' => $playersfighter->coordinate_y]);
        } else {
            $myNewEvent = new Events([
                'name' => $playersname[0] . ' connected',
                'date' => Time::now(),
                'coordinate_x' => 0,
                'coordinate_y' => 0]);
        }
        $this->Events->save($myNewEvent);
    }

    public function getUserConnected() {
        $conn = array();
        //get users connected
        $newconnection = $this->Events->getConnexions();
        if (!is_null($newconnection)) {
            foreach ($newconnection as $nc) {
                $conn[] = $nc->name; //the id of the player connected
            }
        }
        return $conn;
    }

    public function isAlreadyConnected($currentplayer) {
        $alreadyConnected = $this->getUserConnected();
        if (in_array($currentplayer->id, $alreadyConnected)) {
            return true;
        } else
            return false;
    }

}
