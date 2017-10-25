
<div class="ChImg">
<?php 
echo $this->Form->create('particularRecord', ['enctype' => 'multipart/form-data']);
echo $this->Form->input('upload', ['type' => 'file']);
echo $this->Form->button('Save image');
echo $this->Form->end();       

    
    
/*
echo $test4;
echo $this->Html->image("avatar/" . $test4); 
*/
?>
    
    
</div>
