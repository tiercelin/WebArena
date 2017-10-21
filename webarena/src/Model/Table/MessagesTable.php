<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class MessagesTable extends Table{
    
    /**
     * Initialization of the messages table
     * @param array $config : contains configuration data for the messages table
     */
    public function initialize(array $config)
    {
        $this->setTable('messages');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Messages');
        
        // A message belongs to one fighter (actually, to 2 fighters but this does not change anything)
        $this->belongsTo('Fighters')
                ->setForeignKey('fighter_id');
                //->setJoinType('INNER'); uncomment this line if we implement the communication functionnality         
    }
    
     /**
     * Validate data (type, presence, max size) before an entity creation
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')         
            ->requirePresence('id')  // true by default because id is primary key
            ->notEmpty('id');  // true by default because of key auto increment
        
        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->maxLength('title', 45)
            ->requirePresence('title', 'create')
            ->notEmpty('title');
        
        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');
        
        // No fighter_id and fighter_id_from validations because they are foreign keys ! 
        
        return $validator;
    }
    
    // Do we have the verify that an entity of messages clearly refers to two entities of fighters ? (no foreign key violations)

}


