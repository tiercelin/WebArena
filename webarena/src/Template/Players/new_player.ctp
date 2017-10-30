<?php $this->assign('title', 'Sign up');?>
<div id="postuser">
<h2>Create an account : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('email',array('type' => 'email','label' => 'Your email :'));
    echo $this->Form->input('password', array('type' => 'password', 'label' => 'Your password :'));
   // echo $this->Form->input('password', array('type' => 'password', 'label' => 'Confirm your password :'));
    echo $this->Form->submit('Sign up');    // button OR submit : does it change something ?
    echo $this->Form->end();
     
   
?>


 <?= $this->Flash->render() ?>


</div>
