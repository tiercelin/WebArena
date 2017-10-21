<?php $this->assign('title', 'Login');?>
<?php $this->Form->create();
echo $this->Form->control("login");
echo $this->Form->control("password", ["type"=>"password"]);
echo $this->Form->submit('Login');
$this->Form->end(); 

echo $this->Form->create();
echo $this->Form->control("login");
echo $this->Form->control("password", ["type"=>"password"]);
echo $this->Form->submit('Login');
echo $this->Form->end(); 

echo $this->Form->create($myname, ['enctype' => 'multipart/form-data']);
echo $this->Form->control('submittedfile', ['type' => 'file']);
echo $this->Form->button('Submit');
echo $this->Form->end(); 

$this->Form->create('l', ["url"=>"login"]);
echo $this->Form->control('username', ["value" => "hey"]);
echo $this->Form->control('password', ["type"=>"password"]);
echo $this->Form->button('submit', ["type"=> "submit"]);
$this->Form->end();