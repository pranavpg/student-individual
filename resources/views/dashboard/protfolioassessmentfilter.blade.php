<?php 																
			//echo "<pre>";
			//print_r($portfolio_view_ges);
			//echo "</pre>";
			//exit;
			if($ges_topic_id!="")
			{
				if($ges_topic_id!="all")
				{
					$portfolio_view_ges_filter = [];
					$k = 0;
					foreach($portfolio_view_ges as $i=>$portfolio_view_ges){ 	
						
						$portfolio_view_ges_filter[$k]['suboutcome_id'] = $portfolio_view_ges['suboutcome_id'];
						$portfolio_view_ges_filter[$k]['suboutcome_name'] = $portfolio_view_ges['suboutcome_name'];
						
						$pcnt = count($portfolio_view_ges['task']); 
						
						for($j=0;$j<$pcnt;$j++) {														
							foreach($sessionAll['topics'] as $m=>$topic_ges) {
								if($portfolio_view_ges['task'][$j]['topic_id']==$topic_ges['id']){ 
									if("topic_".$topic_ges['sorting']==$ges_topic_id) {
										$portfolio_view_ges_filter[$k]['task'][] = $portfolio_view_ges['task'][$j];
										
									}
								}
								}	
								
							}
							$k++;
					}
				}
				else
				{
					$portfolio_view_ges_filter  = $portfolio_view_ges;
				}
				
				//echo "<pre>";
				//print_r($portfolio_view_ges_filter);
				//echo "</pre>";
				//exit;
				
				foreach($portfolio_view_ges_filter as $i=>$portfolio_view_ges_filter){ 	
					if(isset($portfolio_view_ges_filter['task']))
					{											
					$pcnt = count($portfolio_view_ges_filter['task']);  
					if($pcnt>0)
					{
						$gesCount=0;
					for($j=0;$j<$pcnt;$j++) {														
						$topic = "";
						foreach($sessionAll['topics'] as $m=>$topic_ges) {
							if($portfolio_view_ges_filter['task'][$j]['topic_id']==$topic_ges['id']){ $topic =  $topic_ges['sorting']; }
							}
							?>
					<tr class="topic_{{$topic}} <?php if($j==0){ echo 'iepa-trwc iepa-trwc-'.$gesCount;	}?>">
						<td class="<?php if($j==0){ echo 'iepa-tdwc iepa-tdwc-'.$gesCount;}  $gesCount++;?>">	
							<?php if($j==0){ echo $portfolio_view_ges_filter['suboutcome_name']; } ?>
						</td>
						<td>Topic {{$topic}} </td>
						<td>	<?php foreach($sessionAll['tasks'] as $m=>$task_ges){ 
								if($portfolio_view_ges_filter['task'][$j]['task_id']==$task_ges['id'])	{
									if($task_ges['title']=='Grammar Key') { echo "Gk"; } else { echo "Task " . $task_ges['sorting']; }
								} } ?>
						</td>
						<td>{{$portfolio_view_ges_filter['task'][$j]['marks_gained']}}/{{$portfolio_view_ges_filter['task'][$j]['original_marks']}} ({{$portfolio_view_ges_filter['task'][$j]['marks']}}%) </td>
						<td><?php echo $portfolio_view_ges_filter['task'][$j]['result']; ?></td>												
					</tr>	
					<?php 
					}
					}
					} 
				}
			}
			if($aes_topic_id!="")
			{																																	  
				if($aes_topic_id!="all")
				{
					$portfolio_view_aes_filter = [];
					$k = 0;
					foreach($portfolio_view_aes as $i=>$portfolio_view_aes){ 	
						
						$portfolio_view_aes_filter[$k]['suboutcome_id'] = $portfolio_view_aes['suboutcome_id'];
						$portfolio_view_aes_filter[$k]['suboutcome_name'] = $portfolio_view_aes['suboutcome_name'];
						
						$pcnt = count($portfolio_view_aes['task']); 
						
						for($j=0;$j<$pcnt;$j++) {														
							foreach($sessionAll['topics'] as $m=>$topic_aes) {
								if($portfolio_view_aes['task'][$j]['topic_id']==$topic_aes['id']){ 
									if("topic_".$topic_aes['sorting']==$aes_topic_id) {
										$portfolio_view_aes_filter[$k]['task'][] = $portfolio_view_aes['task'][$j];
										
									}
								}
								}	
								
							}
							$k++;
					}
				}
				else
				{
					$portfolio_view_aes_filter  = $portfolio_view_aes;
				}
				
				//echo "<pre>";
				//print_r($portfolio_view_aes_filter);
				//echo "</pre>";
				//exit;
				
				foreach($portfolio_view_aes_filter as $i=>$portfolio_view_aes_filter){ 	
					if(isset($portfolio_view_aes_filter['task']))
					{											
					$pcnt = count($portfolio_view_aes_filter['task']);  
					if($pcnt>0)
					{
						$aescount =0;
					for($j=0;$j<$pcnt;$j++) {														
						$topic = "";
						foreach($sessionAll['topics'] as $m=>$topic_aes) {
							if($portfolio_view_aes_filter['task'][$j]['topic_id']==$topic_aes['id']){ $topic =  $topic_aes['sorting']; }
							}
							?>
					<tr class="topic_{{$topic}} <?php if($j==0){ echo 'iepa-trwc iepa-trwc-aes-'.$aescount;	}?>">
						<td class="<?php if($j==0){ echo 'iepa-tdwc iepa-tdwc-aes iepa-tdwc-aes-'.$aescount;} $aescount++;?>" >	
							<?php if($j==0){ echo $portfolio_view_aes_filter['suboutcome_name']; } ?>
						</td>
						<td>Topic {{$topic}} </td>
						<td>	<?php foreach($sessionAll['tasks'] as $m=>$task_aes){ 
								if($portfolio_view_aes_filter['task'][$j]['task_id']==$task_aes['id'])	{
									if($task_aes['title']=='Grammar Key') { echo "Gk"; } else { echo "Task " . $task_aes['sorting']; }
								} } ?>
						</td>
						<td>{{$portfolio_view_aes_filter['task'][$j]['marks_gained']}}/{{$portfolio_view_aes_filter['task'][$j]['original_marks']}} ({{$portfolio_view_aes_filter['task'][$j]['marks']}}%) </td>
						<td><?php echo $portfolio_view_aes_filter['task'][$j]['result']; ?></td>												
					</tr>	
					<?php 
					}
					}
					} 
				} 

			}
			?>