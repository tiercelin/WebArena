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
               if(is_null($myrow->getSurroundings($i,$j))){
                   echo "<td>  0 </td>";
               }
               else {
                   //echo "<td> " .$myrow->getSurroundings($i,$j)->type." </td>";
                   echo "<td>  1 </td>";
               }
               //echo "<td> " .$hey." </td>";
           }
}   
echo "</table>";
?>

