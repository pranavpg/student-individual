<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
$style="";
if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && empty($practise['dependingpractise_answer']) && !empty($practise['dependingpractiseid']) ){
  $depend =explode("_",$practise['dependingpractiseid']);
  $style= "display:none";
  
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    if(!empty($practise['user_answer'][0])){
      $user_ans = $practise['user_answer'][0];
    }
  }
?>
	<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
	     <p style="margin: 15px;">In order to do this task you need to have completed
	        <strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
	</div>
<?php
  } else { 
?>
<?php 
	if($practise['type']=='underline_text_multiple') {

		$answerExists = false;
		$encoded_answer = "";
		$underline=array();
		if(!empty($practise['user_answer'])){
			$answerExists = true;
			$user_answers = $practise['user_answer'][0];
			foreach ($user_answers as $key => $value) {
				$decoded_value = json_decode($value['underline']);
				array_push($underline, $decoded_value);
			}
		}
	?>
	<form class="form_{{$practise['id']}}">
	<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
	<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
	<input type="hidden" class="is_save" name="is_save" value="">
	<input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
	<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

	<?php
		if(!empty($practise['question'])) {
			$practise['question'] = str_replace("<br>", "\r\n", $practise['question']);
		 	foreach($practise['question'] as $key => $value) {
		 		if($value=="\r\n"){
					continue; 
				}
		 			$value  	= 	str_replace("  "," ",$value);
					$explode_question =  explode('\n', $value);
					?>
							<div class="text-with-bg multiple-choice mb-5 q{{$key}}">
								<h2 class="text-center">
									<input type="hidden" name="text_ans[0][{{$key}}][title]" value="<?php echo $explode_question[0] ?>">
									<input type="hidden" name="text_ans[0][{{$key}}][text]" value="{!! nl2br($explode_question[1]) !!}">
									{!! $explode_question[0] !!}
								</h2>
								<?php
								$underlineText = explode("\r\n",$explode_question[1]);
								$underlineText = array_filter($underlineText);
								$underlineText = array_merge($underlineText);
								?><div>
									<p class="mb-4 underline_text_list_item underline_text_list_item_n_{{$key}}" data-qno="{{$key}}">
										{!!nl2br($explode_question[1])!!}
									</p>
										</div>
							</div>
							 
					<?php
			}
		} else {

			// dd("Asdadsds");
			$outValue="";

			if(!empty($practise['depending_practise_details']['question']) && $practise['depending_practise_details']['question_type']=='writing_at_end_speaking_up' && !empty($practise['dependingpractise_answer'][0]['text_ans']))
				$exploded_dependent_question = explode(PHP_EOL, $practise['depending_practise_details']['question']);

				$userAnswer = $practise['dependingpractise_answer'][0]['text_ans'];
				//pr($userAnswer);
				$c=0;
				foreach($exploded_dependent_question as $key => $value){
					?>
							<div class="text-with-bg multiple-choice  q{{$c}}">
								<p>
									<input type="hidden" name="text_ans[0][{{$c}}][title]" value="{!! str_replace('@@','', $value) !!}">
								 	{!! str_replace('@@','', $value) !!}
								</p>
								@if(!empty($userAnswer[$key]))
								<input type="hidden" name="text_ans[0][{{$key}}][text]" value="{{ $userAnswer[$key] }}">
									<p style="margin-left:25px; color:blue;" class="mb-4 underline_text_list_item underline_text_list_item_n_{{$key}}" data-qno="{{$c}}">
										{!! str_replace('@@','', $userAnswer[$key]) !!}
									</p>
								@endif
							</div>
							@php 
								$c++;
							@endphp
					<?php

				}
		} 								 
	?>
	<?php } ?>
	</form>
<script>
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var end=0;
	var pid = "<?php echo $practise['id'] ?>"
	var testinc = 0;
	var st=0;
	$('.form_'+pid).find('.underline_text_list_item').each(function(key){
		var k=0;
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);
		var newWord 	= $this.first().text().trim();
		newWord 		= newWord.replace("  ","");
		var words 		= newWord.split(' ');
		for(var i=0; i<words.length;i++){
			var word = words[i].replace(/^\s+/,"");
			wordNumber = k;
			if(word!=""){
				if(i==0 && key==0){
						end=word.length;
				}else{
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
				var start 					= end-word.length
				var iName 					= "text_ans[0]["+testinc+"][underline]["+wordNumber+"][i]";
				var fColorName 				= "text_ans[0]["+testinc+"][underline]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[0]["+testinc+"][underline]["+wordNumber+"][foregroundColorSpan]";
				var wordName				= "text_ans[0]["+testinc+"][underline]["+wordNumber+"][word]";
				var startName 				= "text_ans[0]["+testinc+"][underline]["+wordNumber+"][start]";
				var endName 				= "text_ans[0]["+testinc+"][underline]["+wordNumber+"][end]";
				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
				$this.html(paragraph);
				k++;
				st++;
			}else{
				paragraph+="<br><br>";
				$this.html(paragraph);
			}
		}
		testinc++;
});
	var answers = '<?php echo addslashes(json_encode($underline,true)) ?>';
	if( answers!==undefined && answers!==null ){
    var l=0;
    var parsedAnswers = jQuery.parseJSON(answers);
		$.each(jQuery.parseJSON(answers), function(key, value) {
		   		$.each( value, function(k, v) {
		   			console.log('.form_'+pid+' .underline_text_list_item_n_'+l+ ' #'+v.i);
		    		$('.form_'+pid+' .underline_text_list_item_n_'+l).find('#'+v.i).addClass('bg-success');
		      		$('.form_'+pid+' .underline_text_list_item_n_'+l+' #'+v.i+' input').removeAttr('disabled');
	 			});
	   			l++;
		});
	}
	$('.form_'+pid).on( "click","span.highlight-text", function() {
		if($(this).hasClass('bg-success')){
			$( this ).removeClass( 'bg-success' );
			$(this).find('input').attr('disabled','disabled');
		} else {
			$( this ).addClass( 'bg-success' );
			$(this).find('input').removeAttr('disabled');
		}
	});
});
</script>
<?php }  ?>
<style type="text/css">
	.highlight-text{
		cursor: pointer;
	}
</style>