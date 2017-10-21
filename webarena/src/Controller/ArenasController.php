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
    
    $entity = $this->Fighters->getFighter('545f827c-576c-4dc5-ab6d-27c33186dc3e');
    $this->set('MES', $entity);
    
    //$this->set('hey', $this->Fighters->getBestFighter());

}

public function diary()
{

}

public function fighter()
{

}

public function login()
{

}

public function sight()
{

}
}

