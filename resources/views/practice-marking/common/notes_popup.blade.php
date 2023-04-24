<!--Note Modal-->
<style>	 
	 .add-summary-modal .modal-header .modal-title__right .form-control{
		font-size: 1rem !important;	
	}
</style>
<?php // dd($CourseDetails); ?>
<div class="modal fade add-summary-modal" id="noteModal" tabindex="-1" role="dialog"
        aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">		  
				<form id="my_form" action="" method="post">				
				<input type="hidden" name="course_id" id="course_id" value="<?php echo Session::get('activecourse');?>" />				
                <div class="modal-header align-items-center">
                    <h6 class="modal-title" id="noteModalLabel">
                        <span><img src="{{ asset('public/images/icon-heading-notes.svg')}}" alt="" class="img-fluid"></span>
                        <span class="text2">GES - NOTE</span>
                    </h6>
                    <div class="modal-title__right form-inline" style="max-width:80%;">
                        <div class="form-group mb-2 col-sm-4">
						<?php $acn = Session::get('activecoursename');?>
					 	<select id="topic_id" name="topic_id" class="form-control">
								<option value="">Please Select Topic</option>								 
								<?php foreach($common_all_topics_with_ges_aes[$acn] as $topicId=>$topic){?>
									<option value="<?php echo $topic['id'];?>" data-courseid="<?php echo $topic['course_id'];?>">
                                    <?php echo "Topic&nbsp;".$topic['sorting']." : ".$topic['title'];?></option>
								<?php }?>
                            </select>
                        </div>

                        <div class="form-group mb-2 col-sm-4">
                            <select id="task_id" name="task_id" class="form-control">
								<option value="">Please Select Task</option>
								<?php foreach($sessionAll['tasks'] as $taskId=>$task){?>
									<option value="<?php echo $taskId;?>" data-courseid="<?php echo $task['course_id'];?>" data-topicid="<?php echo $task['topic_id'];?>" ><?php echo $task['title'];?></option>
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

	<script type="text/javascript">
	var topicsData = '<?php echo addslashes(json_encode($common_all_topics_with_ges_aes));?>';
	 
	function openModelexampleModal(){
		var topicsDataJq = JSON.parse(topicsData);	 
		var filterGes = $('.aes_ges_parent li a.active').html();	
		var options = '<option value="" style="">Please Select Topic</option>';
		$('#topic_id').html("");
		topicsDataJq[filterGes.toLowerCase()].forEach(function(entry) {			
			options += '<option value="'+entry.id+'" data-courseid="'+entry.course_id+'" style="">Topic'+entry.sorting+':'+entry.title+'</option>';			
		});
		$('#topic_id').html(options);		
		$('#exampleModal').modal("show");
	}
	
$('#noteModal').on('shown.bs.modal', function (e) {
	var course_id = $('#course_id').val(); 
	$("#noteModal .modal-title span.text2").text(newData + " - NOTE");

	$('#topic_id').val('');
	$('#task_id').val('');

	$('#topic_id option').hide();
	$('#topic_id option').first().show();
	$('#topic_id option[data-courseid="'+course_id+'"]').show();
	
	$('#task_id option').hide();
	$('#task_id option').first().show();
	
 })
    $('#topic_id').on('change',function(){
        var curTopicId = $('#topic_id').val();
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
		} ,
		skill_id: {
			required: !0,
		} 
	},
	messages: {
    title: "Please add note title!",  
    description: "Please add note descriptions!", 
    topic_id: "Please select topic!",  
    task_id: "Please select task!",               
    skill_id: "Please skill task!",               
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


