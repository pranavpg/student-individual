@foreach($records['result']['data'] as $key=>$values)
	<tr>
		<?php 
			$ABCSArray = array("A","B","C","D","E","F","G","H","I","J","K");
		?>
	    <td scope="col">{{ $values['get_topic']['sorting'] }} {{ $values['get_topic']['topicname'] }}</td>
	    <td scope="col"> {{ $values['get_task']['taskname'] }}<?php 
		?></td>
	    <td scope="col"> {{ $values['get_task']['sorting'] }}-{{ (isset($values['sorting']) && $values['sorting']!=0)?$ABCSArray[$values['sorting']-1]:"" }}<?php 
		?></td>
	  


		
		<td scope="col">
			<?php 
				$emoji_progress_width = array('100%','75%','50%','25%');
				$emoji =array('icon-emoji-green.svg','icon-emoji-yellow.svg', 'icon-emoji-orange.svg', 'icon-emoji-red.svg');
				$filterData = [];
				$topicurl = "{{ url('/topic-iframe/') }}";
			?>
			@if(isset($values['teacher_emoji']) && $values['teacher_emoji']!="")
				<?php
					$emojiwidth = "";
					if($values['teacher_emoji'] != ""){
						$emojiwidth = $emoji_progress_width[$values['teacher_emoji']-1];
					}
					$url = "";
					if(isset($values['teacher_emoji']) && $values['teacher_emoji']!="" && $values['teacher_emoji']!=0){
						$url = "public/images/".$emoji[$values['teacher_emoji']-1];
					}
				?>
				<div class="d-sm-block d-md-flex align-items-center open-add-feedback-modal"  data-topicno="{{ $values['get_topic']['topicname'] }}" data-taskno="{{ $values['get_task']['taskname'] }}" data-topicid="{{ $values['get_topic']['topicname'] }}" data-practiceid="{{ $values['practice_id'] }}" data-taskid="{{$values['task_id'] }}" data-taskcomment="{{ isset($values['teacher_comment'])?$values['teacher_comment']:''  }}" data-taskemoji="{{ $values['teacher_emoji'] }}">
					<span class="review-icon">
						<img src="{{ asset($url) }}" alt="" class="img-fluid" />
					</span>
					<span class="progress" > 
						<span class="progress-bar" role="progressbar" style="width:{{ $emojiwidth }};" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></span> 
					</span>
				</div>
			@else
				<div>-</div>
			@endif
		</td>


		@php  $lable = $values['prcatice_type'];$typedata = ""; @endphp 	
		@if($values['prcatice_type'] == "read_only")
			@php $typedata = "Participation Mark"; @endphp 	
		@elseif($values['prcatice_type'] == "automated")
			@php $typedata = "Auto Mark"; @endphp 	
		@elseif($values['prcatice_type'] == "no_marking")
			@php $typedata = "No Mark"; @endphp 	
		@elseif($values['prcatice_type'] == "student_self_marking")
			@php $typedata = "Class Mark"; @endphp 
		@elseif($values['prcatice_type'] == "manual")
			@php $typedata = "Teacher Mark"; @endphp 	
		@elseif($values['prcatice_type'] == "self")
			@php $typedata = "Self Mark"; @endphp 	
		@endif


		<td scope="col">{{ $typedata }}</td>
		<td scope="col"><a href="javascript:void(0)" class="hidden-tr-opner click" topic_id="{{ $values['topic_id'] }}" practice_id="{{ $values['practice_id'] }}" studentId="{{ $values['student_id'] }}" course_id="{{ $values['course_id'] }}" level_id="{{ $values['level_id'] }}"  taskId="{{$values['task_id'] }}" topic-data="{{ $values['get_topic']['sorting'] }}" task-data="{{ $values['get_task']['sorting'] }}"  practise-data="{{ $values['sorting'] }}"><img src="https://student.englishapp.uk/public/images/icon-table-opener.svg"   alt="" class="img-fluid"></a></td>
	</tr>
@endforeach