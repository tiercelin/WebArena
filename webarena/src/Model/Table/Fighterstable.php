<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table {

    function test() {
        return "ok";
    }

    function getBestFighter() {
       $bestfighter = $this->find("all")->max("level");

        return $bestfighter;
    }

}
