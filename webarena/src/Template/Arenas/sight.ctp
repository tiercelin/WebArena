<?php $this->assign('title', 'Sight');

$indextable = array();
foreach ($entities as $myrow) {
    $indextable[$myrow->coordinate_x][$myrow->coordinate_y] = $myrow;
}
$indextable[$fighter->coordinate_x][$fighter->coordinate_y] = $fighter;
$message="";
echo "<table id=\"map\" class = \"table table-bordered \">";
for ($i = 0; $i < $width; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $length; $j++) {
        $check = false;
        if (isset($indextable[$i][$j]))
        {
            if($indextable[$i][$j]!=$fighter){
                if($controller->canISeeIt($indextable[$i][$j], $fighter)){
                    if($indextable[$i][$j]->type=='P'){
                        echo "<td> P </td>";
                    }
                    else {
                        if($controller->doIdisplayMessage($indextable[$i][$j], $fighter))
                        {
                            if($indextable[$i][$j]->type=='T'){
                                $message="Suspicious Break !";
                            }
                            else {
                                $message="Stink !";
                            }
                            echo "<td></td>";
                        }
                        else echo "<td></td>";
                }
            }else echo "<td></td>";
            }
            else echo "<td> F </td>";  
        }    
        else echo "<td></td>";
    }
    echo "</tr>";
}
echo "</table>";

?>
<?= $message; ?>

<!--
<?= $this->Form->postButton('Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'top'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'left'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'right'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'bottom'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Attack Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attacktop'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Attack Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackleft'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Attack Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackright'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Attack Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackbottom'],'class' => 'btn btn-primary']) ?>
<?= $this->Form->postButton('Reset Map', ['controller' => 'Arenas','action' => 'sight'], ['data' => ['regenerate' => 'true'],'class' => 'btn btn-primary']) ?>
-->


<table style="width:90%">

  <tr>
    <td><h5> </h5></td> 
    <td><h5><?= $this->Form->postButton('Move Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'top'],'class' => 'btn btn-primary']) ?> </h5></td>
    <td><h5> </h5></td> 
    <td><h5> </h5></td> 
    <td><h5> </h5></td>
    <td><h5><?= $this->Form->postButton('Attack Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attacktop'],'class' => 'btn btn-primary']) ?> </h5></td>
    <td><h5> </h5></td> 
  </tr>
  <tr>
    <td><h5><?= $this->Form->postButton('Move Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'left'],'class' => 'btn btn-primary']) ?> </h5></td> 
    <td><h5><?= $this->Form->postButton('Move Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'bottom'],'class' => 'btn btn-primary']) ?> </h5></td>
    <td><h5><?= $this->Form->postButton('Move Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'right'],'class' => 'btn btn-primary']) ?> </h5></td> 
    <td><h5> </h5></td> 
    <td><h5><?= $this->Form->postButton('Attack Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackleft'],'class' => 'btn btn-primary']) ?> </h5></td>
    <td><h5><?= $this->Form->postButton('Attack Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackbottom'],'class' => 'btn btn-primary']) ?> </h5></td>
    <td><h5><?= $this->Form->postButton('Attack Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['attack' => 'attackright'],'class' => 'btn btn-primary']) ?> </h5></td> 
  </tr>
  <tr>
    <td><h5> </h5></td> 
    <td><h5> </h5></td>
    <td><h5> </h5></td> 
    <td><h5><?= $this->Form->postButton('Reset Map', ['controller' => 'Arenas','action' => 'sight'], ['data' => ['regenerate' => 'true'],'class' => 'btn btn-primary']) ?> </h5></td> 
    <td><h5> </h5></td>
    <td><h5> </h5></td>
    <td><h5> </h5></td> 
  </tr>
 </table>