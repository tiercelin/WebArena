<div id="postuser">
<?php
echo $this->Html->script('jquery.min.js');
echo $this->Html->script('jquery.jqplot.min.js');
echo $this->Html->script('jquery.jqplot.js');
echo $this->Html->css('jquery.jqplot.css');

echo $this->Html->script('plugins/jqplot.barRenderer.js') ;
echo $this->Html->script('plugins/jqplot.pieRenderer.js') ;
echo $this->Html->script('plugins/jqplot.categoryAxisRenderer.js') ;
echo $this->Html->script('plugins/jqplot.dateAxisRenderer.js') ;
echo $this->Html->script('plugins/jqplot.pointLabels.js') ;
echo $this->Html->script('plugins/jqplot.meterGaugeRenderer.js') ;

?>
    
<?php echo $this->Html->link('Next page Hall of Fame', array('controller' => 'HoF', 'action' => 'drawCharts2')); ?>


<div id="chart1" style="margin:auto; position:absolute; top:200px; left:100px;"></div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><!-- pas le choix -->

<div id="pieChartsSection" style="width:200px; margin:auto; position:absolute; top:50px; left:600px; "></div>


<script>
     
      
$(document).ready(function(){
    
    // First chart : bar chart showing each fighter with their level  
     var arrayFighter = <?php echo json_encode($FightersArray); ?>;
    
      var fighter = [];
      arrayFighter.forEach(function(element)
      {
          fighter.push([element[0]['name'], element[0]['level']]);          
      });
      
    $('#chart1').jqplot([fighter], {
        title:'Fighters and their level',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {
                // Set the varyBarColor option to true to use different colors for each bar.
                // The default series colors are used.
                varyBarColor: true
            }
        },
        axes:{
            xaxis:{
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
    
    
    // Second chart : pie charts showing health, sight and strength skills of every fighter
    var arraySkillsFighter = <?php echo json_encode($FightersSkillsArray); ?>;
    
      var fighterSkills = [];
      arraySkillsFighter.forEach(function(element)
      {
          fighterSkills.push([element[0]['name'], element[0]['health'], element[0]['sight'], element[0]['strength'], element[0]['playerId']]);          
      });
                  
                  
      for (var i in fighterSkills)
      {
          // Create a new sub-region for new pie charts
          $('#pieChartsSection').append('<br><div style="height:200px" id="' + fighterSkills[i][4] + '"> </div><br>');
          $.jqplot(fighterSkills[i][4], [[['health',fighterSkills[i][1]],['sight',fighterSkills[i][2]],['strength',fighterSkills[i][3]]]], {
        title : 'Skills of '+fighterSkills[i][0],
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            trendline:{ show:false }, 
            rendererOptions: { padding: 8, showDataLabels: true }
        },
        legend:{
            show:true, 
            placement: 'outside', 
            rendererOptions: {
                numberRows: 1
            }, 
            location:'s',
            marginTop: '15px'
            }       
        });
    };
    
});
</script>




</div>