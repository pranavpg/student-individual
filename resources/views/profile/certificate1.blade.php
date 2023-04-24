@extends('layouts.app')
@section('content')
<?php
use \App\Http\Controllers\ProfileController;
?>
<style type="text/css">
	.owl-dots {
		display: none;
	}
</style>
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<?php 
			// if(isset($certificate_details['academy_verification']) && !empty($certificate_details['academy_verification'])){
			// 	$academy_status = "done";
			// 	$ieuk_status="active";
			// }
			// if(isset($certificate_details['certificate_number']) && !empty($certificate_details['certificate_number'])){
			// 	$access_status = "done";

			// }
			?>
			<section class="main col-sm-12">
				@include('profile.menu')
				<!-- <span class="only-info-details dashboard-info float-right">
					<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
					<div class="info-details page-info-details">
						<div class="link1">
							<span><a href="#" id="openmodal"><i class="fa fa-file-alt"></i> Click to read</a> <span>Instructions</span></span>
						</div>
					</div>
				</span> -->
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
				<ul class="aes_ges_parent nav nav-pills nav-pills_switch pt-3 pl-3" id="pills-tab" role="tablist">
					<?php $p = 0;?>
					@foreach($award_by_id as $key => $value)
					<?php 
					if($p == 0)
					{
						?>
						<a id="class1" data-toggle="tab" href="#{{$value['award_id']}}">
							<button type="button" id="{{$value['award_id']}}" class="btn btn-lg portfolio_details wes test1" data-button="{&quot;getcoursename&quot;: &quot;General English&quot;, &quot;getlevelname&quot;:&quot;Level 1&quot;}" >{{$value['award_name']}}</button></a>
							&nbsp;
							&nbsp;
							<?php
						}
						else
						{
							?>
							<a id="class1" data-toggle="tab" href="#{{$value['award_id']}}">
								<button type="button" id="{{$value['award_id']}}" class="btn btn-lg portfolio_details wes test1" data-button="{&quot;getcoursename&quot;: &quot;General English&quot;, &quot;getlevelname&quot;:&quot;Level 1&quot;}" style="background: 
								#adb5bd;border: 1px #adb5bd;">{{$value['award_name']}}</button></a>
								&nbsp;
								&nbsp;
								<?php
							}
							?>
							<?php $p++;?>
							@endforeach
						</ul>
						<div class="main__content certificate_process">
							<div class="col-md-12 certificate_details pb-4">
								<h3><span>{{!empty($student_name)?$student_name:''}}</span></h3>
								<!-- <h5><span>Certificate Details</span></h5> -->
							</div>
							<br>
							<div class="tab-content">
								<?php $i = 0;?>  
								@foreach($award_by_id as $key => $value)
								<div class="col-md-12 certificate_details pb-4">
									<?php
									$str_new = '';
									$level_title = '-';
									foreach($value['student_course'] as $course)
									{
										$str_new .= !empty($course['course_title']) ? $course['course_title'].' , ' : "";
										$level_title = !empty($course['level_title']) ? $course['level_title'] : "" ;
									}
									$newarraynama = rtrim($str_new, " , ");
									?>     
									<?php 
									if($i == 0)
									{ 
										?>
										<h3 id="{{$value['award_id']}}1" class="rs">{{$newarraynama}}</h3> 
										<h3 id="{{$value['award_id']}}2" class="rs1">{{$level_title}}</h3> 
										<?php
									}
									else
									{
										?>   
										<h3 id="{{$value['award_id']}}1" class="rs" style="display: none;">{{$newarraynama}}</h3> 
										<h3 id="{{$value['award_id']}}2" class="rs1" style="display: none;">{{$level_title}}</h3> 
										<?php        
									}
									?>
								</div>
								<?php 
                      //  dd($value);
								?>
								<?php //dd($value['status']);?>
								<?php 
								if($i == 0)
								{ 
									?>
									<div class="row tab-pane {{$value['award_id']}} active" id="{{$value['award_id']}}">
										<?php
									}
									else
									{
										?>
										<div class="row tab-pane {{$value['award_id']}}" id="{{$value['award_id']}}">
											<?php        
										}
										?>
										<div class="col-md-10 offset-md-1">
											<?php 
											$statusClass = "done";
											$activeClass="active";
											$ieuk_status="";
											$access_status="";
											$pending_status="";
											$academy_status="";
											$super_admin_status = "";
											$academy_text_status =  0;
											$academy_skip_txt = 0;
											$disapproved_status = 0;
											$pending_verification_status = 0;
											$pass_or_fail = 0;   
                        // for checking "pending ieuk verification" OR "ieuk pending verification" condition
											if(isset($value['status']) && ProfileController::checkCertificateStatus($value['status'])){
												$pending_status = "done";
												$academy_status="done";
												$super_admin_status  = "done";
                          //  $ieuk_status = "done";
												$pending_verification_status = 0;
											}else{
												$pending_status = "done";
												$academy_status="";
												$super_admin_status = "";
											}
											if(isset($value['status']) && $value['status'] == 'IEUK Disapproved')
											{
												$disapproved_status = 1;
												$pending_verification_status = 1; 
												$academy_status="done";
												$ieuk_status="done";
												$super_admin_status = "done";
												$pass_or_fail = 2;


											}
											if(isset($value['status']) && (strtolower($value['status']) == "ieuk approved" || strtolower($value['status']) == 'fail')){
												if(strtolower($value['status']) == "ieuk approved")
												{
													$pass_or_fail = 1;
												}
												else
												{
													$pass_or_fail = 2;
												}
												$pending_status = "done";
												$academy_status = "done";
												$ieuk_status="done";
												$super_admin_status = "done";
												$pending_verification_status = 1;

											}
                        //-------comment mehul code-------------------
                        // if(isset($value['final_status']) && strtolower($value['final_status']) == 'approved')
                        // {      
                        //     $pending_status = "done";
                        //     $academy_status = "done";
                        //     $ieuk_status="done";
                        //     $super_admin_status = "done"; 
                        //     $access_status = "done";
                        // }
                        //----------------
											if(isset($value['final_status']))
											{  
												if(strtolower($value['final_status']) != '')
												{


													if(strtolower($value['final_status']) == 'approved' )
													{
														$pending_status = "done";
														$academy_status = "done";
														$ieuk_status="done";
														$super_admin_status = "done"; 
														$access_status = "done";
														$academy_text_status =  1;
														$academy_skip_txt    =  1;
														$pending_verification_status = 1;   
													}
													else
													{
														$pending_status = "done";
														$academy_status = "done";
														$ieuk_status="done";
														$super_admin_status = "done"; 
														$access_status = "done";
														$academy_text_status =  2;
														$academy_skip_txt    =  2;
														$pending_verification_status = 1;    
													}
												}
											}
											?>
											<?php 

                                 // if(strtolower($value['status']) != 'fail')
                                 // {
											?>
											<ol class="progress_status ieukc-process" data-steps="4">
												<?php 
                                // }
                                // else
                                // {
												?>
												<!-- <ol class="progress_status ieukc-process" data-steps="3"> -->
													<?php       
                                // }
													?>
													<li class="{{$pending_status}}">
														<span class="step"></span>
													</li>
													<?php 
                                 // if($value['status'] != 'Fail')
                                 // {
													?>
													<li class="{{$academy_status}}">
														<span class="step"></span>
													</li>
													<?php 
                                // }
													?>
													<li class="{{$ieuk_status}}">
														<span class="step"></span>
													</li>
													<li class="{{$access_status}}">
														<span class="step"></span>
													</li>
												</ol>
												<?php 
                                 // if(strtolower($value['status']) != 'fail')
                                 // {
												?>
												<ol class="progress_status ieukc-getcerty" data-steps="4">
													<?php 
                                // }
                                // else
                                // {
													?>
													<!-- <ol class="progress_status ieukc-getcerty" data-steps="3"> -->
														<?php       
                              //  }
														?>
														<li class="{{$pending_status}}">
															@if($pass_or_fail == 2)
															<span class="name">Fail</span>
															@elseif($pass_or_fail == 1)
															<span class="name">Pass</span>
															@else
															<span class="name">Course<br> Pending</span>
															@endif
															@if($pending_status =='done')
															<span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif
														</li>
														<?php 
                                 // if(strtolower($value['status']) != 'fail')
                                 // {
														?>
														<li class="{{$academy_status}}">
															@if($disapproved_status == 1)
															<span class="name">IEUK<br> Verification Disapproved</span>
															@elseif($pending_verification_status == 1)
															<span class="name">IEUK<br> Verification Approved</span>
															@else
															<span class="name">IEUK<br> Verification</span>
															@endif
															@if($academy_status == 'done')
															<span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif
														</li>
														<?php
                              //   } 
														?>
														<li class="{{$ieuk_status}}">
															@if($academy_text_status == 1)
															<span class="name">Certificate<br> Approved</span>
															@elseif($academy_text_status == 2)
															<span class="name">Skipped<br>Certificate Approval</span>
															@else
															<span class="name">Certificate<br> Approval</span>
															@endif
															@if($ieuk_status == 'done')
															<span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif
														</li>
														<li  class="{{$access_status}}">
															@if($academy_skip_txt == 1)
															<span class="name">Certificate<br>Access Granted</span> 
															@if($access_status == 'done')
															<span class="psp"><img src="{{ asset('public/images/accept.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif
															@elseif($academy_skip_txt == 2)
															<span class="name">Certificate<br>Access Denied</span>
															@if($access_status == 'done')
															<span class="psp"><img src="{{ asset('public/images/cross.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif 
															@else
															<span class="name">Access<br>Certificate</span> 
															@if($access_status == 'done')
															<span class="psp"><img src="{{ asset('public/images/ieuk-verification.png') }}" alt=""></span>
															@else
															<span class="psp"><img src="{{ asset('public/images/waiting-process.png') }}" alt=""></span>
															@endif
															@endif

														</li>
													</ol>
												</div>
												@if($academy_skip_txt == 1)
												<div class="row pt-5 w-100">
													<div class="col-12 d-flex justify-content-center pr-0">
														<a href="https://s3.amazonaws.com/imperialenglish.co.uk/{{$value['student_certificate']}}" class="ieukcd-btn btn btn-primary  mr-4 py-2 px-3" target="_blank"  download>Download</a>
														<a href="{{$value['verification_url']}}" class="ieukcd-btn btn btn-primary  btn btn-primary  py-2 px-3" target="_blank">Verify</a>
													</div>
                              <!--   <div class="col-md-6 text-center">
                                    data-toggle="modal" data-target="#student_certificate_verification" 
                                  </div> -->
                                </div>
                                @endif
                              </div>
                              <br>
                              <script>
                              	$(document).ready(function() {
                              		PDFObject.embed("https://s3.amazonaws.com/imperialenglish.co.uk/{{$value['student_certificate']}}", "#pdf-view-popup",{height: "60rem"});
                              	});
                              </script> 
                              <?php $i++;?>                
                              @endforeach
                            </div>
                          </div>
                          <!-------->
                        </div>
                      </section>
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
                </main>
                <div class="modal fade" id="student_certificate" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                	<div class="modal-content">
                		<div class="modal-header flex-wrap">
                			<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
                				<h4 class="modal-title" id="cpd-policy-modalLabel"></h4>
                				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                					<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
                				</button>
                			</div>
                			<!-- /. Modal Header top-->
                		</div>
                		<div class="modal-body text-center border-0">
                			<div id="pdf-view-popup"></div>
                		</div>
                	</div>
                </div>
              </div>

              <div class="modal fade" id="student_certificate_verification" tabindex="-1" role="dialog" aria-labelledby="cpd-policy-modalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-xl">
              	<div class="modal-content">
              		<div class="modal-header flex-wrap">
              			<div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100 mb-4">
              				<h4 class="modal-title" id="cpd-policy-modalLabel">

              				</h4>
              				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              					<img src="{{ asset('public/images/icon-close-modal.svg') }}" alt="close" class="img-fluid">
              				</button>
              			</div>
              			<!-- /. Modal Header top-->
              		</div>
              		<div class="modal-body text-center border-0"><br>
              			<iframe src="https://www.imperial-english.com/verification.php" title="description" style="width:100%; height:500px"> </iframe>
              		</div>
              	</div>
              </div>
            </div>
            <script type="text/javascript">
    // $(document).ready(function () {
    //     $('#class1').click(function() {
    //         $('.class1').addClass('active');
    //         $('.class2').removeClass('active');
    //     });
    //     $('#class2').click(function() {
    //         $('.class2').addClass('active');
    //         $('.class1').removeClass('active');
    //     });
    // });
    $(document).ready(function(){

     $(".test1").click(function(){
	    	var id = this.id;
	      //alert(id);
	      $('.rs').hide();
	      $('.rs1').hide();
	      $('#'+id+'1').show();
	      $('#'+id+'2').show();
	      $('.test1').css("background-color","#adb5bd");
	      $('.test1').css("border-color","#adb5bd");
	      $('#'+id).css("background-color","#d55b7d");
	      $('.tab-pane.active').removeClass('active');
	      $('.'+id).addClass('active');
      });

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
@endsection