<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Guilds;

class CommunicationController extends AppController {
    
    public function initialize()
    {
        $this->loadModel('Guilds');
        
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
                    return $this->redirect(['controller' => 'arenas', 'action' => 'index']);
                }
                $this->Flash->error(__('Guild creation failure !'));
            }
        } else {
            $this->Flash->error(__('This guild already exists !'));
        }
    }
    
    public function test()
    {
        $this->createGuild();
    }
  
    
    
}
