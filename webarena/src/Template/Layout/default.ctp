<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    
    <?php echo $this->Html->css(array('base','bootstrap','bootstrap.min','bootstrap-theme','bootstrap-theme.min','cake','home','Webarena'));?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?php echo $this->Html->script(array('bootstrap','bootstrap.min'));?>
    
    
</head>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

</script>



<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
       <a class="navbar-brand"> <?= $this->Html->image("trump_4.png", ['height' => '30', 'width'=>'30','class'=>'trumpimage', 'onclick'=>'openNav()' ]); ?> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	  

		
		<li><a>Welcome to the arena </a></li>
                <li class="name">
                    <a href=""><?= $this->fetch('title') ?></a>
                </li>
		
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
		
		
		<li><?php echo $this->Html->link('Diary', array('controller' => 'Arenas', 'action' => 'diary')); ?></li>
		<li><?php echo $this->Html->link('Fighter', array('controller' => 'Arenas', 'action' => 'fighter')); ?></li>
		<li><?php echo $this->Html->link('Index', array('controller' => 'Arenas', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Sight', array('controller' => 'Arenas', 'action' => 'login')); ?></li>
                <li role="separator" class="divider"></li>
		<li><?php echo $this->Html->link('Login', array('controller' => 'Arenas', 'action' => 'sight')); ?></li>

		
        </ul>

      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <li><?php echo $this->Html->link('Diary', array('controller' => 'Arenas', 'action' => 'diary')); ?></li>
		<li><?php echo $this->Html->link('Fighter', array('controller' => 'Arenas', 'action' => 'fighter')); ?></li>
		<li><?php echo $this->Html->link('Index', array('controller' => 'Arenas', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Sight', array('controller' => 'Arenas', 'action' => 'login')); ?></li>
                <li role="separator" class="divider"></li>
		<li><?php echo $this->Html->link('Login', array('controller' => 'Arenas', 'action' => 'sight')); ?></li>

 <div id="footer">
  <br>
  SI1 <br>
  Options DF<br>
  
  Imbert Pierre-Louis<br>
  Tiercelin Julie<br>
  Champalier Mariane<br>
  Olive Thomas<br>
  
 </div>
</div>

    <div><?= $this->fetch('content') ?></div>


</body>
</html>


