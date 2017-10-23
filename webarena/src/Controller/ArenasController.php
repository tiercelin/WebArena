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
        // Retrieve the ID of the current player thanks to session
        $session = $this->request->session();
        $idPlayer = $session->read('playerId');
        $this->set('test4', $idPlayer);

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
    
    function UPS()
    {
        $this->set('sight_f', $entity->skill_sight+1);
        $this->set('str_f', $entity->skill_strength+1);
        $this->set('health_f', $entity->skill_health+1);
    }
    
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
        echo "bonjour";
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
       //$this->generationColonnes();
        //$this->generationPieges();
        //$this->generationMonstre();
        $length = self::LARGEUR;
        $width = self::LONGUEUR;
        $this->set('length', $length);
        $this->set('width', $width);
        //To generate the arena
        $this->loadModel('Surroundings');
        
      
      $myrow = $this->Surroundings->getSurrounding('i','j');
      $this->set('entity', $myrow->type);
//$myrow = $this->Surroundings->getSurrounding($i,$j);
               //echo "<tr> <td>";
               //$this->set('$before', "<tr> <td>");
               
           // $myrow = $this->Surroundings->getSurrounding($i, $j);
            //$this->set('entity', $myrow->type);
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
    
  /**
   * 
   * @param type $decor entité de surroundings
   * @param type $fighter entité de fighters
   * @return type false si le joueur ne peut pas le voir
   *              true si il peut le voir
   */
    public function canISeeIt($decor, $fighter){
        
        if(abs($decor->coordinate_x-$fighter->coordinate_x) + abs($decor->coordinate_y-$fighter->coordinate_y) <= $fighter->skill_sight){
            return true; 
        }
        else{
            return false;
        }
    }
}

