

<?php
//pr(gettype($practise['user_answer'][0][0][1]['col_3']));
    //echo "<pre>";
    if(isset($practise['dependingpractiseid'])) {
        $depend = explode("_",$practise['dependingpractiseid']);
    }


    $question  = explode(PHP_EOL, $practise['question'], 1);
    $options = explode(" /t ", $question[0]);

    $questions = $options[0];
    $question_title = explode(PHP_EOL, $options[1]);

    $answerExists = false;

    $q = array();
    //dd($practise);
    if(isset($practise['user_answer'])) {
        $answerExists = true;
        //dd($practise['user_answer'][0][1]);
        $user_answer = $practise['user_answer'][0][0];
        //pr($user_answer);
        foreach ($user_answer as $key => $value) {
            if($key > 0){
              $q[] = $value['col_3'];
            }
        }
        $final_answer = json_encode($q);
    }

?>


<p>
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
</p>
<form class="save_three_blank_table_with_check_form_{{$practise['id']}}">

    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" name="table_type" value="3">

    <?php if(isset($depend)): ?>
        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <?php endif;?>

    <p>
        <strong><?php echo $practise['title']; ?></strong>
    </p>

    <div class="multiple-choice mb-4 text-center">
        <div class="mb-4">
            <a href="#!" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Show tape script </a>
        </div>
    </div>


    <div class="table-container mb-4 text-center">
        <div class="appended">
        </div>
    </div>
    <!-- /. Component Table End -->


    <div class="modal fade add-summary-modal" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Tape Script
                    </h5>
                </div>
                <div class="modal-body" style="color:#000;">

                        @php if(strpos($questions, '#%') !== false){
                            $questions = str_replace('#%','',$questions);
                        } @endphp

                        @php if(strpos($questions, PHP_EOL) !== false){
                            $questions = str_replace(PHP_EOL,'<p></p>',$questions);
                        } @endphp

                        {!! $questions !!}


                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Ok</button>
                </div>

            </div>
        </div>
    </div>

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">
            <li class="list-inline-item">
                <input type="button" class="threeBlankTableWithCheckBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="threeBlankTableWithCheckBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
            </li>
        </ul>
</form>
@if(!isset($practise['dependingpractise_answer']) || empty($practise['dependingpractise_answer']))
    <script>
        $(function() {
            $("#dependant_pr_{{$practise['id']}}").css("display", "block");
            $(".save_three_blank_table_with_check_form_{{$practise['id']}}").css("display", "none");
        });
    </script>
@else
<script>
        $(function() {
            $("#dependant_pr_{{$practise['id']}}").css("display", "none");
            $(".save_three_blank_table_with_check_form_{{$practise['id']}}").css("display", "block");
        });
</script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script>jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement("audio").canPlayType;
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

<script>
function setTextareaContent(){
    $("span.textarea.form-control").each(function(){
        var currentVal = $(this).html();
        $(this).next().find("textarea").val(currentVal);
    })
}

function getDependingPractise(){
    if("{{$practise['id']}}"=="15628460315d27234f97724"){
        topic_id=$('.topic_id').val();
        task_id=$('.depend_task_id').val();
        practise_id=$('.depend_practise_id').val();
        student_id = "{{request()->segment(4)}}";
    }else{
        topic_id= $(".save_three_blank_table_with_check_form_{{$practise['id']}}").find('.topic_id').val();
        task_id=$(".save_three_blank_table_with_check_form_{{$practise['id']}}").find('.depend_task_id').val();
        practise_id=$(".save_three_blank_table_with_check_form_{{$practise['id']}}").find('.depend_practise_id').val();     
        student_id = "{{request()->segment(4)}}";
    }
   

    $.ajax({
        url: "{{url('get-student-practisce-answer')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{
            topic_id,
            task_id,
            practise_id,
            student_id
        },
        dataType:'JSON',
        success: function (data) {
            // console.log(data);
            // if(typeof data['user_Answer'][0] != undefined){
            //   $("#dependant_pr_{{$practise['id']}}").css("display", "block");
            //   $(".save_three_blank_table_with_check_form_{{$practise['id']}}").css("display", "none");
            //   return false;
            // }else{
            //    $("#dependant_pr_{{$practise['id']}}").css("display", "none");
            //    $(".save_three_blank_table_with_check_form_{{$practise['id']}}").css("display", "block");
            // }
            // debugger;
            // console.log('====>',data);
            // var results =  document.location +data.user_Answer[0];
            // answers      = data.user_Answer[0];

            var prevtable = $('#abc-{{$depend[1]}}').find('.table-container').find('.table-container').html();
           // console.log('===>',prevtable);
          //  return false;
            prevtable = prevtable.replace(/w-50/g, 'w-33');
            // prevtable = prevtable.replace('/contenteditable/g','');
            $('.appended').html(prevtable);
         //   $(document).find('span.textarea').removeAttr('contenteditable')

            var lastcolumn = '<div class="d-flex justify-content-center align-items-center th w-33">Self Mark</div><div style="display:none"><textarea name="col[]">Self Mark</textarea><input type="hidden" name="true_false[]" kk value="false"></div>';
            $('.appended').find('.table-heading').last().append(lastcolumn);


            $('.appended .table-row').each(function(index){
                $(this).find('input[type=hidden]').val(false);
                var lastcheckbox = '<div class="d-flex justify-content-center align-items-center  border-left td w-33 td-textarea"><div class="custom-control custom-checkbox custom-checkbox_single custom-checkbox_single_dark custom-checkbox_correct"><input type="checkbox" class="custom-control-input" id="cc'+index+'" required=""><label class="custom-control-label" for="cc'+index+'"></label><textarea name="col[]" style="display:none;" value=""></textarea><input  type="hidden" name="true_false[]" value="true"></div></div>';
                $(this).last().append(lastcheckbox);
            })

           
        }
    });
}

// $(document).on('change', 'input[type="checkbox"]', function(e) {
//     e.preventDefault();
//     if($(this).is(":checked")){
//        $(this).closest('div').find('input[type=hidden]').val(true);
//        $(this).closest('div').find("textarea").val(1).html(1);

//     }
//     else if($(this).not("checked")){
//         $(this).closest('div').find('input[type=hidden]').val(false);
//         $(this).closest('div').find("textarea").val(0).html(1);
//     }
// });
$(document).on('change', 'input[type="checkbox"]', function(e) {
    e.preventDefault();
    var ischecked= $(this).is(':checked');

    if(ischecked){
        $(this).closest('div').addClass('custom-checkbox_correct');
        $(this).prop('checked', true);
        $(this).attr('checked','checked');
        // $(this).closest('div').find('input[type=hidden]').val(true);
        $(this).closest('div').find("textarea").val(1).html(1);
        if($(this).parent('div').hasClass('custom-checkbox_incorrect')){
            $(this).closest('div').removeClass('custom-checkbox_incorrect');
        }
    }
    if(!ischecked)
    {
        if($(this).parent('div').hasClass('custom-checkbox_correct'))
        {
            $(this).closest('div').removeClass('custom-checkbox_correct').addClass('custom-checkbox_incorrect');
            $(this).prop('checked', true);
            $(this).attr('checked','checked');
            $(this).val(0);
            //$(this).closest('div').find('input[type=hidden]').val(false);
            $(this).closest('div').find("textarea").val(0).html(1);
        }
        else
        {
            $(this).closest('div').removeClass('custom-checkbox_incorrect').addClass('custom-checkbox_correct');
            $(this).prop('checked', true)
            $(this).attr('checked','checked');
          //  $(this).closest('div').find('input[type=hidden]').val(true);
             $(this).closest('div').find("textarea").val(1).html(1);
        }
    }

})

$(document).on('click','.threeBlankTableWithCheckBtn_{{$practise['id']}}' ,function() {
      $('.threeBlankTableWithCheckBtn_{{$practise['id']}}').attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);
      setTextareaContent();

      $.ajax({
          url: '<?php echo URL('save-three-blank-table-speaking-writing-form'); ?>',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $('.save_three_blank_table_with_check_form_{{$practise['id']}}').serialize(),
          success: function (data) {
                $('.threeBlankTableWithCheckBtn_{{$practise['id']}}').removeAttr('disabled');
                if(data.success){
                    $('.alert-danger').hide();
                    $('.alert-success').show().html(data.message).fadeOut(4000);
                }else{
                    $('.alert-success').hide();
                    $('.alert-danger').show().html(data.message).fadeOut(4000);
                }
          }
      });
    });


</script>

<script>
    $(document).ready(function()
    {
        // $('.nav-item').find('a').on('shown.bs.tab', function () {

        // });
        if("{{$practise['id']}}"=="15628460315d27234f97724"){
            var practise_id=$('.depend_practise_id').val();
        }else{
            var practise_id=$(".save_three_blank_table_with_check_form_{{$practise['id']}}").find('.depend_practise_id').val();
        }
        if(practise_id){
            getDependingPractise() ;
        }

    })

</script>
<?php if($practise['type'] == 'three_blank_table_with_check'): ?>

<script>

    var isanswerExists = '<?php echo $answerExists; ?>';
    $(window).on('load', function() {
        if(isanswerExists !== "" && (isanswerExists == true || isanswerExists == "1"))
        {
            var answers = '<?php echo isset($final_answer) ? $final_answer : ''; ?>';
            var a = JSON.parse(answers);

            $('.appended .table-row').each(function(i){

                var checkbox = $('input:checkbox').eq(i);
                var textarea = $(checkbox).next().next();
                var hiddenfiled = $(checkbox).next().next().next();

                var value = a[i];
                if(value=='1'){
                    $(checkbox).parent().addClass('custom-checkbox_correct')
                    $(checkbox).prop('checked', value);
                    $(hiddenfiled).val(1);
                    $(textarea).html(Number(value)).val(Number(value)).attr('value', Number(value))
                }else if(value=='0'){
                    $(checkbox).parent().addClass('custom-checkbox_incorrect')
                    $(checkbox).prop('checked', value);
                    $(hiddenfiled).val(1);
                    $(textarea).html(Number(value)).val(Number(value)).attr('value', Number(value));
                } else{
                    $(hiddenfiled).val(1);
                    $(textarea).html('').val('').attr('value', '')
                    console.log('============')
                }
            });
        }
        else
        {
            $('.appended .table-row').each(function(i){
                var checkbox = $('input:checkbox').eq(i);
                var hiddenfiled = $(checkbox).next().next().next();
                $(hiddenfiled).val(1);              
            });
            return false;
        }

    });
</script>
<?php endif ?>
