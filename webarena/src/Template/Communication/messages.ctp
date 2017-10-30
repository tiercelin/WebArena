<?php $this->assign('title', 'Messages');?>

<h2>Send a new message : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->select('receiver', array('type' => 'select', 'options' => $fightersNameArray)); 
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
