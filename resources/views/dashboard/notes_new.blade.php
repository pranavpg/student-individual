@extends('layouts.app')
@section('content')
<style type="text/css">
		.overflowhide {
			display: inline-block;
			width: 180px;
			white-space: nowrap;
			overflow: hidden !important;
			text-overflow: ellipsis;
			vertical-align: top;
		}
	</style>
@include('messages')
<div class="filter d-block d-md-none">
	<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
		<span class="mobonly"><img src="{{asset('public/images/filter-options-mobile.png')}}" alt="" class="img-fluid" width="24px"></span>
	</a>
</div>
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<section class="main notes col-sm-12">
				<div class="col-12 d-flex justify-content-center p-3">
					<h1 class="pageheading">
						<span style="display: inline-flex;">
							<!-- <img src="{{ asset('public/images/icon-heading-notes.svg')}}" alt="" class="img-fluid" width="30px"> -->
							<i class="fas fa-file-alt"></i>
						</span>
						Notes
						@if(isset($_REQUEST['type']) && $_REQUEST['type']=="task")
								<a href="{{Session::get('lastTask1')}}"
									class="btn btn-primary  btn-icon">
									<img src="{{ asset('public/images/icon-button-topic.svg') }}" alt=""
									class="img-fluid">
									{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Resume Task' }}
								</a>
							@endif
					</h1>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block d-xl-none notes-selection">
							<select class="col-md-6 custom-select2-dropdown-nosearch" id="onchange_small" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;min-width: 300px;">
								@foreach($onlyCourse as $key=>$course)
								@php
								$courseTitle = str_replace(' ','-', $course['course']['coursetitle']);
								$courseTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $courseTitle);

								$levelTitle = str_replace(' ','-', $course['level']['leveltitle']);
								$levelTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $levelTitle);
								@endphp
								<option value="<?php echo $course['level_id'];?>"> <?php echo $course['course']['coursetitle'];?> - <?php echo $course['level']['leveltitle'];?></option>
								@endforeach
							</select>
						</div>
						<?php //dd(session()->get('course_id'))?>
						<div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8 d-none d-xl-block">
							<?php
							if(count($onlyCourse)>2){
								?>
								<select class="col-md-4 custom-select2-dropdown-nosearch" id="onchange_large">
									@foreach($onlyCourse as $key=>$course)
									@php
									$courseTitle = str_replace(' ','-', $course['course']['coursetitle']);
									$courseTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $courseTitle);
									$levelTitle = str_replace(' ','-', $course['level']['leveltitle']);
									$levelTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $levelTitle);
									@endphp
									<option value="<?php echo $course['level_id']?>"data-new-id1="{{$key}}" data-id="{{ $course['course']['_id'] }}" class="nav-link checkparent"   href="#pills-<?php echo $key;?>"  id="courseList-<?php echo $key;?>"aria-controls="pills-<?php echo $key;?>" aria-selected="true" @if($course['course_id'] == session()->get('course_id')) selected @endif ><?php echo $course['course']['coursetitle'];?> - <?php echo $course['level']['leveltitle'];?></option>
									@endforeach
								</select>
								<?php
							}else{
								?>
								<ul class="aes_ges_parent nav nav-pills nav-pills_switch col-12" id="pills-tab" role="tablist">
									<?php 
									$i = 0;
									foreach($onlyCourse as $key=>$course){ 
										$class= "";
										if(session()->get('course_id')){
											if($course['course_id'] == session()->get('course_id')){
												$class = "active show";
											}
										}else{
											if($i==0){
												$class= "active show";
											}
										}
										$courseTitle = str_replace(' ','-', $course['course']['coursetitle']);
										$courseTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $courseTitle);

										$levelTitle = str_replace(' ','-', $course['level']['leveltitle']);
										$levelTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $levelTitle);
										?>
										<li class="nav-item mr-3 px-0">
											<a class="nav-link {{$class}} checkparent"  data-toggle="pill"  data="{{$courseTitle}}" id="pills-{{$course['level_id']}}-tab" data-toggle="pill" href="#pills-<?php echo $key;?>"data-2="{{$levelTitle}}" data-2-id="{{$course['level']['_id']}}" data-id="{{ $course['course']['_id'] }}" data-index={{$key}} role="tab" aria-controls="pills-<?php echo $key;?>" aria-selected="true"><?php echo $course['course']['coursetitle'];?> - <?php echo $course['level']['leveltitle'];?></a>
										</li>
										<?php $i++;}?>
									</ul>
									<?php
								}
								?>
						</div>
						<div class="col-6 d-sm-none">
							<h6 id="getFirstCourseName"></h6>
						</div>
						<div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
							<div class="row">
								<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
									<div class="search-form">
										<div class="form-group mb-0">
											<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="searchbox" aria-label="Search">
											<span class="icon-search">
												<img src="https://teacher.englishapp.uk/public/teacher/images/icon-search-pink.svg" alt="Search" class="img-fluid">
											</span>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 col-xl-2">
									<div class="filter">
										<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
											<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="main__content main__content_notes main__content_summary pt-3 px-md-3 px-0">
					<div class="tab-content" id="pills-tabContent">
						<?php 
						$i = 0;
						foreach($onlyCourse as $courseId=>$course){
							$class= "";
							if(session()->get('course_id')){
								if($course['course_id'] == session()->get('course_id')){
									$class = "active show";
								}
							}else{
								if($i==0){
									$class= "active show";
								}
							}
							$courseTitle = str_replace(' ','-', $course['course']['coursetitle']);
							$courseTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $courseTitle);
							?>
							<div class="tab-pane fade newclass {{$class}}" id="pills-<?php echo $course['level_id'];?>"  role="tabpanel" aria-labelledby="pills-<?php echo $courseId;?>-tab">
								<div class="table-responsive p-3 p-md-0 hide-table">
									<?php// dd($notes);?>
									<table id="notes-table-{{$course['level_id']}}" class="table work-record__table ieuktable-sline">
										<thead class="thead-dark">
											<tr>
												<th scope="col">Title</th>
												<th scope="col">Topic</th>
												<th scope="col">Task</th>
												<th scope="col">Skill</th>
												<th scope="col">Description</th>
												<th scope="col" class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$k = 0; 
											// dd($notes);
											foreach(collect($notes)->where('level_id',$course['level_id'])->all() as $note){
												$topic = str_replace(' ','-', $note['topic']['topicname']);
												$topic_id = $note['topic']['_id'];
												$task_id = $note['task']['_id'];
												$topic = preg_replace('/[^A-Za-z0-9\-]/', '', $topic);

												$task = str_replace(' ','-', $note['task']['taskname']);
												$task = preg_replace('/[^A-Za-z0-9\-]/', '', $task);
												$skills = "";
												if(isset($note['skill']['skilltitle'])){
													$skills = str_replace(' ','-', $note['skill']['skilltitle']);
													$skills = preg_replace('/[^A-Za-z0-9\-]/', '', $skills);
												}
												?>
												<tr class="{{$topic}} {{$task}} {{$skills}} hideall newids" data-topic-id="{{$topic_id}}" data-task-id="{{$task_id}}">
													<td class="td-half"><span  title="Title"></span><?php echo $note['notetitle'];?></td>
													<td class="td-half"><span  title="Topic"></span><?php echo $note['topic']['topicname']?></td>
													<td class="td-half"><span  title="Task"></span><?php echo $note['task']['taskname'];?></td>
													<td class="td-half"><span  title="Skill"></span><?php echo $note['skill']['skilltitle'];?>
												</td>
												<td class="td-full" title="<?php echo $note['notedescription'];?>" class="dtext-ellipsis"><span  title="Description"></span><?php echo $note['notedescription'];?></td>
												<td class="text-center mwidth-120">
													<img src="{{ asset('public/images/icon-small-eye.png')}}" alt="" class="img-fluid openmodel" style="margin: 0px 5px;cursor: pointer;width:26px;"  data="<?php echo $note['notedescription'];?>" data-title="<?php echo $note['notetitle'];?>" data-topic="<?php echo $note['topic']['topicname'];?>" data-task="<?php echo $note['task']['taskname'];?>" data-skill="{{ $note['skill']['skilltitle'] ??''}}">
													<a href="#" class="img-fluid" data-toggle="modal" data-target="#exampleModal" onclick="openModelexampleModal('{{$note['_id']}}')" style="margin: 0px 5px;">
														<img src="{{ asset('public/images/icon-table-edit.png')}}" alt="" class="img-fluid" width="21px">
													</a>
													<!-- <a href="{{ URL('notes')}}?delete_note=<?php //echo $note['_id'];?>" class="card-delete" style="margin: 0px 5px;" onclick="return confirm('Are you sure you want to delete this note?')">
														<img src="{{ asset('public/images/icon-trash.png')}}" alt="" class="img-fluid" width="21px">
													</a> -->
													<a href="javascript:void(0);" title="Delete" class="action-button open-delete-note-log-modal delete_note_log_{{$note['_id']}}" data-note_id="{{$note['_id']}}">
														<img src="{{ asset('public/images/icon-trash.png') }}" alt="Edit" class="img-fluid" width="21px">
													</a>
												</td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>    
						    <div class="w-100 norecorddata">
					            <div class="main__content" id="dat1-{{$course['level_id']}}" style="display: none;">
					              <div class="row text-center">
					                 <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					                     <img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
					                     <p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
					                  </div>
					              </div>
					            </div>
					        </div>
						</div>
						<?php $i++; } ?>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">                 
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<i class="fas fa-file-alt"></i> <span id="course_name">GES</span> NOTE
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="my_form" action="" method="post">
				<input type="hidden" name="course_id" id="course_id" value="" />
				<input type="hidden" name="level_id" id="level_id" value="" />
				<div class="modal-body">
					<input type="hidden" name="note_id" id="note_id" value="" >
					<div class="row mb-4">                   
						<div class="form-group mb-2 col-sm-4">
							<select id="topic_id" name="topic_id" class="form-control s1">
								<option value="">Please Select Topic</option>
							</select>
						</div>                        
						<div class="form-group mb-2 col-sm-4">
							<select id="task_id" name="task_id" class="form-control">
								<option value="">Please Select Task</option>
							</select>
						</div>

						<div class="form-group mb-2 col-sm-4">
							<select id="skill_id" name="skill_id" class="form-control">
								<option value="">Please Select Skill</option>
							</select>
						</div>
					</div>
					<h6>Title</h6>
					<div class="form-group">
						<textarea type="text" id="title" name="title" class="form-control form-control_underline" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
					</div>

					<h6>Description</h6>
					<div class="form-group">
						<textarea name="description" id="description" name="description" class="form-control form-control_underline" value="" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
					</div>
					<div class="form-group form-group__verification_error" id="error_message" style="display:none;">
						<em class="d-flex">
							<span class="error-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span>
							<span class="error-text"></span>
						</em>
					</div>
					<div class="form-group form-group__verification_success" id="success_message" style="display:none;">
						<em class="d-flex">
							<span class="success-img">
								<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
							</span>
							<span class="success-text"></span>
						</em>
					</div>
				</div>
				<div class="modal-footer justify-content-center">
					<button type="submit" class="btn btn-primary mr-3" id="save_btn">
						<i class="fa-regular fa-floppy-disk"></i> Save</button>
					<button type="button" class="btn btn-cancel" data-dismiss="modal" id="reset">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="description-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Note</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6 mb-3">
						<h6>Title</h6>
						<h5 class="title-append"></h5>
					</div>
					<div class="col-md-6 mb-3">
						<h6>Topic</h6>
						<h5 class="topic-append"></h5>
					</div>
					<div class="col-md-6 mb-3">
						<h6>Task</h6>
						<h5 class="topic-task"></h5>
					</div>
					<div class="col-md-6 mb-3">
						<h6>Skill</h6>
						<h5 class="topic-skill"></h5>
					</div>
					<div class="col-md-12">
						<h6 class="w-100">Description</h6>
						<h5 class="appenddesc h-100"></h5>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- delete modal -->
<div class="modal fade" id="deleteModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title">Delete Records</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body text-center m-5">
				<p>Are you sure you want to delete ?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<form id="deleteClassLogForm">
					<input type="hidden" name="id" class="note_id" >
					<input type="hidden" name="delete_note" class="note_id">
					<button type="button" class="btn btn-primary mr-3 delete-note-log-record">Yes</button>
					<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button>
				</form>
				<!-- <button type="button" class="btn btn-primary yesbutton">Yes</button>
				<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button> -->
			</div>
		</div>
  	</div>
</div>
<!-- instruction popup -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
				<button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<div id="datas"></div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" id="closemodel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end instruction video -->
<aside class="filter-sidebar">
	<div class="heading d-flex flex-wrap justify-content-between">
		<h5><i class="fa fa-filter"></i> Filter</h5>
		<a href="javascript:void(0);" class="close-filter">
			<img src="{{asset('public/images/icon-close-filter-white.svg')}}" alt="" class="img-fluid" width="15px" style="margin-top: -2px;">
		</a>
	</div>
	<div class="filter-body">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partA">
				<span class="sidefilter-heading">Select Course</span>
				<select class="col-md-6 custom-select2-dropdown-nosearch mb-3"  id="onchange_filter" style="min-width: 300px;">
					@foreach($onlyCourse as $key=>$course)
					@php
					$courseTitle = str_replace(' ','-', $course['course']['coursetitle']);
					$courseTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $courseTitle);

					$levelTitle = str_replace(' ','-', $course['level']['leveltitle']);
					$levelTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $levelTitle);
					@endphp
					<option value="<?php echo $course['level_id']?>" data-course-id="{{$course['course']['_id']}}"data-new-id="{{$key}}" @if($course['course_id'] == session()->get('course_id')) selected @endif><?php echo $course['course']['coursetitle'];?> - <?php echo $course['level']['leveltitle'];?></option>

					<label class="custom-control-label" id="sp-{{$courseId}}" for="r_button-{{$courseId}}">{{$course['course']['coursetitle']}} - {{$course['level']['leveltitle']}}</label>
					@endforeach
				</select>
				<div class="mt-3">
					<span class="sidefilter-heading">Select Topic</span>
					<select class="col-md-6 custom-select2-dropdown-nosearch" id="topic_name_jo" style="min-width: 300px;">
						<option>select Topic</option>
					</select>
				</div>
				<div class="mt-3 mb-3">
					<span class="sidefilter-heading">Select Task</span>
					<select class="col-md-6 custom-select2-dropdown-nosearch" id="task_name_jo" style="min-width: 300px;">
						<option>select Task</option>
					</select>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-0 partB">
				<div class="filter-action-buttons">
					<a href="javascript:void(0)" class="btn btn-classic" data-toggle="modal" data-target="#editNoteModal" onclick="openModelexampleModal(0)">
						<i class="fa fa-plus" aria-hidden="true"></i> Add Note
					</a>
					<?php if(!empty($notes)) { ?>
						<form method="post" action="{{ route('notes.downloadnotes_pdf') }}">
							@csrf
							<input type="hidden" name="course_id" id="pdf_course_id" value="">
							<input type="hidden" name="level_id" id="pdf_level_id" value="">
							<input type="hidden" name="topic_id" id="pdf_topic_id" value="">
							<input type="hidden" name="task_id" id="pdf_task_id" value="">
							<input type="hidden" name="skill_id" id="pdf_skill_id" value="">
							<input type="hidden" name="search" id="pdf_search" value="">
							<button type="submit" class="btn btn-classic"><i class="fas fa-download"></i> Download</button>
						</form>
					<?php } else { ?>
						<a href="javascript:void(0)" class="btn btn-classic" id="nodownload"><i class="fas fa-download"></i> Download</a>
					<?php } ?>
				</div>
			</div>
			<?php //dd($instration['getvideo']);?>
			<!-- instrution -->
			@if(empty($instration['getdocument'] OR $instration['getvideo']))
			@else
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
				<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
				<div class="info-details">
					@foreach($instration['getdocument'] as $ins_doc)
					<div class="link1">
						<span><a href="#" id="openmodal" data-id="{{$ins_doc['document_url']}}"><i class="fa fa-file-alt"></i> Click to read</a> <span>{{$ins_doc['document_name']}}</span></span>
					</div>
					@endforeach
					@foreach($instration['getvideo'] as $ins_video)
					<div class="link1">
						<span><a href="#" id="openmodal_forvideo" data-id="{{$ins_video['video_url']}}"><i class="fa fa-file-alt"></i> Click to watch</a> <span>{{$ins_video['video_name']}}</span></span>
					</div>
					@endforeach
				</div>
			</div>
			@endif
			<!-- end -->
		</div>
	</div>

</aside>
<script type="text/javascript">

		function textAreaAdjust(element) {
			element.style.height = "1px";
			element.style.height = (25+element.scrollHeight)+"px";
		}
		var topicArray          = [];
		var taskArray           = [];
		var skillArray          = [];
		var searachArrayNew     = [];
		var regexReplace        = /([,.€!?'&:])+/g;
		var data                =  <?php echo json_encode($onlyCourse); ?>;
		var skillsdata          =  <?php echo json_encode($skillsdata); ?>;
		var notes =  <?php echo json_encode($notes); ?>;
		
		    var table = "";
        $(document).ready(function(){
        	topicfilter();
        	document.getElementById("searchbox").addEventListener("search", function(event) {
        		var value = '';
        		$('#pdf_search').val(value);
        		$(".table tbody tr").filter(function() {
        			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        		});
        	});
        	$(document).on('change',"input[name='task-stacked']",function(){
        		taskArray = [];
        		taskArray.push("."+$(this).val());
        		let taskId = $(this).data('id');
        		$('#pdf_task_id').val(taskId);
        		if($(this).val() == "all"){
        			$('#pdf_task_id').val('');
        			taskArray = [];
        		}
        		let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
        		let skills = data[index].skills
        		let options = '';
        		skills.forEach(function(skill,index){
        			let skill_data = skill.skilltitle.replaceAll(' ','-');
        			skill_data = skill_data.replaceAll(regexReplace,'');
        			options += '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="skill_'+skill._id+'" name="skill-stacked" value="'+skill_data+'" data-id="'+skill._id+'"><label class="custom-control-label" for="skill_'+skill._id+'">'+skill.skilltitle+'</label></div>';
        		});
        		$('#skill-filter').html("");
        		$('#skill-filter').html(options);
        		filterRecord()
        	});
        	$(document).on('change',"input[name='skill-stacked']",function(){
        		skillArray = [];
        		skillArray.push("."+$(this).val());
        		let skillId = $(this).data('id');
        		$('#pdf_skill_id').val(skillId);
        		if($(this).val() == "all"){
        			$('#pdf_skill_id').val('');
        			skillArray = [];
        		}
        		filterRecord()
        	});
        });

        $('.openmodel').click(function(){
        	var datatitle = $(this).attr("data-title")
        	var dataTopic   = $(this).attr("data-topic");
        	var dataTask    = $(this).attr("data-task");
        	var dataSkill   = $(this).attr("data-skill");
        	$('#description-model .appenddesc').text($(this).attr("data"));
        	$('#description-model .title-append').text(datatitle);
        	$('#description-model .topic-append').text(dataTopic);
        	$('#description-model .topic-task').text(dataTask);
        	$('#description-model .topic-skill').text(dataSkill);
        	$('#description-model').modal("show");
        });
        function topicfilter(){
        	let options = '<option value="all" style="">Select topic</option>';
        	let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
		    	if(typeof index == 'undefined'){
						index = window.data_ids; 
					}
        	var levalid =  data[index].level._id;
        	notes.forEach(function(notes,index){
        		if(notes.level_id == levalid){
        			options += '<option value="'+notes.topic['_id']+'" style="">'+notes.topic['topicname']+'</option>';
        		}
        	});
        	$('#topic_name_jo').html(options);
        }

       	$( "#topic_name_jo" ).change(function() {
				  var topicid = $(this).val();
				  let options1 = '<option value="all" style="">Select task</option>';
				  notes.forEach(function(notes,index){
				  	if(notes.topic._id == topicid){
        			options1 += '<option value="'+notes.task['_id']+'" style="">'+notes.task['taskname']+'</option>';
				  	}
        	});
        	$('#task_name_jo').html(options1);

				});

        function resetSkill(){
        	let options = '<option value="" style="">Please Select Skill</option>';
        	$('#skill_id').html(options);
        }

        function resetTask(){
        	let options = '<option value="" style="">Please Select Task</option>';
        	$('#task_id').html(options);
        }

        function resettitle(){
        	$('#title').val('');
        }
        function resetdec(){
        	$('#description').val('');
        }
        function topicdata(){
			    	let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
			    	if(typeof index == 'undefined'){
							index = window.data_ids; 
						}
			    	let courseName = data[index].course.coursetitle;
			    	$('#course_name').text(courseName);
			    }

        function resetTopic(){
        	let options = '<option value="" style="">Please Select Topic</option>';
        	$('#topic_id').html(options);
        }

        function setOptions(){
          let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
        	if(typeof index == 'undefined'){
						index = window.data_ids; 
					}
		    	let courseId_new = data[index].course._id;
					let level_id = data[index].level._id;
			      $.ajax({
			          url: "{{url('/get_topic_task')}}",
			          type: "POST",
			          data: {
			              // courseId_new: courseId_new,
			              level_id:level_id,
			              _token: '{{csrf_token()}}'
			          },
			          dataType: 'json',
			          success: function(result) {
			              $('#topic_id').html('<option value="">Select topic</option>');
			              $.each(result.data, function(key, value) {
			                  $("#topic_id").append('<option value="' + value._id + '" data-courseid="'+courseId_new+'">Topic '+value.sorting+' : '+value.topicname+'</option>');
			              });
			          }
			      });
			  	$('#topic_id').html("");
        }
        function openModelexampleModal(id){
					if(id == 0){
						$('#save_btn').html('<i class="fa-regular fa-floppy-disk"></i> Save');
					}
					else{
						$('#save_btn').html('<i class="fa-regular fa-floppy-disk"></i> Update');
					}
        	$('.invalid-feedback').text('');
        	$('.form-control').removeClass('invalid-feedback');
        	resetSkill();
        	resetTask();
        	resetTopic();
        	resettitle();
        	resetdec();
        	setOptions();
        	if(id != 0){
        		let note = notes.find(note => note._id == id);
        		setTimeout(() => {
	        		$('#topic_id').val(note.topicid);
		        	$('#topic_id').trigger('change');
        		}, 500);
        		setTimeout(() => {
	        		$('#task_id').val(note.taskid);
    				$('#task_id').trigger('change');
					$('#skill_id').val(note.skillid);
	        		$('#title').val(note.notetitle);
	        		$('#description').val(note.notedescription);
	        		$('#note_id').val(id);
        		}, 800);
        	}else{
        		$('#note_id').val("");
        	}
        	$('#exampleModal').modal("show");
        }

        $('#topic_id').on('change',function(){
        	resetTask();
        	resetSkill();
        	var topic_id = $(this).val();
        	let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
        	if(typeof index == 'undefined'){
						index = window.data_ids; 
					}
					let courseId_new = data[index].course._id;
					$.ajax({
				      url: "{{url('/get_task')}}",
				      type: "POST",
				      data: {
				          topic_id: topic_id,
				          _token: '{{csrf_token()}}'
				      },
				      dataType: 'json',
				      beforeSend: function () {
						$(".page-loader-wrapper").show();
					},
					complete: function () {
						$(".page-loader-wrapper").hide();
					},
		      success: function(result) {
		          $('#task_id').html('<option value="">Select Task</option>');
		          $.each(result.data, function(key, value) {
		              $("#task_id").append('<option value="' + value._id + '" >'+value.taskname+'</option>');
		          });
		      }
				});
      });

        $('#task_id').on('change',function(){
        	let options = '<option value="" style="">Please Select Skill</option>';
        	skillsdata.forEach(function(skill,index){
        		options += '<option value="'+skill._id+'" style="">'+skill.skilltitle+'</option>';
        	});
        	resetSkill();
        	$('#skill_id').html(options);
        });
        $("#my_form").validate({
        	rules: {
        		title: {
        			required: !0,
        		},
        		description: {
        			required: !0,
        		},
        		topic_id: {
        			required: !0,
        		},
        		task_id: {
        			required: !0,
        		},
        		skill_id:{
        			required: !0,
        		}          
        	},
        	messages: {
        		title: "Please add note title!",  
        		description: "Please add note descriptions!", 
        		topic_id: "Please select topic!",  
        		task_id: "Please select task!",  
        		skill_id:"Please select skill!"
        	},
        	errorElement: "div",
        	errorClass: "invalid-feedback",
        	submitHandler: function(form) {
        		let index = $("#pills-tab li.nav-item .nav-link.active").data("index");
        		if(typeof index == 'undefined'){
								index = window.data_ids; 
						}
        		let courseId = data[index].course._id;
        		let LevelId = data[index].level._id;
        		$("<input />").attr("type", "hidden")
        		.attr("name", "course_id")
        		.attr("value",courseId)
        		.appendTo("#my_form");
        		$("<input />").attr("type", "hidden")
        		.attr("name", "level_id")
        		.attr("value",LevelId)
        		.appendTo("#my_form");

        		$("#my_form").find("input[type='submit']").prop("disabled",true);
        		$("#my_form").find("input[type='submit']").attr("value","Submitting...");
        		$("#my_form").find("button[type='submit']").prop("disabled",true);
        		$("#my_form").find("button[type='submit']").text("Submitting...");
        		$.ajaxSetup({
        			headers: {
        				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        			}
        		});
        		$.ajax({
        			type: "POST",
        			url: '{{ URL("note_post") }}',
        			data : $("#my_form").serialize(),
        			dataType: "json",
        			beforeSend: function () {
								$(".page-loader-wrapper").show();
							},
							complete: function () {
								$(".page-loader-wrapper").hide();
							},
        			success: function(res) {
        				if(!res.success){
        					$("#error_message .error-text").text(res.message);
        					$("#error_message").show();
        					$("#success_message").hide();
        					$("#my_form").find("input[type='submit']").prop("disabled",false);
        					$("#my_form").find("input[type='submit']").attr("value","Save");
        					$("#my_form").find("button[type='submit']").prop("disabled",false);
        					$("#my_form").find("button[type='submit']").text("Sign In");
        				}else{
        					$("#success_message .success-text").text(res.message);
        					$("#error_message").show();
        					$("#error_message").hide();
        					setTimeout(function(){
        						window.location.reload();
        					},1000);
        				}
        			}
        		});
        		return false;                               
        	}
        })
        $(".close-filter").click(function () {
        	$(".filter-sidebar").toggleClass("openclose");
        });
        $('#nodownload').click(function(){
        	alert("You don't have any notes to download.");
        	function goBack() { window.history.back(); }
        });
        $('#searchbox').keyup(function(){
				  var get_id = $(".checkparent.active").attr('data-2-id');
				  if(typeof get_id == 'undefined'){
				     get_id = $("#onchange_large").val();
				  }
				  // alert(get_id);
				  var tabnew = table1[get_id];
				  tabnew.search($(this).val()).draw();
				});
</script>


<script>
	  window.data_ids = $('#onchange_large').find(':selected').attr('data-new-id1');
  	$(document).on('click','.open-delete-note-log-modal', function(){
  		var note_id = $(this).attr('data-note_id');
  		$('#deleteClassLogForm').find('.note_id').val(note_id);
  		$('#deleteModal').modal('toggle');
  	});
  	$(document).on('click','.delete-note-log-record', function(){
  		var $this = $(this);
  		var note_id = $('#deleteClassLogForm').find('.note_id').val()
  		$.ajax({
  			url: "{{url('notes_new_dev')}}",
  			headers: {
  				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			},
  			type: 'get',
  			data: $('#deleteClassLogForm').serialize(),
  			success: function(data) {
  				if(!data.success){
					$("#error_message .error-text").text(data.message);
					$("#error_message").show();
					$("#success_message").hide();
					$("#my_form").find("input[type='submit']").prop("disabled",false);
					$("#my_form").find("input[type='submit']").attr("value","Save");
					$("#my_form").find("button[type='submit']").prop("disabled",false);
					$("#my_form").find("button[type='submit']").text("Sign In");
				}else{
					$("#success_message .success-text").text(data.message);
					$("#error_message").show();
					$("#error_message").hide();
					setTimeout(function(){
						window.location.reload();
					},1000);
				}
  			}
  		});

  	});
</script>


<script>
	$(document).ready(function() {
	   topicdata();
	});
	function resetTask_new(){
    	let options = '<option value="" style="">Please Select Task</option>';
    	$('#task_name_jo').html(options);
    }
</script>
<script>
$("#topic_name_jo").change(function() {
	var currentVal = $(this).val();
	var row = $('.newids');
	row.hide()
	if($(this).val() == 'all'){
		console.log('asdasd');
		$('.newids').show();
	}
	row.each(function(i, el) {
		if($(el).attr('data-topic-id') == currentVal) {
			$(el).show();
		}
	})
});
$("#task_name_jo").change(function() {
	var currentVal = $(this).val();
	var row = $('.newids');
	//console.log(row)
	row.hide()
	if($(this).val() == 'all'){
		$('.newids').show();
	}
	row.each(function(i, el) {
		if($(el).attr('data-task-id') == currentVal) {
			$(el).show();
		}
	})
});
</script>

<script>
  	$(document).on('click',"#openmodal",function(){
  		var url = $(this).attr("data-id");
		// PDFObject.embed('https://s3.amazonaws.com/imperialenglish.co.uk/'+url, "#datas",{height: "60rem"});
		const app_url = '{{ env('S3URL') }}';
		PDFObject.embed(app_url+url, "#datas",{height: "60rem"});
		$('#myModal').modal("show")
	});
	$(document).on('click',"#openmodal_forvideo",function(){
  		var url = $(this).attr("data-id");
  		var url2 = $(this).attr("data-id2");
  		var url_update = 'https://www.youtube.com/embed/'+url2+'';
  		$("#datas").show().html('<iframe width="653" height="345" src="'+url_update+'"></iframe>');
		$('#myModal').modal("show")
	});
</script>

<script>
	var table1 = [];
	$(document).ready(function() {
	    var p = '';
	    var course_list  =   <?php echo json_encode($onlyCourse);?>;
      course_list.forEach(function(course,index){
      table1[course.level_id] = $('#notes-table-'+course.level_id).DataTable({
			"aaSorting": [],
			"paging":true,
			"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
			    if (aiDisplay.length > 0) {
						$("#dat1-"+course.level_id).hide();
						$(".datatable-footer").show();
			    }else{
			        $("#dat1-"+course.level_id).show();	
			        $(".datatable-footer").hide();
			    }
				}
			});
	  });
	});
	$(document).on('change',"#onchange_large",function(){
		let open_button_id = $(this).find(':selected').attr('data-new-id1');
		window.data_ids = open_button_id;
		var current_val = $("#onchange_large").val();
		var download_course_id = $(this).find(':selected').attr('data-id');
		$('#pdf_course_id').val(download_course_id);
	 	$('#pdf_level_id').val(current_val);
	  var get_rec     = $("#onchange_large option[value='"+current_val+"']" ).text();
		$( "#onchange_small option[value='"+current_val+"']" ).prop('selected', true);
		var test_id1  =  $('.checkparent.active').attr('data-2-id');
		$(".checkparent").removeClass('active');
		$(".newclass").removeClass('active show');
		$("#pills-"+current_val).addClass('active show');
		$("#pills-"+current_val+"-tab").addClass('active');
	  $("#select2-onchange_small-container").text(get_rec);
		$("#notes-table-"+test_id1).hide();
		$("#notes-table-"+current_val).show();
	  var get_rec     = $( "#onchange_filter option[value='"+current_val+"']" ).text();
		$("#onchange_filter option[value='"+current_val+"']" ).prop('selected', true);
    $("#select2-onchange_filter-container").text(get_rec);
    topicdata();
    resetTask_new();
    topicfilter();
	});

	$(document).on('change',"#onchange_filter",function(){
		let open_button_id = $(this).find(':selected').attr('data-new-id');
		window.data_ids = open_button_id;
		var current_val = $("#onchange_filter").val();
		var download_course_id = $(this).find(':selected').attr('data-course-id');
		$('#pdf_course_id').val(download_course_id);
	 	$('#pdf_level_id').val(current_val);
	  var get_rec     = $("#onchange_filter option[value='"+current_val+"']" ).text();
		$( "#onchange_small option[value='"+current_val+"']" ).prop('selected', true);
		var test_id1  =  $('.checkparent.active').attr('data-2-id');
		$(".checkparent").removeClass('active');
		$(".newclass").removeClass('active show');
		$("#pills-"+current_val).addClass('active show');
		$("#pills-"+current_val+"-tab").addClass('active');
	  $("#select2-onchange_small-container").text(get_rec);
		$("#notes-table-"+test_id1).hide();
		$("#notes-table-"+current_val).show();
	  var get_rec     = $( "#onchange_large option[value='"+current_val+"']" ).text();
		$("#onchange_large option[value='"+current_val+"']" ).prop('selected', true);
    $("#select2-onchange_large-container").text(get_rec);
    topicdata();
    resetTask_new();
    topicfilter();
	});

</script>
<script>
	$(document).ready(function() {
	    var download_course_id = $('#onchange_large').find(':selected').attr('data-id');
	   	$('#pdf_course_id').val(download_course_id);
	   	var leval_id = $('#onchange_large').find(':selected').val();
	   	$('#pdf_level_id').val(leval_id);
	});
</script>
@endsection
