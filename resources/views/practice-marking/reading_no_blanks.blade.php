<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>
<?php
$exploded_question = explode(PHP_EOL, $practise['question']);
if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){
	?>
	@include('practice.reading_no_blanks_roleplay')
	<?php  
} else {
	?>
	@include('practice.reading_no_blanks_regular')
<?php } ?>
<script type="text/javascript">
	var sorting 		= "<?php echo isset($topic_tasks[0]['sorting'])?$topic_tasks[0]['sorting']:''; ?>";
	var courseType 		= "<?php echo isset($CourseDetails)?$CourseDetails[$sessionAll['topics'][$topicId]['course_id']]['title']:""; ?>";
	var courseType 		= courseType.split("-");
	var level           = courseType[1];
	var courseType 		= courseType[0];
	var feedbackPopup   = true;
	$(".stringProper").on({
	    keydown: function(e) {
	        if(e.key === ";" || e.key === "&" ||e.key === ")" ||e.key === "(" ) {
	            return false;
	        }
	    }
	});
	$('.stringProper').on("cut copy paste",function(e) {
      	e.preventDefault();
   	});
	var id = "<?php echo $practise['id'];?>";
	function RoleplayOpen(id){
		$("#selfMarking_"+id+" .s-button-"+id).on("click",function(){
			if($("#selfMarking_"+id+" .s-button-"+id+".d-none").length > 0){
				$("#selfMarking_"+id+" .s-button-"+id+".d-none");
				$("#selfMarking_"+id+" .s-button-box").addClass("d-none");
				$("#selfMarking_"+id+" .s-button-"+id+"").removeClass("d-none").removeClass("btn-bg");
				return false;
			}
			$("#selfMarking_"+id+" .s-button-"+id+"").addClass("d-none");
			$(this).removeClass("d-none").addClass("btn-bg");
			var curId = $(this).attr("id");
			curId = curId.replace("s-button-","");
			$("#selfMarking_"+id+" #s-button-"+curId+curId).removeClass("d-none");
		});
	}
	$(function () {
		$(".selected_option").click(function () {
		    var content_key = $(this).attr('data-key');
		    if( $('.selected_option_description:visible').length>0 ){
		      $('.is_roleplay_submit').val(0);
		    }else{
		      $('.is_roleplay_submit').val(1);
		    } 
		});
		$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").on("click",function(){
			if($("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none").length > 0){
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>.d-none");
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-box").addClass("d-none");
				$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-<?php echo $practise['id'];?>").removeClass("d-none").removeClass("btn-bg");
				return false;
			}
			$("#reading-no-blanks_form-<?php echo $practise['id'];?> .s-button-box,.s-button-<?php echo $practise['id'];?>").addClass("d-none");
			$(this).removeClass("d-none").addClass("btn-bg");
			var curId = $(this).attr("id");
			curId = curId.replace("s-button-","");
			$("#reading-no-blanks_form-<?php echo $practise['id'];?> #s-button-"+curId+curId).removeClass("d-none");
		})
	});
	function CommonAnsSet(){
		$('.spandata').each(function(){
			$(this).next().val( $(this).html() )
		})
	}
	var flag = true;
	$(document).on('keyup','.spandata',function(){
			var value = $(this).html().trim().length
			if(value == ""){
			$(this).css("min-width","3ch");
		}else{
		  	if(value == "1" || value == "2" || value == "3"){
		  		$(this).css("min-width","1ch");
		  	}else{
		  		if(flag){
					flag = false;
					$(this).css("min-width","3ch");
		  		}
		  	}
		}
	});
  	$(document).ready(function(){
	    $('#openmodal').click(function(){
	        $('#myModal').modal("show")
	        return false;
	    });
  	});
  	$(document).ready(function(){
  		// 15531790115c93a183ccf6f
  		if("{{$practise['id']}}" == "15531790115c93a183ccf6f"){
	    	$(document).find("#reading-no-blanks_form-"+"{{$practise['id']}}").find('.s-button-15531790115c93a183ccf6f').css('pointer-events','auto');
  		}
  	});
</script>
<style type="text/css">
  	*[contenteditable]:empty:before {
	    content: "\feff";
	}
	.resizing-input1 {
		margin-left: -3px;
		margin-right: -3px;
	}
	.appendspan {
	 	color:red;
	}
</style>