<?php $this->assign('title', 'Create guild');?>

<h2>Create a new guild : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('name',array('type' => 'text','label' => 'Choose a name : '));
    echo $this->Form->submit('Create'); 
    echo $this->Form->end();
    
    ?>
    
    <?= $this->Flash->render() ?>
    
    
     
  