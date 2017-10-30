<?php echo $this->Html->script('jquery.min.js');?>
<?php $this->assign('title', 'Messages');?>

<h2>Send a new message : </h2><br>

<?php
    echo $this->Form->create();
    echo $this->Form->input('receiver', array('type' => 'text','label' => 'Addressee : ')); 
    echo $this->Form->input('title',array('type' => 'text','label' => 'Title : '));
    echo $this->Form->textarea('message', ['rows' => '5', 'cols' => '5']);
    echo $this->Form->submit('Send', array('name' => 'sendmessage'));
    echo $this->Form->end();

?>

<br><br>

<h3>Create an event : </h3><br>

<?php
    echo $this->Form->create();
    echo $this->Form->textarea('description', ['rows' => '5', 'cols' => '5']);
    echo $this->Form->submit('Scream !', array('name' => 'scream'));
    echo $this->Form->end();

?>


<br><br>

<h3>View your messages : </h3><br>

<h5>Messages sent : </h5><br>
<ul id="ms"></ul>    

<h5>Messages received : </h5><br>
<ul id="mr"></ul> 

<script>
$(document).ready(function(){
     // MESSAGES SENT
      var arrayMessagesS = <?php echo json_encode($messagesSent); ?>;
      var arrayMessagesSent = [];
      arrayMessagesS.forEach(function(element)
      {
          arrayMessagesSent.push([element[0]['addressee'], element[0]['date'], element[0]['title'], element[0]['text']]);          
      });
                                  
      for (var i in arrayMessagesSent)
      {
        $('#ms').append('<li>Message sent to '+arrayMessagesSent[i][0]+' at ' +arrayMessagesSent[i][1]+ ' :<br>Object : ' +arrayMessagesSent[i][2]+ '<br>Text : ' +arrayMessagesSent[i][3]+ '</li><br>');
      }
      
      // MESSAGES RECEIVED
      var arrayMessagesR = <?php echo json_encode($messagesReceived); ?>;
      var arrayMessagesReceived = [];
      arrayMessagesR.forEach(function(element)
      {
          arrayMessagesReceived.push([element[0]['sender'], element[0]['date'], element[0]['title'], element[0]['text']]);          
      });
                                  
      for (var i in arrayMessagesReceived)
      {
        $('#mr').append('<li>Message received from '+arrayMessagesReceived[i][0]+' at ' +arrayMessagesReceived[i][1]+ ' :<br>Object : ' +arrayMessagesReceived[i][2]+ '<br>Text : ' +arrayMessagesReceived[i][3]+ '</li><br>');
      }
   
});
</script>




<?= $this->Flash->render() ?>
