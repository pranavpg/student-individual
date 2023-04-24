 <!--summary Modal-->
 <style>
	 .add-summary-modal .modal-body .reading-form label{
		font-size: 1rem !important;	
		padding: 6px 0 0 0;
	 }
	.add-summary-modal .modal-body .reading-form .form-control{
		font-size: 1rem !important;	
	}
</style>
<?php
// echo "<pre>";
// dd(Request::segment(2));
// echo "</pre>";
?>
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
                        	<?php 
 
                        	$student_aes_level = Session::all()['user_data']['student_aes_level'];
							$student_ges_level = Session::all()['user_data']['student_ges_level'];
							$common_all_topics_with_ges_aes = [];
							foreach(Session::all()['topics'] as $data) {
								if($data['level_id'] == $student_aes_level){
									$common_all_topics_with_ges_aes['aes'][] = $data;
								}else if($data['level_id'] == $student_ges_level){
									$common_all_topics_with_ges_aes['ges'][] = $data;
								}
							}
							// echo "<pre>";
       //                  		print_r($common_all_topics_with_ges_aes[Session::all()['activecoursename']]);
       //                  	echo "</pre>";
							$selecetedOption ="";
                        	?>
                            <select id="topic_id1" name="topic_id1" class="form-control" style="font-size: 1.0rem !important;" disabled="true">
								<option value="">Please Select Topic</option>
								<?php foreach($common_all_topics_with_ges_aes[Session::all()['activecoursename']] as $topicId=>$topic){
										$seleced = "";
										if(null !==Request::segment(2)) {
											if(Request::segment(2) == $topic['id']){
												$seleced = "selected";
												$selecetedOption =$topic['id'];					
											}
										}
									?>
									<option <?php echo $seleced; ?> value="<?php echo $topic['id'];?>" data-courseid="<?php echo $topic['course_id'];?>"><?php echo $topic['title'];?></option>
								<?php }?>
                            </select>

							
								<input id="topic_id" name="topic_id"  type="hidden" value="<?php echo $selecetedOption;?>" >
                           </div>
                    </div>
                </div>
                <div class="modal-body">
                    <h3>What you have learned from this topic?</h3>
                    <div class="reading-form d-flex flex-wrap">
                        <label for="">Reading:</label>
                        <!-- <input type="text" name="reading_summary" id="reading_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="reading_summary" id="reading_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['reading_summary'])?$topicWiseSummary['reading_summary']:"":""; ?></textarea>
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap">
                        <label for="">Writing:</label>
                        <!-- <input type="text" name="writing_summary" id="writing_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="writing_summary" id="writing_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['writing_summary'])?$topicWiseSummary['writing_summary']:"":""; ?></textarea>
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap">
                        <label for="">Speaking:</label>
                        <!-- <input type="text" name="speaking_summary" id="speaking_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="speaking_summary" id="speaking_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['speaking_summary'])?$topicWiseSummary['speaking_summary']:"":""; ?></textarea>
                    </div>
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap">
                        <label for="">Listening:</label>
                        <!-- <input type="text" name="listening_summary" id="listening_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="listening_summary" id="listening_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['listening_summary'])?$topicWiseSummary['listening_summary']:"":""; ?></textarea>
                    </div>
                   
                    <!-- /. Reading Form -->

                    <div class="reading-form d-flex flex-wrap">
                        <label for="">Vocabulary: </label>
                        <!-- <input type="text" name="vocabulary_summary" id="vocabulary_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="vocabulary_summary" id="vocabulary_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['vocabulary_summary'])?$topicWiseSummary['vocabulary_summary']:"":""; ?></textarea>
                    </div>
					 <!-- /. Reading Form -->

					 <div class="reading-form d-flex flex-wrap">
                        <label for="">Grammar:</label>
                        <!-- <input type="text" name="grammar_summary" id="grammar_summary" class="form-control" placeholder="write here..."> -->
                        <textarea name="grammar_summary" id="grammar_summary" class="form-control" placeholder="write here..." oninput="auto_grow(this)"><?php echo !empty($topicWiseSummary)?isset($topicWiseSummary['grammar_summary'])?$topicWiseSummary['grammar_summary']:"":""; ?></textarea>
                    </div>
                    <!-- /. Reading Form -->
					
					
					<div class="form-group form-group__verification_error" id="error_message2" style="display:none;">
					<em class="d-flex">
						<span class="error-img">
							<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
						</span>
						<span class="error-text1"></span>
					</em>
				</div>
				
				
				<div class="form-group form-group__verification_success" id="success_message1" style="display:none;">
					<em class="d-flex">
						<span class="success-img">
							<img src="{{ asset('public/images/icon-invalid-code.svg') }}" alt="">
						</span>
						<span class="success-text1"></span>
					</em>
				</div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <span><img src="{{ asset('public/images/icon-btn-save.svg')}}" alt="" class="img-fluid"></span>
                        Save
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
				</form>
            </div>
        </div>
    </div>
    <style type="text/css">
    	.add-summary-modal textarea {
		    resize: none;
		    overflow: hidden;
		    /*min-height: 50px;
		    max-height: 100px;*/
		}
    </style>
    <script>
		$('.add-summary-modal textarea').each(function () {
			$(this).css("height",$(this).val().split(/\r?\n/).length*30+"px")
		});
    	function auto_grow(element) {
		    element.style.height = "5px";
		    element.style.height = (element.scrollHeight)+"px";
		}
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
		$('#summary_form textarea').each(function(){
			if($(this).val() !== ""){
				textFields = true;
			}
		});
		if(!textFields){
			$("#error_message2 .error-text1").text('Please fill at least one summary');
			$("#error_message2").show();
			$("#success_message1").hide();
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
		// console.log($("#summary_form").serialize());
		// return false;
		$.ajax({
			type: "POST",
			url: '{{ URL("summary_post") }}',
			data : $("#summary_form").serialize(),
			dataType: "json",
			success: function(res) {
				console.log(res)
				if(!res.success){
					$("#error_message2 .error-text1").text(res.message);
					$("#error_message2").show();
					$("#success_message1").hide();
					$("#summary_form").find("input[type='submit']").prop("disabled",false);
					$("#summary_form").find("input[type='submit']").attr("value","Save");
					$("#summary_form").find("button[type='submit']").prop("disabled",false);
					$("#summary_form").find("button[type='submit']").text("Sign In");
				}else{
					$("#success_message1").show();
					$("#success_message1 .success-text1").text(res.message);
					// $("#error_message2").show();
					setTimeout(function(){
						window.location.reload();
					$("#error_message2").hide();
					},1000);
				}
				
			}
		});
		return false;								
	}
})
</script>