<?php $this->assign('title', 'Create guild');?>

<h2>Create a new guild : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('name',array('type' => 'text','label' => 'Choose a name : '));
    echo $this->Form->submit('Create'); 
    echo $this->Form->end();
    ?>
<br>

<?php
    
    // Create an array which will contains all the name of the available guilds
    $arrayNameGuild = array(); 

foreach($guildsArray as $guild) {
    array_push($arrayNameGuild, $guild->name);   
 }
 
 // Display a drop-down list with the name of all guilds
    echo $this->Form->select('guild', array('type' => 'select', 'options' => $arrayNameGuild)); 
     
?>

    <?= $this->Flash->render() ?>
  