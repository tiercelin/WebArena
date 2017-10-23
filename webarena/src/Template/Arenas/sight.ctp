<?php $this->assign('title', 'Sight');

$indextable = array();
foreach ($entities as $myrow) {
    $indextable[$myrow->coordinate_x][$myrow->coordinate_y] = $myrow;
}
$indextable[$fighter->coordinate_x][$fighter->coordinate_y] = $fighter;

echo "<table>";
for ($i = 0; $i < $width; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $length; $j++) {
        $check = false;
        if (isset($indextable[$i][$j]))
        {
            if($indextable[$i][$j]!=$fighter){
                if($controller->canISeeIt($indextable[$i][$j], $fighter))
            echo "<td>" .$indextable[$i][$j]->type. "</td>";
            else echo "<td> - </td>";
            }
            else echo "<td> F </td>";
            
        }
            
        else
            echo "<td>_</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>


<?= $this->Form->postButton('Top', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'top']]) ?>
<?= $this->Form->postButton('Left', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'left']]) ?>
<?= $this->Form->postButton('Right', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'right']]) ?>
<?= $this->Form->postButton('Bottom', ['controller' => 'Arenas','action' => 'sight'],['data' => ['movement' => 'bottom']]) ?>
