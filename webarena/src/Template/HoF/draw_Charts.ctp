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

<div id="chart1" style="height:400px;width:500px; margin:auto; position:absolute; top:100px; left:100px;"></div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<div id="pieChartsSection" style="height:200px;width:200px; margin:auto; position:absolute; top:100px; left:700px; "></div>
<div id="chart3" style="height:400px;width:500px; margin:auto; position:absolute; top:600px; left:100px;"></div>

<div id="jaugeChartsSection" style="width:300px; margin:auto; position:absolute; top:100px; left:900px;"></div>


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
          $('#pieChartsSection').append('<br><div id="' + fighterSkills[i][4] + '"> </div>');
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
    
    // Third charts : default charts with dates axis showing when users last connexion
    var arrayDate = <?php echo json_encode($eventsConnexionArray); ?>;
    
    var dateConnexion = [];
      arrayDate.forEach(function(element)
      {
          dateConnexion.push([element[0]['nameUser'], (element[0]['dateLastDisconnexion'] - element[0]['dateLastConnexion'])/60]);          
      });    
     
     $('#chart3').jqplot([dateConnexion], {
        title:'Time spent by each user since their last connexion',
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
    
    
    
    // Fourth chart : meter jauge charts showing victorious attacks
    var arrayXPFighter = <?php echo json_encode($FightersXPArray); ?>;
    
      var fighterXP = [];
      arrayXPFighter.forEach(function(element)
      {
          fighterXP.push([element[0]['name'], element[0]['level'], element[0]['XP'], element[0]['playerId']]);          
      });
                                  
      for (var i in fighterXP)
      {
          // Create a new sub-region for new meter jauge charts
          $('#jaugeChartsSection').append('<br><div style="height:200px" id="' + fighterXP[i][3] + '"> </div>');
          
          // Determine "needle" position
          s1 = [fighterXP[i][1]*4 + fighterXP[i][2] - 4];
 
        $.jqplot(fighterXP[i][3],[s1],{
            title: 'Victorious attacks by '+fighterXP[i][0],
         seriesDefaults: {
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
               min: 0,
               max: 60,
               intervals:[10, 20, 30, 40, 50, 60],
               intervalColors:['#66cc66', '#93b75f', '#E7E658', '#cc6666', '#66cc66', '#ff0000']
             }
            }
         });         
    };
});
</script>


</div>