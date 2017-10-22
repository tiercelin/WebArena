<?php $this->assign('title', 'Sight');

$LENGTH = 10;
$WIDTH = 15;

//$this->loadModel('Surroundings');
    //$entity = $this->Surrondings->getSurrondings();
?>
<?php
echo "<table>";
    
      for ($i=0;$i<$LENGTH;$i++) {
           echo "<tr> </tr>";
           for ($j=0;$j<$WIDTH;$j++) {
               echo "<td> " .$hey." </td>";
           
           }
}   
echo "</table>";
?>

