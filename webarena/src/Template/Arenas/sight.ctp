<?php $this->assign('title', 'Sight');

//$this->loadModel('Surroundings');
    //$entity = $this->Surrondings->getSurrondings();
?>
<?php
echo "<table>";
//echo $before;
for ($i=0;$i<$length;$i++) {
            echo "<tr> </tr>";
           for ($j=0;$j<$width;$j++) {
               echo "<td>".$entity." </td>";
               //echo $entity;
               //$this->set('after',"</td> </tr>");
                //echo  "</td> </tr>";
               
           }
      }

//echo $after;
//echo "</table>";
/*echo "<table>";
      for ($i=0;$i<$length;$i++) {
          
           for ($j=0;$j<$width;$j++) {
               
           }
      }*/
echo "</table>";
?>

<button type="button" onclick="">Top</button>
<button type="button" onclick="">Left</button>
<button type="button" onclick="">Right</button>
<button type="button" onclick="">Bottom</button>
