<!--Note Modal-->
<style>	 
	 .add-summary-modal .modal-header .modal-title__right .form-control{
		font-size: 1rem !important;	
	}
</style>
<?php // dd($CourseDetails); ?>
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog"
        aria-labelledby="noteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="noteModalLabel">
                        <i class="fas fa-file-alt"></i>
                        <span class="text2">NOTE</span>
                    </h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
                </div>
                
				<form id="my_form" action="" method="post">
                @csrf
                <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseIdCurrunt ?>" />
                <input type="hidden" name="level_id" id="level_id" value="" />

                <div class="modal-body">
                <!-- <input type="hidden" name="note_id" id="note_id" value="" > -->
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
                        <textarea type="text" id="title" name="title" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                    </div>

                    <h6>Description</h6>
                    <div class="form-group">
                        <textarea name="description" id="description" name="description" class="form-control" value="" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
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
                    <button type="submit" class="btn  btn-primary">
                    <i class="fa-regular fa-floppy-disk"></i>
                        Save
                    </button>
                    <button type="button" class="btn  btn-cancel" data-dismiss="modal" id="reset">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
$("#pills-tab").click(function(){
   $('#searchbox').val("").trigger('keyup').focus();
});
</script>
<script type="text/javascript">
function textAreaAdjust(element) {
  element.style.height = "1px";
  element.style.height = (25+element.scrollHeight)+"px";
}
</script>
<script>
// $('.alert-success').show().html(data.message).fadeOut(8000);
</script>
    <script type="text/javascript">
        var topicArray          = [];
        var taskArray           = [];
        var skillArray          = [];
        var searachArrayNew     = [];
        var regexReplace = /([,.€!?'&:])+/g;
        var data =  <?php echo json_encode($sessionAll['coursesWithAllData']['result']); ?>;
        var index =  <?php echo $curuntCourseKey; ?>;
        var skillsdata          =  <?php echo json_encode($skillsdata); ?>;
        console.log(index);
        
        console.log(data);


        function setOptions(){
                        let index1 = index;
                        let courseName = data[index1].course.coursetitle;
                        $('#course_name').text(courseName);    
                        let topics = data[index1].topics;
            // let topics = data[0].topics;
            let options = '<option value="" style="">Please Select Topic</option>';
            topics.forEach(function(topic,index){
                options += '<option value="'+topic._id+'" data-courseid="'+topic.course_id+'" style="">Topic '+topic.sorting+' : '+topic.topicname+'</option>';
            });
            // $('#topic_id').html("");
            $('#topic_id').html(options);
        }


        function openModelexampleModal(){
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('invalid-feedback');
            setOptions();

        }
        function resetSkill(){
            let options = '<option value="" style="">Please Select Skill</option>';
            $('#skill_id').html(options);
        }

        $('#topic_id').on('change',function(){
           // alert('topic id change');
            // resetTask();
            // resetSkill();
            let index1 = index;
            let topicId = $(this).val();
            // let topics = data[index].topics;
            let topics = data[index1].topics;
            let selectedTopic = topics.find(topic => topic._id == topicId);
            let tasks = selectedTopic.tasks;

            let options = '<option value="" style="">Please Select Task</option>';
            tasks.forEach(function(task,index){
                options += '<option value="'+task._id+'" data-courseid="'+task.course_id+'" style="">'+task.taskname+'</option>';
            });
            $('#task_id').html(options);
            
        });

        // $('#task_id').on('change',function(){
        //    // alert('task id change');
        //     let index1 = index;
        //     // let skills = data[index].skills
        //     let skills = data[index1].skills
        //     let options = '<option value="" style="">Please Select Skill</option>';
        //     skills.forEach(function(skill,index){
        //         options += '<option value="'+skill._id+'" style="">'+skill.skilltitle+'</option>';
        //     });
        //     // resetSkill();
        //     $('#skill_id').html(options);

        // });
        $('#task_id').on('change',function(){
            // let index1 = index;
            // let skills = data[index1].skillsdata
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
        // debugger;
        let LevelId = data[index].level._id;
        $("<input />").attr("type", "hidden")
                .attr("name", "level_id")
                .attr("value",LevelId)
                .appendTo("#my_form");
        console.log(LevelId);
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
                console.log(res)
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

$(".close-filter").click(function () {
    $(".filter-sidebar").toggleClass("openclose");
});


setTimeout(function(){
    $('.flash-message').fadeOut()
},5000)
</script>
