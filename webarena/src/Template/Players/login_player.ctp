<?php $this->assign('title', 'Sign in');?>

<h2>Connect to your account : </h2><br>

<?php
echo $this->Form->create();
echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :', 'value'=>$password));
echo $this->Form->submit('Sign in', array('type' => 'submit', 'controller'=> 'Players', 'action'=>'loginPlayer', 'name'=>'Sign in'));
echo $this->Form->end();?>
<?= $this->Form->create(); echo $this->Form->input('retrieveemail',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->postButton('Retrieve', ['controller' => 'Players','action' => 'loginPlayer'],['data' => ['retrieve' => 'true']]); 
        $this->Form->end();if($displayRetrieve==true){
            echo "your password is ".$password;
        }
?>
<?= $this->Form->create(); echo $this->Form->input('resetemail',array('type' => 'email','label' => 'Your email :', 'value'=>$email2));
echo $this->Form->postButton('Reset', ['controller' => 'Players','action' => 'loginPlayer'],['data' => ['reset' => 'true']]); 
        $this->Form->end();if($displayReset==true){
            echo "your new password is ".$password;
        }
?>

<br><br>

<a><?php echo $this->Html->link('Create an account', array('controller' => 'players', 'action' => 'newPlayer')); ?></a>


 <?= $this->Flash->render() ?>