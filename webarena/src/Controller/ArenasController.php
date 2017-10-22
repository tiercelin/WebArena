<?php
namespace App\Controller;
use App\Controller\AppController;
use App\Model\Entity\Surroundings;

/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{
    
    const LARGEUR = 15;
    const LONGUEUR = 10;
    
    public function index()
    {

        $this->set('myname', "Julien Falconnet");
        $this->loadModel('Players');
        $this->loadModel('Fighters');
        $this->loadModel('Surroundings');
        $this->loadModel('Events');

        $entity = $this->Surroundings->getSurroundings();
        $test = $this->Players->getPlayer('admin@test.com');
        $this->set('MES', $test->id);
        
         //$this->set('hey', $this->Fighters->getBestFighter());
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

    

    public function diary()
    {


    }



    public function login()
    {
        //echo "helllllo";
      //$this->request->data= 'julien';
    //echo $this->set($this->request->data, 'julien');
    //$data = new \App\Model\Entity\Players();
      //$data = $this->request->data;
      //pr($data);
        // $this->set('l', $data);
        //Array($data);
    $login = $this->Players;
    // Save logic goes here
    $this->set('login', $login);
    
    if ($this->request->is('post')) {
        echo "bonojur";
        //$username = $this->request->getData("username");
        //$this->set('l', $data);
       /// echo $data;
        }
    //echo "h";
    $user="coucou";
    $pwd = "0";
    $this->set('username', $user);
    $this->set('password', $pwd);

    }
    
    
    
    public function sight()
    {
        $this->loadModel('Surroundings');
    
    $myrow = $this->Surroundings->getSurroundings();
    
     if(is_null($myrow)){
         $this->set('hey', "0");
     }
     else {
         $this->set('hey', "P");
     }

    }
    
    /**
     * Génère les colonnes
     * @global type $largeur
     * @global type $longueur
     */
    public function generationColonnes()
    {
        $this->loadModel('Surroundings');
        $nb_cases = self::LARGEUR * self::LONGUEUR;
        $nb = $nb_cases%10;
        //Génération des colonnes
        for($i=0; $i<($nb_cases-$nb)/10; $i++){
            $isFree = false;
            //tant qu'on ne trouve pas une case libre
            while($isFree == false){
                $x = rand(0, self::LONGUEUR);
                $y = rand(0, self::LARGEUR);
                $content = $this->Surroundings->getSurrounding($x,$y);
                //si la case est libre, la condition devient true
                if(is_null($content)){
                    $isFree = true;
                }
            }

            $entity = new Surroundings([
                'type' => 'P',
                'coordinate_x' => $x,
                'coordinate_y' => $y]);
            $this->Surroundings->save($entity);
        }
    }
    
    /**
     * Génère les pièges
     * @global type $largeur
     * @global type $longueur
     */
    public function generationPieges()
    {
        $this->loadModel('Surroundings');
        $nb_cases = self::LARGEUR * self::LONGUEUR;
        $nb = $nb_cases%10;
        //Génération des colonnes
        for($i=0; $i<($nb_cases-$nb)/10; $i++){
            $isFree = false;
            //tant qu'on ne trouve pas une case libre
            while($isFree == false){
                $x = rand(0, self::LONGUEUR);
                $y = rand(0, self::LARGEUR);
                $content = $this->Surroundings->getSurrounding($x,$y);
                //si la case est libre, la condition devient true
                if(is_null($content)){
                    $isFree = true;
                }
            }

            $entity = new Surroundings([
                'type' => 'T',
                'coordinate_x' => $x,
                'coordinate_y' => $y]);
            $this->Surroundings->save($entity);
        }
    }
    
    /**
     * Génère le monstre
     * @global type $largeur
     * @global type $longueur
     */
    public function generationMonstre()
    {
        $this->loadModel('Surroundings');
        //Génération des colonnes
        $isFree = false;
        //tant qu'on ne trouve pas une case libre
        while($isFree == false){
            $x = rand(0, self::LONGUEUR);
            $y = rand(0, self::LARGEUR);
            $content = $this->Surroundings->getSurrounding($x,$y);
            //si la case est libre, la condition devient true
            if(is_null($content)){
                $isFree = true;
            }
        }

        $entity = new Surroundings([
            'type' => 'W',
            'coordinate_x' => $x,
            'coordinate_y' => $y]);
        $this->Surroundings->save($entity);
    
    }
}

