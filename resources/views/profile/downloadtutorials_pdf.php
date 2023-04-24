<style>table, th { border: 1px solid black;  }</style>
<table width="100%">
   <tr>
      <td colspan="3" align="center">Tutorials</td>
   </tr>
   <tr>
      <td colspan="3"><?php echo 'Student Id:-'.' '.Session::get('user_id_new').' | '.'Student Name:-'.' '.Session::get('first_name').' '.Session::get('last_name') ?>
      </td>
   </tr>
   <tr style="background-color:black;color:white;">
      <td>Tutorial Date & Time</td>
      <td>Teacher Name</td>
      <td>Review Date & Time</td>
   </tr>
   <?php 
      $k = 0;
      foreach($tutorials as $tutorial){
      	//dd($tutorial);
      $tutorialDateTime = $tutorial['tutorial_date'];
                                 $tutorialDateTime = explode("\n",$tutorialDateTime);
      ?>                                    
   <tr>
      <td><?php echo isset($tutorialDateTime[0]) ? $tutorialDateTime[0] : '';?>&nbsp;<?php echo isset($tutorialDateTime[1]) ? $tutorialDateTime[1] : '';?></td>
      <td><?php echo $tutorial['get_teacher_name']['teacher_name'];?></td>
      <td><?php echo $tutorial['review_date'];?>&nbsp;<?php echo $tutorial['review_time'];?></td>
   </tr>
   <!-- /. Card -->
   <?php $k++; }?>
   <?php if($k == 0){?>
   <tr>
      <td colspan="3">No Records Found</td>
      <?php
         }									 ?>
   </tr>
</table>