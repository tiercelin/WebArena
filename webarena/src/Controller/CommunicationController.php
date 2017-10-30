<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Model\Entity\Events;

class CommunicationController extends AppController {
    
    public function initialize()
    {
        $this->loadModel('Guilds');
        $this->loadModel('Fighters');
        $this->loadModel('Messages');
        $this->loadModel('Events');
        
        $this->loadComponent('Flash');
    }
    
    
    ///// *****  GUILDS PART ***** \\\\\\\\\\\\\\\\\
    
    
    /**
     * Allow the user to create new guild(s) (one condition : names have to be different)
     */
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
    
    
    /**
     * Allow the user to join a guild. The user can select a choice. If he still belongs to a guild, we keep the new choice. 
     */
    public function joinGuild () 
    {
        $idPlayer = $this->request->session()->read('playerId');
                
        if($this->request->is('post'))
        {
            // Retrieve the guild thanks to the selected value
            if (is_int($this->request->data['guildjoin'])+1)
            {
                $numGuild = $this->request->data['guildjoin'] + 1;
                $guild = $this->Guilds->find()->where(['id = ' => $numGuild])->first();
                       
                 // Retrieve the current fighter
                 $fighter = $this->Fighters->getFighter($idPlayer);

                // Set and save (new) guild ID
                $fighter->guild_id = $guild->id;
        
                if ($this->Fighters->save($fighter))
                {
                    $this->Flash->success (__('You have joined the guild "'.$guild->name.'"'));
                }
        
                else
                {
                    $this->Flash->error(__('You fail to join the guild "'.$guild->name.'"'));
                } 
            }
            
            else
                {
                    $this->Flash->error(__('Please select a guild to join'));
                }
        }
    }
    
     
    /**
     * Display fratures related to the guilds -> create or join one of them
     */
    public function guilds()
    {
        // Build the dropdown list containing the name of the available guilds        
        $guilds = $this->Guilds->find('all', array('fields' => array('Guilds.name')));
        $arrayNameGuild = array(); 
        foreach($guilds as $guild) {
            array_push($arrayNameGuild, $guild->name); 
        }
        $this->set('guildsArray', $arrayNameGuild);
 
        if($this->request->is('post'))
        {
            // Determine if the user wants to create or join a guild
            if(isset($this->request->data['cguild']))
            {
                $this->createGuild();
            }
            
            if(isset($this->request->data['jguild']))
            {
                $this->joinGuild();
            }  
        }
    }
    
    
    
    
    
    ////// ***** MESSAGES PART ***** \\\\\\\\\\\\\\\\\\\\
        
    
    /**
     * Allow the user to create manually an event 
     */
    public function scream()
    {
        $idPlayer = $this->request->session()->read('playerId');
        // Retrieve the current fighter
        $fighter = $this->Fighters->getFighter($idPlayer);
        
        if ($this->request->is('post')) {
            // If the description of the event is less than 255 characters (database constraints)
            if(strlen($this->request->getData('description'))>255)
            {
                $this->Flash->error(__('Your event description must be less than 255 characters'));
            }
            
            else
            {
                 // Create manually the new event
            $myNewEvent = new Events([
                'name' => $this->request->getData('description'),
                'date' => Time::now(),
                'coordinate_x' => $fighter->coordinate_x,
                'coordinate_y' => $fighter->coordinate_y]);
            $this->Events->save($myNewEvent);
            
            $this->Flash->success(__('Your event description has been added to the diary !'));   
            } 
         }
    }
    
    
    /**
     * Allow the user to choose a destinary and send him a message
     */
    public function sendMessage()
    {
        // Create an empty entity of message
        $messagesTable = TableRegistry::get('Messages');
        $newMessage = $messagesTable->newEntity();
        
        // Define ID of the (fighter) sender = current fighter
        $idPlayer = $this->request->session()->read('playerId');
        $fighter = $this->Fighters->getFighter($idPlayer);
        $idFighter1 = $fighter->id;
                   
        if ($this->request->is('post')) {
             // Retrieve ID of the receiver fighter according to the choice in the textbox
            // Retrieve the name of all fighters available
            $nameFighters = $this->Fighters->find('all', array('fields' => array('Fighters.name')));
            $arrayNameFighters = array(); 
            foreach($nameFighters as $nameFighter) {
            array_push($arrayNameFighters, $nameFighter->name); 
            }
            
            // Retrieve the name of the chosen addressee
            $nameFighter2 = $this->request->data['receiver'];
            
            // Verify that the name of the addressee exists, and is different from the name of the sender.
            // If yes, send the message. If no, display an error message
            if(in_array($nameFighter2,$arrayNameFighters) && $nameFighter2 != $fighter->name)
            {
                $fighter2 = $this->Fighters->find()->where(['name = ' => $nameFighter2])->first();
                $idFighter2 = $fighter2->id;
            
                // Merge form data with the new (empty) entity
                $newMessage->date = Time::now();
                $newMessage->title = $this->request->getData('title');
                $newMessage->message = $this->request->getData('message');
                $newMessage->fighter_id_from = $idFighter1;
                $newMessage->fighter_id = $idFighter2;

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
            
            else
            {
                $this->Flash->error(__('You must choose a valid addressee fighter'));
            }
            
        }
    }
    
    
    /**
     * Collect all messages (sent and received by the current fighter) in order to display them in proper format
     */
    public function getMessage()
    {
        // Retrieve the ID of the current fighter
        $idPlayer = $this->request->session()->read('playerId');
        $fighter = $this->Fighters->getFighter($idPlayer);
        $idFighter = $fighter->id;
        
        // Get the messages sent
        $messagesS = $this->Messages->getMessagesSent($idFighter);
        $messagesSent = array();
        foreach($messagesS as $message)
        {
            $fighterTo = $this->Fighters->find()->where(['id = ' => $message->fighter_id])->first(); 
            $nameAddresse = $fighterTo->name;
            array_push($messagesSent, array(['title' => $message->title, 'text' => $message->message, 'date' => $message->date, 'addressee' => $nameAddresse]));
        }
        $this->set('messagesSent', $messagesSent);
        
        // Get the messages received
        $messagesR = $this->Messages->getMessagesReceived($idFighter);
        $messagesReceived = array();
        foreach($messagesR as $message)
        {
            $fighterFrom = $this->Fighters->find()->where(['id = ' => $message->fighter_id_from])->first(); 
            $nameSender = $fighterFrom->name;
            array_push($messagesReceived, array(['title' => $message->title, 'text' => $message->message, 'date' => $message->date, 'sender' => $nameSender]));
        }
        $this->set('messagesReceived', $messagesReceived);
    }
     
        
        
        
        
    
    
   
    
    
    public function messages()
    {
        if($this->request->is('post'))
        {
            // Determine if the user wants to send a message or create an event
            if(isset($this->request->data['sendmessage']))
            {
                $this->sendMessage();
            }
            
            if(isset($this->request->data['scream']))
            {
                $this->scream();
            }  
        }
       
        
          
        
        $this->getMessage();
        
     
        
    }
  
    
    
}
