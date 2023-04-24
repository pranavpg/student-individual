<style>
.course-book ul:not(.nav) li .form-control-inline{
}
</style>
<?php ?>
<p>
    <strong>
        {!! $practise['title'] !!}
    </strong>
</p>
@if(!isset($practise['is_roleplay']) OR $practise['is_roleplay']!=1)
@php
    $answerExists = false;
    $count = substr_count($practise['question'],"@@");
    $exploded_question  =  explode(PHP_EOL, $practise['question']);
    $exploded_question  =  str_replace("@@..", "", $exploded_question);
    //dd($exploded_question);
    $ans=array();
    if(isset($practise['user_answer']) && !empty($practise['user_answer']))
    {
        $answerExists = true;
        $user_answer = $practise['user_answer'][0];
        //dd($user_answer);
        foreach($user_answer as $y=> $answers)
        {
            //$ans[$y]['ans_pos'] = $answers['ans_pos'];
            $ans[] = $answers['ans'];
        }
        $final_answers = json_encode($ans);
        //dd($final_answers);
    }
    //dd($practise);
@endphp
    <div class="table-container">
      <form class="form" id="form_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <?php if(isset($practise['options']) && !empty($practise['options'])) { ?>
        <div class="match-answer">
            <div class="form-slider w-100 mr-auto ml-auto mb-5">
                <div class="owl-carousel owl-theme diffowl">

                    <?php 
                    // dd($practise['options']);
                    ?>
                    @if(!empty($practise['options']))
                        @foreach($practise['options'] as $k => $value)
                            <div class="item align-middle" data-itemNo="{{$k}}">
                                <div class="table-slider-box text-center d-flex mt-3 pb-3" id="parent_{{$k}}">
                                    @foreach($value as $x=> $val)
                                        <?php 
                                            $border_class = ($x == 0 ? 'border-right' : '');
                                            $active_class = 'background-color: initial';
                                            if($answerExists == true)
                                            {
                                               if(isset($practise['user_answer'][0][$k]['ans_pos']))
                                               {
                                                     if((int) $practise['user_answer'][0][$k]['ans_pos'] === (int)$x)
                                                     {
                                                         $active_class = 'background-color: #D2DBE3;';
                                                     }
                                               }
                                            }
                                        ?>
                                        <div class="w-50 table-option mr-2 shadow bg-white {{ $border_class }} ">
                                            <a href="#!" id="{{$k}}_{{$x}}" data-pos="{{$x}}" style="" data="{{$k}}" class="{{$k}}_{{$x}}">{{ $val }}</a>
                                        </div>
                                    @endforeach
                                    @if(isset($practise['user_answer'][0][$k]['ans_pos']))
                                    <input type="hidden" name="text_ans[ans_pos][]" id="ans_pos_{{$k}}" value="{{ $answerExists == true ? $practise['user_answer'][0][$k]['ans_pos'] : "-1" }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <br>
        <?php } ?>
        @if(isset($practise['audio_file']))
         @if($practise['audio_file'] !== "")
            @include('practice.common.audio_player')
         @endif
        @endif
        <br>
        @php $i = 0; @endphp
         <div class="simple-list mb-4">
            <ul class="list-unstyled commonFontSize" >
                <?php 
                // dd($exploded_question);
                $inc =0; 
                foreach($exploded_question as $key=>$item){
                    if(str_contains($item,'@@')){
                        echo $outValue = preg_replace_callback('/@@/',function ($m) use (&$key, &$c, &$userAnswer, &$flag, &$s, &$item, &$practise, &$inc) {

                                $ans = "";
                                if(!empty($practise['user_answer']) && isset($practise['user_answer']) ){
                                    if(isset($practise['user_answer'][0][$inc])){
                                        $ans = $practise['user_answer'][0][$inc]['ans'];
                                    }
                                }
                                $str = '<span class="resizing-input1">
                                        <span readonly disabled contenteditable="true" class="enter_disable spandata fillblanks stringProper text-left disable_writing edit_span">'.$ans.'</span>
                                        <input type="hidden" class="form-control form-control-inline appendspan text_question" name="text_ans[ans][]" value="'.$ans.'">
                                        
                                    </span>';
                                $inc++;
                            return $str;
                        }, $item);

                    }
                    else
                    {
                        echo  $item;
                    }
                    echo "<br>"
                    ?>
                <?php } ?>
            </ul>
        </div>
        <input type="hidden" name="ptype" value="reading_blanks" />
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <button type="button" class="btn btn-primary btnSubmits" data-is_save="0">Save</button>
            </li>
            <li class="list-inline-item">
                <button type="button" class="btn btn-primary btnSubmits" data-is_save="1">Submit</button>
            </li>
        </ul>
      </form>
    </div>

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

<style type="text/css">

 *[contenteditable]:empty:before
 {
     content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
 }
 .appendspan {
     color:red;
 }
 .borderAdd{
     border-bottom:2px solid blue !important;
     color:blue;
     font-weight: 600;
 }
</style>
<script src="{{asset('public/js/owl.carousel.js')}}"></script>
<script type="text/javascript">
 var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
 $(function () {
     $('.disable_writing').on('keydown', function (event) {
         return false;
     });
 });
//$(window).on('load', function()
 $(document).ready(function()
 {

    var answers = '<?php echo $answerExists; ?>';
    if(answers == "1" || answers == true)
    {

        var final_answers = <?php echo isset($final_answers) ? $final_answers : "null"; ?>;
        console.log(final_answers);
        if( final_answers !== null){
            $('.text_question').each(function(i)
            {
                // $(this).val(final_answers[i]).text(final_answers[i]);
                // $(this).next("input:hidden").val(final_answers[i]);
                

            })
        }
    }
 });

function isEmpty(val){
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }

function setTextareaContent(){

    $("#form_<?php echo $practise['id'];?> .form-control.text_question").each(function(){
        var currentVal = $(this).text();
        $(this).next("input:hidden").val(currentVal);
    })
}

$(document).on('click','#form_<?php echo $practise['id'];?> .btnSubmits' ,function() {
    
    if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }

    $('#form_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');

    var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
    if(markingmethod =="student_self_marking"){
     if($(this).attr('data-is_save') == '1'){
        var fullView = $("#form_<?php echo $practise['id']?>").html();
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
        $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
        $(".modal-content .match-answer").hide();
      }
    }
    if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
        $("#reviewModal_{{$practise['id']}}").modal('toggle');
    }
    else
    {
        $(".modal-backdrop").removeClass('show');
    }
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
    $.ajax({
        url: '<?php echo URL('save_reading_blanks_new'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('#form_<?php echo $practise['id'];?> ').serialize(),
        success: function (data) {
        $('#form_<?php echo $practise['id'];?> .btnSubmits').removeAttr('disabled');
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

function commonCssChange(){
    $('.borderAdd').each(function(){
        $(this).removeClass("borderAdd")
    })
}
$(document).on('click','.can',function(){
  $(".modal-backdrop.fade").hide();
});
$(document).on('click','.close',function(){
  $(".modal-backdrop.fade").hide();
});
$(document).ready(function() {
 
    var maxcounter= {{ $count }} ;
    var selected_option = '';
    var owl =  $('.diffowl');
    var selected_item ='';
    var selected_color='#D2DBE3';
    owl.owlCarousel({
        loop:false,
        margin: 10,
        pagination: false,
        items: 1,
        nav: true,
        dots: false,
        touchDrag:false,
        mouseDrag:false,
        onInitialized: function()
        {
            if( $(this).find(".owl-item.active").index() == $(this).find(".own-item").first().index() ) {

            }
        },
        onChange: function()
        {

        }
    })

    $('#form_<?php echo $practise['id'];?> .owl-next').off("click");
    $('#form_<?php echo $practise['id'];?> .owl-prev').off("click");
    var counter = 0;
    $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').focus();
    var text_init_color="red";
    var text_append_color="darkblue";

    $('#form_<?php echo $practise['id'];?> .table-option a').on('click', function(e){

        $('#parent_'+$(this).attr('data')+" a").each(function(){
            $(this).css('background-color','');
        });
            $(this).css('background-color','#D2DBE3');
        e.preventDefault();
        selected_item = $(this).text();
        textbox_index = $(this).attr('id');
        ans_pos_index = $(this).data('pos');
        $('#form_<?php echo $practise['id'];?> .edit_span:eq('+counter+')').val(selected_item).text(selected_item);
        $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').val(selected_item).text(selected_item);
        $('#form_<?php echo $practise['id'];?> #ans_pos_'+counter+'').val(ans_pos_index);
    })


    $("#form_<?php echo $practise['id'];?> .owl-next").on("click", function(e) {
        e.preventDefault();
        if(counter >= maxcounter-1){
            return false;
        }
        if(selected_item !== "") {
            $('.text_question:eq('+counter+')').css('color', text_init_color);
            counter++;
            owl.trigger('next.owl.carousel', [300]);
            selected_item="";
            $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').focus();
            return false;
         }         
         if($('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').val() !== "") {
            $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')');
            counter++;
            owl.trigger('next.owl.carousel', [300]);
            selected_item="";
            $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').focus();
            return false;
         }
         else {
             alert('Oops! You missed a gap!')
             return false;
         }
    })
    $("#form_<?php echo $practise['id'];?> .owl-prev").on("click", function(e) {
        e.preventDefault();
        console.log(counter)
        if(counter == 0){
            selected_item="";
            return false;
        }
        counter--;
        $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').css('color', text_append_color);
        selected_item = $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').text();
        selected_item_index = $('#form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').data('id');
        owl.trigger('prev.owl.carousel', [300]);
        $(' #form_<?php echo $practise['id'];?> .text_question:eq('+counter+')').focus();
        return false;
    })
})
</script>
@else
  @include('practice.reading_blanks_roleplay')
@endif
<!--- Static Condition for beginner ges topic 09 task 8 AB-->
@if(isset($_GET['n']))
 @if($_GET['n'] == "1629890480612627b01e67d")
    <style type="text/css">
     #abc-1629890480612627b01e67d
     {
         display: block  !important;
     }
     #abc-1629890534612627e6028cd
     {
         display: none;
     }
    </style>
 @endif
@endif
<!------------------------------------------------------------>