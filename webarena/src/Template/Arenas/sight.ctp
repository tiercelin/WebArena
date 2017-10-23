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

<button type="button" onclick="">Top</button>
<button type="button" onclick="">Left</button>
<button type="button" onclick="">Right</button>
<button type="button" onclick="">Bottom</button>
