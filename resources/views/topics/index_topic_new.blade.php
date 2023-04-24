@extends('layouts.app') @section('content')
<style>
	.menu-option{
		display:none;
	}
	.menu-back{
		display:block !important;
	}
	.menu-back img{
		width: 10px;
		margin: 6px 10px;
	}
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<div class="ieukmob-bredcumb <?php echo $taskIdNew ?> <?php if(isset($taskIdNew) && !empty($taskIdNew)){?> fullscreen <?php }?>" Add class: id="mobile-bread">
	<marquee direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
		<span class="ieuk-b-toc" id="bred-course"></span>
		&nbsp;>&nbsp; Topic: <span ><?php echo $topic_no; ?></span>
		<!-- <span class="ieuk-b-totsk" id="bred-task"></span> -->
		 <!-- <span class="ieuk-b-totsk" id="bred-taskname"></span> -->
	</marquee>
</div>
<main class="course-book <?php echo $taskIdNew ?> <?php if(isset($taskIdNew) && !empty($taskIdNew)){?> fullscreen <?php }?>">
	<div class="container-fluid">
		<div class="row flex-wrap">
			<div class="col-lg-6 course-book-navigation d-flex flex-wrap">
				<div class="row mb-3">
					<div class="say-hello col-12 col-md-6 col-lg-5 col-xl-7">
						<a class="mobbackbtn-b" href="{{url('/')}}"><i class="fas fa-chevron-left"></i> back</a>
						<h1 style="color:white; font-weight:300"><?php echo isset($taskinfo['topic_detail']['topicname'])?$taskinfo['topic_detail']['topicname']:"";?></h1>
						<!-- <div id="sync">sync</div> -->
						<picture class="picture d-flex"> <img src="{{ env('S3URL') }}<?php echo isset($taskinfo['topic_detail']['image'])?$taskinfo['topic_detail']['image']:'';?>" alt="<?php echo isset($taskinfo['topic_detail']['topicname'])?$taskinfo['topic_detail']['topicname']:"";?>" class="img-fluid rounded-lg"> </picture>
					</div>
					<div class="book-navigation col-12 col-md-6 col-lg-7 col-xl-5 parentSidebar">
						<div class="close-course">
							<a href="javascript:void(0);" class="close-course-icon"><img src="{{ asset('public/images/icon-close-course.svg') }}" alt="X" class="img-fluid"></a>
						</div>
						<a href="" class="navigation <?php if(isset($taskIdNew) && !empty($taskIdNew)){?> <?php }else{?>active<?php }?>">AIM</a>
						<div class="ieuk-taimmobonly">
						  <div class="course-content course-content-1 bg-white" style="width:100%; height: calc(100% - 4rem); overflow:hidden; <?php if(isset($taskIdNew) && !empty($taskIdNew)){?> display:none; <?php }?>">
						  	<div class="expand-option-aim">
									<ul class="list-inline">
										<li class="list-inline-item">
											<a href="javascript:void(0);" class="expand-collapse-aim"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
										</li>
									</ul>
								</div>
								<div><h1 style="font-size: 2rem;">AIM</h1>{!!  $taskinfo['topic_detail']['aim']!!}</div>
							</div>
						</div>
						<?php
							$activeTaskKey = '';
							$task_number   = 1;
							$task_number1  = 1;
							if(!empty($taskinfo['topic_task_list'])) {
								foreach($taskinfo['topic_task_list'] as $taskKey=>$task) {
								?>
								<a href="<?php echo URL('topic/'.$topicId.'/'.$task['_id']);?>"  data-topic_id="{{$task['_id']}}" data-task_id="{{$task['_id']}}" data-task-brd="<?php if( strtolower($task['taskname']) == 'grammar key'){ echo ' '; } else if( strtolower($task['taskname']) == 'grammar practice'){ echo ' '; }else {	echo ' '. $task_number1; $task_number1++; } ?>" class=" navigation-task-sorting navigation <?php if(isset($taskIdNew) && !empty($taskIdNew) && $taskIdNew == $task['_id']){ $activeTaskKey = $taskKey;?>active<?php }?>" data-task-name="<?php echo $task['taskname'];?>" >
									<small>
										<?php
											if(strtolower($task['taskname']) == 'grammar key') {
												echo 'GK';
											}else if( strtolower($task['taskname']) == 'grammar practice'){
												echo 'GP';
											}else{
												$current_sort = isset($task['sorting'])?$task['sorting']:'-';
												echo 'T'.$task['sorting']; 
											}
											$task_number++;
										?>
									</small>
									<p><?php echo $task['taskname'];?></p>
									@if(!empty($taskinfo['progress']))
										<?php
										 	$result1 =0;
										 	$final_progress =0;

											if($taskinfo['progress'][$task['_id']]['gain'] != 0){
												if($taskinfo['progress'][$task['_id']]['total'] != 0){
													$result1 = $taskinfo['progress'][$task['_id']]['gain'] / $taskinfo['progress'][$task['_id']]['total'];
			                                        $result2 = $result1 * 100;      
			                                        $final_progress  = number_format($result2, 0);
												}
											}
										?>
										@if(strtolower($task['taskname']) == 'grammar key')
											<div class="progress task_progress">
												<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
											</div>
										@else
											<div class="progress task_progress">
												<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $final_progress; ?>%"></div>
											</div>
										@endif				
									@endif
									<span>
										<img src="{{ asset('public/images/icon-right-circle.svg') }}" alt="" class="img-fluid">
									</span>
								</a>
						<?php }
						}?>
					</div>
				</div>
			</div>
			<div class="speaking-course d-md-flex flex-wrap col-lg-6">
				<div class="course-content course-content-1 bg-white" style="width:100%; height: calc(100vh - 4rem); overflow:auto; <?php if(isset($taskIdNew) && !empty($taskIdNew)){?> display:none; <?php }?>">
					<div>
						<h1>AIM</h1>{!!  $taskinfo['topic_detail']['aim']!!}
					</div>
				</div>
				<?php 
					$class = "";
					$style= "";
					$class1 = "";
					$style1= "";
					if(isset($tasks_new['tasks'][0]['taskcategory']) && strtolower($tasks_new['tasks'][0]['taskcategory']) == 'grammar key'){
						$class="expanded-block";
						$style="display:none !important;";
					}
					if(isset($tasks_new['tasks'][0]['taskcategory']) && strtolower($tasks_new['tasks'][0]['taskcategory']) == 'grammar_practice'){
						$class1="expanded-block";
						$style1="display:none !important;";
					}
				?>
				<?php 
                  // if(isset($taskIdNew))
				?>
				<div class="course-content cc bg-white course-content-2 {{$class}} {{$class1}}" style="<?php if(isset($taskIdNew) && !empty($taskIdNew)){?>  <?php }else{?> display:none; <?php }?>{{$style1}}">
					<div class="course-tab">
						<div class="course-tab-fixed-heading d-flex flex-wrap align-items-center" style="{{$style}}">
							<ul class="nav nav-pills" id="pills-tab" role="tablist">
								<li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Course Book</a> </li>
							</ul>
							<div class="course-tab-fixed-footer d-flex flex-wrap align-items-center" style="{{$style}}">
								<div class="w-100">
									<a href="javascript:void(0);" class="etra_options_buttons">
										<img src="{{ asset('public/images/ic_plus.png') }}" alt="" class="img-fluid rotate">
									</a>
									<ul class="etra_options collapse animate__animated animate__pulse">
										<li><a href="{{ url('notes') }}?type=task">Add Note</a></li>
										<li><a href="{{ url('vocabulary') }}?type=task">Add Vocabulary</a></li>
										<li><a href="{{ url('summary') }}?type=task">Add Summary</a></li>
									</ul>
								</div>
							</div>
							<div class="course-tab-chat-support d-flex flex-wrap align-items-center">
								<div class="w-100">
									<a href="javascript:void(0);" class="expand-chat-support">
										<img src="{{ asset('/public/images/task-chat-support.png') }}" alt="Chat Support" style="width:36px;">
									</a>
								</div>
							</div>
							<div class="expand-option-course">
								<ul class="list-inline">
									<li class="list-inline-item">
										<a href="javascript:void(0);" class="expand-collapse-course"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
									</li>
								</ul>
							</div>
						</div>
						<div class="course-tab-content">
							<div class="tab-content" id="pills-tabContent" style="height:100%;">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" style="height:100%;">
									<div class="coursebook-section" id="coursebook_section">
										<h1>{!!  isset($tasks_new['tasks'][0]['name'])?$tasks_new['tasks'][0]['name']:"" !!}</h1>
										{!! isset($tasks_new['tasks'])?$tasks_new['tasks'][0]['description']:"" !!} 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="practice-content pc bg-white course-content ieukpb-cucmob  ssssssss {{ $class1 }}" style="{{$style}} ">
					<?php
						$azRange = range('A', 'Z');
						if(isset($tasks_new['tasks'][0]['practise'])){
							$practises 			= $tasks_new['tasks'][0]['practise'];
							$nextPractises 		= !empty($tasks_new['tasks'][0]['practise'][$activeTaskKey+1])?$tasks_new['tasks'][0]['practise'][$activeTaskKey+1]: '0';		
							$activeTaskId  		= $tasks_new['tasks'][0]['id'];
							$activeTopicId 		= $topicId;
							?> 
							<div class="practice-tab course-tab">
								<div class="practice-content-heading course-tab-fixed-heading d-flex flex-wrap justify-content-between align-items-center">
									<ul class="nav nav-pills">
										<li class="nav-item"> <a class="nav-link active ieukpb-btnmain" href="javascript:void(0);">Practice Book</a> </li>
									</ul>
									<div class="abc-tab m-auto">
										<ul class="nav nav-pills text-uppercase align-items-center ieukpb-abcul" id="abc-tab" role="tablist">
											<?php
											$isactive = ""; foreach($practises as $i=>$practise) {
												if(null == \Request::get('n')) {
													if($i == 0){
														$isactive = "active";
													}else{
														$isactive = "";
													}
												}
												?>
												<li class="nav-item menu__item">
													<a class="nav-link open-practice <?php echo $isactive; ?> parent_id_{{ $practise['id'] }}" 
													data-href="{{url('/').'/topic/'.$activeTopicId.'/'.$activeTaskId.'?n='.$practise['id']}}"
													data-roleplay="{{!empty($practise['is_roleplay'])?$practise['is_roleplay']:0}}" 
													data-dependent="<?php echo (!empty($practise['is_dependent']) && $practise['is_dependent'] == 1)?1:0 ?>" 
													data-nextdependent="<?php  echo (!empty($nextPractises[0]['is_dependent']) && $nextPractises[0]['is_dependent'] == 1)?1:0 ?>"
													data-id="<?php echo $practise['id'];?>"
													data-islastpractise= "<?php echo (count($practises) == $i+1) ? '1':'0'; ?>"
													data-nextid="<?php echo !empty($nextPractises[0]['id'])?$nextPractises[0]['id']:"" ;?>"
													id="abc-<?php echo $practise['id'];?>-tab" 
													aria-controls="abc-<?php echo $practise['id'];?>" aria-selected="true">
														<?php echo $azRange[$i];?>
													</a>
												</li>
												<?php } ?>
										</ul>
									</div>
									<div class="heading-right erase-practice-data">
										<ul class="list-inline">
											<li class="list-inline-item">
												<a href="javascript:void(0);" class="erase-modal"> <img src="{{ asset('public/images/icon-tab-edit.png') }}" alt="edit" class="img-fluid" width="36px"></a>
											</li>
										</ul>
									</div>
									<div class="expand-option-practice">
										<ul class="list-inline">
											<li class="list-inline-item">
												<a href="javascript:void(0);" class="expand-collapse-practice"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
											</li>
										</ul>
									</div>
								</div>
								<div class="course-tab-content">
									<div class="tab-content" id="abc-tabContent">
										<?php 
										 	// dd($practises);
											$isactive = ""; 
											foreach($practises as $i=>$practise) {
												$flag = "display:none";
												if(null == \Request::get('n')) {
													if($i == 0) {
														$isactive = "active";
													} else {
														$isactive = "";
													}
												}
												if(!empty(request()->get('reset'))) {
													if($practise['id'] == request()->get('reset')) {
														unset($practise['user_answer']);
													}
												}
												?>
												<div class="tab-pane fade {{ $isactive }}" id="abc-<?php echo $practise['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $practise['id'];?>-tab">
													<?php  
														if($practise['is_complete'] === false){
															if(isset($practise['user_answer'][0])){
																$flag = "display:block";
															}else{
																$flag = "display:none";
															}
														}
													?>
													<div class="row msg" style='{{ $flag }}'>
														<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
															<span style="color: #6c6c6c;background-color: #ecfbe5;padding: 4px 30px 4px 30px;border-radius: 6px;font-size: 15px;"><img src="{{ asset('public/images/notification-bell.png') }}" style="padding-right: 5px;width: 20px;margin-top: -3px;"></i> Task saved. Submit your task for marking.</span>
														</div>
													</div>
													@if(env("PRODUCTION_URL") == 'https://admin.englishapp.uk/api' || env("PRODUCTION_URL") == 'http://localhost/final-admin/public/api'  )
														@php 
															echo isset($practise['markingmethod'])? "<b>Marking Method </b>==>  ".$practise['markingmethod']:'';
															echo isset($practise['typeofdependingpractice'])? "<br><b>Depending practice Type</b>==>".$practise['typeofdependingpractice']:"<br><b>Depending practice Type</b>==> None";
															echo "";
														@endphp
														<br>
														<b>Practice Type</b> ==>{{ $practise['type'] }}
														<br>
														<br>
													@endif 
													<?php
													if(\Session::all()['user_id_new'] == "6PFW8C"){
														?>	
														@php 
															echo isset($practise['markingmethod'])? "<b>Marking Method </b>==>  ".$practise['markingmethod']:'';
															echo isset($practise['typeofdependingpractice'])? "<br><b>Depending practice Type</b>==>".$practise['typeofdependingpractice']:"<br><b>Depending practice Type</b>==> None";
															echo "";
														@endphp
														<br>
														<b>Practice Type</b> ==>{{ $practise['type'] }}
														<br>
														<br>

														<?php
													}
													  $is_automated = false;
													  if(isset($practise['markingmethod']))
													  {
														  if($practise['markingmethod'] == "automated")
														  {
														    $practise['markingmethod'] = "student_self_marking";
														    $is_automated = true;
														  }
													  }
                                                     ?>
													@include('common.all-practice-list')
												</div>
											<?php } ?>
									</div>
								</div>
						<?php }?>
							</div>
					</div>
				</div>
			</div>
		</main>
		<!--topic_tasks_new-->
<div class="modal fade" id="erasemodal" tabindex="-1" role="dialog" aria-labelledby="erasemodalLongTitle" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title text-center" id="erasemodalLongTitle">Reset Answers</h5>
			</div>
			<div class="modal-body text-center m-5">
				<p class="erase__modal__text"></p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-primary mr-3 reset-answer" data-dismiss="modal">Yes</button>
				<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button>
			</div>
		</div>
	</div> 
</div>
<div class="page-loader-wrapper_upload" style="display:none">
	<div class="loader_upload">
	    <img class="loading-img-spin_upload" src="{{asset('public/images/logo-main.svg')}}" alt="admin">
	    <p class="primary font-weight-bolder">Uploading Audio...</p>
	</div>
</div>
<style>
.nav-item{
	cursor:pointer;
}
.page-loader-wrapper_upload {
    z-index: 99999999;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: rgba(111,89,89,.4);
    overflow: hidden;
    text-align: center;
}
.page-loader-wrapper_upload .loader_upload {
    position: relative;
    top: calc(50% - 30px);
}
.loading-img-spin_upload {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150px;
    height: 150px;
    margin: -130px 0 20px -75px;
}
.smallcontent{
	font-size: 25px !important;
	float: left;
	margin-left: 2px;
	padding-left: 2px;
}
</style>
	<?php 
		$url 				= \Request::fullUrl();
		$url_components 	= parse_url($url);
		$activePracticeID	= "";
		if(!empty($practises)){
			$activePracticeID=$practises[0]['id'];
			if(!empty($url_components['query'])){
				parse_str($url_components['query'], $params); 
				$activePracticeID = !empty($params['n'])?$params['n']:"";
			}
		}else{
			$practises = [];
		}
		$lastPractice=end($practises);
		if($lastPractice != false && $lastPractice['id'] == $practiceId){
			$reviewPopup=true;
		}else{
			$reviewPopup=false;
		}
	?>
	<script type="text/javascript">
		// var replace 			= "<?php //echo isset($CourseDetails)?$CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title']:""; ?>";
			// var replace = "<?php //echo $CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title'];?>";
		// var newData  = replace.replace("-PRE- INTERMEDIATE","");
		var dependentPractiseIdTab = "{{request()->get('n')}}";
		if(dependentPractiseIdTab && dependentPractiseIdTab!==undefined && dependentPractiseIdTab!==null && $.trim(dependentPractiseIdTab)!=""){
			$('#abc-'+dependentPractiseIdTab+'-tab').trigger('click');
			$('#abc-'+dependentPractiseIdTab+'-tab').addClass('active').addClass('show');
		}
		$(document).on('click', '.student_self_mark_cancel_btn', function(){
			if($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type") == "button"){
				if(typeof($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').closest('.myclass').attr("class")) === "undefined"){
					$('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').trigger('click');
					$('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').attr('disabled',true);
				}else{
					var ids = $('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').closest('.myclass').attr("data");
					$('.self_marking_modal_popup').find('.append_'+ids).find('.plyr__controls__item').trigger('click');
					$('.self_marking_modal_popup').find('.append_'+ids).find('.plyr__controls__item').attr('disabled',true);
				}
			}
		});
		jQuery(document).ready(function(){
			$(".navigation-task-sorting").on("click", function(){
				var dataTask = $(this).attr("data-task-brd");
				var dataTaskname = $(this).attr("data-task-name");
				// alert(dataTaskname);
				sessionStorage.setItem("bred-topic",topic_no);
				sessionStorage.setItem("bread-task", "");
				sessionStorage.setItem("bread-task", dataTask);
				sessionStorage.setItem("bread-taskname", dataTaskname);
				$('#bred-task').text(' > '+sessionStorage.getItem("bread-task"));
			});
			$('#bred-task').text('> Task : ' +sessionStorage.getItem("bread-task"));
			$('#bred-taskname').text(sessionStorage.getItem("bread-taskname"));
			$('#bred-task').prepend("&nbsp;");
			jQuery(".heading-right .list-inline-item a").attr("data-toggle","modal");
			jQuery(".heading-right .list-inline-item a").attr("data-target","#erasemodal");
			var isRoleplayPractice = jQuery('.menu__item a').attr('data-roleplay');
			if(isRoleplayPractice==1){
				$('.erase__modal__text').html("Are you sure you want to reset your answers? Please note that all role cards will be reset.");
			} else {
				$('.erase__modal__text').html("Are you sure you want to reset your answers?")
			}
			jQuery('.menu__item a').on('click', function(e){
				var isRoleplayPractice = $(this).attr('data-roleplay');
				if(isRoleplayPractice==1){
					$('.erase__modal__text').html("Are you sure you want to reset your answers? Please note that all role cards will be reset.");
				} else {
					$('.erase__modal__text').html("Are you sure you want to reset your answers?")
				}
			});
			jQuery('.reset-answer').on('click', function(e){
				e.preventDefault();
				var reset_practice_id = $('.menu__item a.active').attr('data-id');
				$.ajax({
			      	url: '<?php echo URL('reset-answer'); ?>',
			      	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			      	type: 'POST',
			      	data: {reset_practice_id:reset_practice_id},
					dataType:'json',
					success: function (data) {
						location.reload()
		      		}
			  	});
			});
		});
		function resizeIFrameToFitContent(iFrame) {
			iFrame.width = iFrame.contentWindow.document.body.scrollWidth;
			iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
		}
		window.addEventListener('DOMContentLoaded', function(e) {
			var iFrame = document.getElementById('iframe_aim');
			if(iFrame !== null){
				resizeIFrameToFitContent(iFrame);
			}
			var iFrame2 = document.getElementById('iframe_aim2');
			if(iFrame2 !== null){
				resizeIFrameToFitContent(iFrame2);
			}
			var iframes = document.querySelectorAll("iframe_aim");
			for(var i = 0; i < iframes.length; i++) {
				resizeIFrameToFitContent(iframes[i]);
			}
			var iframes = document.querySelectorAll("iframe_aim2");
			for(var i = 0; i < iframes.length; i++) {
				resizeIFrameToFitContent(iframes[i]);
			}
		});
	</script>
	<?php if(isset($taskIdNew) && !empty($taskIdNew)){?>
		<script type="text/javascript">
			$("#fullscreen, .close-course-icon").click(function() {
				$(".course-content-2").toggle();
				$(".course-content-1").toggle();
				$("#mobile-bread").removeClass("fullscreen");
			});
			$(".navigation.active").click(function() {
				$(".close-course-icon").trigger("click");
				return false;
			});
			var rename_audio = '{{ URL("rename-audio") }}'
		</script>
		<script src="{{asset('public/js/audio-recorder/recorder.js')}}"></script>
		<script src="{{asset('public/js/audio-recorder/app-multiple.js')}}?v={{env('CACTH')}}"></script>
		<script src="{{ asset('public/js/audioplayer.js') }}"></script>
		<script>
			var practiceid  = "";
			var rendomId 	= "";
			function openModelForConform(practiceId , autoId) {
		      	practiceid = practiceId;
		      	rendomId = autoId;
		      	$('#deleteErasemodal').modal("show")
		    }
			$(function () {
				$('audio.practice_audio').audioPlayer();
				 $('.practice-tab').find('.course-tab-content').find('#abc-{{$activePracticeID}}').addClass('show active')
			});
			$(document).on('click','.open-practice', function(){
				var practice_location = $(this).attr('data-href')
				window.location.href = practice_location;
			});
			$(document).on('click','.delete-popup-icon', function() {
				var this1 = $('.delete-recording-'+practiceid+'-'+rendomId)
				var delete_audiokey = this1.attr('data-key');
				$(this1).parent().find('.practice_audio').prop('src','');
				$(this1).parent().find('.practice_audio').find('source').prop('src','');
				$(this1).parent().find('.audioplayer-bar-played').css('width','0%');
				$(this1).hide();
				$(this1).parent().find('div.audio-element').css('pointer-events','none');
				$(this1).parent().find('.audioplayer-playpause').hide();
				$(this1).parent().find('.record-icon').css({'margin-left':'-60px'});
				var audio_key= $(this).attr('data-key');
				var practise_id = this1.attr('data-pid');
			
				$.ajax({
					url: '<?php echo URL('delete-audio'); ?>',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					data: {practice_id:practise_id,'audio_key':rendomId},
					success: function (data) {
						this1.parent().find('.mic-icon-'+delete_audiokey).show();
						this1.parent().find('#record_audio'+delete_audiokey).show();
						$(document).find('.deleted_audio_'+practise_id+'_'+delete_audiokey).val('blank')
						$('.audio_path'+delete_audiokey).val('')
					}
			  });
			});

			$(document).ready(function(){
				$("#coursebook_section img").click(function(){
					var path = $(this).attr('src');
					document.getElementById("image-c").src = path;
					$("#full_image_modal").modal("show");
				});
				$(".rotate").click(function(){
					$(this).toggleClass("quarter"); 
				});
				$(".etra_options_buttons").click(function(){
					$(".etra_options").fadeToggle();
				});
				$(".rotate-expand-icon").click(function(){
					$(this).toggleClass("half"); 
				});
				$(".expand-collapse-course").click(function(){
					$(".cc").toggleClass("expanded-block");
					$(".pc").toggle();
				});
				$(".expand-collapse-practice").click(function(){
					$(".pc").toggleClass("expanded-block");
					$(".cc").toggle();
				});
				let reviewPopDisplay   = "{{ $reviewPopup }}";
			  $(document).on('click','.submit_btn',function(){
				let value = $(this).val();
				let text = $(this).text();
				if(value == 'Submit' || text == 'Submit'){
					if(!reviewPopDisplay){
							$('#course-feedback-init-mid').modal("show");
						}
					}
				});
				$("#reviewModal_{{isset($practise['id'])?$practise['id']:''}}").on('click','.skip-review', function() {
					// $('#course-feedback-init-mid').modal("show");
				});
			});
		</script>
	<?php } ?>
<script>
	$(".expand-option-aim").click(function(){
		$('.say-hello').toggleClass('d-none');
		$('.navigation').toggleClass('d-none');
		$('.row').toggleClass('w-100');
		$('#iframe_aim1').toggleClass('expanded-block-aim');
		$('.container-fluid').toggleClass('pr-0');
		$('.col-12').toggleClass('pr-0');
		$('.col-lg-6').toggleClass('pr-0');
		$('main').toggleClass('p-0');
		$('.rotate-expand-icon').toggleClass('half');
	});
</script>
@include('practice.common.audio_record_popup')
<div class="modal fade" id="deleteErasemodal" tabindex="-1" role="dialog" aria-labelledby="deleteErasemodalLongTitle" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="deleteErasemodalLongTitle">Delete Recording</h5>
			</div>
			<div class="modal-body text-center m-5">
				<p>Are you sure you want to delete this recording ?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-primary delete-popup-icon" data-dismiss="modal">Yes</button>
				<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade show" id="full_image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">                 
			<div class="modal-body position-relative">
				<button type="button" class="custom-image-modal-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<div class="w-100">
					<img src="" id="image-c" style="width:100%;">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function getLocalStream() {
		navigator.mediaDevices.getUserMedia({
			video: false,
			audio: true
		}).then(stream => {
			
			window.localStream = stream;
			window.localAudio.srcObject = stream;
			window.localAudio.autoplay = true;
		}).catch(err => {
			
			console.log("u got an error:" + err)
		});
	}
	// getLocalStream();
</script>
<script>
$( document ).ready(function() {
    var coursename = localStorage.getItem('course_name');
    $('#bred-course').text(coursename)
});
</script>

@endsection