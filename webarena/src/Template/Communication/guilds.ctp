<?php $this->assign('title', 'Guilds');?>
<div id="postuser">
<h2>Create a new guild : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('name',array('type' => 'text','label' => 'Choose a name : '));
    echo $this->Form->submit('Create', array('name' => 'cguild')); 
    echo $this->Form->end();
    ?>
<br>

<h2>Join a guild : </h2><br>

<?php
     
 // Display a drop-down list with the name of all guilds
    echo $this->Form->create();
    echo $this->Form->select('guildjoin', array('type' => 'select', 'options' => $guildsArray)); 
    echo $this->Form->submit('Join', array('name' => 'jguild')); 
    echo $this->Form->end();
     
?>

    <?= $this->Flash->render() ?>


  </div>