<?php $this->assign('title', 'Fighter');?>


  Welcome <?php echo $myname;?> in Webarena ! <br>
  
  <?php // echo $MES;?> <br>
  
  
  <table style="width:90%">
  <tr>
    <th> <h3>Fighter ID card</h3></th>
    <th> </th> 
  </tr>
  <tr>
      <td><h5>Name :</h5></td> 
    <td><h5><?php echo $name_f;?> </h5></td>
  </tr>
  <tr>
    <td><h5>level :</h5></td> 
    <td><h5><?php echo $lvl_f;?> </h5></td>
  </tr>
  <tr>
    <td><h5>Experience points :</h5></td> 
    <td><h5><?php echo $exp_f;?> </h5></td>
  </tr>
 </table>
    
  <table style="width:90%">
  <tr>
    <th><h3>Fighter abilities</h3></th>
    <th> </th> 
  </tr>
  <tr>
    <td><h5>Sight :</h5></td> 
    <td><h5><?php echo $sight_f;?> </h5></td>
  </tr>
  <tr>
    <td><h5>Strength :</h5></td> 
    <td><h5><?php echo $str_f;?> </h5></td>
  </tr>
   <tr>
    <td><h5>Health :</h5></td> 
    <td><h5><?php echo $health_f;?> </h5></td>
  </tr>
 </table>
