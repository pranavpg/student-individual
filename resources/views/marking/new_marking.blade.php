@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">
	
  <link rel="stylesheet" href="https://teacher.englishapp.uk/public/css/all.min.css?v=91202" />
	<link href="https://teacher.englishapp.uk/public/css/_style.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/css/student-style.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/css/developer.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/student/css/custom.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/css/custom.css?v=91202" rel="stylesheet">
	<script src="https://teacher.englishapp.uk/public/js/jquery-3.5.1.min.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/js/bootstrap.min.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/js/popper.min.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/teacher/js/owl.carousel.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/teacher/js/general.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/js/owl.carousel.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/js/jquery.validate.min.js?v=91202"></script>
	<script src="https://teacher.englishapp.uk/public/js/additional-methods.min.js?v=91202 "></script>
	<script src="https://teacher.englishapp.uk/public/js/audioplayer.js?v=91202"></script>
	<link href="https://teacher.englishapp.uk/public/css/audioplayer.css?v=91202" rel="stylesheet">
	<script src="https://teacher.englishapp.uk/public/teacher/js/pdf-popup.js?v=91202"></script>
	<link href="https://teacher.englishapp.uk/public/css/jquery-ui.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/css/bootstrap-clockpicker.min.css?v=91202" rel="stylesheet">
	<script src="https://teacher.englishapp.uk/public/js/select2.js?v=91202"></script>
	<link href="https://teacher.englishapp.uk/public/css/select2.min.css?v=91202" rel="stylesheet">
	<link href="https://teacher.englishapp.uk/public/css/dropdown.css?v=91202" rel="stylesheet" />
	<link href="https://teacher.englishapp.uk/public/css/d-scrollbar.css?v=91202" rel="stylesheet">
	<script src="https://teacher.englishapp.uk/public/js/d-scrollbar/jquery.scrollbar.js?v=91202"></script>
	<link rel="stylesheet" href="https://teacher.englishapp.uk/public/css/font-awesome-6.1.1.css?v=91202">
	<link rel="stylesheet" href="https://teacher.englishapp.uk/public/css/dataTables.bootstrap5.min.css?v=91202">
	<script type="text/javascript" src="https://teacher.englishapp.uk/public/js/jquery.dataTables.min.js?v=91202"></script>
	<script type="text/javascript" src="https://teacher.englishapp.uk/public/js/dataTables.bootstrap5.min.js?v=91202"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.js"></script>

  <link rel="stylesheet" href="https://teacher.englishapp.uk/public/css/1.13.1-jquery-ui.css?v=91202">

  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
  <link href="https://teacher.englishapp.uk/public/css/responsive1.css?v=91202" rel="stylesheet"> 
  <link href="https://teacher.englishapp.uk/public/css/responsive2.css?v=91202" rel="stylesheet">
@section('content')
@include('common.sidebar')
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css">

<div class="filter d-block d-md-none">
	<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
		<span class="mobonly"><img src="{{asset('public/images/filter-options-mobile.png')}}" alt="" class="img-fluid" width="24px"></span>
	</a>
</div>
<input type="hidden" name="teacher_new_id"  id="teacher_new_id" value="{{ $teacher_id }}">
<main class="main">
	<div class="container-fluid">
		<div class="alert alert-success mt-3" role="alert" style="display:none"></div>
		<div class="alert alert-danger mt-3" role="alert" style="display:none"></div>
		<div class="row">
			<div class="main__content d-sm-flex flex-wrap align-items-center w-100 pb-3 pt-3">
				<div class="col-12 d-flex flex-column flex-sm-row justify-content-center justify-content-md-between align-items-center mb-3">
					<h1 class="pageheading mr-1 mb-0">
						<span>
							<img src="{{asset('public/images/icon-marking-logo.png')}}" alt="" class="img-fluid" style="margin-bottom: 9px;" width="27px">
						</span>
						Marking
					</h1>
					<div class="filter">
						<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn d-none d-md-inline-block">
							<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
						</a>
					</div>
				</div>
				<div class="col-xl-12 d-none d-sm-flex justify-content-between">
					<div class="col-12 col-sm-8 col-md-8 d-flex justify-content-end pr-0">
						<ul class="list-inline marking-button float-left mb-0">
							<li class="list-inline-item"><a href="javascript:void(0);" class="findOne btn btn-danger pending-tab" style="width:90px;">Pending</a></li>
							<li class="list-inline-item"><a href="javascript:void(0);" class="findOne btn btn-light extra-tab" style="width:91px;">Extra</a></li>
							<li class="list-inline-item"><a href="javascript:void(0)" class="findOne btn btn-light work-tab">Work Record</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="main__content pt-0 mb-5">
				<div class="col-xl-12 marking-data-table">
					<div class="row">
						<div class="col-12 col-md-6 text-right" style="display: none;">
							<button type="submit" class="btn btn-primary">Add Ma'rking</button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table datatable_draw mt-2 ieuktable-sline newdata new-marking-table" style="width:100%;">
							<thead class="thead-dark">
								<tr>
									<th scope="col">Student ID</th>
									<th scope="col">Student Name</th>
									<th scope="col">Course</th>
									<th scope="col">Level</th>
									<th scope="col">Topic</th>
									<th scope="col">Task</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		<aside class="filter-sidebar">
			<div class="heading d-flex flex-wrap justify-content-between">
				<h5><i class="fa fa-filter"></i> Filter</h5>
				<a href="javascript:void(0);" class="close-filter">
					<img src="{{asset('public/images/icon-close-filter-white.svg')}}" alt="" class="img-fluid" style="margin-top: -2px;width: 15px;">
				</a>
			</div>
			<div class="filter-body">
				<div class="row">
						<div class="student-dropdown mb-3">
							<span class="sidefilter-heading">Marking Type</span>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-light sidebar-filter" checked="true" id="topic_1" name="topic-stacked" data="Pending" value="a">
								<label class="custom-control-label" for="topic_1">Pending</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-light sidebar-filter" id="topic_2" name="topic-stacked" data="Extra" value="b">
								<label class="custom-control-label" for="topic_2">Extra</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-danger sidebar-filter" id="topic_3" name="topic-stacked" data="Work Record" value="b">
								<label class="custom-control-label" for="topic_3">Work Record</label>
							</div>
						</div>
						<br>
						<div class="student-dropdown mb-3" id="pendingTaskParent" style="display: none;">
							<span class="sidefilter-heading">Marking Type</span>
							<div class="custom-control custom-radio" style="padding: 0;">
								<select id="pendingTask" class="form-control">
									<option value="">Select Type</option>
									<option value="manual">Teacher Mark</option>
									<option value="student_self_marking">Class Marks</option>
									<option value="automated">Auto Mark</option>
									<option value="self">Self Mark</option>
									<option value="read_only">Participation Mark</option>
									<option value="no_marking">No Mark</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partB">
						<div class="search">
							<form class="pending-marking-search" data-bind="with:$root.SearchModel" action="javascript:;">
								<span class="sidefilter-heading">Search</span>
								<div class="row">
									<div class="col-12 mb-3">
										<select class=" form-control " id="course_select">	
												<option value="">Select Course</option>
											@foreach($studentsData['academyCourseIds'] as $key => $value)
												<option value="{{ $value['course']['_id'] }}">{{$value['course']['coursetitle']}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-12 mb-3">
										<select class="form-control" id="level">
											<option value="">Select Level</option>
										</select>
									</div>
									<div class="col-12 mb-3">
										<select class="form-control" id="topic">
											<option value="">Select Topic</option>
										</select>
									</div>
									<div class="col-12 mb-3">
										<select class="form-control" id="task">
											<option value="">Select Task</option>
										</select>
									</div>
									<div class="col-12 mb-3">
										<select class="form-control" id="practise">
											<option value="">Select Practise</option>
										</select>
									</div>
									<div class="col-12 text-center">
										<button type="submit" class="btn btn-primary submitFilter" >Submit</button>
										<button class="btn btn-light ml-1 clearFilter" style="width:74.2px;">Clear</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
						<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
						<div class="info-details" style="display: none;">
							<div class="link1">
								<span><a href="https://s3.amazonaws.com/imperialenglish.co.uk/static_file/Marking.pdf" target="_black"><i class="fa fa-file-alt"></i> Click to read</a> more information</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
	</div>
</main>

<div class="modal fade" id="submitModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">IEUK Student App</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_video">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="row">
          <div class="col-12">
            <p class="content-body"> Submit </p>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-cancel" data-dismiss="modal" id="close_video">Close</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
	#studentlist{
		display: inline-flex;
		list-style-type: none;
		cursor: pointer;
	}
	#studentlist li{
		border: solid 1px red;
	    border-radius: 10px;
	    padding-left: 9px;
	}

</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.6/jquery.jgrowl.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.6/jquery.jgrowl.js"></script>
<script type="text/javascript">
$(function() {
	/*$.jGrowl("<div class='test'><span class='test2'></span>Hello World</div>", { 
	  	position: 'top-right',
	  	 theme:  'default',
	   	life: 3000
	});*/
});
</script>

<script type="text/javascript">
	window.taskId 		= "";
	window.practiseId 	= "";
	window.courseId 	= "";
	window.topicId 		= "";
	window.StudetnId 	= "";
	window.levelId 		= "";
	window.type 		= 1;
	window.findParent 	= 1;
	window.typeofMarking= 1;
	window.table 		= "";
	$(document).on('click','.score',function() {
		window.findParent = $(this).attr('data');
		getData($(this).attr('data'));
	});
	$(document).on('click','.submit',function() { //submit
		var mark 		= parseInt($('.mark').val());
		var orignal 	= parseInt($('.orignal_mark').attr("data"));
		if(mark > orignal){
			alert("Not allow score more then currnt mark");
			return false;
		}
		window.findParent1 = window.typeofMarking == 1?3:window.findParent;

		var student_id 			= $(this).closest("tr").prev().find("#std_id").val();
		var practise_id 		= $(this).closest("tr").prev().find("#pra_id").val();
		var student_practise_id	= $(this).closest("tr").find("#"+$(this).closest("tr").find(".findactive.active").attr("data")+" .student_practise_id").val();
		
		var markingmethod		= $(this).closest("tr").find("#markingmethod").val();
		var taskId				= $(this).closest("tr").find(".taskId").val();
		var comment				= $(this).closest("tr").find(".comment").val();
		var mark				= $(this).closest("tr").find(".mark").val();
		var emoji				= $(this).closest("tr").find(".emoji.active").attr('data');
		var subsmitAgain		= window.flagForsubmit;
		var teacher_id			= $("#teacher_new_id").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '<?php echo URL('/teacher_marking'); ?>',
			type: 'post',
			data: {'student_id':student_id,'practise_id':practise_id,'student_practise_id':student_practise_id,'taskId':taskId,'teacher_id':teacher_id,'markingmethod':markingmethod,'mark':mark,'comment':comment,'teacher_emoji':emoji,'subsmitAgain':subsmitAgain},
			beforeSend: function() {
				$('#cover-spin').fadeIn();
			},
			complete: function() {
				$('#cover-spin').fadeOut();
			},
			success: (json) => {
				if(window.type ==1){
					setTimeout(() => {
						$(this).closest('tr').prev().remove();
						$(this).closest('tr').remove();
					}, 500)
				}else{
					$(this).closest('tr').prev().css("background-color",'background-color: rgb(255, 255, 255);');
				}
				$(this).closest('tr').slideUp();
				setTimeout(() => {
					$(this).closest('tr').remove();
				}, 500)

				$(this).closest('tr').prev().find('td').removeClass('border-bottom-0');
				$(this).closest('tr').prev().find('.hidden-tr-opner').removeClass('active');
				
				if(!json.success) {
					$('#submitModal').modal("show");
					$('.content-body').text(json.message);
					getAlldata();
					return false;
					// location.reload();
				}
				getAlldata();
				// $('.findOne').eq(window.type-1).click();

				$('.'+window.StudetnId).click();

				$.jGrowl("<div class='test'><span class='test2'></span>Mark successfully submited.</div>",{
				  	position: 'top-right',
				  	 theme:  'default',
				   	life: 3000
				});
			}
		});
	}); 

	$(document).on('change','#pendingTask',function() {
		getAlldata();
	});
	$(document).on('change','.sidebar-filter',function() {
		window.type = 1;
		if($(this).attr("data") == "Pending"){
			window.type = 1;
			window.typeofMarking = "1";
			getAlldata();
			getData(window.type);
		}else if($(this).attr("data") == "Extra"){
			window.type = 2;
			window.typeofMarking = "2";
			getAlldata();
		}else{
			window.typeofMarking = "3";
			window.type = 3;
			getAlldata();
		}
		$('.findOne').removeClass("btn-danger");
		$('.findOne').addClass("btn-light");
		$('.findOne').eq(window.type-1).addClass('btn-danger');
	});
	$(document).on('click','.clearFilter',function() {
		$('#course_select').val("");
		$('#level').val("");
		$('#topic').val("");
		$('#task').val("");
		$('#practise').val("");
		$('.submitFilter').click();
	});
	$(document).on('click','.submitFilter',function() {
		getAlldata();
	});
	window.studentFlag = false;
	$(document).on('click','.findOne',function() {
		window.type = 1;
		$('#pendingTask').val("");
		if($(this).html() == "Extra"){
			$('#pendingTaskParent').fadeOut();
			window.type = 2;
			window.typeofMarking = "2";
			$('.findOne').removeClass("btn-danger");
			$('.findOne').addClass('btn-light');
			$(this).addClass("btn-danger");
			$(this).removeClass("btn-light");
		  getAlldata();
		}else if($(this).html() == "Pending") {
			
			$('#pendingTaskParent').fadeOut();
			window.studentFlag = true;
			window.student_id_new = "";
			$('.findOne').removeClass("btn-danger");
			$('.findOne').addClass('btn-light');
			$(this).addClass("btn-danger");
			$(this).removeClass("btn-light");
			window.type = 1;
			window.typeofMarking = "1";
			getAlldata();
			getData(window.type);
			$('.sidebar-filter').attr("checked",false);
			$('.sidebar-filter:eq(0)').attr("checked",true);
		} else if($(this).html() == "Work Record") {
			$('#pendingTaskParent').fadeIn();
			window.typeofMarking = "3";
			window.type = 3;
			$('.findOne').removeClass("btn-danger");
			$('.findOne').addClass('btn-light');
			$(this).addClass("btn-danger");
			$(this).removeClass("btn-light");
		  getAlldata();
		}
	});
	$('#course_select').change(function() {
		$.ajax({
			url: '<?php echo URL('/getlevel'); ?>',
			type: 'get',
			data: { 'course_id':$(this).val()},
			success: (json) => {
				var data = JSON.parse(json);
				var option = "<option value=''>Select Level</option>";
				$('#level').html("");
				$('#level').html(option);
				var topic = "<option value=''>Select Topic</option>";
				$('#topic').html("");
				$('#topic').html(topic);
				var task = "<option value=''>Select Task</option>";
				$('#task').html("");
				$('#task').html(task);
				var practise = "<option value=''>Select Practise</option>";
				$('#practise').html("");
				$('#practise').html(practise);
				$.each(data, function(key,valueObj){
					option += "<option value="+valueObj._id+">"+valueObj.leveltitle+"</option>";
				});
				$('#level').html("");
				$('#level').html(option);
			}
		});
	});
	$('#level').change(function() {
		$.ajax({
			url: '<?php echo URL('/gettopic'); ?>',
			type: 'get',
			data: {'level_id':$(this).val()},
			success: (json) => {
				var data = JSON.parse(json);
				var option = "<option value=''>Select Topic</option>";
				var topic = "<option value=''>Select Topic</option>";
				$('#topic').html("");
				$('#topic').html(topic);
				var task = "<option value=''>Select Task</option>";
				$('#task').html("");
				$('#task').html(task);
				var practise = "<option value='' >Select Practise</option>";
				$('#practise').html("");
				$('#practise').html(practise);
				$.each(data, function(key,valueObj){
					option += "<option value="+valueObj._id+">Topic - "+valueObj.sorting+" "+valueObj.topicname+"</option>";
				});
				$('#topic').html("");
				$('#topic').html(option);
			}
		});
	});
	$('#topic').change(function() {
		$.ajax({
			url: '<?php echo URL('/gettask'); ?>',
			type: 'get',
			data: {'topic_id':$(this).val()},
			success: (json) => {
				var data = JSON.parse(json);
				var option = "<option value=''>Select Task</option>";
				var task = "<option value=''>Select Task</option>";
				$('#task').html("");
				$('#task').html(task);
				var practise = "<option value=''>Select Practise</option>";
				$('#practise').html("");
				$('#practise').html(practise);
				$.each(data, function(key,valueObj){
					option += "<option value="+valueObj._id+">Task - "+valueObj.sorting+" "+valueObj.taskname+"</option>";
				});
				$('#task').html("");
				$('#task').html(option);
			}
		});
	});
	$('#task').change(function() {
		$.ajax({
			url: '<?php echo URL('/getpractice'); ?>',
			type: 'get',
			data: {'task_id':$(this).val()},
			success: (json) => {
				var data = JSON.parse(json);
				var option = "<option value=''>Select Practise</option>";
				var ABCSArray = new Array("A","B","C","D","E","F","G","H","I","J","K");
				$.each(data, function(key,valueObj){
					// $.each(valueObj.practise, function(key1,valueObj1){
						var valued = parseInt(valueObj.sorting);
						var newVaue = valued-1;
						option += "<option value="+valued+">"+ABCSArray[newVaue]+"</option>";
					// });
				});
				$('#practise').html("");
				$('#practise').html(option);
			}
		});
	});
	$(document).on('click','.save',function() {
	});
	$(document).on('change','#student-sidebar',function() {
		window.studentFlag = false;
	});
	$(document).on('click','.click',function() {
		window.findParent = window.type == 1?3:window.findParent;
		$(".odd").css("background-color","#ffffff");
		$(".even").css("background-color","#ffffff");
		$(".odd").find('td').removeClass('border-bottom-0');
		$(".even").find('td').removeClass('border-bottom-0');
		var flag= true;
		if($(this).closest("tr").next().attr('class') == "hidden-data"){
			$(this).removeClass("active");
			$(this).closest("tr").next().slideUp('slow');
			setTimeout(() => {
				$(this).closest("tr").next().remove();
			}, 1000);
			flag= false;
		}else{
			flag= true;
		}
			$(".hidden-tr-opner").removeClass("active");
		if(flag){
			window.taskId 			= $(this).attr('taskid');
			window.practiseId 		= $(this).attr('practice_id');
			window.levelId 			= $(this).attr('level_id');
			window.courseId 		= $(this).attr('course_id');
			window.StudetnId 		= $(this).attr('studentid'); 
			$.ajax({
				url: '<?php echo URL('/getview-marking'); ?>',
				type: 'get',
				data: {'flag_for_tab':window.type,'studenId':$(this).attr('studentid'),'taskId':$(this).attr('taskid'),'course':$(this).attr('course_id'),'level':$(this).attr('level_id'),'practice_id':$(this).attr('practice_id')},
				beforeSend: function() {
					$('#cover-spin').fadeIn();
				},
				complete: function() {
					$('#cover-spin').fadeOut();
				},
				success: (json) => {
					$('.hidden-data').remove();
					$(this).closest('tr').after(json);
					$(this).addClass("active");
					$(this).parents('tr').css("background-color","#FFFFF8 ");
					$(this).parents('tr').find('td').addClass('border-bottom-0');
					$(this).parents('tr').next('tr').find(".hidden-tr").css("background-color","#FFFFF8 ");
					setTimeout(function() {
						$('html, body').animate( {
							scrollTop: $('.topic-block-marking').offset().top - 100 }, 800);
					}, 100);
					if($('.score').length == 1){
						window.findParent = 3;
						if($('.score').attr("data") == 1){
							getData("1");
						}else{
							getData("3");
						}
					}else{
						window.findParent = 1;
						getData("1");	
					}
				}
			});
		}
	});
	$(document).ready(function () {
		var classId 	= "{{  Request::segment(2) }}";
		window.student_id_new = "";
		$('#studentlist li').click(function(){
			window.student_id_new  = $(this).attr("data");
			if(window.type == 2 || window.type == 3){

				$('.findOne').removeClass("btn-danger");
				$('.findOne').addClass("btn-light");
				$('.findOne').eq(window.type-1).removeClass('btn-light');
				$('.findOne').eq(window.type-1).addClass('btn-danger');
			}
			$('#student-sidebar').val(window.student_id_new)
			getAlldata();
			$("#selectStudent").modal("hide");

			$('.sidebar-filter').attr("checked",false);
			var vel = window.type-1;
			$('.sidebar-filter:eq('+vel+')').attr("checked",true);

		});
		$('.classchange').change(function(){
			location.href = $(this).val();
		});
			window.type = 1;
			getAlldata();

	});
	$.fn.dataTable.pipeline = function (opts) {
	    var conf = $.extend({
            pages: 5, 
            url: '',
            data: null, 
            method: 'GET',
	    },opts);
	    var cacheLower = -1;
	    var cacheUpper = null;
	    var cacheLastRequest = null;
	    var cacheLastJson = null;
	    return function (request, drawCallback, settings) {
	    	var ajax = false;
	    	var requestStart = request.start;
	    	var drawStart = request.start;
	    	var requestLength = request.length;
	    	var requestEnd = requestStart + requestLength;
	    	request.page   = requestEnd/10;
	    	request.per_page   = requestLength;
	    	if (settings.clearCache) {
	            ajax = true;
	            settings.clearCache = false;
	          } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
	            ajax = true;
	          } else if (
	          	JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
	          	JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
	          	JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
	          	) {
	            ajax = true;
	          }
	        cacheLastRequest = $.extend(true, {}, request);
	        if (ajax) {
	            if (requestStart < cacheLower) {
	            	requestStart = requestStart - requestLength * (conf.pages - 1);
	            	if (requestStart < 0) {
	            		requestStart = 0;
	            	}
	            }
	            cacheLower = requestStart;
	            cacheUpper = requestStart + requestLength * conf.pages;
	            request.start = requestStart;
	            request.length = requestLength * conf.pages;
	            if (typeof conf.data === 'function') {
	                var d = conf.data(request);
	                if (d) {
	                	$.extend(request, d);
	                }
	              } else if ($.isPlainObject(conf.data)) {
	                $.extend(request, conf.data);
	              }
	              return $.ajax({
	              	type: conf.method,
	              	url: conf.url,
	              	data: request,
	              	dataType: 'json',
	              	cache: false,
	              	success: function (json) {
	              		cacheLastJson = $.extend(true, {}, json);
	              		if (cacheLower != drawStart) {
	              			json.data.splice(0, drawStart - cacheLower);
	              		}
	              		if (requestLength >= -1) {
	              			json.data.splice(requestLength, json.data.length);
	              		}
	              		drawCallback(json);
	              	},
	              });
	        } else {
	            	json = $.extend(true, {}, cacheLastJson);
		            json.draw = request.draw; 
		            json.data.splice(0, requestStart - cacheLower);
		            json.data.splice(requestLength, json.data.length);
		            drawCallback(json);
	        }
	    };
    };
	function getData(append) {
		$.ajax({
			url: '<?php echo URL('/getpractise-marking'); ?>',
			type: 'get',
			data: { 'studenId':window.StudetnId,'taskId':window.taskId,'course':window.courseId,'level':window.levelId,'practice_id':window.practiseId,'flag':append },
			beforeSend: function() {
				$('#cover-spin').fadeIn();
			},
			complete: function() {
				$('#cover-spin').fadeOut();
			},
			success: (json) => {
				// console.log(append)
				if(append == 1){
					$('#2').html("")
					$('#3').html("")
				}
				if(append == 2){
					$('#1').html("")
					$('#3').html("")
				}
				if(append == 3){
					$('#2').html("")
					$('#1').html("")
				}
				$('#'+append).html("")
				//$('.marking-data').append(json)
				// $(json).appendTo()
				$('#'+append).append(json)
				$('.tabss').removeClass('active show');
				$('#'+append).addClass('active show');
			}
		});
	}
	function getAlldata(){

		var course 		= $('#course_select').val();
		var level 		= $('#level').val();
		var topic 		= $('#topic').val();
		var task 		= $('#task').val();
		var practise 	= $('#practise').val();
		var student 	= window.studentFlag?"":$('#student-sidebar').val();
		var is_manual 	= $('#pendingTask').val();
    
		window.table 	= $('.newdata').DataTable({
			processing: true,
			serverSide: true,
			"pageLength": 10,
			"bLengthChange": false,
			destroy: true,
			"ordering": false,
			ajax: $.fn.dataTable.pipeline({
				url: "{{route('marking_list')}}?course="+course+"&level="+level+"&topic="+topic+"&task="+task+"&practise="+practise+"&type_data="+window.type+"&student="+window.student_id_new+"&student_new="+student+"&is_manual="+is_manual,
				pages: 1,
			}),
		});
	}
	$(".open-filter").click(function() {
		$("aside.filter-sidebar").addClass("openclose");
	});
	$(".close-filter").click(function() {
		$("aside.filter-sidebar.openclose").removeClass("openclose");
	});
</script>
@endsection