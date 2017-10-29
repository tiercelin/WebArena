<?php $this->assign('title', 'Sign in');?>

<h2>Connect to your account: </h2><br>

<?php
echo $this->Form->create();
echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :'));
echo $this->Form->submit('Sign in', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer', 'name'=>'Sign in'));
echo $this->Form->end();?>

<h6>Forgotten password? </h6><br>
<?= $this->Form->create();
echo $this->Form->input('emailreset',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->submit('reset password', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer', 'name'=>'Sign in'));
echo $this->Form->end();?>

<h2>Change your password: </h2><br>

<?php
echo $this->Form->create();
echo $this->Form->input('emailchange',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->input('oldpassword', array('type' => 'password', 'label' => 'Your old password :'));
echo $this->Form->input('newpassword', array('type' => 'password', 'label' => 'Your new password :'));
echo $this->Form->input('checkpassword', array('type' => 'password', 'label' => 'Enter your new password again:'));
echo $this->Form->submit('Change password', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer'));
echo $this->Form->end();?>
<br><br>

<a><?php echo $this->Html->link('Create an account', array('controller' => 'players', 'action' => 'newPlayer')); ?></a>


 <?= $this->Flash->render() ?>