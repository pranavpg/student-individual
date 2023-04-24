<p><strong>{{ $practise['title'] }}</strong></p>
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
                        <p> <?php echo str_replace('@@','<span class="textarea d-inline-flex mw-20 form-control form-control-textarea enter_disable appenvalue" data="'.$mm.'"  data1="'.$p.'"  role="textbox" contenteditable disabled placeholder="Write here..." style="margin: -2px;padding: 0px;">'.$data.'</span>',$practise['question_2'][$img1[$k]]); ?>   <input type="hidden" name="question_new[{{$q}}][]" value='{{isset($user_answer[$i]) && !empty($user_answer[$i]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ?$user_answer[$i][$q]:"":""}}'  class="inputs" id="append-{{$mm}}"/></p>
                        </div>
                    </div>
                    <?php $q++; $mm++;?>
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
                            <p><?php 
                                echo str_replace('@@','<span class="textarea d-inline-flex mw-20 form-control spandata fillblanks form-control-textarea enter_disable appenvalue" data="'.$mm.'"  role="textbox" contenteditable disabled placeholder="Write here..." style="margin: -2px;padding: 0px;min-width:'.$style.' !important;" >'.$data.'</span>',$practise['question_2'][$img2[$k]]); 
                                ?>   
                                    <input type="hidden" name="question_new[{{$q}}][]" value='{{isset($user_answer[$i]) && !empty($user_answer[$i][$q]) ? $user_answer[$i][$q]!="" && isset($user_answer[$i][$q]) ? $user_answer[$i][$q]:"":""}}' class="inputs" id="append-{{$mm}}" /></p>
                        </div>
                        <div class="user__icon">
                            <img src="{{$practise['question'][$img2[$k++]]}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
       <?php $s++; }?>
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
        </div>
</form>
<script type="text/javascript">
$(document).on('keyup',".appenvalue" ,function() {
    $(this).next('.inputs').val($(this).html())
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
})
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