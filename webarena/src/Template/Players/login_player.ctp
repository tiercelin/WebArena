<?php $this->assign('title', 'Sign in');?>
<div id="postuser"> 
<h3>Connect to your account: </h3><br>

<?php
echo $this->Form->create('signIn');
echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :'));
echo $this->Form->postButton('Sign In', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer'), ['data'=> ["type"=>'signIn'],'class' => 'btn btn-info']);
echo $this->Form->end();?>

<br><br>
<b>Forgotten password? </b><br>
<?= $this->Form->create();
echo $this->Form->input('emailreset',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->postButton('Reset Password', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer'), ['data'=> ["type"=>'resetPwd'],'class' => 'btn btn-info']);
echo $this->Form->end();?>

<br><br>
<b>Change your password: </b><br>
<?php
echo $this->Form->create();
echo $this->Form->input('emailchange',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->input('oldpassword', array('type' => 'password', 'label' => 'Your old password :'));
echo $this->Form->input('newpassword', array('type' => 'password', 'label' => 'Your new password :'));
echo $this->Form->input('checkpassword', array('type' => 'password', 'label' => 'Enter your new password again:'));
echo $this->Form->postButton('Change Password', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer'), ['data'=> ["type"=>'changePwd'],'class' => 'btn btn-info']);
echo $this->Form->end();?>
<br><br>

<a><?php echo $this->Html->link('Create an account', array('controller' => 'players', 'action' => 'newPlayer')); ?></a>

 <?= $this->Flash->render() ?>

</div>