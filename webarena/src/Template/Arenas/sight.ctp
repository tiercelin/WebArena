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


<?= $this->Form->postButton('Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'top']]) ?>
<?= $this->Form->postButton('Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'left']]) ?>
<?= $this->Form->postButton('Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'right']]) ?>
<?= $this->Form->postButton('Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'bottom']]) ?>