<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PlayersTable extends Table {

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
     * @param type $pwd
     * @return boolean true = success, false = echec (email existe déjà)
     */
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
