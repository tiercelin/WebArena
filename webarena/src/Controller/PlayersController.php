<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class PlayersController extends AppController {

    //Constant to define the lenght of the reseted password
    const PASSLENGTH = 15;

    // Initialization 
    public function initialize() {
        $this->loadComponent('Flash');
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
                $newPlayer->password = $this->request->getData('password');

                // Then we save the new player in the database
                // If it works, redirect the user to the login page. If not, display an error message.
                if ($playersTable->save($newPlayer)) {
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
        //$password = $this->resetPassword();
        //$this->set('email', $email);
        //$this->Players->save($myresetPwd);

        $password = '';
        $display = false;
        $email2='';
        
        if (!is_null($this->request->getData('reset'))) {
            $email2='admin@test.com';
            $email2 = $this->request->getData('resetemail');
            $this->loadModel('Players');
            $myresetPwd = $this->Players->getPlayer($email2);
            
            $password = $myresetPwd->password;
            $display = true;
            
        }
        $this->set('email2', $email2);
        $this->set('password', $password);
        $this->set('display', $display);

        if ($this->request->is('post')) {
            // Retrieve all the players with the combinaison email + password entered (theoretically, only one result)
            $players = $this->Players->find()->where(['email = ' => $this->request->getData('email'), 'password = ' => $this->request->getData('password')]);

            // If the player has been found in the database
            if ($players->count() == 1) {
                // Secondary check
                $currentPlayer = $players->first();

                // Set session variable with the ID of the current player
                $session = $this->request->session();
                $session->write('playerId', $currentPlayer->id);

                // Redirect the user to the index page
                return $this->redirect(['controller' => 'arenas', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Authentification failed, please try again'));
            }
        }
    }

    //Code from stackoverflow to generate a random password, with a variable lentgh(here we use a constant)
    public function resetPassword() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, self::PASSLENGTH);
        return $password;
    }

}
