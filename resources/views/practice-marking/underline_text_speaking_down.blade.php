<script src="{{asset('/public/js/jquery.highlight-5.js')}}"></script>

<p>
	<strong>{!! $practise['title'] !!}</strong>
	<?php
      //pr($practise['user_answer']);

      $answerExists = false;
					//pr($practise['user_answer']);
      if(isset($practise['user_answer']) && !empty($practise['user_answer']) && !empty($practise['user_answer'][0]['text_ans']))
      {

        $answerExists = true;
        if(array_key_exists('text_ans', $practise['user_answer'][0])){
            $answers = json_decode($practise['user_answer'][0]['text_ans'][0], true);
            //dd($answers);
        }
        else{
            $answers = json_decode($practise['user_answer'][0][0], true);
        }
	  }

		$exploded_question  =  explode('<br>', $practise['question']);
		// $exploded_question = array_filter($exploded_question);
		// $exploded_question = array_merge($exploded_question);

		// dd($practise);
	?>
</p>
<form class="save_underline_text_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="audio" value="0">
  <ul class="list-unstyled list-texthighlighted" id="{{$practise['id']}}">
			@if(!empty($exploded_question))
				@foreach($exploded_question as $key => $value)
					@if( !empty(trim($value)) )
						<li class="list-item underline_text_list_item" >
							{!! $value !!}
						</li>
					@else
						<li class="list-item underline_text_list_item empty_word" >
							{!! $value !!}
						</li>
					@endif
				@endforeach
			@endif

  </ul>
	@if($practise['type']=="underline_text_speaking_down")
        @include('practice.common.audio_record_div',['key'=>0])
    @endif

    {{-- @if($practise['type'] == "underline_text_speaking_down")
        @include('practice.common.audio_record_div')
    @endif --}}
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <!-- <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="btn btn-secondary submitUnderLineBtn_{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="btn btn-secondary submitUnderLineBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul> -->
</form>
<style>
.highlight { background-color: yellow }
</style>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script> --}}


<script>
    var token = $('meta[name=csrf-token]').attr('content');
      var upload_url = "{{url('upload-audio')}}";
      var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
      $('.delete-icon').on('click', function() {
          $('.practice_audio').attr('src','');
          $(document).find('.stop-button').hide();
          $('.audioplayer-bar-played').css('width','0%');
          $('.delete-icon').hide();
          $('div.audio-element').css('pointer-events','none');

          var practise_id = $('.practise_id:hidden').val();
          $.ajax({
            url: '<?php echo URL('delete-audio'); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {practice_id:practise_id},
            success: function (data) {
                $('.record-icon').show();
                $('.recordButton').show();
                $('.recordButton').attr('visible', true);
            }
        });
       });
  </script>

<script>
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var k=0;
	var end=0;
	var pid = "<?php echo $practise['id'] ?>"

	$('.save_underline_text_form_'+pid).find('.underline_text_list_item').each(function(key){
		//console.log('+++>>',key)
		
			var paragraph		=	"";
			var str 			= 	$(this).text();
			var $this 			=	$(this);
			str.replace(/[ ]{2,}/gi," ");
			$this.attr('data-total_characters', str.length);
			$this.attr('data-total_words', str.split(' ').length);
			var words = $this.first().text().trim().split(' ');
			var newWord 	= $this.first().text().trim();
			newWord 		= newWord.replace("  ","");
			var words 		= newWord.split(' ');
		for(var i=0; i<words.length;i++){
			var word = $.trim(words[i].replace(/^\s+/,""));
			console.log(word);
			if(word !=""){
        		wordNumber = k;
				if(i==0 && key==0){
				//	console.log(words[i],'i===>',i)
						end=word.length;
				}else{
					end+=word.length;
					end++;
					// if(key>=1){
					// 	if(i==0){
					// 		end+=word.length;
					// 		end+= 3
					// 	} else{
					// 		end+=word.length;
					// 		end++;
					// 	}
					// } else {
					// 	end+=word.length;
					// 	end++;
					// }
				}
				console.log('end-word.length', end-word.length);
				var start = end-word.length
				var iName= "text_ans[0][0]["+wordNumber+"][i]";
				var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
				var wordName="text_ans[0][0]["+wordNumber+"][word]";
				var startName = "text_ans[0][0]["+wordNumber+"][start]";
				var endName = "text_ans[0][0]["+wordNumber+"][end]";
				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
				$this.html(paragraph);
				k++;
			}else{
				// alert("asdasd");
			}
			
		}
	 	//var text = words.join( "</span> <span class='highlight-text'>" );
	});

	var answers='<?php echo (isset($answers) && !empty($answers)) ? addslashes(json_encode($answers))  : ""; ?>';
    if( answers !=="" && answers!==undefined && answers!==null)
    {

        var parsedAnswer = JSON.parse(answers);
        if( parsedAnswer!==undefined && parsedAnswer!==null && answers !==""){
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
		//console.log($(this).text())
		// $('.list-item').highlight($( this ).text() );
	});

    function setTextareaContent(){
		$("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			$(this).next().find("textarea").val(currentVal).html(currentVal);
		})
	}

	$('.save_underline_text_form_'+pid).on('click','.submitUnderLineBtn_'+pid ,function() {

		$('.submitUnderLineBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);
        setTextareaContent();
		$.ajax({
				url: '<?php echo URL('save-underline-text-speaking-down'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $('.save_underline_text_form_'+pid).serialize(),
				success: function (data) {
					$('.submitUnderLineBtn_'+pid).removeAttr('disabled');
					if(data.success){
						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(4000);
					} else {
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(4000);
					}
				}
		});
	});
});



</script>
