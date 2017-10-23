<?php $this->assign('title', 'Sight');
?>
<?php
//pr($entities->toArray());
$indextable = array();
foreach ($entities as $myrow) {
    $indextable[$myrow->coordinate_x][$myrow->coordinate_y] = $myrow->type;
}
//pr($indextable);


echo "<table>";
for ($i = 0; $i < $width; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $length; $j++) {
        $check = false;
        if (isset($indextable[$i][$j]))
            echo "<td>" .$indextable[$i][$j]. "</td>";
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
