<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class CommunicationController extends AppController {
    
    public function initialize()
    {
        $this->loadModel('Guilds');
        $this->loadModel('Fighters');
        $this->loadModel('Messages');
        
        $this->loadComponent('Flash');
    }
    
    public function createGuild()
    {
        // Declare a new guild entity
        $guildsTable = TableRegistry::get('Guilds');
        $newGuild = $guildsTable->newEntity();

        // Verify that this new guild is unique, thanks to its name
        // First, retrieve all guilds with THIS name
        $guilds = $this->Guilds->find()->where(['name = ' => $this->request->getData('name')]);

        // If the count equals 0, so there is no guild in the database with this name
        if ($guilds->count() == 0) {
            if ($this->request->is('post')) {
                // Merge form data with the new (empty) entity
                $newGuild->name = $this->request->getData('name');

                // Then we save the new guild in the database
                // If it works, redirect the user to the index page. If not, display an error message.
                if ($guildsTable->save($newGuild)) {
                    $this->Flash->success(__('Guild "'.$newGuild->name. '" has been created !'));
                    return $this->redirect(['controller' => 'arenas', 'action' => 'index']);
                }
                else
                {
                    $this->Flash->error(__('Guild creation failure !'));
                }
            }
        } else {
            $this->Flash->error(__('This guild already exists !'));
        }
    }
    
    public function joinGuild () //$nameGuild
    {
        $nameGuild = 'mad max';
        $idPlayer = 'df92817e-59c4-4098-8123-487fac1d8299';
        
        // Retrieve the current fighter
        $fighter = $this->Fighters->getFighter($idPlayer);
        
        // Retrieve the ID of the guild thanks to its name
        $guild = $this->Guilds->getGuild($nameGuild);
        
        // Set and save (new) guild ID
        $fighter->guild_id = $guild->id;
        
        if ($this->Fighters->save($fighter))
        {
            $this->Flash->success (__('You have joined the guild "'.$nameGuild.'"'));
        }
        
        else
        {
            $this->Flash->error(__('You fail to join the guild "'.$nameGuild.'"'));
        }     
    }
    
    
    public function sendMessage()
    {
        // Create an empty entity of message
        $messagesTable = TableRegistry::get('Messages');
        $newMessage = $messagesTable->newEntity();
        
        // Define ID of the sender = current fighter
        $idPlayer1 = 1;
        
        // Define ID of the receiver = define it with email of player ?
        $idPlayer2 = 5;
        
        if ($this->request->is('post')) {
                // Merge form data with the new (empty) entity
                $newMessage->date = Time::now();
                $newMessage->title = $this->request->getData('title');
                $newMessage->message = $this->request->getData('message');
                $newMessage->fighter_id_from = $idPlayer1;
                $newMessage->fighter_id = $idPlayer2;

                // Then we save the new message in the database
                // If it works, empty fields and display a success message. If not, display an error message.
                if ($messagesTable->save($newMessage)) {
                    $this->Flash->success(__('Message '.$newMessage->title. ' has been sent !'));
                    // empty fields;
                }
                else
                {
                    $this->Flash->error(__('Message creation failure !'));
                }
   
            }
    }
    
    /*
    public function getMessage()
    {
        $test = $this->Messages->getMessagesSent(1);
        $this->set('test4', $test);
    }
     */
        
        
        
        
    
    
    
    
    public function test()
    {
        $this->createGuild();
        
        $guilds = $this->Guilds->find('all', array('fields' => array('Guilds.name')));
        // Create an array which will contains all the name of the available guilds, and send it to the view
        $arrayNameGuild = array(); 
        foreach($guilds as $guild) {
            array_push($arrayNameGuild, $guild->name); 
        }
        $this->set('guildsArray', $arrayNameGuild);
        
        //$this->joinGuild();
        
        //$this->sendMessage();
        
    
    }
  
    
    
}
