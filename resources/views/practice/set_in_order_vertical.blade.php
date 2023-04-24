
<p>
    <strong><?php
            echo $practise['title'];
            //pr($practise);
           // echo '<pre>'; print_r($practise); 
          ?>
    </strong>
</p>

        <?php
            $exploded_question = [];
            $style="";
            // if($practise['id']=='15506732135c6d653dbafb1'){

            //  echo "<pre>";
            //  print_r($practise);die;
            //   }
            if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
                $depend =explode("_",$practise['dependingpractiseid']);
                //$style= "display:none";
                if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
                    $answerExists = true;
                    if(!empty($practise['user_answer'][0])){
                        $user_ans = $practise['user_answer'][0];
                    }
                    if(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
                        if(isset($practise['depending_practise_details']['question']) && !empty($practise['depending_practise_details']['question'])){
                            $userAnswer = $practise['dependingpractise_answer'];
                            if(isset($userAnswer[0]) && !empty($userAnswer[0]) && str_contains($userAnswer[0],';')){
                                $userAnswer = explode(";",$userAnswer[0]);
                            }else{
                                if(isset($userAnswer) && !empty($userAnswer) && str_contains($userAnswer,';')){
                                    $userAnswer = explode(";",$userAnswer);
                                }else{
                                    $userAnswer=[];
                                }                           
                            }
                            
    
                            $questions= explode("\r\n", $practise['depending_practise_details']['question']);
                             //pr($userAnswer);
                             $c = 0;
                            foreach($questions as $key => $value)
                            {
    
                                            if(str_contains($value,'@@')){
                                                $value= str_replace("<br>"," ",$value);
                                        //  $value = str_replace('<br>', '', $value);
                                         $outValue[] = preg_replace_callback('/@@/',
                                                    function ($m) use (&$key, &$c, &$userAnswer) {
                                                        $ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
                                                        $str = $ans;
                                                        $c++;
                                                        return $str;
                                                    }, $value);
                                            }
    
                            }
                           // pr($outValue);
                           
                            // $exploded_question  =   explode("\r\n", $practise['question']); $i=1;
                             $exploded_question  =   array_filter(array_merge(array(0), $outValue));
                        }
                    }
                }elseif(isset($practise['question']) && !empty($practise['question'])){
                    $exploded_question  =   explode("\r\n", $practise['question']); $i=1;
                    $exploded_question  =   array_filter(array_merge(array(0), $exploded_question));
                }elseif(isset($practise['dependingpractise_answer']) && !empty($practise['dependingpractise_answer'])){
                    if(isset($practise['depending_practise_details']['question']) && !empty($practise['depending_practise_details']['question'])){
                        $userAnswer = $practise['dependingpractise_answer'];
                        if(isset($userAnswer[0]) && !empty($userAnswer[0]) && str_contains($userAnswer[0],';')){
                            $userAnswer = explode(";",$userAnswer[0]);
                        }else{
                            if(isset($userAnswer) && !empty($userAnswer) && str_contains($userAnswer,';')){
                                $userAnswer = explode(";",$userAnswer);
                            }else{
                                $userAnswer=[];
                            }                           
                        }
                        

                        $questions= explode("\r\n", $practise['depending_practise_details']['question']);
                         //pr($userAnswer);
                         $c = 0;
                        foreach($questions as $key => $value)
                        {

                                        if(str_contains($value,'@@')){
                                            $value= str_replace("<br>"," ",$value);
                                    //$outValue = str_replace('@@', $str, $value);
                                     $outValue[] = preg_replace_callback('/@@/',
                                                                        function ($m) use (&$key, &$c, &$userAnswer) {
                                                                            $ans= !empty($userAnswer[$c])?trim($userAnswer[$c]):"";
                                                                            $str = $ans;
                                                                            $c++;
                                                                            return $str;
                                                                        }, $value);
                                        }

                        }
                       // pr($outValue);
                       
                        // $exploded_question  =   explode("\r\n", $practise['question']); $i=1;
                         $exploded_question  =   array_filter(array_merge(array(0), $outValue));
                    }
                }else{
                     ?>
                        <div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px;">
                            <p style="margin: 15px;">In order to do this task you need to have completed
                                <strong>Practice {{$depend[2]}}
                                    <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>.
                                </strong> Please complete this first.
                            </p>
                        </div>
               <?php } ?>
        
       
        <?php
              } else {
                
                if(isset($practise['question'])){
                    $exploded_question  =   explode("\r\n", $practise['question']); $i=1;
                    $exploded_question  =   array_filter(array_merge(array(0), $exploded_question));
                }
              }
           
               //echo '<pre>'; print_r($exploded_question); exit;
        ?>

    <form class="save_set_in_order_vertical_listening_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <?php 
                    // $exploded_question = [];
                    // if(isset($practise['question'])){
                    //     $exploded_question  =   explode("\r\n", $practise['question']); $i=1;
                    //     $exploded_question  =   array_filter(array_merge(array(0), $exploded_question));
                    // }

                ?>
        @if( !empty( $practise['audio_file'] ) )
            @include('practice.common.audio_player')
        @endif
        <?php //echo '<pre>'; print_r($exploded_question);  ?>
        <div class="vertical-set-order">
            <ul class="list-unstyled" id="columns">
            
                    @php $k = 1; @endphp
                    @if(isset($practise['user_answer']) && !empty($practise['user_answer']))
                        <?php 
                                $exploded_answer  =  explode(";", $practise['user_answer']); $i=1;
                               // dd($practise);
                            ?>

                        @foreach($exploded_answer as $p => $item)
                            @if(!empty($exploded_question[$item]))
                                @if($exploded_question[$item] == "@@")
                                    <?php  $k++;
                                        //  echo '<br><input type="hidden" name="inOrderAnswer[]" value="'.$item.'" draggable="false"><br>';
                                        echo '<li class="list-item" draggable="true" data-group="'.($k-1).'"><span style="opacity:0" class="text-left text-muted"></span></li><input type="hidden" name="inOrderAnswer[]" value="'.$item.'" draggable="false" class="inOrderAnswer">';
                                    ?>
                                @else
                                    <li class="list-item" draggable="true" {{$item}} data-group="{{$k}}">
                                        <span class="text-left text-muted"><b>{{ $exploded_question[$item] }}</b></span>
                                        <input type="hidden" name="inOrderAnswer[]" value="{{$item}}" class="inOrderAnswer">
                                    </li>
                                @endif

                                @php $i++; @endphp
                            @endif

                        @endforeach
                        <li class="list-item"  draggable="false"  data-group="{{$k}}" >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        </li>
                    @else
                        @foreach($exploded_question as $p=> $item)
                            <?php if($item == "@@" || strpos($item, '@@')){
                                            $k++;
                                            echo '<li class="list-item" draggable="true" data-group="'.($k-1).'"><span style="opacity:0" class="text-left text-muted"></span></li><input type="hidden" name="inOrderAnswer[]" value="'.$p.'" draggable="false" class="inOrderAnswer">';
                                        }else{ ?>
                            <li class="list-item " draggable="true" data-group="{{$k}}">
                                <span class="text-left text-muted"><b>{{$item}}</b></span>
                                <input type="hidden" name="inOrderAnswer[]" value="{{$p}}" class="inOrderAnswer">
                            </li>
                            <?php $i++;
                                            }
                                    ?>
                        @endforeach
                        <li class="list-item"  draggable="false" data-group="{{$k}}" >
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> 
                        </li>
                    @endif               
            </ul>
        </div>

        <div class="alert alert-success" role="alert" style="display:none">
            This is a success alert check it out!
        </div>

        <ul class="list-inline list-buttons previousButton">
            <li class="list-inline-item">
                <!-- <a href="#!" class="btn btn-primary"
                        data-toggle="modal" data-target="#exitmodal">Save</a> -->
                <input type="button" class="save_btn inOrderVrLsBtn_{{$practise['id']}} btn btn-primary" value="Save"
                    data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="submit_btn inOrderVrLsBtn_{{$practise['id']}} btn btn-primary" value="Submit"
                    data-is_save="1">

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
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/base/jquery-ui.css">
<script>
// $(function () {
//           $('audio').audioPlayer();

//       });
//       function setTextareaContent(){
//       $("span.textarea.form-control").each(function(){
//         var currentVal = $(this).html();
//         $(this).next().find("textarea").val(currentVal);
//       })
//     }

$(function() {
    $("#columns").sortable({
        revert: true,
        stop: function (e, t) {        
            // alert($(this).data('index'));
        },
        receive: function (ev, ui) {                  
            var $target = ($(this).data().uiSortable  || $(this).data().sortable).currentItem;
                
            var $source = $(ui.sender);                
           $target.data('index',$source.data('index'));
        }
    });
});


$(document).on('click', ".inOrderVrLsBtn_{{$practise['id']}}", function() {

    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    
    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".save_set_in_order_vertical_listening_form_{{$practise['id']}}").html();
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
                    $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
    $(".inOrderVrLsBtn_{{$practise['id']}}").attr('disabled', 'disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    // setTextareaContent();
    $.ajax({
        url: "{{url('save-setin-order-vertical-listening')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: $(".save_set_in_order_vertical_listening_form_{{$practise['id']}}").serialize(),
        success: function(data) {
            $(".inOrderVrLsBtn_{{$practise['id']}}").removeAttr('disabled');

            $('.alert-success').show().html(data.message).fadeOut(8000);

        }
    });

});
</script>
<script>

/*function addDnDHandlers(elem) {
    elem.addEventListener('dragstart', handleDragStart, false);
    elem.addEventListener('dragenter', handleDragEnter, false)
    elem.addEventListener('dragover', handleDragOver, false);
    elem.addEventListener('dragleave', handleDragLeave, false);
    elem.addEventListener('drop', handleDrop, false);
    elem.addEventListener('dragend', handleDragEnd, false);

}*/

var cols = document.querySelectorAll('#columns .list-item');
// [].forEach.call(cols, addDnDHandlers);


// $(function () {
//     $('audio').audioPlayer();
// });

// auto resizing input
</script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->

<script>
jQuery(function($) {
    'use strict'
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        // initialize plyr
        var i;

        var player = new Plyr("#audio_{{$practise['id']}}", {
            controls: [

                'play',
                'progress',
                'current-time',

            ]
        });


    } else {
        // no audio support
        $('.column').addClass('hidden');
        var noSupport = $('#audio1').text();
        $('.container').append('<p class="no-support">' + noSupport + '</p>');
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>