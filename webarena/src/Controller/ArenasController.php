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
    
    $id = $this->Players->getPlayerId('test');
    $this->set('MES', $this->Fighters->newFighter($id, 'Lapinou'));
    
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

