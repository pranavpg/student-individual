<p>
	<strong>{{$practise['title']}}</strong>
	<?php
    $answerExists = false;
		$writing_text  ="";
		if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
	      $answerExists = true;
				$answers = json_decode($practise['user_answer'][0][0], true);
				$writing_text  = !empty($practise['user_answer'][1][0])?$practise['user_answer'][1][0]:"";
	    }
     	$practise['question'] 	= str_replace("<br>", "\r\n", $practise['question']);
		$exploded_question  	=  explode('/t', $practise['question']);

		$writing_question = $exploded_question[0];
		$highlight_question = [];
		
		if(isset($exploded_question[1])){
			$highlight_question =explode(PHP_EOL,  $exploded_question[1]);
		}
		$tempQue = [];
		foreach ($highlight_question as $key => $value) {
			if($value!="\r"){
				array_push($tempQue,$value);
			}
		}
		$highlight_question =$tempQue; 

	?>
</p>
<form class="save_underline_text_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
			@if(!empty($highlight_question))
				@foreach($highlight_question as $key => $value)
					@if(!empty($value))
						<li class="list-item underline_text_list_item"  data-qno="{{$key}}" >
							
							{!!	nl2br($value) !!}
						</li>
					@endif
				@endforeach
			@endif
  </ul>
  <p>{!!$writing_question!!}</p>
	@if($practise['type']=="underline_text_writing")
		<p></p>
		<div class="form-slider p-0 mb-4">
		    <div class="component-control-box">
					<span class="textarea form-control form-control-textarea main-answer" role="textbox" contenteditable placeholder="Write here...">
						{{$writing_text}}
					</span>
					<div style="display:none">
						<textarea name="text_ans[1][0]" class="main-answer-input">{{$writing_text}}</textarea>
					</div>
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
	$('.save_underline_text_form_'+pid).find('.underline_text_list_item').each(function(key) {
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);
		var newWord = $this.first().text().trim()
		var words = newWord.split(' ');
		for(var i=0; i<words.length;i++){
			var word = words[i].replace(/^\s+/,"");
			wordNumber = k;
			if(word.trim()!="") {
				if(i==0 && key==0) {
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
	var answers='<?php echo !empty($practise["user_answer"])?$practise["user_answer"][0][0]:"" ?>';
	if( answers !=""){
		var parsedAnswer = JSON.parse(answers);
		if( parsedAnswer!==undefined && parsedAnswer!==null ){
			$.each(parsedAnswer, function(key, value) {
				 $('.save_underline_text_form_'+pid).find('#'+value.i).addClass('bg-success');
				 $('.save_underline_text_form_'+pid).find('#'+value.i).find('input').removeAttr('disabled');
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
	.highlight-text{
		cursor: pointer;
	}
</style>
