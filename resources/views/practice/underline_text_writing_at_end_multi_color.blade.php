<p>
	<strong>{!! $practise['title']!!}</strong>
	<style>
		.course-book .multiple-choice p .bg-success{
			background-color: #EE863A !important;
		}

		.course-book .multiple-choice p .bg-opinion {
			background-color: #264B82 !important;
			color: #fff;
		}
		.course-book .pickcolor__heading p {
			margin-bottom:0px;
		}
	</style>
	<?php
	// pr($practise);
      $answerExists = false;
			$decoded_answer="";
      if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
            $answerExists = true;

            if($practise['type']=="underline_text_writing_at_end_multi_color"){
                $answers = $practise['user_answer'][0][0];
                $underline_answers = $practise['user_answer'][0][1];
                $encode_answer=array();
                foreach ($underline_answers as $key => $value) {
									if(empty($value)){
											array_push($encode_answer,"");
									}else{
										array_push($encode_answer,json_decode($value));
									}
                }
                $decoded_answer = json_encode($encode_answer);

								//pr($decoded_answer);
								 // $underline_answers = json_decode($practise['user_answer'][0][1], true);
            }
        }

        $question                       =  $practise['question'];
			//	pr($question);
        $question_option                =  explode('  #% ', $question);
        $exploded_question              =  explode(PHP_EOL, $question_option[1]);

				$getColorData  =  explode('#%', $practise['question']);
				$colorArray = explode('/@', $getColorData[0]);
				$colorTextArray = explode('@@',$colorArray[0]);

				$colorCodeArray =  explode('@@',$colorArray[1]); //['#A9FFD4', '#FFF4BB'];
				$fColorArray = ['-1145286', '-14267518'];


        foreach ($exploded_question as $key => $value) {
            if($value !== "" || !empty($value))
            {
                $questions[] = $value;
            }
        }
        //dd($questions);
        $i=0;
	?>
</p>
<form class="save_underline_text_form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
	<div
      class="pickcolor__heading row d-flex w-100 flex-wrap align-items-center mb-4">
      <div class="col-3">
          <p><strong>Pick a colour</strong></p>
      </div>
      @if(!empty($colorCodeArray))
        @foreach($colorCodeArray as $colorKey => $colorValue)
        <?php
          $colorCode = "background-color:".$colorValue;
        ?>
          <div class="col-3">
              <p class="d-flex flex-wrap align-items-center">
                  <span class="change-color {{($colorKey==0)?'fColorActive':''}} mr-2" data-fcolor="{{$fColorArray[$colorKey]}}"  style="{{$colorCode}}"></span>
              </p>
							<p><strong>{{$colorTextArray[$colorKey]}}</strong></p>
          </div>
        @endforeach
      @endif

  </div>
    <div class="multiple-choice multiple-choice__custom">
        @if(!empty($questions))
           <?php
					 $j=1;
					 foreach($questions as $key => $value)
					 {
                if(strpos($value, '<b>')!== false)
                {
                    echo '<h6 style="color:#d55b7d;">'.$value.'</h6>';
                    echo '<input type="hidden" name="text_ans[0]['.$key.'][]" value="">';
                    continue;
                }
                ?>
  							@if(!empty(trim($value)))
	                <p class="underline_text_list_item q{{$j}}" data-qno="{{$key}}">
	                  {!! str_replace('@@', '', $value) !!}
                    <div class="form-group focus">
                        <span class="textarea form-control form-control-textarea stringProper text-left enter_disable" role="textbox" contenteditable placeholder="Write here...">{{($answerExists && !empty($answers[$j])?$answers[$j]:"")}}</span>
                        <div style="display:none"><input type="hidden" name="text_ans[0][{{$key}}][]"></div>
                    </div>
	                </p>
									<?php $j+=2;?>
								@endif
            <?php  }?>
        @endif
    </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitUnderLineBtn_{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
      </li>
      <li class="list-inline-item"><button type="button" class="submit_btn btn btn-primary submitUnderLineBtn_{{$practise['id']}}" data-is_save="1" >Submit</button>
      </li>
  </ul>
</form>
<style>
.highlight { background-color: yellow }
</style>
<script>
$(document).ready(function(){

	var pid = "<?php echo $practise['id'] ?>"

	$('.save_underline_text_form_'+pid).find('.underline_text_list_item').each(function(key){
		var wordNumber;
		var k=0;
		var end=0;

		var qno = $(this).attr('data-qno')
		var paragraph="";
    var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);

		var words = $this.first().text().split(' ');//split( /\s+/ );
		words = words.filter(item => item);
	//	console.log('words-====>', words)
		for(var i=0; i<words.length;i++){
				var word = $.trim(words[i].replace(/^\s+/,""));
			if(word !=""){
				wordNumber = k;

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
				if( i==1  ) {
						end=word.length;
				} else {
          	end+=word.length;
          	end++;
				}
				var start = end-word.length
				var iName= "text_ans[1]["+qno+"]["+wordNumber+"][i]";
				var fColorName =  "text_ans[1]["+qno+"]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[1]["+qno+"]["+wordNumber+"][foregroundColorSpan]";
				var wordName="text_ans[1]["+qno+"]["+wordNumber+"][word]";
				var startName = "text_ans[1]["+qno+"]["+wordNumber+"][start]";
				var endName = "text_ans[1]["+qno+"]["+wordNumber+"][end]";

				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
                $this.html(paragraph);

								k++;
			}
		}
	});


var answers='<?php echo !empty($practise["user_answer"])?$decoded_answer : "" ?>';

  if( answers!==undefined && answers!==null  && answers!=="" ){
		console.log('-=====>',answers);
    $.each( jQuery.parseJSON(answers), function(key, value) {
      $.each( value, function(k, v) {

          console.log(k,'===>ssk', v.i)
          // $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+k).addClass('bg-success');
          // $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+k).find('input').removeAttr('disabled');


					if(v.fColor=='-1145286'){
					 $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+ v.i).addClass('bg-success');
					} else if(v.fColor == '-14267518'){
					 $('.save_underline_text_form_'+pid).find('.q'+key).find('#'+ v.i).addClass('bg-opinion');
					}
					$('.save_underline_text_form_'+pid).find('.q'+key).find('#'+ v.i).attr('fColor',v.fColor)

					$('.save_underline_text_form_'+pid).find('.q'+key).find('#'+ v.i).find('input').removeAttr('disabled');
      });
      console.log('============')
    });
	}


	$('.save_underline_text_form_'+pid).on( "click","span.highlight-text", function() {
		// alert()
		// if($(this).hasClass('bg-success')){
		// 	$( this ).removeClass( 'bg-success' );
		// 	$(this).find('input').attr('disabled','disabled');
		// } else {
		// 	$( this ).addClass( 'bg-success' );
		// 	$(this).find('input').removeAttr('disabled');
		// }
		// alert()
		var fcolor = $('.fColorActive').attr('data-fcolor')
		if($(this).hasClass('bg-success')){
			$( this ).removeClass( 'bg-success' );
			$(this).find('input').attr('disabled','disabled');
		}
		else if($(this).hasClass('bg-opinion')){
			$( this ).removeClass( 'bg-opinion' );
			$(this).find('input').attr('disabled','disabled');
		}
		else {
			if(fcolor=="-1145286"){
				$( this ).addClass( 'bg-success' );

				$(this).find('input.fColor').val('-1145286');
			} else{
				$( this ).addClass( 'bg-opinion' );
				$(this).find('input.fColor').val('-14267518');
			}
			$(this).find('input').removeAttr('disabled');
		}
	});

	function setTextareaContent(){
		$('.save_underline_text_form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
			var currentVal = $(this).html();
			$(this).next().find("input:hidden").val(currentVal);
		});
	}


	$('.save_underline_text_form_{{$practise['id']}}').on('click','.submitUnderLineBtn_'+pid ,function() {
			if($(this).attr('data-is_save') == '1'){
			    $(this).closest('.active').find('.msg').fadeOut();
			}else{
			    $(this).closest('.active').find('.msg').fadeIn();
			}
		$('.submitUnderLineBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);
		setTextareaContent();
		$.ajax({
				url: '<?php echo URL('save-underline-text-writing-end'); ?>',
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

$('.change-color').on('click', function() {
  $('.change-color').removeClass('fColorActive');
	$('.change-color').css('border','none');
	$(this).css('border','1px solid black');
  $(this).addClass('fColorActive');
})

</script>
