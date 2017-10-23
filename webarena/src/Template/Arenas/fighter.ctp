<?php $this->assign('title', 'Fighter');?>


   
  <table style="width:90%">
  <tr>
    <th> <h3>Fighter ID card</h3></th>
    <th> </th> 
    <th> </th> 
  </tr>
  <tr>
      <td><h5>Name :</h5></td> 
    <td><h5><?php echo $name_f;?> </h5></td>
    <td> </td> 
  </tr>
  <tr>
    <td><h5>level :</h5></td> 
    <td><h5><?php echo $lvl_f;?> </h5></td>
    <td> </td> 
  </tr>
  <tr>
    <td><h5>Experience points :</h5></td> 
    <td><h5><?php echo $exp_f;?> </h5></td>
    <td> </td> 
  </tr>
 </table>
    
  <br> <br>
  
  <table style="width:90%">
  <tr>
    <th><h3>Fighter abilities</h3></th>
    <th> </th> 
    <th> </th>
  </tr>
  <tr>
    <td><h5>Sight :</h5></td> 
    <td><h5><?php echo $sight_f;?> </h5></td>
    <td>
       <?php $this->Form->create();
        $this->Form->text('upgrade', ['default' => 'sight']);
        echo $this->Form->submit('Upgrade Sight',array('class' => 'btn btn-success'));
        $this->Form->end(); 
       ?> 
    </td>
  </tr>
  <tr>
    <td><h5>Strength :</h5></td> 
    <td><h5><?php echo $str_f;?> </h5></td>
    <td>
       <?php $this->Form->create();
        $this->Form->text('upgrade', ['default' => 'strength']);
        echo $this->Form->submit('Upgrade Strength',array('class' => 'btn btn-success'));
        $this->Form->end(); 
       ?> 
    </td>
  </tr>
   <tr>
    <td><h5>Health :</h5></td> 
    <td><h5><?php echo $health_f;?> </h5></td>
    <td>
       <?php $this->Form->create();
        $this->Form->text('upgrade', ['default' => 'health']);
        echo $this->Form->submit('Upgrade Health',array('class' => 'btn btn-success'));
        $this->Form->end(); 
       ?> 
    </td>
  </tr>

 </table>
  