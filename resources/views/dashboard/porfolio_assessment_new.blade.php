@extends('layouts.app')
@section('content')
<main class="main pl-0 ieuk-pappg">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')

			<section class="main col-sm-12 portfolio_sidea">
				
				<div class="col-12 d-flex justify-content-center pt-3">
					<h1 class="text-center pageheading"><i class="fa fa-briefcase"></i> Portfolio Assessment</h1>
				</div>
				<div class="col-12">
					<div class="row w-100">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<span class="only-info-details dashboard-info float-right mt-0 invisible">
								<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
								<div class="info-details page-info-details">
									<div class="link1">
										<span><a href="javascript:void(0);" id="openmodal"><i class="fa fa-file-alt"></i> Click to read</a> <span>Instructions</span></span>
									</div>
								</div>
							</span>
							<!--  -->
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
				<div class="main__content portfolio-blank w-100 pt-3">
					<div class="row portfolio_course_list">
						<?php foreach($courses as $key=>$course) { 
							// dd($course);
							$leval_id = $course['level_id'];
							$total_task = !empty($course['total_task']) ? $course['total_task'] : 0;
							$submitted_task = !empty($course['completed_task']) ? $course['completed_task'] : 0;
							$total_marks = !empty($course['total_marks']) ? $course['total_marks'] : 0;
							$gained_marks = !empty($course['gained_marks']) ? $course['gained_marks'] : 0;
							$coursename = "";
						?>
						<?php //dd($totaltask)?>
						<div class="col-6 col-sm-4 col-md-6 col-lg-6 col-xl-4 pb-5">
							<div class="portfolio_course_block d-flex flex-wrap justify-content-between">
								<div class="portfolio_course_block_content col-12 p-0">
									<h2 class="text-center"><?php echo $coursename ?></h2>
								</div>

								<div class="tab__block_chart portfolio_course_block_chart col-6">
									<div class="progress task_submission_data" data-percentage="">
										<span class="progress-left"> <span class="progress-bar"></span> </span>
										<span class="progress-right"> <span class="progress-bar"></span> </span>
										<div class="progress-value">
											<div>{{$total_task}}%</div>
										</div>
									</div>
									<h6>Task Submission</h6>
									<span class="text-md-right text-lg-left text-xl-right">{{ $submitted_task.'/'.$total_task }}</span>
								</div>

								<div class="tab__block_chart portfolio_course_block_chart col-6">
									<div class="progress task_achievement_data" data-percentage="">
										<span class="progress-left"> <span class="progress-bar"></span> </span>
										<span class="progress-right"> <span class="progress-bar"></span> </span>
										<div class="progress-value">
											<div>{{number_format($total_task,2)}}%</div>
										</div>
									</div>
									<h6>Task Achievement</h6>
									<span class="text-md-right text-lg-left text-xl-right">{{ $gained_marks.'/'.$total_marks }}</span>
								</div>
						  	<div class="col-6 mt-4 text-center">
									<button type="button" id="<?php echo $course['level_id']; ?>" class="btn btn-cancel wes" data-button='{"getcoursename": "<?php  echo $coursename; ?>", "getlevelname":"-"}'>Progress Report</button>
								</div>
								<div class="col-6 mt-4 text-center">
									<a href="work-record-new" target="_blank"><button type="button" class="btn btn-cancel">Work Record</button></a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</section>
			<div class="modal fade" id="task_submission_data" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><i class="fas fa-file-alt"></i> Task Submission Data</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							<div id="datas"></div>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="task_achievement_data" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><i class="fas fa-file-alt"></i> Task Achievement Data</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							<div id="datas"></div>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<script>
		    $(document).on('click','.wes',function() {
					var level_id  =  $(this).attr('id');
					alert(level_id);
					$.ajax({
							type:"GET",
							url:'{{ URL("porfolio_assessment1") }}',
							data: {'level_id':level_id},
							dataType:'json',
							success:function(data){
								alert(data);
							if(data.success == true) {
								window.location = '{{ URL("/student_progress_report") }}';
							} else {
								alert("Something Went To Wrong Please Try After Sometime");
							}
						}
					});
				});
			</script>
			<script>
				$(document).on('click',".task_submission_data",function() {
					$('#task_submission_data').modal("show");
				});
				$(document).on('click',".task_achievement_data",function() {
					$('#task_achievement_data').modal("show");
				});
  $(document).on('click',"#openmodal",function() {
  	var url = $(this).attr("data-id");
		const app_url = '{{ env('S3URL') }}';
		PDFObject.embed(app_url+url, "#datas",{height: "60rem"});
		$('#myModal').modal("show")
	});
	$(document).on('click',"#openmodal_forvideo",function() {
		var url = $(this).attr("data-id");
		var url2 = $(this).attr("data-id2");
		var url_update = 'https://www.youtube.com/embed/'+url2+'';
		$("#datas").show().html('<iframe width="653" height="345" src="'+url_update+'"></iframe>');
		$('#myModal').modal("show")
	});
</script>
@endsection