<?php
namespace App\Controller;
use App\Controller\AppController;
/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{
    
public function index()
{

    $this->set('myname', "Julien Falconnet");
    $this->loadModel('Players');
    $this->loadModel('Fighters');
    $this->loadModel('Surroundings');
    
    $entity = $this->Surroundings->getSurroundings();
    $this->set('MES', $entity);
    
    //$this->set('hey', $this->Fighters->getBestFighter());

}

public function diary()
{

}

public function fighter()
{
    $this->set('myname', "Julien Falconnet");

    $this->loadModel('Fighters');

    $entity = $this->Fighters->getFighter('545f827c-576c-4dc5-ab6d-27c33186dc3e');
    $this->set('MES', $entity);
    
    $this->set('id_f', $entity->id);
    $this->set('name_f', $entity->name);
    $this->set('lvl_f', $entity->level);
    $this->set('exp_f', $entity->exp);
    
    $this->set('sight_f', $entity->skill_sight);
    $this->set('str_f', $entity->skill_strength);
    $this->set('health_f', $entity->skill_health);
    
}

public function login()
{

}

public function sight()
{

}
}

