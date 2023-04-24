<p>
	<strong>{{$practise['title']}}</strong>
	<?php
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
			$answers = json_decode($practise['user_answer'][0][0], true);
    }
		// dd($practise);

    	$practise['question']  	= 	str_replace("\r\n"," ",$practise['question']);
		$practise['question']  	= 	str_replace("  "," ",$practise['question']);
		$exploded_question  	=  	explode("<br><br>", $practise['question']);
		// $exploded_question  =  explode(PHP_EOL, $practise['question']);

		// dd($exploded_question);

		$tempQue = [];
		foreach ($exploded_question as $key => $value) {
			if($value!="\r"){
				array_push($tempQue,$value);
			}
		}
		$exploded_question =$tempQue; 


	?>
</p>
<form class="form_{{$practise['id']}}">
	@include('practice.common.audio_player')
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if( !empty(trim($value)) )
						<li class="list-item underline_text_list_item" >
							{!! $value !!}
						</li>
					@endif
				@endforeach
			@endif

  </ul>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitUnderLineBtn_{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitUnderLineBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
<style>
.highlight { background-color: yellow }
</style>
<script>
	var markingMethod = "<?php echo $practise['markingmethod']?>";
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var k=0;
	var end=0;
	var pid = "<?php echo $practise['id'] ?>"

	$('.form_'+pid).find('.underline_text_list_item').each(function(key){
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);

		var words = $this.first().text().trim().split(' ');//split( /\s+/ );

		for(var i=0; i<words.length;i++){


			var word = $.trim(words[i].replace(/^\s+/,""));

			if(word !=""){

				wordNumber = k;

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
				var start = end-word.length
				// end = end-key;
			
				// console.log(end)
				// console.log(start)
				// console.log(word)
				var iName= "text_ans[0][0]["+wordNumber+"][i]";
				var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
				var mColorName =  "text_ans[0][0]["+wordNumber+"][mColor]"
				var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";


				var wordName="text_ans[0][0]["+wordNumber+"][word]";
				var startName = "text_ans[0][0]["+wordNumber+"][start]";
				var endName = "text_ans[0][0]["+wordNumber+"][end]";
				if(markingMethod =="no_marking"){

				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+">\
											<input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+">\
											<input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'>\
											<input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> \
											<input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" >\
											<input type='hidden' disabled name="+startName+" class='start' value="+parseInt(start-key)+" >\
											<input disabled type='hidden' name="+endName+" value="+parseInt(end-key)+" class='end'>"+word+"</span>"
				}else{
						paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+">\
											<input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+">\
											<input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'>\
											<input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> \
											<input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" >\
											<input type='hidden' disabled name="+startName+" class='start' value="+parseInt(start)+" >\
											<input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
				}
				$this.html(paragraph);
			}
			k++;
		}
	 	//var text = words.join( "</span> <span class='highlight-text'>" );
	});

	var answers='<?php echo !empty($practise["user_answer"])?$practise["user_answer"][0][0]:"" ?>';
	if( answers !=""){
		var parsedAnswer = JSON.parse(answers);
		if( parsedAnswer!==undefined && parsedAnswer!==null ){

			$.each(parsedAnswer, function(key, value) {
				 $('.form_'+pid).find('#'+value.i).addClass('bg-success');
				 $('.form_'+pid).find('#'+value.i).find('input').removeAttr('disabled');
			});
		}
	}

	$('.form_'+pid).on( "click","span.highlight-text", function() {
		if($(this).hasClass('bg-success')){
			$( this ).removeClass( 'bg-success' );
			$(this).find('input').attr('disabled','disabled');
		} else {
			$( this ).addClass( 'bg-success' );
			$(this).find('input').removeAttr('disabled');
		}
		//console.log($(this).text())
		// $('.list-item').highlight($( this ).text() );
	});

	$('.form_'+pid).on('click','.submitUnderLineBtn_'+pid ,function() {
		if($(this).attr('data-is_save') == '1'){
			                $(this).closest('.active').find('.msg').fadeOut();
			            }else{
			                $(this).closest('.active').find('.msg').fadeIn();
			            }
		$('.submitUnderLineBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);

		$.ajax({
				url: '<?php echo URL('save-underline-text'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $('.form_'+pid).serialize(),
				success: function (data) {
					$('.submitUnderLineBtn_'+pid).removeAttr('disabled');
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
