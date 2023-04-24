<!--Note Modal-->

<div class="modal fade add-summary-modal" id="noteModal" tabindex="-1" role="dialog"
        aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
				<form id="my_form" action="" method="post">
				<input type="hidden" name="course_id" id="course_id" value="" />
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="noteModalLabel">
                        <span><img src="{{ asset('public/images/icon-heading-notes.svg')}}" alt="" class="img-fluid"></span>
                        <span class="text2">GES - NOTE</span>
                    </h5>
                    <div class="modal-title__right form-inline" style="max-width:80%;">
                        <div class="form-group mb-2 col-sm-4">
                            <select id="topic_id1" name="topic_id1" class="form-control">
								<option value="">Please Select Topic</option>
								<?php foreach($sessionAll['topics'] as $topicId=>$topic){?>
                                    
									<option value="<?php echo $topicId;?>" data-courseid="<?php echo $topic['course_id'];?>"><?php echo $topic['title'];?></option>
								<?php }?>
                            </select>
                        </div>

                        <div class="form-group mb-2 col-sm-4">
                            <select id="task_id" name="task_id" class="form-control">
								<option value="">Please Select Task</option>
								<?php foreach($sessionAll['tasks'] as $taskId=>$task){?>
									<option value="<?php echo $taskId;?>" data-courseid="<?php echo $task['course_id'];?>" data-topicid="<?php echo $task['topic_id'];?>" style="display:none"><?php echo $task['title'];?></option>
								<?php }?>
                            </select>
                        </div>

                        <div class="form-group mb-2 col-sm-4">
                            <select id="skill_id" name="skill_id" class="form-control">
								<option value="">Please Select Skill</option>
								<?php foreach($sessionAll['skills'] as $skillId=>$skill){?>
									<option value="<?php echo $skillId;?>"><?php echo $skill['title'];?></option>
								<?php }?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    <h3>Title</h3>
                    <div class="form-group">
                        <input type="text" id="title" name="title" class="form-control" placeholder="write here...">
                    </div>

                    <h3>Description</h3>
                    <div class="form-group">
                        <textarea name="description" id="description" name="description" class="form-control" value=""></textarea>
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
                    <button type="submit" class="btn btn-primary">
                        <span><img src="{{ asset('public/images/icon-btn-save.svg')}}" alt="" class="img-fluid"></span>
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
				</form>
            </div>
        </div>
    </div>

<!--Vocabulary Modal-->
<div class="modal fade add-summary-modal" id="vocabularyModal" tabindex="-1" role="dialog"
        aria-labelledby="vocabularyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
				<form id="my_form2" action="{{ URL('vocab_post') }}" method="post">
				@csrf
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="vocabularyModalLabel">
                        <span><img src="{{ asset('public/images/icon-heading-notes.svg') }}" alt="" class="img-fluid"></span>
                        Vocabulary
                    </h5>
					
                    <div class="modal-title__right form-inline">
                        <div class="form-group mb-2">
                            <select name="modal_topic_id" id="modal_topic_id" class="form-control">
								<option value="">Please Select Topic</option>
								<?php if(!empty($vocabtopiclist)){?>
								<?php foreach($vocabtopiclist as $i=>$vocabtopic){?>
									<option value="<?php echo $vocabtopic['id'];?>"><?php echo $vocabtopic['name']?></option>
								<?php }?>
								<?php }?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-body vocabulary-body">
                    <div class="row">
                        <div class="col-6 form-group form-group-inline d-flex align-items-end">
                            <span>Word: </span>
                            <input type="text" name="word" id="word" class="form-control">
                        </div>
                        <div class="col-6 form-group form-group__copy form-group-inline d-flex align-items-end">
                            <span>Copy the word: </span>
                            <input type="text" name="copytheword" id="copytheword" class="form-control">
                        </div>
                        <div class="col-6 form-group form-group-inline d-flex align-items-end">
                            <span>Word Type: </span>
                            <input type="text" name="wordtype" id="wordtype" class="form-control">
                        </div>
                        <div class="col-6 form-group form-group__phonetic form-group-inline d-flex align-items-end">
                            <span>Phonetic Transcription:</span>
                            <input type="text" name="phonetictranscription" id="phonetictranscription" class="form-control">
                        </div>
						<div class="col-6 form-group form-group-inline d-flex align-items-end">
                            <span>Meaning: </span>
                            <input type="text" name="translationmeaning" id="translationmeaning" class="form-control">
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline d-flex align-items-end">
                            <span>Sample Sentence 1:</span>
                            <input type="text" name="sentence1" id="sentence1" class="form-control">
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline d-flex align-items-end">
                            <span>Sample Sentence 2:</span>
                            <input type="text" name="sentence2" id="sentence2" class="form-control">
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline d-flex align-items-end">
                            <span>Sample Sentence 3:</span>
                            <input type="text" name="sentence3" id="sentence3" class="form-control">
                        </div>
						<div class="col-12 form-group form-group__full form-group-inline d-flex align-items-end">
                            <span>Sample Sentence 4:</span>
                            <input type="text" name="sentence4" id="sentence4" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <span><img src="{{ asset('public/images/icon-btn-save.svg') }}" alt="" class="img-fluid"></span>
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
				</form>
            </div>
        </div>
    </div>

    <!--summary Modal-->
<div class="modal fade add-summary-modal" id="summaryModal" tabindex="-1" role="dialog"
        aria-labelledby="summaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
				<form id="summary_form" action="" method="post">
				<input type="hidden" name="course_id" id="course_id" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryModalLabel">
                        <span><img src="{{ asset('public/images/icon-heading-notes.svg') }}" alt="" class="img-fluid"></span>
                        Summary
                    </h5>
                    <div class="modal-title__right">
                        <div class="form-group">
                            <select id="topic_id" name="topic_id" class="form-control">
								<option value="">Please Select Topic</option>
								<?php foreach($sessionAll['topics'] as $topicId=>$topic){?>
									<option value="<?php echo $topicId;?>" data-courseid="<?php echo $topic['course_id'];?>"><?php echo $topic['title'];?></option>
								<?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h3>What you have learned from this topic?</h3>
                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Reading:</label>
                        <input type="text" name="reading_summary" id="reading_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Writing:</label>
                        <input type="text" name="writing_summary" id="writing_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Speaking:</label>
                        <input type="text" name="speaking_summary" id="speaking_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Listening:</label>
                        <input type="text" name="listening_summary" id="listening_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Grammar:</label>
                        <input type="text" name="grammar_summary" id="grammar_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap align-items-end">
                        <label for="">Vocabulary:</label>
                        <input type="text" name="vocabulary_summary" id="vocabulary_summary" class="form-control" placeholder="write here...">
                    </div>
                    <!-- /. Reading Form -->
					
					
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
                    <button type="submit" class="btn btn-primary">
                        <span><img src="{{ asset('public/images/icon-btn-save.svg')}}" alt="" class="img-fluid"></span>
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
				</form>
            </div>
        </div>
    </div>



<script type="text/javascript">
$('#noteModal').on('shown.bs.modal', function (e) {
	var activeCourse = $("#pills-tab li.nav-item .nav-link.active").attr("href");
	
	var activeCourseName = $("#pills-tab li.nav-item .nav-link.active").text();
	var activeCourseId = activeCourse.replace("#pills-","");
	$("#noteModal .modal-title span.text2").text(activeCourseName + " - NOTE");
	$("#noteModal #course_id").val(activeCourseId);
	
	$('#topic_id1').val('');
	$('#task_id').val('');
	
	
	$('#topic_id1 option').hide();
	$('#topic_id1 option').first().show();
	$('#topic_id1 option[data-courseid="'+activeCourseId+'"]').show();
	
	$('#task_id option').hide();
	$('#task_id option').first().show();
})
    $('#topic_id1').on('change',function(){
        var curTopicId = $('#topic_id1').val();
        $('#task_id').val('');
        $('#task_id option').hide();
        $('#task_id option').first().show();
        $('#task_id option[data-topicid="'+curTopicId+'"]').show();
        
    })


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
		skill_id: {
			required: !0,
		}	
	},
	errorElement: "div",
	errorClass: "invalid-feedback",
	submitHandler: function(form) {
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
</script>


<script>
$("#summary_form").validate({
	rules: {
		topic_id: {
			required: !0,
		}	
	},
	errorElement: "div",
	errorClass: "invalid-feedback",
	submitHandler: function(form) { 
	
		var textFields = false;
		$('#summary_form input[type="text"]').each(function(){
			if($(this).val() !== ""){
				textFields = true;
			}
		})
		if(!textFields){
			$("#error_message .error-text").text('Please fill at least one summary');
			$("#error_message").show();
			$("#success_message").hide();
			return false;
		}
	
		$("#summary_form").find("input[type='submit']").prop("disabled",true);
		$("#summary_form").find("input[type='submit']").attr("value","Submitting...");
		$("#summary_form").find("button[type='submit']").prop("disabled",true);
		$("#summary_form").find("button[type='submit']").text("Submitting...");
		$.ajaxSetup({
			  headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
		});
		$.ajax({
			type: "POST",
			url: '{{ URL("summary_post") }}',
			data : $("#summary_form").serialize(),
			dataType: "json",
			success: function(res) {
				if(!res.success){
					$("#error_message .error-text").text(res.message);
					$("#error_message").show();
					$("#success_message").hide();
					$("#summary_form").find("input[type='submit']").prop("disabled",false);
					$("#summary_form").find("input[type='submit']").attr("value","Save");
					$("#summary_form").find("button[type='submit']").prop("disabled",false);
					$("#summary_form").find("button[type='submit']").text("Sign In");
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
</script>