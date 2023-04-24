<div class="modal fade" id="reviewModal_{{$practise['id']}}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog erase-modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="reviewModalLongTitle">Review the task</h5>
            </div>
            <div class="modal-body p-0">
              <form class="studentSelfMarkingReviewForm_{{$practise['id']}}">
                <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
                <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
                <input type="hidden" name="task_emoji" class="task_emoji" value="1">
                <input type="hidden" name="task_level" class="task_level" value="6">
                <input type="hidden" name="task_comment" class="task_comment" value="task ni commment">

                <div class="taskbox mt-4 pb-4 review-steps review-step-1">
                    <div class="task-box__rounded p-4 m-4">
                        <div class="d-flex flex-wrap justify-content-between flex-grow-1">
                            <div class="clickable-task w-25">
                                <a href="javascript:;" data-taskemoji="4">
                                    <div class="icon">
                                        <img src="{{ asset('public/images/icon-dont-understand.svg')}}"
                                            alt="I don’t understand the task" class="img-fluid inactive">
                                        <img src="{{asset('public/images/icon-dont-understand-color.svg')}}"
                                            alt="I don’t understand the task" class="img-fluid active">
                                    </div>
                                    <span>I don’t understand the task</span>
                                </a>
                            </div>
                            <div class="clickable-task w-25">
                                <a href="javascript:;"  data-taskemoji="3">
                                    <div class="icon">
                                        <img src="{{ asset('public/images/icon-too-hard.svg')}}" alt="Too Hard"
                                            class="img-fluid inactive">
                                        <img src="{{asset('public/images/icon-too-hard-color.svg')}}"   alt="Too Hard"
                                            class="img-fluid active">
                                    </div>
                                    <span>Too hard</span>
                                </a>
                            </div>
                            <div class="clickable-task w-25">
                                <a href="javascript:;"  data-taskemoji="2">
                                    <div class="icon">
                                        <img src="{{asset('public/images/icon-too-easy.svg')}}" alt="Too Easy"
                                            class="img-fluid inactive">
                                        <img src="{{asset('public/images/icon-too-easy-color.svg')}}" alt="Too Easy"
                                            class="img-fluid active">
                                    </div>
                                    <span>Too Easy</span>
                                </a>
                            </div>
                            <div class="clickable-task w-25 active">
                                <a href="javascript:;" data-taskemoji="1" >
                                    <div class="icon">
                                        <img src="{{asset('public/images/icon-just-right.svg')}}" alt="Just Right"
                                            class="img-fluid inactive">
                                        <img src="{{asset('public/images/icon-just-right-color.svg')}}" alt="Just Right"
                                            class="img-fluid active">
                                    </div>
                                    <span>Just Right</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="task-box_buttons">
                        <a href="javascript:;" class="btn btn-primary mr-3 submit_step" data-step='1'>Done</a>
                        <a href="javascript:;" class="btn btn-secondary skip-review">Skip</a>
                    </div>
                </div>

                <div class="taskbox mt-4 pb-4 review-steps review-step-2" style="display:none">
                    <div class="task-box__rounded p-4 m-4">
                        <p>How much did you enjoyed this task?</p>

                        <ul class="list-inline d-flex flex-wrap justify-content-center select_task_level"  >
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="1">1</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="2">2</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="3">3</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="4">4</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="5">5</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="6">6</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="7">7</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="8">8</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="9">9</a></li>
                            <li class="list-inline-item"><a href="javascript:;" data-taskLevel="10">10</a></li>
                        </ul>
                    </div>
                    <div class="task-box_buttons">
                        <a href="javascript:;" class="btn btn-primary mr-3 submit_step" data-step='2'>Done</a>
                        <a href="javascript:;" class="btn btn-secondary skip-review">Skip</a>
                    </div>
                </div>

                <div class="taskbox mt-4 pb-4 review-steps review-step-3" style="display:none">
                    <div class="task-box__rounded p-4 m-4">
                        <p>Tell us how we can make this task better for you.</p>
                        <div class="form-group">
                            <span class="textarea form-control form-control-textarea" role="textbox"
                                contenteditable placeholder="Write here..."></span>
                            <div style="display:none">

                              <textarea name="student_task_comment" class="main-answer-input student_task_comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert" style="display:none"></div>
                    <div class="alert alert-danger" role="alert" style="display:none"></div>
                    <div class="task-box_buttons">
                        <a href="javascript:;" class="btn btn-primary mr-3 submit_form">Done</a>
                        <a href="javascript:;" class="btn btn-secondary skip-review" >Skip</a>
                    </div>
                </div>
              </form>
            </div>
            <!--<div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>-->
        </div>
    </div>
</div>
<script>
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
              $('#reviewModal_{{$practise["id"]}}').find('.alert-success').show().html(data.message).fadeOut(4000);
              setTimeout(function(){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');
              },2000)

            } else {
    					$('#reviewModal_{{$practise["id"]}}').find('.alert-success').hide();
    					$('#reviewModal_{{$practise["id"]}}').find('.alert-danger').show().html(data.message).fadeOut(4000);
    				}
          }
      });
    });
    $("#reviewModal_{{$practise['id']}}").on('click','.select_task_level li a', function() {
      var task_level = $(this).attr('data-taskLevel');
      $("#reviewModal_{{$practise['id']}}").find('.task_level').val(task_level);
    });

</script>
