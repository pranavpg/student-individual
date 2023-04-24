<div class="modal fade" id="reviewModal_{{$practise['id']}}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLongTitle"aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form class="studentSelfMarkingReviewForm_{{$practise['id']}}">
				<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
				<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
				<input type="hidden" name="task_emoji" class="task_emoji" value="1">
				<input type="hidden" name="task_level" class="task_level" value="6">
				<input type="hidden" name="task_comment" class="task_comment" value=" ">
				<div class="modal-body text-center" style="background-color: #fafafa;border-top-right-radius: calc(0.3rem - 1px);border-top-left-radius: calc(0.3rem - 1px);">
					<div class="taskbox pb-4 review-steps review-step-1">
						<h5 class="modal-title" id="reviewModalLongTitle">Task Review</h5>
						
						<div class="task-box__rounded text-center">
							<span style="font-size: 12px;color: #6f6f6f;">This information is seen in your work record. If the task is “too hard” or “don’t understand” you can practice this task again.</span>
							<div class="d-flex flex-wrap justify-content-between flex-grow-1 mt-3">
								<div class="clickable-task w-25">
									<a href="javascript:void(0);" data-taskemoji="4">
										<div class="icon">
											<img src="{{ asset('public/images/icon-emoji-gray-orange.svg')}}" alt="I don’t understand the task" class="img-fluid inactive">
											<img src="{{asset('public/images/icon-emoji-orange.svg')}}" alt="I don’t understand the task" class="img-fluid active">
										</div>
										<span>Don’t Understand</span>
									</a>
								</div>
								<div class="clickable-task w-25">
									<a href="javascript:void(0);" data-taskemoji="3">
										<div class="icon">
											<img src="{{ asset('public/images/icon-too-hard.svg')}}" alt="Too Hard" class="img-fluid inactive">
											<img src="{{asset('public/images/icon-too-hard-color.svg')}}" alt="Too Hard" class="img-fluid active">
										</div>
										<span>Too Hard</span>
									</a>
								</div>
								<div class="clickable-task w-25">
									<a href="javascript:void(0);"  data-taskemoji="2">
										<div class="icon">
											<img src="{{asset('public/images/icon-emoji-gray-yellow.svg')}}" alt="Too Easy" class="img-fluid inactive">
											<img src="{{asset('public/images/icon-emoji-yellow.svg')}}" alt="Too Easy" class="img-fluid active">
										</div>
										<span>Too Easy</span>
									</a>
								</div>
								<div class="clickable-task w-25 active">
									<a href="jjavascript:void(0);" data-taskemoji="1" >
										<div class="icon">
											<img src="{{asset('public/images/icon-just-right.svg')}}" alt="Just Right" class="img-fluid inactive">
											<img src="{{asset('public/images/icon-just-right-color.svg')}}" alt="Just Right" class="img-fluid active">
										</div>
										<span>Just Right</span>
									</a>
								</div>
							</div>
							<p class="mb-0 mt-3" style="font-size: 16px;">Your Notes</p>
							<div class="form-group mb-0">
								<span class="textarea form-control form-control-textarea text-left" role="textbox" contenteditable placeholder="Write here..."></span>
								<div style="display:none;">
									<textarea name="student_task_comment" class="main-answer-input student_task_comment"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="taskbox pb-0 review-steps review-step-2"> 
						<h5 class="modal-title" id="reviewModalLongTitle">Task Review for IEUK</h5>
						
						<div class="task-box__rounded">
							<span style="font-size: 12px;color: #6f6f6f;">This information is sent to IEUK to help make the courses better.</span>
							<p class="mb-1 mt-3" style="font-size: 16px;">How much did you enjoyed this task?</p>

							<ul class="list-inline d-flex flex-wrap justify-content-center select_task_level mb-0">
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="1" class="reviewRating">1</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="2" class="reviewRating">2</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="3" class="reviewRating">3</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="4" class="reviewRating">4</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="5" class="reviewRating">5</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="6" class="reviewRating">6</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="7" class="reviewRating">7</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="8" class="reviewRating">8</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="9" class="reviewRating">9</a></li>
								<li class="list-inline-item mb-0"><a href="javascript:void(0);" data-taskLevel="10" class="reviewRating">10</a></li>
							</ul>

							<p class="mb-0 mt-3" style="font-size: 16px;">Tell us how we can make this task better.</p>
							<div class="form-group mb-0">
								<span class="textarea form-control form-control-textarea text-left" role="textbox" contenteditable placeholder="Write here..."></span>
								<div style="display:none">
									<textarea name="ieuk_comment" class="main-answer-input ieuk_comment"></textarea>
								</div>
							</div>
						</div>
					</div>
					

				</div>
				<div class="modal-footer justify-content-center">
					<div class="taskbox review-steps review-step-3">
						<div class="task-box_buttons">
							<a href="javascript:void(0);" class="btn btn-primary mr-3 submit_form">Done</a>
							<a href="javascript:void(0);" class="btn btn-cancel skip-review" >Skip</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(".reviewRating").click(function() {
  	$(".reviewRating").removeClass('selectedRating');
  	$(this).addClass('selectedRating');
	});
</script>

<script>
	var sorting             = "{{ isset($topic_tasks_new)?$topic_tasks_new:$topic_tasks[0]['sorting'] }}";
	var feedbackExits       = "<?php echo isset($feedbackExits)?$feedbackExits:""; ?>";
	var allowPopupDisplay   = false;

    // alert($('.parentSidebar .navigation').length)
    var checkActiveLevel = 0;
    $('.parentSidebar .navigation').each(function(key){
        // alert(key)
        // alert($(this).hasClass("active"))
        if(!$(this).hasClass("active")){
        	checkActiveLevel=key;
        }else{
        	return false; 
        }
      });
    // alert($('.parentSidebar .navigation').length)
    // alert(checkActiveLevel)
    if($('.parentSidebar .navigation').length == checkActiveLevel+2){
    	allowPopupDisplay = true;
    }
    // alert(allowPopupDisplay)
    $("#reviewModal_{{$practise['id']}}").find(".task-box__rounded .clickable-task > a ").click(function () {
    	$(".task-box__rounded .clickable-task").removeClass("active");
    	$(this).parent().addClass('active');
    	var task_emoji = $(this).attr('data-taskemoji');
    	$("#reviewModal_{{$practise['id']}}").find('.task_emoji').val(task_emoji);
    });

    $("#reviewModal_{{$practise['id']}}").on('click','.submit_step', function(){
    	var step = parseInt($(this).attr('data-step'));
    	$('.review-steps').hide();
    	$('.review-step-'+(step+1)).show();
    });

    $("#reviewModal_{{$practise['id']}}").on('click','.skip-review', function() {
    	$("#reviewModal_{{$practise['id']}}").modal('toggle');
        // alert(allowPopupDisplay);
        // alert(feedbackPopup);
        // alert(sorting);
        // alert(facilityFeedback);
        // alert(courseFeedback);
        // alert(feedbackExits);
        if(allowPopupDisplay) {
        	if(feedbackPopup) {
        		if(sorting ==4 || sorting ==5 || sorting ==14 || sorting ==15 || sorting ==29 || sorting ==30){
        			if(facilityFeedback){
        				if(feedbackExits==""){
        					$('#facility-feedback').modal("show");
        				}
        			}
        			if(courseFeedback){
        				if(feedbackExits==""){
        					if(sorting == 30){
        						$('#course-feedback-end').modal("show")
        						$('#course-feedback-end').find('#feedback-form-modalLabel').text('ELT END-OF-TERM FEEDBACK FORM')
        					}else{
        						$('#course-feedback-init-mid').modal("show")
        						if(sorting == 5){
        							$('#course-feedback-init-mid').find('#feedback-form-modalLabel').text('ELT INITIAL-COURSE FEEDBACK FORM')
        						}else if(sorting == 15){

        							$('#course-feedback-init-mid').find('#feedback-form-modalLabel').text('ELT MID-COURSE FEEDBACK FORM')
        						}
        					}
        				}
        			}
        		}
        	}
        }
      });

    $("#reviewModal_{{$practise['id']}}").on('click','.submit_form', function() {
    	var $this = $(this);
    	$this.attr('disabled');
    	$('#reviewModal_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
    		var currentVal = $(this).html();

    		$(this).next().find("textarea").val(currentVal);
    	});
    	$.ajax({
    		url: '<?php echo URL('save-student-self-marking-review'); ?>',
    		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    		type: 'POST',
    		data: $('.studentSelfMarkingReviewForm_{{$practise["id"]}}').serialize(),
    		success: function (data) {

    			$this.removeAttr('disabled');
    			if(data.success){
              //$("#reviewModal_{{$practise['id']}}").modal('toggle');
              $('#reviewModal_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(8000);
              setTimeout(function(){
              	$("#reviewModal_{{$practise['id']}}").modal('toggle');
              	$('#course-feedback-init-mid').modal("show");

              	if(allowPopupDisplay) {
              		if(feedbackPopup) {
              			if(sorting ==4 || sorting ==5 || sorting ==14 || sorting ==15 || sorting ==29 || sorting ==30){
              				if(facilityFeedback){
              					if(feedbackExits==""){
              						$('#facility-feedback').modal("show");
              					}
              				}
              				if(courseFeedback){
              					if(feedbackExits==""){

              						if(sorting == 30) {
              							$('#course-feedback-end').modal("show")
              							$('#course-feedback-end').find('#feedback-form-modalLabel').text('ELT END-OF-TERM FEEDBACK FORM')
              						}else{
              							$('#course-feedback-init-mid').modal("show")
              							if(sorting == 5){
              								$('#course-feedback-end').find('#feedback-form-modalLabel').text('ELT INITIAL-COURSE FEEDBACK FORM')
              							}else if(sorting == 15){
              								$('#course-feedback-end').find('#feedback-form-modalLabel').text('ELT MID-COURSE FEEDBACK FORM')
              							}
              						}
              					}
              				}
              			}
              		}
              	}

              },2000)
            }else{
            	$('#reviewModal_{{$practise["id"]}}').find('.alert-success').hide();
            	$('#reviewModal_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(8000);
            }
          }
        });
    });
    $("#reviewModal_{{$practise['id']}}").on('click','.select_task_level li a', function() {
    	var task_level = $(this).attr('data-taskLevel');
    	$("#reviewModal_{{$practise['id']}}").find('.task_level').val(task_level);
    });

  </script>