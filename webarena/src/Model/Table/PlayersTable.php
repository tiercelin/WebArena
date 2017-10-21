<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PlayersTable extends Table {
    
    /**
     * Initialization of the players table
     * @param array $config : contains configuration data for the players table
     */
    public function initialize(array $config)
    {
        $this->setTable('players');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\Players');
        
        // A player has one and only one fighter
        ///// ***** CARREFUL : change hasOne to hasMany if we implement the tool functionnality ***** \\\\\
        $this->hasOne('Fighters')
                ->setForeignKey('player_id')
                ->setJoinType('INNER');        
    }
    
     /**
     * Validate data (type, presence, max size) before an entity creation
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator       
            ->uuid('id')
            ->requirePresence('id')  // true by default because id is primary key
            ->notEmpty('id');  // because id is the primary key (carreful : no auto increment here, id is char type)
        
        $validator
            ->email('email')
            ->maxLength ('email', 255)
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');
     
        return $validator;
    }
    
    // Do we have the verify that an entity of players clearly refers to at least one entity of fighter ? (no foreign key violations)


    
    function test() {

        $query = $this->find()->where(['password =' => 'aaa'])->count();
               
        return $query;
    }

    /**
     * Generator of uid for database
     * @return type
     */
    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
    
   /**
    * 
    * @param type $email
    * @return player id or false if wrong parameter
    */
    function getPlayerId($email){
        if(is_string($email)){
            $query = $this->find()->select(['id'])->where(['email =' => $email])->first();
            return $query;
        }
        return false;
    }
    
    /**
    * 
    * @param type $email
    * @return player id or false if wrong parameter
    */
    function getPlayerPassword($email){
        if(is_string($email)){
            $query = $this->find()->select(['password'])->where(['email =' => $email])->first();
            return $query;
        }
        return false;
    }

    /**
     * Créer nouveau joueur
     * @param type $email
     * @param type $pwd
     * @return boolean true = success, false = echec (email existe déjà)
     */
    
    //// **** ATTENTION : pour moi, cette fonction doit être dans un contrôleur, et non un modèle **** \\\\
    function newPlayer($email, $pwd){
        if(is_string($email) && is_string($pwd)){
            
            //on vérifie que le joueur n'existe pas dans la base
            $query = $this->find()->where(['email =' => $email])->count();

            //si le joueur n'existe pas en base
            if($query == 0){
                $id = $this->gen_uuid();
            
                $query = $this->query()
                    ->insert(['id', 'email', 'password'])
                    ->values([
                        'id' => $id,
                        'email' => $email,
                        'password' => $pwd
                    ])

                    ->execute();
                if($query == false){
                    return false;}
                else{
                    return true;}
            }
        }    
        return false;
    }    
}
