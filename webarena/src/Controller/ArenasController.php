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
        $this->Surroundings->deleteAllSurroundings();
        $this->generationColonnes();
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
    
    /**
     * Génère les colonnes, pièges et monstres
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
}

