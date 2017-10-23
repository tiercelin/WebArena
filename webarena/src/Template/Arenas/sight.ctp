<?php $this->assign('title', 'Sight');
?>
<?php
//pr($entities->toArray());
$indextable = array();
foreach ($entities as $myrow) {
    $indextable[$myrow->coordinate_x][$myrow->coordinate_y] = $myrow;
}
//pr($fighter);

//$fighter;
echo "<table>";
for ($i = 0; $i < $width; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $length; $j++) {
        $check = false;
        if (isset($indextable[$i][$j]))
        {
            if($controller->canISeeIt($indextable[$i][$j], $fighter))
            echo "<td>" .$indextable[$i][$j]->type. "</td>";
            else echo "<td> - </td>";
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
