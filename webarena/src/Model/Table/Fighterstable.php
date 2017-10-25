<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FightersTable extends Table {
    
    /**
     * Initialization of the fighters table
     * @param array $config : contains configuration data for fighters table
     */
    public function initialize(array $config)
    {
        // Three operations to assigned this file to the right table, entity class and primary key (done by default also)
        $this->setTable('fighters');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Fighters');
        
        // Define links between this table and others tables (key constraints)
        
        // A fighter belongs to one and only one player
        $this->belongsTo('Players')
                ->setForeignKey('player_id')
                ->setJoinType('INNER');
        
        // A fighter belongs to one and only one guild
        $this->belongsTo('Guilds')
                ->setForeignKey ('guild_id');
               // ->setJoinType('INNER'); uncomment this line if we implement the guild functionnality
        
        // A fighter can have many tools
        $this->hasMany('Tools')
                ->setForeignKey('fighter_id');
                //->setJoinType('INNER'); uncomment this line if we implement the tools functionnality   
                //  
         // A fighter can send many messages
        $this->hasMany('Messages')
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
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmpty('name');
        
        // No 'player_id' validation because it is a foreign key !

        $validator
            ->integer('coordinate_x')
            ->requirePresence('coordinate_x', 'create')
            ->notEmpty('coordinate_x');

        $validator
            ->integer('coordinate_y')
            ->requirePresence('coordinate_y', 'create')
            ->notEmpty('coordinate_y');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->integer('xp')
            ->requirePresence('xp', 'create')
            ->notEmpty('xp');

        $validator
            ->integer('skill_sight')
            ->requirePresence('skill_sight', 'create')
            ->notEmpty('skill_sight');

        $validator
            ->integer('skill_strength')
            ->requirePresence('skill_strength', 'create')
            ->notEmpty('skill_strength');

        $validator
            ->integer('skill_health')
            ->requirePresence('skill_health', 'create')
            ->notEmpty('skill_health');

        $validator
            ->integer('current_health')
            ->requirePresence('current_health', 'create')
            ->notEmpty('current_health');

        $validator
            ->dateTime('next_action_time')
            ->requirePresence('next_action_time', 'create')  
            ->allowEmpty('next_action_time'); // field can be null if we don't implement the time limit functionnality
        
         // No 'guild_id' validation because it is a foreign key !

        return $validator;
    }
    
    // Do we have the verify that an entity of fighters clearly refers to an entity of player and an entity of guilds ? (no foreign key violations)

    /**
     * 
     * @param type $playerid
     * @return boolean player entity or null if wrong parameter
     */
    public function getFighter($playerid){
        if(is_string($playerid)){
            $entity = $this->find()->where(['player_id =' => $playerid])->first();
            return $entity;
        }
        return null;
    }
    
    public function getBestFighter() {
       $bestfighter = $this->find("all")->max("level");

        return $bestfighter;
    }

}
