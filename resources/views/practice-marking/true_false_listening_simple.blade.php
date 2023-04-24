
        <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
          <?php //echo '<pre>'; print_r($practise); ?>
        </p>
          <form class="save_true_false_listening_simple_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <?php if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
                $depend =explode("_",$practise['dependingpractiseid']); 
          ?>
                 <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                 <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
                 <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong style="color:#e0790b">Task <?php echo $depend[2]; ?></strong> <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
           <?php  } ?>
             <!-- /. Component Audio Player -->
             @if( !empty( $practise['audio_file'] ) )
					  @include('practice.common.audio_player')
		    @endif
            <!-- /. Component Audio Player END-->
            <?php 
                if(!isset($practise['dependingpractiseid'])){
                    if(isset($practise['question']) && !empty($practise['question'])){
                        $exploded_question  =  explode(PHP_EOL, $practise['question']); ?>
                        @foreach($exploded_question as $k => $question)
                            <div class="true-false">
                                <div class="box box-flex align-items-center">
                                    <div class="box__left flex-grow-1">
                                        <p>{{str_replace('@@','',$question)}} </p>
                                    
                                    </div>
                                    <div class="true-false_buttons">
                                        <div class="form-check form-check-inline">
                                        <input type="hidden" name="userans[{{$k}}][question]" value="{{$question}}">
                                        
                                            <input class="form-check-input" type="radio"
                                                name="userans[{{$k}}][true_false]" id="inlineRadioTrue_{{$k}}" value="1" {{ isset($practise['user_answer'][0][$k]['true_false']) && !empty($practise['user_answer'][0][$k]['true_false']) && $practise['user_answer'][0][$k]['true_false'] == '1' ?  'checked' :  " " }}>
                                            <label class="form-check-label" for="inlineRadioTrue_{{$k}}">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="userans[{{$k}}][true_false]" id="inlineRadiofalse_{{$k}}" value="0" {{ isset($practise['user_answer'][0][$k]['true_false'])  && $practise['user_answer'][0][$k]['true_false'] == '0' ?  'checked' :  '' }}>
                                            <label class="form-check-label" for="inlineRadiofalse_{{$k}}">False</label>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        @endforeach
                    <?php
                    }


            }else{

                        $exploded_question  =  explode(PHP_EOL, $practise['depending_practise_details']['question']);
                        $ans  =  !empty($practise['dependingpractise_answer'])?$practise['dependingpractise_answer'][0]:[];
                        if(!empty($ans)){ ?>
                            @foreach($exploded_question as $k => $question)
                                <div class="true-false">
                                    <div class="box box-flex d-flex align-items-center">
                                        <div class="box__left flex-grow-1">
                                            <p>{{str_replace('@@',!empty($ans)?' : '.$ans[$k]['ans']:'',$question)}} </p>
                                        </div>
                                        <div class="true-false_buttons">
                                            <div class="form-check form-check-inline">
                                            <input type="hidden" name="userans[{{$k}}][question]" value="{{$question}}">
                                            
                                                <input class="form-check-input" type="radio"
                                                    name="userans[{{$k}}][true_false]" id="inlineRadioTrue_{{$k}}" value="1" {{ isset($practise['user_answer'][0][$k]['true_false']) && !empty($practise['user_answer'][0][$k]['true_false']) && $practise['user_answer'][0][$k]['true_false'] == '1' ?  'checked' :  " " }}>
                                                <label class="form-check-label" for="inlineRadioTrue_{{$k}}">True</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="userans[{{$k}}][true_false]" id="inlineRadiofalse_{{$k}}" value="0" {{ isset($practise['user_answer'][0][$k]['true_false'])  && $practise['user_answer'][0][$k]['true_false'] == '0' ?  'checked' :  '' }}>
                                                <label class="form-check-label" for="inlineRadiofalse_{{$k}}">False</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            @endforeach
                    <?php
                        }else{
                            $depend =explode("_",$practise['dependingpractiseid']);
                            ?>
                                     <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
                                     <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
                                     <div id="dependant_pr_{{$practise['id']}}" style=" border: 2px dashed gray; border-radius: 12px;">
                                        <p style="margin: 15px;">In order to do this task you need to have completed <strong style="color:#e0790b">Task <?php echo $depend[2]; ?></strong> <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                                    </div><br>
                                    <script type="text/javascript">
                                        setTimeout(function(){

                                        $('.audio-player').fadeOut();
                                        $('.submitbuttons').fadeOut();
                                        },600)
                                    </script>
                        <?php } 
            } 
            ?>
            
        <div class="alert alert-success" role="alert" style="display:none">
            This is a success alert—check it out!
        </div>
      </form>
      <script>jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement("#audio_plyr_{{$practise['id']}}").canPlayType;
        if (supportsAudio) {
            var i;
               var player = new Plyr('audio', {
                controls: [
                    'play',
                    'progress',
                    'current-time',
                ]
            });
        } else {
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->