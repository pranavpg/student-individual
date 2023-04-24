<p>
	<strong><?php echo $practise['title']; ?></strong>
</p>
<?php
// echo "<pre>";
// print_r($practise);
// echo "</pre>";
// dd($practise);
// dd($practise);
?>

<?php
$exploded_question = explode(PHP_EOL, $practise['question']);

if(isset($practise['is_roleplay']) && $practise['is_roleplay'] == 1){
	// dd("1");

	?>
	@include('practice.reading_no_blanks_roleplay')
<?php  } else { 
	// dd("2");
	?>
	@include('practice.reading_no_blanks_regular')
<?php } ?>



@if(isset($practise["markingmethod"]) && ($practise["markingmethod"] == "student_self_marking" || $practise["markingmethod"] =="automated"))
@include('practice.common.student_self_marking')
@endif
@php 
$lastPractice=end($practises);
@endphp 
@if($lastPractice['id'] == $practise['id'])
@include('practice.common.review-popup')
@php
$reviewPopup=true;                
@endphp
@else
@php
$reviewPopup=false;                
@endphp
@endif

<script type="text/javascript">
	var sorting             = "{{ isset($topic_tasks_new)?$topic_tasks_new:$topic_tasks[0]['sorting'] }}";
	var courseType 		= "<?php echo $CourseDetails; ?>";
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
	
	// if(courseType == "GES" && sorting == 14){
	//     var facilityFeedback    = true;
	//     var courseFeedback      = false;         
	// }else if(courseType == "AES" && sorting == 29){
	//     var facilityFeedback    = true;
	//     var courseFeedback      = false;
	// }else{
	    // var facilityFeedback    = false;
	    // var courseFeedback      = true;
	// }
	if(level == "INTERMEDIATE"){
		if(courseType == "GES" && sorting == 14){
			var facilityFeedback    = true;
			var courseFeedback      = false;
		}else if(courseType == "GES" && sorting == 15){
			var facilityFeedback    = false;
			var courseFeedback      = true;
		}else if(courseType == "GES" && sorting == 30){
			var facilityFeedback    = false;
			var courseFeedback      = true;
		}else if(courseType == "GES" && sorting == 5){
			var facilityFeedback    = false;
			var courseFeedback      = true;
		}
	}else if(level == "ADVANCED"){
		if(courseType == "GES" && sorting == 15){
			var facilityFeedback    = false;
			var courseFeedback      = true;
		}
		if(courseType == "AES" && sorting == 5){
			var facilityFeedback    = false;
			var courseFeedback      = true;
		}
	}
	var id = "<?php echo $practise['id'];?>";

	$(document).on('click','#reading-no-blanks_form-<?php echo $practise['id'];?> .btnSubmits_reding' ,function(e) {
		if($(this).attr('data-is_save') == '1'){
			$(this).closest('.active').find('.msg').fadeOut();
		}else{
			$(this).closest('.active').find('.msg').fadeIn();
		}
		CommonAnsSet();
		var reviewPopup = '{!!$reviewPopup!!}';
		var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
		var is_roleplay = '<?php echo isset($practise["is_roleplay"])?$practise["is_roleplay"]:""; ?>';
		if(markingmethod =="student_self_marking") {

			if($(this).attr('data-is_save') == '1') {
				if(is_roleplay){
					var fullView= $("#reading-no-blanks_form-{{$practise['id']}}").html();          
				}else{
					var fullView= $("#reading-no-blanks_form-{{$practise['id']}}").html();                    
				}
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.spandata').each(function(){
					$(this).attr("contenteditable",false)
				})
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
				$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
				RoleplayOpen('<?php echo $practise['id'];?>');  
			}

		}
		
		if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
			$("#reviewModal_{{$practise['id']}}").modal('toggle');
		}

		e.preventDefault()

		$('#reading-no-blanks_form-<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);
		$.ajax({
			url: '<?php echo URL('reading-no-blanks'); ?>',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data: $('#reading-no-blanks_form-<?php echo $practise['id'];?>').serialize(),
			success: function (data) {
				$('.btnSubmits').removeAttr('disabled');
				if(data.success){
					if(is_save=="1"){
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
          setTimeout(function(){
          	$('.alert-success').hide();
          	var isNextTaskDependent =  $('.nav-link.active').parent().next().find('a').attr('data-dependent');
            // alert(isNextTaskDependent);
            if( isNextTaskDependent == 1 ){
            	var dependentPractiseId =  $('.nav-link.active').parent().next().find('a').attr('data-id');
            	var baseUrl = "{{url('/')}}";
            	var topic_id = "{{request()->segment(2)}}";
            	var task_id = "{{request()->segment(3)}}";
                //window.location.href=baseUrl+'/topic/'+topic_id+'/'+task_id+'?n='+dependentPractiseId
              ////$('#abc-'+dependentPractiseId+'-tab').trigger('click');
            } else {
               //$('.nav-link.active').parent().next().find('a').trigger('click');
             }
           //  setTimeout(function(){
           //  location.reload();
          	// },2000);
          },2000);
          // =========================== START : TO SHOW NEXT PRACTICE AFTER SUBMIT ========================//
        }
        $('.alert-danger').hide();
        $('.alert-success').show().html(data.message).fadeOut(8000);
      }else{
      	$('.alert-success').hide();
      	$('.alert-danger').show().html(data.message).fadeOut(8000);
      }

    }
  });
	});

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

	// $("#reading-no-blanks_form-"+id+" .s-button-box,.s-button-"+id+"").removeClass("d-none");
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
	// two click js
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
	/*$("#p-button").click(function () {
		$("#police, #s-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});

	$("#s-button").click(function () {
		$("#suspect, #p-button").toggleClass("d-none");
		$(this).toggleClass('btn-bg');
	});*/
});

function CommonAnsSet(){
	$('.spandata').each(function(){
		$(this).next().val( $(this).html() )
	})
}

var flag = true;
$(document).on('keyup','.spandata',function() {
	var value = $(this).html().trim().length
	if(value == "") {
		$(this).css("min-width","3ch");
	} else {
		if(value == "1" || value == "2" || value == "3") {
			$(this).css("min-width","1ch");
		} else {
			if(flag) {
				flag = false;
				$(this).css("min-width","3ch");
			}
		}
	}
});

$(document).ready(function(){
	if("{{$practise['id']}}" == "15566123695cc805110182b"){
		$("#dependant_pr_new_{{$practise['id']}}").show();
	}
	$('#openmodal').click(function(){
		$('#myModal').modal("show")
		return false;
	});



});
</script>

<style type="text/css">

	*[contenteditable]:empty:before
	{
		content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}

	.appendspan {
		color:red;
	}
	.stringProperNew{
		white-space: pre;
	}

</style>