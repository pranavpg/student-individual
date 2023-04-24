@extends('layouts.app')
@section('content')
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main col-sm-12">
				@include('profile.menu')
				<div class="col-12">
					<div class="row w-100">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2">
							@if(empty($instration['getdocument'] OR $instration['getvideo']))
			
							@else
							<span class="only-info-details float-right">
								<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
								<div class="info-details page-info-details">
									@foreach($instration['getdocument'] as $ins_doc)
									<div class="link1">
										<span><a href="#" id="openmodal" data-id="{{$ins_doc['document_url']}}"><i class="fa fa-file-alt"></i> Click to read</a> <span>{{$ins_doc['document_name']}}</span></span>
									</div>
									@endforeach
									@foreach($instration['getvideo'] as $ins_video)
									<div class="link1">
										<span><a href="#" id="openmodal_forvideo" data-id="{{$ins_video['video_url']}}" data-id2="{{$ins_video['video_id']}}"><i class="fa fa-file-alt"></i> Click to watch</a> <span>{{$ins_video['video_name']}}</span></span>
									</div>
									@endforeach
								</div>
							</span>
							@endif
						</div>
					</div>
				</div>
				<!-- instruction popup -->
				<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_video">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body text-center">
								<div id="datas"></div>
							</div>
							<div class="modal-footer justify-content-center">
								<button type="button" class="btn btn-cancel" data-dismiss="modal" id="close_video">Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- end instruction video -->
					<div class="main__content pt-3">
						<div class="d-flex flex-wrap justify-content-center main-course">
							<?php foreach($response as $i=>$course) { ?>
							<div class="col-12 col-lg-6 mb-4">
								<div class="course-enrolement course-enrolement-card">
									<h2 class="mb-5 mb-md-0"> 
										<span class="text-uppercase">{{$course['course']['coursetitle']}}</span>
									</h2>
									  <div class="row text-md-center mt-0 mt-md-5">
										<div class="col-md-12">
											<h5 class="text-left text-md-center">Level Assigned</h5>
											<h4 class="text-right text-md-center">{{$course['student_levels']['level_new']['current_level']}}</h4>
										</div>
									</div>  
									<div class="row text-md-center pb-0 pb-md-3 mt-0 mt-md-5">
										<div class="col-md-6">
											<h5 class="text-left text-md-center">Course Title</h5>
											<h4 class="text-right text-md-center">{{$course['course']['coursetitle']}}</h4>
										</div>
										<div class="col-md-6">
											<h5 class="text-left text-md-center">Course Duration</h5>
											<h4 class="text-right text-md-center">0</h4>
										</div>
									</div>
									<div class="row text-md-center mb-4">
										<div class="col-md-6">
											<h5 class="text-left text-md-center">Course Start Date</h5>
											<h4 class="text-right text-md-center"><?php echo date("d-m-Y",strtotime($course['course_start_date']))?></h4>
										</div>
										<div class="col-md-6">
											<h5 class="text-left text-md-center">Course End Date</h5>
											<h4 class="text-right text-md-center"><?php echo date("d-m-Y",strtotime($course['course_end_date']))?></h4>
										</div>
									</div>                      
                                </div>                         
                            </div> 
                        <?php  }?>   
                        </div> 
                    </div>
                </section>
		</div>
	</div>
</main>
<div class="alert alert-danger" role="alert" id="error_message">
   <a href="#" class="alert-link">Course enrolment letter not found</a>.
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cpd-policy-modalLabel">
                	&nbsp;
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
            </div>
            <div class="modal-body text-center">
            	<div id="c_later"></div>
            </div>
        	<div class="modal-footer justify-content-center">
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Close</button>
			</div>
        </div>
    </div>
</div>
<script>
	$(document).on('click',"#openlater",function(){
  		var url = $(this).attr("data");
  		if(url == ""){
  			$("#error_message").show()
  			setTimeout(function(){
  				$("#error_message").hide()
  			}, 3000);
  			return false;
  		}
		const app_url = '{{ env('S3URL') }}';
		PDFObject.embed(app_url+url, "#c_later",{height: "60rem"});
		$('#myModal2').modal("show")
	});
</script>
@endsection