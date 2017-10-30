<?php echo $this->Html->script('diary.js');?>
<?php echo $this->Html->script('datatables.min.js');?>
<div id="postuser">
    
<?php
$this->assign('title', 'Diary');

if (!is_null($entities)) {
    echo "<table id=\"example\" class=\"cell-border hover row-border order-columnstripe table table-striped table-bordered\" width=\"100%\" cellspacing=\"0\">";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Coordinate_x</th>
                <th>Coordinate_y</th>
            </tr>
        </thead>";
    foreach ($entities as $row) {
        if ($row->date >= $date) {
            echo "<tr>";
            echo "<td>" . $row->id . "</td>";
            echo "<td>" . $row->name . "</td>";
            echo "<td>" . $row->date . "</td>";
            echo "<td>" . $row->coordinate_x . "</td>";
            echo "<td>" . $row->coordinate_y . "</td>";
            echo "</tr>";
        }
        //echo $row->name." => ".$row->date ."<br>";
    }
}
echo "</table>";
?>
</div>