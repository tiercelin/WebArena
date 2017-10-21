<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SurroundingsTable extends Table{
    
    /**
     * Initialization of the surroundings table
     * @param array $config : contains configuration data for the surroundings table
     */
    public function initialize(array $config)
    {
        $this->setTable('surroundings');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Surroundings');
          
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
            ->maxLength('type', 45)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
     * @return boolean false si aucun résultat, ou liste d'entity si il y a des surroundings dans la base de données
     */
    function getSurroundings(){
        $entity = $this->find();
        if($entity->isEmpty()){
            return false;
        }
        return $entity;
    }
}
