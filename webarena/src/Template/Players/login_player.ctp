<?php $this->assign('title', 'Sign in');?>

<h2>Connect to your account : </h2><br>

<?php
echo $this->Form->create();
echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :', 'value'=>$password));
echo $this->Form->submit('Sign in', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer', 'name'=>'Sign in'));
echo $this->Form->end();?>
<?php /* echo $this->Form->create(); echo $this->Form->input('retrieveemail',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->postButton('Retrieve', ['controller' => 'Players','action' => 'loginPlayer'],['data' => ['retrieve' => 'true'],'class' => 'btn btn-primary']); 
        $this->Form->end();if($displayRetrieve==true){
            echo "your password is ".$password;
        }
?>
<?= $this->Form->create(); echo $this->Form->input('resetemail',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->postButton('Reset', ['controller' => 'Players','action' => 'loginPlayer'],['data' => ['reset' => 'true'],'class' => 'btn btn-primary']); 
        $this->Form->end();if($displayReset==true){
            echo "your new password is ".$password;
        }*/
?>
<?php
echo $this->Form->create('changepassword');
echo $this->Form->input('emailchange',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->input('oldpassword', array('type' => 'password', 'label' => 'Your old password :', 'value'=>$password));
echo $this->Form->input('newpassword', array('type' => 'password', 'label' => 'Your new password :', 'value'=>$password));
echo $this->Form->input('checkpassword', array('type' => 'password', 'label' => 'Enter your new password again:', 'value'=>$password));
echo $this->Form->submit('Change password', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer', 'name'=>'Sign in'));
echo $this->Form->end();?>
<br><br>

<a><?php echo $this->Html->link('Create an account', array('controller' => 'players', 'action' => 'newPlayer')); ?></a>


 <?= $this->Flash->render() ?>