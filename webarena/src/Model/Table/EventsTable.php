<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

class EventsTable extends Table {

    /**
     * Initialization of the events table
     * @param array $config : contains configuration data for the events table
     */
    public function initialize(array $config) {
        $this->setTable('events');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Events');

        // No foreign key constraints here         
    }

    /**
     * Validate data (type, presence, max size) before an entity creation
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->requirePresence('id')  // true by default because id is primary key
                ->notEmpty('id');  // true by default because of key auto increment

        $validator
                ->maxLength('name', 255)
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->dateTime('date')
                ->requirePresence('date', 'create')
                ->notEmpty('date');

        $validator
                ->integer('coordinate_x')
                ->requirePresence('coordinate_x', 'create')
                ->notEmpty('coordinate_x');

        $validator
                ->integer('coordinate_y')
                ->requirePresence('coordinate_y', 'create')
                ->notEmpty('coordinate_y');

        return $validator;
    }

    /**
     * 
     * @return boolean null si aucun résultat, ou liste d'entity si il y a des events dans la base de données
     */
    public function getEvents() {
        $entity = $this->find()->where(['coordinate_y >='=>0]);
        if ($entity->isEmpty()) {
            return null;
        }
        return $entity;
    }
    
    public function getEvent($name) {
        $entity = $this->find()->where(['name ='=>$name]);
        
        return $entity;
    }

    public function getConnexions(){
        $entity = $this->find()->where(['coordinate_y = '=>-2]);
        if ($entity->isEmpty()) {
            return null;
        }
        return $entity;
    }
    

}
