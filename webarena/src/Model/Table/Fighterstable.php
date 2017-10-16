<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table {

    function test() {
        return "ok";
    }

    function getBestFighter() {
        //$sql ="SELECT * FROM fighters WHERE level=(SELECT MAX(level) FROM fighters)";
        //$result = $this->query($sql);
        //return $result;

        $bestfighter = $this->find("all")->max("level");

        return $bestfighter;
    }

}
