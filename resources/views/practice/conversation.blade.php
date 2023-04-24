<p><strong>{{ $practise['title'] }}</strong></p>
<?php 
  // dd($practise);
?>
<form class="save_conversation_{{$practise['id']}}">
<input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
<input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
<input type="hidden" class="is_save" name="is_save" value="">
<input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        @if( !empty( $practise['audio_file'] ) )
                @include('practice.common.audio_player')
        @endif
        <?php $img1=array(0,2,4,6,8,10,12); $img2=array(1,3,5,7,9,11,13); $k=0;$p=0;$s=0; 

            $user_answer = [];
            if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $user_answer = $practise['user_answer'];
            }
$mm=0;
           for($i = 0; $i< 7; $i++){ $p++;$q=0; 
            // echo $q;
            ?>

            <div class="chat-conversation mb-4">
                <?php if($p<5){?>
                <h3>Conversation {{$p}}</h3>
                <?php } ?>
                <div class="row d-flex flex-wrap align-items-center">
                    <div class="col-12 col-lg-6 chat chat-left d-flex flex-wrap align-items-center">
                        <div class="user__icon">
                            <img src="{{$practise['question'][$img1[$k]]}}" alt="" class="img-fluid">
                        </div>
                        <div class="user__chat_box multiple-choice text-center">
                            <?php 
                            $data = isset($user_answer[$i]) && !empty($user_answer[$i]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ?$user_answer[$i][$q]:"":"";
                            ?>
                        <p> <?php echo str_replace('@@','<span class="textarea d-inline-flex mw-20 form-control form-control-textarea enter_disable appenvalue" data="'.$mm.'"  data1="'.$p.'"  role="textbox" contenteditable placeholder="Write here..." style="margin: -2px;padding: 0px;">'.$data.'</span>',$practise['question_2'][$img1[$k]]); ?>   <input type="hidden" name="question_new[{{$q}}][]" value='{{isset($user_answer[$i]) && !empty($user_answer[$i]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ?$user_answer[$i][$q]:"":""}}'  class="inputs" id="append-{{$mm}}"/>
</p>

                        </div>
                    </div>
                    
                    <?php $q++; $mm++;?>
                    <!-- /. Chat Left-->
                    
                    <div class="col-12 col-lg-6 chat chat-right d-flex flex-wrap align-items-center justify-content-end">
                        <div class="user__chat_box multiple-choice text-center">
                            <?php 
                                $data = isset($user_answer[$i]) && !empty($user_answer[$i][$q]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ? $user_answer[$i][$q]:"":"";

                                $value = strlen($data);
                                if($value == ""){
                                    $style = "3ch";
                                }else{
                                    if($value == "1" || $value == "2" || $value == "3"){
                                        $style = "1ch";
                                    }else{
                                        $style = "3ch";
                                    }
                                }

                            ?>
                            <p>

                                <?php 
                                echo str_replace('@@','<span class="textarea d-inline-flex mw-20 form-control spandata fillblanks form-control-textarea enter_disable appenvalue" data="'.$mm.'"  role="textbox" contenteditable placeholder="Write here..." style="margin: -2px;padding: 0px;min-width:'.$style.' !important;" >'.$data.'</span>',$practise['question_2'][$img2[$k]]); 
                                ?>   
                                    <input type="hidden" name="question_new[{{$q}}][]" value='{{isset($user_answer[$i]) && !empty($user_answer[$i][$q]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ? $user_answer[$i][$q]:"":""}}' class="inputs" id="append-{{$mm}}" /></p>

                                       

                                       
                            
                        </div>
                        <div class="user__icon">
                            <img src="{{$practise['question'][$img2[$k++]]}}" alt="" class="img-fluid">
                        </div>
                    </div>

                   
                    <!-- /. Chat Left-->
                </div>
            </div>

       <?php $s++; }?>
            <!-- /. List Button Start-->
            <div class="alert alert-success" role="alert" style="display:none"></div>
                    <div class="alert alert-danger" role="alert" style="display:none"></div>
          


            <ul class="list-inline list-buttons">
                <li class="list-inline-item">
                    <input type="button" class="save_btn single_tick_reading_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
                </li>
                <li class="list-inline-item">
                    <input type="button" class="submit_btn single_tick_reading_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
                </li>
            </ul>


            <!-- /. List Button Ends-->
        </div>
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
    /* record_video jquery save */
$(document).on('keyup',".appenvalue" ,function() {
// alert($(this).attr("data"))
    $(this).next('.inputs').val($(this).html())
// $('#append-'+$(this).attr("data")).val($(this).html())
});
function TextToTextboxVlauePush(){
    $('.appenvalue').each(function(){
        $(this).next().val($(this).html())
    });
}

var flag = true;
$(document).on('keyup','.spandata',function(){
    var value = $(this).html().trim().length
    if(value == ""){
        $(this).css("min-width","3ch");
    }else{
        if(value == "1" || value == "2" || value == "3"){
            $(this).css("min-width","1ch");
        }else{
            if(flag){
                flag = false;
                $(this).css("min-width","3ch");
            }
        }
    }
  // $(this).next().val($(this).html())

})


$(document).on('click',".single_tick_reading_form_{{$practise['id']}}" ,function() {
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
      }else{
        $(this).closest('.active').find('.msg').fadeIn();
      }
    TextToTextboxVlauePush();
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_conversation_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.textarea').attr("contenteditable","false");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
    // console.log($(".save_conversation_{{$practise['id']}}").serialize());
    $(".single_tick_reading_form_{{$practise['id']}}").attr('disabled','disabled');
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
      }else{
        $(this).closest('.active').find('.msg').fadeIn();
      }
    var is_save = $(this).attr('data-is_save');
    // alert(is_save);
    $('.is_save:hidden').val(is_save);

    $.ajax({
        url: "{{ route('save-single-tick-reading') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $(".save_conversation_{{$practise['id']}}").serialize(),
        success: function (data) {
        
            if(data.success){
                $(".single_tick_reading_form_{{$practise['id']}}").removeAttr('disabled');
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
<style type="text/css">
 

    *[contenteditable]:empty:before
    {
        content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
    }

    .appendspan {
        color:red;
    }
</style>