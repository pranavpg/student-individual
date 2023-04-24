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
<!-- /======= Breadcumb html added 24-8-21 ==========-->
<div class="ieukmob-bredcumb <?php echo $taskId ?> <?php if(isset($taskId) && !empty($taskId)){?> fullscreen <?php }?>" Add class: id="mobile-bread">
	<marquee direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
		<span class="ieuk-b-toc" id="bred-course"></span>
		&nbsp;>&nbsp; Topic : <span class="ieuk-b-tot" id="bred-topic"></span>
		<span class="ieuk-b-totsk" id="bred-task"></span>
		<span class="ieuk-b-totsk" id="bred-taskname"></span>
	</marquee>
</div>
<!-- /======= Breadcumb html added 24-8-21 ==========-->
<main class="course-book <?php echo $taskId ?> <?php if(isset($taskId) && !empty($taskId)){?> fullscreen <?php }?>">
	<div class="container-fluid">
		<div class="row flex-wrap">
			<div class="col-lg-6 course-book-navigation d-flex flex-wrap">
				<div class="row">
					<div class="say-hello col-12 col-md-6 col-lg-5 col-xl-7"> <a class="mobbackbtn-b" href="{{url('/')}}"><i class="fas fa-chevron-left"></i> back</a>
						<h1 style="color:white; font-weight:300"><?php echo $topic_tasks[0]['title'];?></h1>
						<picture class="picture d-flex"> <img src="<?php echo $topic_tasks[0]['image'];?>" alt="<?php echo $topic_tasks[0]['title'];?>" class="img-fluid rounded-lg"> </picture>
					</div>
					<?php
						//pr($topic_tasks[0]['tasks']);
					?>
					<div class="book-navigation col-12 col-md-6 col-lg-7 col-xl-5 parentSidebar">
						<div class="close-course">
							<a href="javascript:void(0);" class="close-course-icon"><img src="{{ asset('public/images/icon-close-course.svg') }}" alt="X" class="img-fluid"></a>
						</div>
						<a href="{{ URL('topic/'.$topic_tasks[0]['id'])}}" class="navigation <?php if(isset($taskId) && !empty($taskId)){?> <?php }else{?>active<?php }?>">
							AIM
							<!-- <span style="top:50%;">
								<img src="{{ asset('public/images/icon-right-circle.svg') }}" alt="" class="img-fluid">
							</span> -->
						</a>
					<!-- /======= need aim data here 06-09-21 ==========-->
						<div class="ieuk-taimmobonly">
						  <div class="course-content course-content-1 bg-white" style="width:100%; height: calc(100% - 4rem); overflow:hidden; <?php if(isset($taskId) && !empty($taskId)){?> display:none; <?php }?>">
						  	<div class="expand-option-aim">
								<ul class="list-inline">
									<li class="list-inline-item">
										<a href="javascript:void(0);" class="expand-collapse-aim"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
									</li>
								</ul>
							</div>
							<iframe id="iframe_aim1" src="{{ URL('topic_aim/'.$topic_tasks[0]['id'])}}" scrolling="auto" frameborder="0" width="100%" style="min-height:100%"></iframe>
						  </div>
						</div>

					<!-- /======= need aim data here 06-09-21==========-->	
						
						<?php
							$activeTaskKey = '';
							$task_number   = 1;
							$task_number1  = 1;
							// dd($topic_tasks);
							if(!empty($topic_tasks[0]['tasks'])) {
							foreach($topic_tasks[0]['tasks'] as $taskKey=>$task){
								
								if(isset($task['practise']))
								{
								  // dd();
								   $total_practise_count = count($task['practise']);
								   $matchedcount  = 0;
								   	foreach($task['practise'] as $k => $value1)
									{
									    if($value1['is_complete'] == true)
										{ 
	                                       $matchedcount++;
										}
	                                        // $matchedcount++;
									}
								}
								else
								{
                                     $total_practise_count = 1;
								}
								//if($value1)
                                // $perfectcount  = count($task['practise']);
								// $donePractises = count(array_filter($answers, function($ans) use ($task) {
								// 	return $ans['task_id'] === $task['id'];
								// }, ARRAY_FILTER_USE_BOTH));
								// dd($donePractises);
								?>
														<a  href="<?php echo URL('topic/'.$topic_tasks[0]['id'].'/'.$task['id']);?>"  data-topic_id="{{$topic_tasks[0]['id']}}" data-task_id="{{$task['id']}}" data-task-brd="<?php if( strtolower($task['name']) == 'grammar key'){ echo ' '; } else if( strtolower($task['name']) == 'grammar practice'){ echo ' '; }else {	echo ' '. $task_number1; $task_number1++; } ?>" class="navigation-task-sorting navigation <?php if(isset($taskId) && !empty($taskId) && $taskId == $task['id']){ $activeTaskKey = $taskKey;?>active<?php }?>" data-task-name="<?php echo $task['name'];?>">
															<small>
																<?php
																	if( strtolower($task['name']) == 'grammar key'){
																		echo 'GK';
																	} else if( strtolower($task['name']) == 'grammar practice'){
																		echo 'GP';
																	}else {
																		$current_sort = isset($task['sorting'])?$task['sorting']:'-';
																		echo 'T'.$task_number; 
																		$task_number++;
																	}
																?>

															</small>
															<!-- <p class="mb-3 pr-5"> -->
															<p>
																<?php echo $task['name'];?>
															</p>
															<?php
                                                                 $result1 = $matchedcount / $total_practise_count;
                                                                 $result2 = $result1 * 100;  
                                                                 $final_progress  = number_format($result2, 0);
															 ?>
															@if(strtolower($task['name']) == 'grammar key')
															<div class="progress task_progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
															</div>
															@else
															<div class="progress task_progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $final_progress; ?>%"></div>
															</div>
															@endif
															<span>
                                    <img src="{{ asset('public/images/icon-right-circle.svg') }}" alt="" class="img-fluid">
                              </span>
														</a>
							<?php } }?>
					</div>
				</div>
			</div>
			<div class="speaking-course d-md-flex flex-wrap col-lg-6">
				<div class="course-content course-content-1 bg-white" style="width:100%; height: calc(100% - 4rem); overflow:hidden; <?php if(isset($taskId) && !empty($taskId)){?> display:none; <?php }?>">
					<iframe id="iframe_aim1" src="{{ URL('topic_aim/'.$topic_tasks[0]['id'])}}" scrolling="auto" frameborder="0" width="100%" style="min-height:100%"></iframe>
				</div>
				<?php 
				$class = "";
				$style= "";
				$class1 = "";
				$style1= "";
					if(isset($topic_tasks[0]['tasks'][$activeTaskKey]['name']) && strtolower($topic_tasks[0]['tasks'][$activeTaskKey]['name']) == 'grammar key'){
						$class="expanded-block";
						$style="display:none !important;";
					
					}
					if(isset($topic_tasks[0]['tasks'][$activeTaskKey]['name']) && strtolower($topic_tasks[0]['tasks'][$activeTaskKey]['name']) == 'grammar practice'){
						$class1="expanded-block";
						$style1="display:none !important";
					
					}
				?>
				
				<!-- <div class="course-content cc bg-white course-content-2 {{$class}}" style="{{$style1}} <?php if(isset($taskId) && !empty($taskId)){?>  <?php }else{?> display:none; <?php }?>"> -->
				<div class="course-content cc bg-white course-content-2 {{$class}}" style="<?php if(isset($taskId) && !empty($taskId)){?>  <?php }else{?> display:none; <?php }?>">
					<div class="course-tab">
						
						<div class="course-tab-fixed-heading d-flex flex-wrap align-items-center" style="{{$style}}">
							<ul class="nav nav-pills" id="pills-tab" role="tablist">
								<li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Course Book</a> </li>
								<?php 
								 
									/* ?>
										<li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Teacher Book</a> </li>
									<?php */ ?>
							</ul>
							<div class="course-tab-fixed-footer d-flex flex-wrap align-items-center" style="{{$style}}">
								<div class="w-100">
									<a href="javascript:void(0);" class="etra_options_buttons">
										<img src="{{ asset('public/images/ic_plus.png') }}" alt="" class="img-fluid rotate">
									</a>
									<ul class="etra_options collapse animate__animated animate__pulse">
										<li><a href="" data-toggle="modal" data-target="#noteModal" onclick="openModelexampleModal(0);">Add Note</a></li>
										<li><a href="" data-toggle="modal" data-target="#vocabularyModal">Add Vocabulary</a></li>
										<li><a href="" data-toggle="modal" data-target="#summaryModal">Add Summary</a></li>
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
									<div style="width:100%; height: 100%;">
										<iframe id="iframe_aim2" src="{{ URL('topic_aim/'.$topic_tasks[0]['id'].'/'.$taskId)}}" scrolling="auto" frameborder="0" width="100%" style="height:100%;width:100%;"></iframe>
									</div>
								</div>
								<!-- tab 1-->
								<?php /*?>
									<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
									<?php */?>
							</div>
							<!-- /. tab content-->
						</div>
					</div>
				</div>
				<!-- <div class="practice-content pc bg-white course-content ieukpb-cucmob {{$class1}}" style="{{$style}}"> -->
				<div class="practice-content pc bg-white course-content ieukpb-cucmob" style="{{$style}}">
					<?php
						$azRange = range('A', 'Z');
						if(isset($topic_tasks[0]['tasks'][$activeTaskKey]['practise'])){
						$practises = $topic_tasks[0]['tasks'][$activeTaskKey]['practise'];
						$nextPractises = !empty($topic_tasks[0]['tasks'][$activeTaskKey+1]['practise'])? $topic_tasks[0]['tasks'][$activeTaskKey+1]['practise']: '0';		
						// dd($topic_tasks);
						$activeTaskId  = $topic_tasks[0]['tasks'][$activeTaskKey]['id'];
						$activeTopicId = $topic_tasks[0]['id'];
						?>
						<div class="practice-tab course-tab">
							<div class="practice-content-heading course-tab-fixed-heading d-flex flex-wrap justify-content-between align-items-center">
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active ieukpb-btnmain" href="javascript:void(0);">Practice Book</a> </li>
								</ul>
								<div class="abc-tab m-auto">
									<ul class="nav nav-pills text-uppercase align-items-center ieukpb-abcul" id="abc-tab" role="tablist">
										<?php $isactive = ""; foreach($practises as $i=>$practise) { 
											if(null == \Request::get('n')) {
												if($i == 0){
													$isactive = "active";
												}else{
													$isactive = "";
												}
											}
											?>
											<li class="nav-item menu__item">
												<a class="nav-link open-practice <?php echo $isactive; ?>" 
												data-href="{{url('/').'/topic/'.$activeTopicId.'/'.$activeTaskId.'?n='.$practise['id']}}"
												data-roleplay="{{!empty($practise['is_roleplay'])?$practise['is_roleplay']:0}}" 
												data-dependent="<?php echo (!empty($practise['is_dependent']) && $practise['is_dependent'] == 1)?1:0 ?>" 
												data-nextdependent="<?php  echo (!empty($nextPractises[0]['is_dependent']) && $nextPractises[0]['is_dependent'] == 1)?1:0 ?>"
												data-id="<?php echo $practise['id'];?>"
												data-islastpractise= "<?php echo (count($practises) == $i+1) ? '1':'0'; ?>"
												data-nextid="<?php echo !empty($nextPractises[0]['id'])?$nextPractises[0]['id']:"" ;?>"
												 id="abc-<?php echo $practise['id'];?>-tab" 
												//data-toggle="pill" 
												{{--href="#abc-<?php echo $practise['id'];?>"--}}
												//role="tab" 
												
												aria-controls="abc-<?php echo $practise['id'];?>" aria-selected="true">
													<?php echo $azRange[$i];?>
												</a>
											</li>
											<?php } ?>
									</ul>
								</div>
								<!-- /. abc tab-->
								<div class="heading-right">
									<ul class="list-inline">
										<li class="list-inline-item">
											<a href="javascript:void(0);" class="erase-modal"> <img src="{{ asset('public/images/icon-tab-edit.svg') }}" alt="edit" class="img-fluid"> </a>
										</li>
									</ul>
								</div>
								<div class="expand-option-practice" style="{{$style1}}">
									<ul class="list-inline">
										<li class="list-inline-item">
											<a href="javascript:void(0);" class="expand-collapse-practice"> <img src="{{ asset('public/images/ic_expand.png') }}" alt="edit" class="img-fluid rotate-expand-icon"> </a>
										</li>
									</ul>
								</div>
							</div>
							<!-- /. practice heading-->

							<div class="course-tab-content">
								<div class="tab-content" id="abc-tabContent">
									<h1><?php// echo dd($practises); ?></h1>
									<?php $isactive = ""; foreach($practises as $i=>$practise) {

										if(null == \Request::get('n')) {
											if($i == 0){
												$isactive = "active";
											}else{
												$isactive = "";
											}
										}
										
										if(!empty(request()->get('reset'))){
											if($practise['id'] == request()->get('reset')){
												unset($practise['user_answer']);
											}
										}
										//dd($practise);
									  //    $pid  =  $practise['id'];
										 // $tpe  =  $practise['markingmethod'];
										 //dd($pid);
										?>
										<div class="tab-pane fade <?php echo $isactive; ?>" id="abc-<?php echo $practise['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $practise['id'];?>-tab">
											
											@if(env("PRODUCTION_URL") == 'https://admin.englishapp.uk/api' || env("PRODUCTION_URL") == 'http://localhost/final-admin/public/api'  || env("PRODUCTION_URL") == 'https://imperialenglish.co.uk/api' )
					
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
											@include('common.all-practice-list')
										</div>
										<!-- tab 1-->
									<?php } ?>
											<!-- /. tab content-->
								</div>
							</div>
						</div>
						<?php }?>
				</div>
			</div>
		</div>
</main>
@include('practice.common.audio_record_popup')
@include('practice.common.notes_popup')
@include('practice.common.vocabulary_popup')
@include('practice.common.summary_popup')

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
    /*-webkit-animation: spin 1.5s linear infinite;
    -moz-animation: spin 1.5s linear infinite;
    animation: spin 1.5s linear infinite;*/
}


</style>
@php 
$url = \Request::fullUrl();
$url_components = parse_url($url);
$activePracticeID="";
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
@endphp
	<script type="text/javascript">
			var replace 			= "<?php //echo isset($CourseDetails)?$CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title']:""; ?>";
			// var replace = "<?php //echo $CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title'];?>";
			var newData  = replace.replace("-PRE- INTERMEDIATE","");

			var courseId = "<?php echo $courseId;?>"
		//console.log(courseId);

		var dependentPractiseIdTab = "{{request()->get('n')}}";
		if(dependentPractiseIdTab && dependentPractiseIdTab!==undefined && dependentPractiseIdTab!==null && $.trim(dependentPractiseIdTab)!=""){
			$('#abc-'+dependentPractiseIdTab+'-tab').trigger('click');
			$('#abc-'+dependentPractiseIdTab).addClass('active').addClass('show');
		}

		$(document).on('click', '.student_self_mark_cancel_btn', function(){
			// alert(('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type"))
			// 	alert("calll")
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

		// $(document).on('click', 'ul li .btn-primary', function(){

		// 	if($(this).text().toLowerCase() == "submit"){

		// 		if($('form').find('.audio-player').find('.plyr__control--pressed').attr("type") == "button"){
		// 			$('form').find('.audio-player').find('.plyr__controls__item').trigger('click');
		// 		}
		// 	}
		// });

		jQuery(document).ready(function(){
			var topicname = <?php echo json_encode($topic_name)?>;
			// $('#bred-course').text(sessionStorage.getItem("bread-course"));
			$('#bred-course').text("{{ $course_name  }}");
			// $('#bred-topic').text(sessionStorage.getItem("bread-topic"));
			// $('#bred-topic').text("{{ $topic_name  }}");
			$('#bred-topic').text(topicname);
			$(".navigation-task-sorting").on("click", function(){
				var dataTask = $(this).attr("data-task-brd");
				var dataTaskname = $(this).attr("data-task-name");
				//alert(dataTaskname);
				sessionStorage.setItem("bread-task", "");
				sessionStorage.setItem("bread-task", dataTask);
				sessionStorage.setItem("bread-taskname", dataTaskname);
				$('#bred-task').text(' > '+sessionStorage.getItem("bread-task"));
			});
			$('#bred-task').text('> Task : ' +sessionStorage.getItem("bread-task"));
			$('#bred-taskname').text(sessionStorage.getItem("bread-taskname"));
			// console.log(sessionStorage.getItem("bread-task"));
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
				//$('.reset-answer').attr('data-isroleplay', isRoleplayPractice)

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
							//if(data.success) {
								location.reload()
								// var currentActiveID = jQuery(".practice-tab.course-tab .abc-tab .nav-link.active").attr("href");
								// currentActiveID = currentActiveID.replace("#abc-","");
								// jQuery("#erasemodal .modal-footer button").first().attr("onclick","window.location='?reset="+currentActiveID+"'");
						//	}
			      }
			  });
			});
			// jQuery('#erasemodal').on('shown.bs.modal', function() {
			// 	var currentActiveID = jQuery(".practice-tab.course-tab .abc-tab .nav-link.active").attr("href");
			// 	currentActiveID = currentActiveID.replace("#abc-","");
			// 	jQuery("#erasemodal .modal-footer button").first().attr("onclick","window.location='?reset="+currentActiveID+"'");
			// });
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

	<?php if(isset($taskId) && !empty($taskId)){?>
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
				$('.practice-tab').find('.course-tab-content').find('.tab-pane:first').removeClass('show active')
				$('.practice-tab').find('.course-tab-content').find('#abc-{{$activePracticeID}}').addClass('show active')
			});

			$(document).on('click','.open-practice', function(){
				var practice_location = $(this).attr('data-href')
				window.location.href = practice_location;
			});
			$(document).on('click','.delete-popup-icon', function() {
				// alert(('.delete-recording-'+practiceid+'-'+rendomId))
				var this1 = $('.delete-recording-'+practiceid+'-'+rendomId)
				var delete_audiokey = this1.attr('data-key');
				$(this1).parent().find('.practice_audio').prop('src','');
				$(this1).parent().find('.practice_audio').find('source').prop('src','');
				$(this1).parent().find('.audioplayer-bar-played').css('width','0%');
				$(this1).hide();
				$(this1).parent().find('div.audio-element').css('pointer-events','none');
				$(this1).parent().find('.audioplayer-playpause').hide();
				$(this1).parent().find('.record-icon').css({'margin-left':'-60px'});
				var practise_id = this1.attr('data-pid');
				$.ajax({
					url: '<?php echo URL('delete-audio'); ?>',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					type: 'POST',
					data: {practice_id:practise_id},
					success: function (data) {
						// alert('.mic-icon-'+delete_audiokey)
						this1.parent().find('.mic-icon-'+delete_audiokey).show();
						this1.parent().find('#record_audio'+delete_audiokey).show();
						// alert('.deleted_audio_'+practise_id+'_'+delete_audiokey);
						$(document).find('.deleted_audio_'+practise_id+'_'+delete_audiokey).val('blank')
						$('.audio_path'+delete_audiokey).val('')
						// $(document).find('.submitBtn_'+practise_id).attr('disabled','disabled');
					}
			  });
			});

		

		$(document).ready(function(){
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
			// let blankTableBtn = '.blankTableBtn_'+"{{$practiceId}}";
			// let trueFalseSubmitBtn = '.true_false_submitBtn_'+"{{$practiceId}}";
			// let submitBtnClass = '.submitBtn';
			// let submitBtn = '.submitBtn_'+"{{$practiceId}}";
			let reviewPopDisplay   = "{{ $reviewPopup }}";

			// $(blankTableBtn+','+submitBtn+','+submitBtnClass+','+trueFalseSubmitBtn).on('click',function(){
			$('.submit_btn').on('click',function(){
				let value = $(this).val();
				let text = $(this).text();
				if(value == 'Submit' || text == 'Submit'){
					if(!reviewPopDisplay){
						$('#course-feedback-init-mid').modal("show");
					}
				}
			});

			$("#reviewModal_{{isset($practise['id'])?$practise['id']:''}}").on('click','.skip-review', function() {
				$('#course-feedback-init-mid').modal("show");
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
@endsection