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
    <td> <h5>Level available:</h5></td>
    <td> <h5><?php echo $levelsavailable;?></h5></td> 
    <td> </td> 
  </tr>
  
  <tr>
    <td><h5>Sight :</h5></td> 
    <td><h5><?php echo $sight_f;?> </h5></td>
    <td>

        <?=$this->Form->postButton('Upgrade Sight', ['controller' => 'Arenas','action' => 'fighter'],['data' => ['upgrade' => 1]], ['class' => 'btn btn-outline-primary']) ?>
 
    </td>
  </tr>
  <tr>
    <td><h5>Strength :</h5></td> 
    <td><h5><?php echo $str_f;?> </h5></td>
    <td>

        <?=$this->Form->postButton('Upgrade Strength', ['controller' => 'Arenas','action' => 'fighter'],['data' => ['upgrade' => 2]])?> 

    </td>
  </tr>
   <tr>
    <td><h5>Health :</h5></td> 
    <td><h5><?php echo $health_f;?> </h5></td>
    <td>

        <?=$this->Form->postButton('Upgrade Health', ['controller' => 'Arenas','action' => 'fighter'],['data' => ['upgrade' => 3]]) ?>

    </td>
  </tr>

 </table>
  