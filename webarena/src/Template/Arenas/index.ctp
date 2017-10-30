<?php $this->assign('title', 'Index'); ?>
<?php echo $this->Html->script('jquery.min.js'); ?>
<?php echo $this->Html->script('bootstrap.min.js'); ?>

<div id="postuser">
<h1>Welcome to WebArena ! </h1><br>

<h3>Here are the rules of the game : </h3>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner">
        <div class="item active">
            <?= $this->Html->image("avatar/kittenWarrior.jpg", ['height' => '1000', 'width'=>'1000', "align" =>"center" ]) ?>
        </div>
        <?php
        foreach ($avatars as $avatar) {
            echo "<div class=\"item\">";
            echo $this->Html->image("avatar/" . $avatar, ['height' => '1000', 'width'=>'1000', "align" =>"center" ]) . "</div>";
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