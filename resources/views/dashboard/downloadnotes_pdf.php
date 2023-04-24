<style>table, th { border: 1px solid black;  }</style>
								<table width="100%">
								<tr>
										<td colspan="5" align="center">Notes</td>										
									</tr>
									<tr style="background-color:black;color:white;">
										<td>Title</td>
										<td>Description</td>
										<td>Topic</td>
										<td>Task</td>
										<td>Skill</td>
									</tr>
									<?php 
								$i = 0;
								foreach($sessionAll['courses'] as $courseId=>$course){?>

									<?php 
									$k = 0;
									foreach($notes as $note){
									$taskDetails = $sessionAll['tasks'][$note['taskid']];
									if($taskDetails['course_id'] !== $courseId){ continue;}
									?>                                    
                                    <tr>
                                            <td><?php echo $note['title'];?></td>
                                            <td><?php echo $note['description'];?></td>
											<td><?php echo $sessionAll['topics'][$note['topicid']]['title'];?></td>
											<td><?php echo $sessionAll['tasks'][$note['taskid']]['title'];?></td>
											<?php if(isset($note['skillid']) && !empty($note['skillid'])){?>
											<td><?php echo $sessionAll['skills'][$note['skillid']]['title'];?></td>
											<?php }?>  
                                       </tr>
                                    
                                    <!-- /. Card -->
									<?php $k++; }?>
									
									<?php if($k == 0){?>
									<tr><td colspan="5">No Records Found</td>
									 </tr>
									<?php }?>
							
                                <!-- tab 1-->
								<?php $i++;}?>
</table>
								