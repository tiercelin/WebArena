<?php $this->assign('title', 'Create fighter');?>
<div id="postuser">
<h2>Create your fighter : </h2><br>

<?php
  echo $this->Form->create();
  echo $this->Form->input('name',array('type' => 'text','label' => 'Name :'));
?>

<h5>If you want to join a guild, please go to the "Guild" page when you fighter will be created</h5>
<h5>You will be able to select an avatar on the next page</h5>

<h5>Your fighter will begin with these characteristics : </h5>
<ul>
    <li>Strength : 1</li>
    <li>Sight : 2</li>
    <li>Health : 5</li>
    <li>Level : 1</li>
    <li>Experience : 0</li>
</ul>

<?php
  echo $this->Form->submit(__('Create this fighter'));
  echo $this->Form->end();
?>

</div>

<?= $this->Flash->render() ?>