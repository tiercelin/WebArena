<?php $this->assign('title', 'Login');?>
<?php $this->Form->create();
echo $this->Form->control("login");
echo $this->Form->control("password", ["type"=>"password"]);
echo $this->Form->submit('Login');
$this->Form->end(); 
?>