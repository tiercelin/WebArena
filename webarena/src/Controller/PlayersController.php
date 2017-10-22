<?php

namespace App\Controller;
use App\Controller\AppController;
use App\Model\Entity\Players;
use Cake\ORM\TableRegistry;

class PlayersController extends AppController {
    
    // Initialization : cookies and session variables 
    
    /**
     * Add a new player in database -> sign up function !
     */
    public function newPlayer ()
    {
       
        // Declare a new player entity
        $playersTable = TableRegistry::get('Players');
        $newPlayer = $playersTable->newEntity();
        
        // Verify that this new player is unique, thanks to its email
        // First, retrieve all players with THIS email
         $players = $this->Players->find()->where(['email = ' => $this->request->getData('email')]);
              
         // If the count equals 0, so there is no player in the database with this email
         if ($players->count() == 0)
         {  
             if ($this->request->is('post'))
             {
                 // Merge form data with the new (enmpty) entity
                 //$newPlayer = $this->Players->patchEntity($newPlayer, $this->request->getData());
                 $newPlayer->email = $this->request->getData('email');
                 $newPlayer->password = $this->request->getData('password');
            
                 // Then we save the new player in the database
                 // If it works, redirect the user to the login page. If not, display an error message.
                 if ($playersTable->save($newPlayer))
                 {                    
                     return $this->redirect (['controller' => 'arenas', 'action' => 'login']);
                 }
               
                 // Display error message -> use the Flash component ??
             }
         }
        
    }
}
