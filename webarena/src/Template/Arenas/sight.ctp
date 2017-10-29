
<div id="BACKGRD">
    <br><br><br>
    <?php
    $this->assign('title', 'Sight');

    $indextable = array();
    foreach ($entities as $myrow) {
        $indextable[$myrow->coordinate_x][$myrow->coordinate_y] = $myrow;
    }
    //pr($fighters);
    if (!empty($fighters)) {
        foreach ($fighters as $enemyFighter) {
            if (!is_null($enemyFighter))// first if empty is working when it should not
                $indextable[$enemyFighter->coordinate_x][$enemyFighter->coordinate_y] = $enemyFighter;
        }
    }
    $indextable[$fighter->coordinate_x][$fighter->coordinate_y] = $fighter;
    $message = "";

    echo "<table id=\"map\" class = \"table table-bordered\">";
    for ($i = 0; $i < $width; $i++) {
        echo "<tr style='width: 25px'>";
        for ($j = 0; $j < $length; $j++) {
            $check = false;
            if (isset($indextable[$i][$j])) {
                if ($indextable[$i][$j] != $fighter) {
                    if ($controller->canISeeIt($indextable[$i][$j], $fighter)) { // frame squares than I can see
                        if ($indextable[$i][$j]->type == 'P') {
                            echo "<td style='height: 35px; length: 20px' background='../img/pillar2.png' >  </td>";
                        } else {/// to display the enemy's avatart
                            if (in_array($indextable[$i][$j], $fighters)) {
                                $idPlayer = $indextable[$i][$j]->player_id;
                                $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                                $avfilecount = count($totfile);
                                if($avfilecount == 0){
                                    $avatarFilename = 'kittenWarrior.jpg';
                                }
                                if ($avfilecount == 1) {
                                    foreach ($totfile as $fileAlredyUploaded) {
                                        $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                                        $avatarFilename = $idPlayer . '.' . $ext;
                                    }
                                }
                                echo "<td>" . $this->Html->image("avatar/" . $avatarFilename, ['height' => '35', 'width' => '20']) . "</td>";
                            }
                            if ($controller->doIdisplayMessage($indextable[$i][$j], $fighter)) {
                                if ($indextable[$i][$j]->type == 'T') {
                                    $message = $message. "Suspicious Break !";
                                } else {
                                    $message = $message. "Stink !";
                                }
                                echo "<td style='height: 35px; length: 20px'> </td>";
                            } else
                                echo "<td style='height: 35px; length: 20px'> </td>";
                        }
                    } else

                echo "<td style='height: 35px; length: 20px' background='../img/fog.png'> </td>"; // frame squares than I can NOT see
                } else { // to display the player's avatar on the map !
                    $idPlayer = $fighter->player_id;
                    $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                    $avfilecount = count($totfile);

                    if ($avfilecount == 1) {
                        foreach ($totfile as $fileAlredyUploaded) {
                            $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                            $avatarFilename = $idPlayer . '.' . $ext;
                        }
                    }
                    echo "<td>" . $this->Html->image("avatar/" . $avatarFilename, ['height' => '35', 'width' => '20']) . " </td>";
                }

            } else {
                if ($controller->canISeeFreeSquares($i, $j, $fighter)) {
                    echo "<td style='height: 35px; length: 20px'>  </td>"; // free squares than I can see
                } else
                    echo "<td style='height: 35px; length: 20px' background='../img/fog.png' >  </td>"; // free squares than I can NOT see
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>


    <br>
</div>

<?= $message; ?>

<table id="but" >

    <tr>
        <td><h5> </h5></td> 
        <td><h5><?= $this->Form->postButton('Move Top', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['movement' => 'top'], 'class' => 'btn btn-primary']) ?> </h5></td>
        <td><h5> </h5></td> 
        <td><h5> </h5></td> 
        <td><h5> </h5></td>
        <td><h5><?= $this->Form->postButton('Attack Top', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['attack' => 'attacktop'], 'class' => 'btn btn-primary']) ?> </h5></td>
        <td><h5> </h5></td> 
    </tr>
    <tr>
        <td><h5><?= $this->Form->postButton('Move Left', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['movement' => 'left'], 'class' => 'btn btn-primary']) ?> </h5></td> 
        <td><h5><?= $this->Form->postButton('Move Bottom', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['movement' => 'bottom'], 'class' => 'btn btn-primary']) ?> </h5></td>
        <td><h5><?= $this->Form->postButton('Move Right', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['movement' => 'right'], 'class' => 'btn btn-primary']) ?> </h5></td> 
        <td><h5> </h5></td> 
        <td><h5><?= $this->Form->postButton('Attack Left', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['attack' => 'attackleft'], 'class' => 'btn btn-primary']) ?> </h5></td>
        <td><h5><?= $this->Form->postButton('Attack Bottom', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['attack' => 'attackbottom'], 'class' => 'btn btn-primary']) ?> </h5></td>
        <td><h5><?= $this->Form->postButton('Attack Right', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['attack' => 'attackright'], 'class' => 'btn btn-primary']) ?> </h5></td> 
    </tr>
    <tr>
        <td><h5> </h5></td> 
        <td><h5> </h5></td>
        <td><h5> </h5></td> 
        <td><h5><?= $this->Form->postButton('Reset Map', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['regenerate' => 'true'], 'class' => 'btn btn-primary']) ?> </h5></td> 
        <td><h5> </h5></td>
        <td><h5> </h5></td>
        <td><h5> </h5></td> 
    </tr>
</table>

