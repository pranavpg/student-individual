<p>
	<strong>{!! $practise['title']!!}</strong>
	<?php
	//pr($practise);
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
	// dd($practise);
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
								<span class="textarea form-control form-control-textarea"
									role="textbox" contenteditable
									placeholder="Write here...">
									<?php
										if ($answerExists)
										{
												echo  $practise['user_answer'][0][0][$j];
										}
									?>
								</span>
								<div style="display:none">
									<textarea name="text_ans[0][0][{{$j}}]">
									<?php
											if ($answerExists)
											{
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
		<p></p>
		<div class="form-slider p-0 mb-4">
		    <div class="component-control-box">
		        <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">

						</span>
		    </div>
		</div>
	@endif
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
@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")
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
				// wordNumber = i;
				// if(i==0 && key==0){
				// 		end=word.length;
				// }else{
				// 	if(key>=1){
				// 		if(i==0){
				// 			end+=word.length;
				// 			end+= 3
				// 		} else{
				// 			end+=word.length;
				// 			end++;
				// 		}
				// 	} else {
				// 		end+=word.length;
				// 		end++;
				// 	}
				// }
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
		// alert()
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
	function setTextareaContent(pid){
		$('.save_underline_text_form_'+pid).find("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			$(this).next().find("textarea").val(currentVal);
		});
	}
	$('.save_underline_text_form_'+pid).on('click','.submitUnderLineBtn_'+pid ,function() {
			if($(this).attr('data-is_save') == '1'){
	            $(this).closest('.active').find('.msg').fadeOut();
	        }else{
	            $(this).closest('.active').find('.msg').fadeIn();
	        }
		var reviewPopup = '{!!$reviewPopup!!}';
    	var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_underline_text_form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){

                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
		$('.submitUnderLineBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);
		setTextareaContent(pid);
		$.ajax({
				url: '<?php echo URL('save-underline-text'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $('.save_underline_text_form_'+pid).serialize(),
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
