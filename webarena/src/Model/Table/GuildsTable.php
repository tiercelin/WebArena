<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GuildsTable extends Table{
    
    /**
     * Initialization of the guilds table
     * @param array $config : contains configuration data for the guilds table
     */
    public function initialize(array $config)
    {
        $this->setTable('guilds');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Guilds');
        
        // A guild can welcome many fighters
        $this->hasMany('Fighters')
                ->setForeignKey('guild_id');
                //->setJoinType('INNER'); uncomment this line if we implement the guild functionnality         
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
        
        return $validator;
    }
}
