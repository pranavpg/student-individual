<p><strong>{{$practise['title']}}</strong>
      @php    
         $answerExists = false;
      @endphp
        @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
            @php $answerExists = true;  @endphp
      @endif
</p>  
<?php 
// dd($practise);
?>
    <form class="save_true_false_simple_form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
			<input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
			<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
			<?php
            if(str_contains($practise['question'],'#@')){
                $mainQuestion = explode('#@', $practise['question']);
                $exploded = explode('@@', $mainQuestion[0]);
                $option1=$exploded[0];
                $option2=$exploded[1];

                $exploded_question = explode('@@', $mainQuestion[1]);
            }elseif(str_contains($practise['question'],'@@')){
                $exploded_question = explode('@@', $practise['question']);
            }
        
			$answerExists = false;
           ?>   
                    @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                    @php 
                            $answerExists = true;  
                    @endphp

                            @if($practise['type'] == "true_false_simple")
                                @php	$answers = $practise['user_answer'][0];  @endphp
                            @else
                                @php	$answers = $practise['user_answer'][0]['text_ans']; @endphp
                            @endif
                    @endif
			 <?php 

             ?>
                    <div class="true-false">
					@if(!empty($exploded_question))
						@foreach($exploded_question as $key => $value)
							@if(!empty($value))
								<div class="box box-flex align-items-center">

                                        <div class="box__left flex-grow-1">    
                    						@if($practise['type'] == "true_false_simple")
                    							<p>{{ str_replace('@@','',$value)  }}</p>
                    						@endif
                                        </div>   

										<div class="true-false_buttons">
												<input type="hidden" name="text_ans[{{$key}}][question]"  value="{{ str_replace(' Disagree  #@ ','',$value)  }} @@" >
                                                <?php 
                                                if(isset($answers)){
                                                   
                                                     if(isset($answers[$key]['true_false'])){

                                                        if($answers[$key]['true_false'] == "1"){
                                                            ?>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" checked>
                                                                        <label class="form-check-label" for="inlineRadioTrue{{$key}}">{{$option1}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" >
                                                                        <label class="form-check-label" for="inlineRadioFalse{{$key}}">{{$option2}}</label>
                                                                </div>
                                                            <?php
                                                        }elseif($answers[$key]['true_false'] == "0"){
                                                            ?>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" >
                                                                        <label class="form-check-label" for="inlineRadioTrue{{$key}}">{{$option1}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" checked >
                                                                        <label class="form-check-label" for="inlineRadioFalse{{$key}}">{{$option2}}</label>
                                                                </div>
                                                            <?php

                                                        }else{

                                                            ?>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" >
                                                                        <label class="form-check-label" for="inlineRadioTrue{{$key}}">{{$option1}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" >
                                                                        <label class="form-check-label" for="inlineRadioFalse{{$key}}">{{$option2}}</label>
                                                                </div>
                                                            <?php
                                                        }
                                                    }else{
                                                         ?>
                                                            <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" >
                                                                    <label class="form-check-label" for="inlineRadioTrue{{$key}}">{{$option1}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" >
                                                                    <label class="form-check-label" for="inlineRadioFalse{{$key}}">{{$option2}}</label>
                                                            </div>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                            <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioTrue{{$key}}" value="1" >
                                                                    <label class="form-check-label" for="inlineRadioTrue{{$key}}">{{$option1}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="text_ans[{{$key}}][true_false]" id="inlineRadioFalse{{$key}}" value="0" >
                                                                    <label class="form-check-label" for="inlineRadioFalse{{$key}}">{{$option2}}</label>
                                                            </div>
                                                        <?php
                                                }

                                                ?>
												

										</div>
								</div>
							@endif
						@endforeach
					@endif
					<!-- /. box -->
			</div>
			<div class="alert alert-success" role="alert" style="display:none"></div>
			<div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="save_btn true_false_simple_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                <input type="button" class="submit_btn true_false_simple_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
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
<script type="text/javascript">    
$(document).on('click',".true_false_simple_form_{{$practise['id']}}" ,function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
    if(markingmethod =="student_self_marking"){
      if($(this).attr('data-is_save') == '1'){                    
        var fullView= $(".save_true_false_simple_form_{{$practise['id']}}").html();                    
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.enter_disable').attr("contenteditable",false);
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable",false);
      }
    }
    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
              $("#reviewModal_{{$practise['id']}}").modal('toggle');
    }
    $(".true_false_simple_form_{{$practise['id']}}").attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-true-false-simple') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_true_false_simple_form_{{$practise['id']}}").serialize(),
        success: function (data) {  
        $("input").removeAttr('disabled');
            if(data.success){
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(8000);
            }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(8000);
            }
        }
    });
});
</script>
 
