<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ToolsTable extends Table{
    
    /**
     * Initialization of the tools table
     * @param array $config : contains configuration data for the tools table
     */
    public function initialize(array $config)
    {
        $this->setTable('tools');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Tools');
        
        // A tool belongs to one and only one fighter
        $this->belongsTo('Fighters')
                ->setForeignKey('fighter_id');
                //->setJoinType('INNER'); uncomment this line if we implement the tool functionnality         
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
            ->integer('bonus')
            ->requirePresence('bonus', 'create')
            ->notEmpty('bonus');
        
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
    
        // Do we have the verify that an entity of tools clearly refers to an entity of fighter ? (no foreign key violations)
    
}
