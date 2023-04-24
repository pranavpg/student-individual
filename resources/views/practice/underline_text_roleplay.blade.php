<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// dd($practise);
 $user_answer = "";
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	$answerExists = true;
	$practice_user_answer = $practise['user_answer'];
	$user_answer=array();
	$i = 0;
	foreach($practice_user_answer as $key => $value) {
		if($value=="##" || $value=="" ){
		//	$user_answer[$key] = "##";
		} 
		else {
			$user_answer[$i] = json_decode($value[0][0],JSON_OBJECT_AS_ARRAY);
		}
		$i++;
	}
	// dd($user_answer);
  }
?>
<?php
$style="";
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){ 
  $depend =explode("_",$practise['dependingpractiseid']);
  $style= "display:none";
  //pr($practise);
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    if(!empty($practise['user_answer'][0])){
      $user_answer = $practise['user_answer'];
    }
  }
?>
    <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
         <p style="margin: 15px;">In order to do this task you need to have completed
            <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
<?php
  } else {

    $exploded_question_roleplay = explode('##',$practise['question']);
    $exploded_question_roleplay_option = explode('@@',$exploded_question_roleplay[0]);
    //  $exploded_question = explode(PHP_EOL,$exploded_question_roleplay[1]);
    //  $question = array_pop($exploded_question);
   array_shift($exploded_question_roleplay);
   // dd($exploded_question_roleplay);  
  }
?>
 
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
	<form class="save_underline_text_form_{{$practise['id']}}">
		<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
		<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
		<input type="hidden" class="is_save" name="is_save" value="">
		<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
		<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
		<input type="hidden" name="is_roleplay" value="true" >
		<input type="hidden" class="dependancy_practise_id" name="dependancy_practise_id" value="{{$practise['id']}}">
	    <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

		<?php
			if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
			$depend =explode("_",$practise['dependingpractiseid']);
		?>
			<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
			<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
		<?php } ?>
			<div class="component-two-click mb-4">

				@if(!empty($exploded_question_roleplay_option))
				<div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
					@foreach($exploded_question_roleplay_option as $key => $value)
						<a href="javascript:void(0)" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
					@endforeach
				</div>
				@endif
				<div class="two-click-content w-100">
					@if(!empty($exploded_question_roleplay))
						<?php
							$j = 0;
							$count=0;
							$last_key = array_key_last($exploded_question_roleplay);
						?>

						@foreach($exploded_question_roleplay as $key=> $que)
						<div  {{$key}} class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$key}} selected_option_description_remove_{{$key}}"  >
							<ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
								<?php 
									$exploded_question  =  explode("<br>", $que);
									$exploded_question = array_filter($exploded_question);
									$exploded_question = array_merge($exploded_question);
									// dd($exploded_question);
									if(!empty($exploded_question)){
										foreach($exploded_question as $k => $v){
											if( !empty(trim($v)) ) { ?>
												<li class="list-item underline_text_list_item" data-part="{{$key}}">
													{!! $v !!}
												</li> 
												<?php
											}
										}
									}
						
								?>
							</ul>
						</div>
						
						<?php $j++;
							if($last_key!=$key ){
						?>
							<input type="hidden" name="text_ans[{{$j}}]" value="##">
						<?php } $j++; $count++;?>
						@endforeach
					@endif
				</div>
			</div>

		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
		<ul class="list-inline list-buttons">
			<li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
					data-toggle="modal" data-is_save="0" data-target="#exitmodal"  >Save</button>
			</li>
			<li class="list-inline-item"><button type="button"
					class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1" >Submit</button>
			</li>
		</ul>
	</form>
</div>

@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
	@include('practice.common.review-popup')
@endif

<script>
$(document).ready(function(){

	$(".save_underline_text_form_{{$practise['id']}}").find(".selected_option").click(function () {

		var content_key = $(this).attr('data-key');
		$(".save_underline_text_form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
		$(".save_underline_text_form_{{$practise['id']}}").find('.selected_option_description_'+content_key).toggleClass('d-none');
		$(".save_underline_text_form_{{$practise['id']}}").find('.selected_option_'+content_key).show();
		$(this).toggleClass('btn-bg');
	
		if( $('.selected_option_description:visible').length>0 ){
		var ans_key = (content_key == 0) ? 0 : 2;
		$(".save_underline_text_form_{{$practise['id']}}").find('.prev_ans_'+ans_key).show();
		$(".save_underline_text_form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
		}else{
		$(".save_underline_text_form_{{$practise['id']}}").find('.prev_ans_0').hide();
		$(".save_underline_text_form_{{$practise['id']}}").find('.prev_ans_2').hide();
		$(".save_underline_text_form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
		}

	});

	var wordNumber;

	
	var pid = "<?php echo $practise['id'] ?>"

	for(var l=0;l<2;l++){

		$('.selected_option_description_'+l+' ul').each(function(index){
			var card = index;
			if(index>0){
				 card = index+1;
			}
			// alert(card);
			var k = 0;
			var end = 0;
			var $thisCard = $(this);
			$thisCard.find('.underline_text_list_item').each(function(key){
				
				// console.log(index,'index===>', key)
				var paragraph="";
				var str = $(this).text();
				var $this = $(this);
				str.replace(/[ ]{2,}/gi," ");
				$this.attr('data-total_characters', str.length);
				$this.attr('data-total_words', str.split(' ').length);

				var words = $this.first().text().trim().split(' ');


				var newWord 	= $this.first().text().trim();
				newWord 		= newWord.replace("  ","");
				var words 		= newWord.split(' ');


				for(var i=0; i<words.length;i++){
					var word = words[i].replace(/^\s+/,"");
					wordNumber = k;
					if(word.trim()!=""){
						if(i==0 && key==0){
								end=word.length;
						} else {
							if(key>=1){

								if(i==0){
									end+=word.length;
									end+= 3
								} else{
									end+=word.length;
									end++;
								}

							} else {

								end+=word.length;
								end++;

							}
						}
						if(l==1){
							l = 2;
						}
						var start 					= end-word.length
						var iName 					= "text_ans["+l+"][0][0]["+wordNumber+"][i]";
						var fColorName 				= "text_ans["+l+"][0][0]["+wordNumber+"][fColor]"
						var foregroundColorSpanName = "text_ans["+l+"][0][0]["+wordNumber+"][foregroundColorSpan]";
						var wordName 				= "text_ans["+l+"][0][0]["+wordNumber+"][word]";
						var startName 				= "text_ans["+l+"][0][0]["+wordNumber+"][start]";
						var endName 				= "text_ans["+l+"][0][0]["+wordNumber+"][end]";

						paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word.replace(/^\s+/,"")+"</span>"
						$this.html(paragraph);
					}
					k++;
				}
				//var text = words.join( "</span> <span class='highlight-text'>" );
			});
		});
	}
	
	var t = 0;
	for(var l=0;l<=1;l++){

		var answers = '<?php echo json_encode($user_answer) ?>';

		if( answers !=""){

			var parsedAnswer = JSON.parse(answers);
			if( parsedAnswer!==undefined && parsedAnswer!==null ){

				var o=0;
				console.log(parsedAnswer[t]);
				$.each(parsedAnswer[t], function(key, value) { 
					// console.log('.selected_option_description_'+l+' # '+value.i);
						$('.selected_option_description_'+l).find('#'+value.i).addClass('bg-success');
						$('.selected_option_description_'+l).find('#'+value.i).find('input').removeAttr('disabled');

		// console.log(key)
					/*$.each(value, function(k, v) {
						// console.log(k)
						// $('.save_underline_text_form_'+pid).find('.selected_option_description_'+v.i).find('#'+v.i).addClass('bg-success');
						// $('.save_underline_text_form_'+pid).find('.selected_option_description_'+v.i).find('#'+v.i).find('input').removeAttr('disabled');
alert(value.i)
						$('.selected_option_description_'+l).find('#'+value.i).addClass('bg-success');
						$('.selected_option_description_'+l).find('#'+value.i).find('input').removeAttr('disabled');
					});*/
				});
				
				t = t+2;
			}
		}
	}	
	

	$('.save_underline_text_form_'+pid).on( "click","span.highlight-text", function() {
		if($(this).hasClass('bg-success')){
			$( this ).removeClass( 'bg-success' );
			$(this).find('input').attr('disabled','disabled');
		} else {
			$( this ).addClass( 'bg-success' );
			$(this).find('input').removeAttr('disabled');
		}
	});

	$('.save_underline_text_form_'+pid).on('click','.submitBtn_'+pid ,function() {
		if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
		$('.submitBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);

		$.ajax({
				url: '<?php echo URL('save-underline-text-roleplay'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $('.save_underline_text_form_'+pid).serialize(),
				success: function (data) {
					$('.submitBtn_'+pid).removeAttr('disabled');
					if(data.success){
						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(8000);
					} else {
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(8000);
					}
				}
		});
	});
});



</script> 
<style type="text/css">
	.highlight-text{
		cursor: pointer;
	}
</style>