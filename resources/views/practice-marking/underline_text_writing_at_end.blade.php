<p>
	<strong>{!! $practise['title']!!}</strong>
	<?php
	$answerExists = false;
	$decoded_answer = "";
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$answerExists = true;
		if($practise['type']=="underline_text"){
			$answers = $practise['user_answer'][0][0];
		}
		if($practise['type']=="underline_text_writing_at_end"){
			$answers = $practise['user_answer'][0][0];
			$underline_answers = $practise['user_answer'][0][1];
			$encode_answer=array();
			foreach ($underline_answers as $key => $value) {
				array_push($encode_answer,json_decode($value));
			}
			$decoded_answer = json_encode($encode_answer);
		}
    }
	$exploded_question  =  explode(PHP_EOL, $practise['question']);
	?>
</p>
<form class="save_underline_text_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
@if($practise['type']=="underline_text")
  <ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if( !empty(trim($value)) )
						<li class="list-item underline_text_list_item" >
							{!! str_replace(' @@','',$value) !!}
						</li>
					@endif
				@endforeach
			@endif
  </ul>
@endif
@if($practise['type']=="underline_text_writing_at_end")

	<div class="multiple-choice"  id="{{$practise['id']}}" >
		@if(!empty($exploded_question))
		<?php $j=0; ?>
			@foreach($exploded_question as $key => $value)
				@if( !empty(trim($value)) ) 
					@if(str_contains($value,'@@'))
						<div class="choice-box q{{$j}}" >
							<p class="mb-0 underline_text_list_item" data-qno="{{$j}}">{!! str_replace(' @@','',$value) !!}</p>
							<div class="form-group">
								<span class="textarea form-control form-control-textarea" role="textbox" contenteditable disabled placeholder="Write here...">
									<?php
										if ($answerExists) {
											echo  $practise['user_answer'][0][0][$j];
										}
									?>
								</span>
								<div style="display:none">
									<textarea name="text_ans[0][0][{{$j}}]">
									<?php
										if ($answerExists) {
											echo  $practise['user_answer'][0][0][$j];
										}
									?>
									</textarea>
								</div>
							</div> 
						</div>  
						<?php $j++; ?>
					@else
					<input type="hidden" name="text_ans[0][0][{{$j}}]" >
					<input type="hidden" name="text_ans[0][1][{{$j}}]" >
					<p class="mb-0">{!! $value !!}</p>
					<?php $j++; ?>
					@endif
				@endif
			@endforeach
		@endif 
	</div>
@endif
	@if($practise['type']=="underline_text_writing")
		<div class="form-slider p-0 mb-4">
		    <div class="component-control-box">
		        <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable="" placeholder="Write here..."></span>
		    </div>
		</div>
	@endif

</form>


<style>
.highlight { background-color: yellow }
</style>
<script>
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var pid = "<?php echo $practise['id'] ?>"
	$('.save_underline_text_form_'+pid).find('.underline_text_list_item').each(function(key){
		var end=0;
		var k=0;
		var qno =$(this).attr('data-qno')
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);
		var words = $this.first().text().split(' ');//split( /\s+/ );
		for(var i=0; i<words.length;i++){
			var word = $.trim(words[i].replace(/^\s+/,""));
			if(word.trim()!=""){
				  wordNumber = k;
				if(i==0  ){
						end=word.length;
            var start = 0;
				} else {
          	end+=word.length;
          	end++;
				}
				var start = end-word.length
				var iName= "text_ans[0][1]["+qno+"]["+wordNumber+"][i]";
				var fColorName =  "text_ans[0][1]["+qno+"]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[0][1]["+qno+"]["+wordNumber+"][foregroundColorSpan]";
				var wordName="text_ans[0][1]["+qno+"]["+wordNumber+"][word]";
				var startName = "text_ans[0][1]["+qno+"]["+wordNumber+"][start]";
				var endName = "text_ans[0][1]["+qno+"]["+wordNumber+"][end]";
				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-16776961'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
				$this.html(paragraph);
				k++;
			}
		}
	});
	var answers = '<?php echo $decoded_answer ?>';
	if(answers!=""){
		var parsedAnswer = answers;
		if( parsedAnswer!==undefined && parsedAnswer!==null ){
			console.log('=========+>',parsedAnswer)
			$.each( jQuery.parseJSON(parsedAnswer), function(key, value) {
				$.each( value, function(k, v) {
					console.log(v)
					 $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+v.i).addClass('bg-success');
					 $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+v.i).find('input').removeAttr('disabled');
				});
				console.log('============')
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
	function setTextareaContent(pid){
		$('.save_underline_text_form_'+pid).find("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			$(this).next().find("textarea").val(currentVal);
		});
	}
});



</script>
