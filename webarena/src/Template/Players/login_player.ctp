<?php $this->assign('title', 'Sign in');?>

<h2>Connect to your account : </h2><br>

<?php
echo $this->Form->create();
echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :'));
echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :'));
echo $this->Form->submit('Sign in');
echo $this->Form->end();
?>

<?php /*echo $this->Form->postButton('Reset Password', ['controller' => 'Players','action' => 'loginPlayer', 'data'=>[ 'resetpsw'=>'true']]) */?>
<?php/* echo $newPassword;
if($reset==true){ //do not display
    echo "your new password is ".$newPassword;
    echo "<br>Think to note it somewhere to be able to acces your account !";
*/}?>
