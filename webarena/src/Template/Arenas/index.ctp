<?php $this->assign('title', 'Index'); ?>
<?php echo $this->Html->script('jquery.min.js'); ?>
<?php echo $this->Html->script('bootstrap.min.js'); ?>

<div id="postuser">
    <h1>Welcome <?php echo $playername ?> to WebArena ! </h1><br>

    <h3>Here are the rules of the game : </h3>
    <h5>
        - Fight for your life in the Arena! <br><br>
        - Watch out for traps, invisible monsters, and, of course, other fighters!<br><br>
        - Remember: When you die, you die. So be careful!<br><br>
        - Join forces with other players, using the Guild system!<br><br>
        - Watch your statistics evolve, in our Hall of Fame!<br><br>
        - Please do not forget to logout before closing the website, otherwise you will not be able to connect again with the same account!!<br><br>
    </h5>

    <div id="myCarousel" class="carousel slide" data-ride="carousel" height="30%" width="30%">

        <div class="carousel-inner">
            <div class="item active carrousel-inner">
                <?= $this->Html->image("avatar/kittenWarrior.jpg", ['height' => '30%', 'width' => '30%', "text-align" => "center center", "margin-left"=>'auto', "margin-right"=>'auto']) ?>
            </div>
            <?php
            if (!is_null($avatars) && !empty($avatars)) {
                foreach ($avatars as $avatar) {
                    echo "<div class=\"item carrousel-inner\">";
                    echo $this->Html->image("avatar/" . $avatar, ['height' => '30%', 'width' => '30%', "text-align" => "center center", "margin-left"=>'auto', "margin-right"=>'auto']) . "</div>";
                }
            }
            ?>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

   
</div>