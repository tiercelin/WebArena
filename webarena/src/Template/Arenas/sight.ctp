<div id="postuser">

    <div id="BACKGRD">
        <br><br><br>
        <?php
        $this->assign('title', 'Sight');
        $avatarFilename = "";
        $avatarFilenameEnnemi = "";
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
        $messageSuspicious = "";
        $messageStink = "";

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
                            } else {/// to display the enemy's avatar
                                if (in_array($indextable[$i][$j], $fighters)) {
                                    $idPlayer = $indextable[$i][$j]->player_id;
                                    $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                                    $avfilecount = count($totfile);
                                    if ($avfilecount == 0) {
                                        $avatarFilenameEnemi = 'kittenWarrior.jpg';
                                    }
                                    if ($avfilecount == 1) {
                                        foreach ($totfile as $fileAlredyUploaded) {
                                            $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                                            $avatarFilenameEnemi = $idPlayer . '.' . $ext;
                                        }
                                    }
                                    echo "<td>" . $this->Html->image("avatar/" . $avatarFilenameEnemi, ['height' => '35', 'width' => '20']) . "</td>";
                                } else {
                                    echo "<td style='height: 35px; length: 20px'> </td>";
                                    if ($controller->doIdisplayMessage($indextable[$i][$j], $fighter)) {
                                        if ($indextable[$i][$j]->type == 'T') {
                                            $messageSuspicious = 'Suspicious Break !';
                                        } else {
                                            $messageStink = 'Stink!';
                                        }
                                    }
                                }
                            }
                        } else
                            echo "<td style='height: 35px; length: 20px' background='../img/fog.png'> </td>"; // frame squares than I can NOT see
                    } else { // to display the player's avatar on the map !
                        $idPlayer = $fighter->player_id;
                        $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                        $avfilecount = count($totfile);
                        if ($avfilecount == 0) {
                            $avatarFilename = 'kittenWarrior.jpg';
                        }
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
   
    <table id="but">

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
            <td colspan="3" style="text-align:center; background: linear-gradient(to right top,  red, red,red, white, white"><h5> <?= $messageSuspicious; ?> </h5></td> 
            <td><h5><?= $this->Form->postButton('Reset Map', ['controller' => 'Arenas', 'action' => 'sight'], ['data' => ['regenerate' => 'true'], 'class' => 'btn btn-primary']) ?> </h5></td> 
            <td colspan="3" style="text-align:center; background: linear-gradient(to left top,  orangered, orangered,orangered, white, white"><h5> <?= $messageStink; ?> </h5></td> 
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <td> Fighter's Avatar</td>
                <td> Fighter's Name</td>
                <td> Fighter's life bar</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $idPlayer = $fighter->player_id;
                $percentageoflife = $fighter->current_health / $fighter->skill_health * 100;
                if ($percentageoflife < 25) {
                    $progressStyle = "progress-bar-danger";
                }
                if (($percentageoflife >= 25) && ($percentageoflife < 50)) {
                    $progressStyle = "progress-bar-warning";
                }
                if (($percentageoflife >= 50) && ($percentageoflife < 75)) {
                    $progressStyle = "progress-bar-info";
                }
                if ($percentageoflife >= 75) {
                    $progressStyle = "progress-bar-success";
                }
                $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                $avfilecount = count($totfile);
                if ($avfilecount == 0) {
                    $avatarFilename = 'kittenWarrior.jpg';
                }
                if ($avfilecount == 1) {
                    foreach ($totfile as $fileAlredyUploaded) {
                        $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                        $avatarFilename = $idPlayer . '.' . $ext;
                    }
                }
                echo "<td>" . $this->Html->image("avatar/" . $avatarFilename, ['height' => '30%', 'width' => '30%']) . " </td>";
                echo "<td>" . $fighter->name . "</td>";
                echo "<td> <div class=\"progress\">
                        <div class=\"progress-bar " . $progressStyle . "\" style=\"width:" . $percentageoflife . "%\" role=\"progressbar\" aria-valuenow=\"70\"
                             aria-valuemin=\"0\" aria-valuemax=\"100\">" . $fighter->current_health . " </div></div></td>";
                ?>
            </tr>
            <?php
            if (!empty($fighters)) {
                foreach ($fighters as $enemyFighter) {
                    echo "<tr>";
                    if (!is_null($enemyFighter)) {
                        $idPlayer = $enemyFighter->player_id;

                        $percentageoflife = $enemyFighter->current_health / $enemyFighter->skill_health * 100;
                        if ($percentageoflife < 25) {
                            $progressStyle = "progress-bar-danger";
                        }
                        if (($percentageoflife >= 25) && ($percentageoflife < 50)) {
                            $progressStyle = "progress-bar-warning";
                        }
                        if (($percentageoflife >= 50) && ($percentageoflife < 75)) {
                            $progressStyle = "progress-bar-info";
                        }
                        if ($percentageoflife >= 75) {
                            $progressStyle = "progress-bar-success";
                        }
                        $totfile = glob(WWW_ROOT . '/img/avatar/' . $idPlayer . '.*');
                        $avfilecount = count($totfile);
                        if ($avfilecount == 0) {
                            $avatarFilename = 'kittenWarrior.jpg';
                        }
                        if ($avfilecount == 1) {
                            foreach ($totfile as $fileAlredyUploaded) {
                                $ext = substr(strtolower(strrchr($fileAlredyUploaded, '.')), 1);
                                $avatarFilename = $idPlayer . '.' . $ext;
                            }
                        }
                        echo "<td>" . $this->Html->image("avatar/" . $avatarFilename, ['height' => '30%', 'width' => '30%']) . " </td>";
                        echo "<td>" . $enemyFighter->name . "</td>";
                        echo "<td> <div class=\"progress\">
                        <div class=\"progress-bar " . $progressStyle . "\" style=\"width:" . $percentageoflife . "%\" role=\"progressbar\" aria-valuenow=\"70\"
                             aria-valuemin=\"0\" aria-valuemax=\"100\">" . $enemyFighter->current_health . " </div></div></td>";
                    }
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

</div>

<?= $this->Flash->render() ?>
