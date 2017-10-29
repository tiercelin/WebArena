<?php $this->assign('title', 'Create guild');?>

<h2>Create a new guild : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('name',array('type' => 'text','label' => 'Choose a name : '));
    echo $this->Form->submit('Create'); 
    echo $this->Form->end();
    ?>
<br>

<h2>Join a guild : </h2><br>

<?php
     
 // Display a drop-down list with the name of all guilds
    echo $this->Form->create();
    echo $this->Form->select('guildjoin', array('type' => 'select', 'options' => $guildsArray)); 
    echo $this->Form->submit('Join'); 
    echo $this->Form->end();
     
?>


<h2>Send a new message : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('title',array('type' => 'text','label' => 'Title : '));
    echo $this->Form->textarea('message', ['rows' => '5', 'cols' => '5']);
    echo $this->Form->submit('Send');
    echo $this->Form->end();

?>

<br><br>

<h3>Create an event : </h3><br>

<?php
    echo $this->Form->create();
    echo $this->Form->textarea('description', ['rows' => '5', 'cols' => '5']);
    echo $this->Form->submit('Scream !');
    echo $this->Form->end();

?>



    <?= $this->Flash->render() ?>


  