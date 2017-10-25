
<div class="ChImg">
<?php 
echo $this->Form->create('particularRecord', ['enctype' => 'multipart/form-data']);
echo $this->Form->input('upload', ['type' => 'file']);
echo $this->Form->button('Save image');
echo $this->Form->end();       

    
    echo $this->Html->image("avatar/df92817e-59c4-4098-8123-487fac1d8299.jpg"); ?>
    
    
</div>
