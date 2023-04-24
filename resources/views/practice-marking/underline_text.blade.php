<p>
	<strong>{!!$practise['title']!!}</strong>
	<?php
		$user_answer="";
      	$answerExists = false;
      	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
			$answerExists = true;
			$user_answer = !empty($practise['user_answer'][0][0])?$practise['user_answer'][0][0]:"";
			$answers = json_decode($user_answer, true);
      	}

      	if(isset($practise['question'])){
			$practise['question']  	= 	str_replace("\r\n"," ",$practise['question']);
			$practise['question']  	= 	str_replace("  "," ",$practise['question']);
			$exploded_question  	=  	explode("<br>", $practise['question']);
			$tempQue = [];
			foreach ($exploded_question as $key => $value) {
				if($value!="\r"){
					array_push($tempQue,$value);
				}
			}
			$exploded_question =$tempQue; 
      	}else{
			$exploded_question =[]; 
      	}
	?>
</p>
<form class="save_underline_text_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
  		<?php 
  		if(empty($practise['dependingpractise_answer'])){
  		?>
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if( !empty(trim($value)) )
						<li class="list-item underline_text_list_item" >
							{!! $value !!}
						</li>
					@endif
				@endforeach
			@endif
		<?php 
	}
		 
			if(!empty($practise['dependingpractise_answer'])){
				if($practise['typeofdependingpractice'] == "get_answers_put_into_quetions"){
					$que = explode(PHP_EOL, $practise['depending_practise_details']['question']);
					$que = array_filter($que);
					$que = array_merge($que);
					$ans = explode(";", !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[]);
					$question = [];
					$p=0;
					$practise['depending_practise_details']['question']  	= 	str_replace("  "," ",$practise['depending_practise_details']['question']);
					$outValue = "";
					$d=0;
					$outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$answer, &$data, &$question, &$k, &$d, &$ans, &$que, &$practise) {
						$newanst = isset($ans[$d])?$ans[$d]:'';
						
						$str =$newanst;
                       	$d++;
						return $str;
					}, $practise['depending_practise_details']['question']);
					foreach($que as $key=>$data){
							$finalAns = str_replace("@@",$ans[$p] ,$data);
							array_push($question, $finalAns);
							if(str_contains($data,'@@')) {
								$p++;
							}
					}

					$que  	=  	explode("\r\n", $outValue);

					$que = array_filter($que);
					$que = array_merge($que);
					foreach($que as $key => $value){
						if($value !="\r\n"){


							?>
							<li class="list-item underline_text_list_item" >
								{!! trim($value) !!}
							</li><?php
					
						}
					}
				}elseif($practise['typeofdependingpractice'] == "get_answers_generate_quetions"){
					$ans = !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
					foreach($ans as $key => $value){
						if( !empty(trim($value)) ){
							?>
							<li class="list-item underline_text_list_item" >
								{!! $value !!}
							</li><?php
						}
					}
				}
			}else{
					if(isset($practise['dependingpractise_answer']) && empty($practise['dependingpractise_answer']) && $practise['typeofdependingpractice'] != "set_full_view"){
										$depend =explode("_",$practise['dependingpractiseid']);
									
									?>

									<input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
									<input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

									<div id="dependant_pr_new_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
										<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
									</div>
					<?php }
			}
		?>	
  </ul>
	@if($practise['type']=="underline_text_writing")
		<p></p>
		<div class="form-slider p-0 mb-4">
		    <div class="component-control-box">
		        <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">
				</span>
		    </div>
		</div>
	@endif
</form>
<script>
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var k=0;
	var end=0;
	var pid = "<?php echo $practise['id'] ?>"
	$('.list-texthighlighted').find('.underline_text_list_item').each(function(key){
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);
		var newWord = $this.first().text().trim()

		// newWord = newWord.replace(" ",'');
		
		var words 	= newWord.split(' ');//split( /\s+/ );
    
		for(var i=0; i<words.length;i++){
			var word = words[i];
			console.log(word);
			wordNumber = k;
			if(word.trim()!=""){
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
					}
				}
				var start = end-word.length
				var iName= "text_ans[0][0]["+wordNumber+"][i]";
				var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
				var wordName="text_ans[0][0]["+wordNumber+"][word]";
				var startName = "text_ans[0][0]["+wordNumber+"][start]";
				var endName = "text_ans[0][0]["+wordNumber+"][end]";

				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word.replace(/^\s+/,"")+"</span>"
				$this.html(paragraph);
			}
		
			k++;
		}
	});
	var answers='<?php echo addslashes($user_answer) ?>';

	if( answers !=""){
		var parsedAnswer = JSON.parse(answers);
		if( parsedAnswer!==undefined && parsedAnswer!==null ){
			$.each(parsedAnswer, function(key, value) {
				 $('.list-texthighlighted').find('#'+value.i).addClass('bg-success');
				 $('.list-texthighlighted').find('#'+value.i).find('input').removeAttr('disabled');
			});
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

});
</script>
<style type="text/css">
	.list-texthighlighted{
		cursor: pointer;
	}
</style>
