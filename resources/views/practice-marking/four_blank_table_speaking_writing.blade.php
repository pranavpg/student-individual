<?php 

    // dd($practise);

?>

    <p>
        <strong><?php echo $practise['title']; ?></strong>

    </p>
  
            @if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
            @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
                <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
                    <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
                </div>
            @endif

          <form class="save_four_blank_table_speaking_writing_form_{{$practise['id']}}">
            <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
            <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
            <input type="hidden" class="is_save" name="is_save" value="">
            <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
            <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
            <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">


            <?php

            $exploded_question  =  explode(PHP_EOL, $practise['question']); $i=0;
            // dd($exploded_question);
            $table_header = explode('@@', $exploded_question[0]);
            $table_header = str_replace('\t','',$table_header);

            $answerExists = false;
            if (isset($practise['user_answer']) && !empty($practise['user_answer']))
            {
                $answerExists = true;
            }

            if(is_numeric($exploded_question[1]))
            {
                $firstColumns = array();
            }
            else
            {
                $firstColumns = explode('@@', $exploded_question[1]);
                $exploded_question[1] = count($firstColumns);

            }

           // dd($exploded_question);
            if($practise['type'] == "four_blank_table_speaking_writing")
            {
                $columnCount = 4;
                $columnClass = 'w-25';
                
            }
            // dd($answerExists);
            ?>

<div class="table-container mb-4 text-center four_table_parent">
    <div class="table w-75 m-auto">
        <div class="table-heading thead-dark d-flex justify-content-between">
            @foreach($table_header as $key=> $table_head)
                <?php $table_head = str_replace('/t','',$table_head); ?>
                <div class="d-flex justify-content-center align-items-center th {{ $columnClass }} ">{{$table_head}}</div>
                <div style="display:none">
                    <textarea name="col[]">{{ $table_head }}</textarea>
                    <input type="hidden" name="true_false[]" value="false" />
                </div>
            @endforeach
        </div>

        @for($j = 0;$j < 9 ;$j++) <!-- Total Question Loop -->
            <div class="table-row thead-dark d-flex justify-content-between ">
                @for($k = 1; $k <= $columnCount; $k++) <!-- Total Column Loop -->
                    <div class="d-flex justify-content-center align-items-center  border-left td {{ $columnClass }} td-textarea">
                        @if($k == 1 && isset($firstColumns) && !empty($firstColumns) )
                            <span class="textarea form-control form-control-textarea temp four_table col_{{$j+1}}_{{$k}}"></span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}"></textarea>
                                <input type="hidden" name="true_false[]" value="false" />
                            </div>
                        @else
                            <span class="textarea form-control form-control-textarea temp four_table col_{{$j+1}}_{{$k}}" role="textbox" contenteditable="true" placeholder="Write here...">
                            @if($answerExists && isset($practise['user_answer']))
                                 
                            @endif
                            </span>
                            <div style="display:none">
                                <textarea name="col[]" class="col_{{$j+1}}_{{$k}}">
                                @if($answerExists && isset($practise['user_answer']))
                                    
                                @endif
                                </textarea>
                                <input type="hidden" name="true_false[]" value="true" />
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endfor
    </div>
</div>

<div class="form-group">
    @if($practise['type']=="four_blank_table_speaking_writing")
                      <input type="hidden" name="audio_answer" class="audio_path0">
                        <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="four_blank_table_speaking_writing" value="0">

        @include('practice.common.audio_record_div',['key'=>0])
    @endif
</div>


    <div class="form-group audioparrent">
        <span class="textarea form-control form-control-textarea temp" role="textbox" contenteditable="true" placeholder="Write here..." style="white-space: pre-line;">{{ isset($practise['user_answer'][0]['text_ans'][1][0]) && !empty($practise['user_answer'][0]['text_ans'][1][0]) && $answerExists == true ? trim($practise['user_answer'][0]['text_ans'][1][0]) : "" }}</span>
        <div style="display:none">
            <textarea name="block">
                {{ isset($practise['user_answer'][0]['text_ans'][1][0]) && !empty($practise['user_answer'][0]['text_ans'][1][0]) && $answerExists == true ? $practise['user_answer'][0]['text_ans'][1][0] : ""  }}
            </textarea>
        </div>
    </div>
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons butttton">
                <li class="list-inline-item"><button type="button" class="btn btn-secondary four_blank_table_speaking_writingBtn{{$practise['id']}}"
                         data-is_save="0" >Save</button>
                </li>
                <li class="list-inline-item"><button type="button"
                        class="btn btn-secondary four_blank_table_speaking_writingBtn{{$practise['id']}}" data-is_save="1" >Submit</button>
                </li>
            </ul>

            <input type="hidden" name="table_type" value="<?php echo $columnCount; ?>" />
    </form>
    <?php 
        $onlyLastVlaue = [];
        if(isset($practise['depending_practise_details']['independant_practise']['user_answer'][0][0])){
            foreach ($practise['depending_practise_details']['independant_practise']['user_answer'][0][0] as $key => $value) {
                if($key != 0) {

                array_push($onlyLastVlaue,$value['col_2']);
                }
        }
        }
       
        // dd($onlyLastVlaue);
    ?>

    <script type="text/javascript">
        var checkAns  = '<?php echo $answerExists; ?>' ;
        var practiseId  = '<?php echo $practise['id']; ?>' ;

        $(document).ready(function(){
            $('.cover-spin').fadeIn();
        });
    function setTextareaContent(){
        $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}} span.textarea.form-control").each(function(){
            var currentVal = $(this).html();
            $(this).next().find("textarea").val(currentVal);
        })
    }
    function getDependingPractises(){

        var topic_id= $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('.topic_id').val();
        var task_id=$(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('input.depend_task_id').val();
        var practise_id=$(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").find('input.depend_practise_id').val();
        var storagedata = localStorage.getItem('{{$topicId}}_{{ Session::get('user_data')['student_id']}}');
        var previousdata = "<?php echo addslashes(json_encode($onlyLastVlaue))  ; ?>";
        var predata = JSON.parse(previousdata);
        $.ajax({
            url: "{{url('get-student-practisce-answer')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data:{
                topic_id,
                task_id,
                practise_id
            },
            dataType:'JSON',
            success: function (data) {
                console.log(data);
                // console.log(data.question.split("\r\n"));
                if(typeof(data.question)!="undefined"){
                    var dependancyData = data.question.split("\r\n");
                    var dependancyOrinalData = dependancyData[1].split("@@");

                    if(data['success'] == false|| jQuery.isEmptyObject(data) == true && storagedata == ""){
                      $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                      $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").css("display", "none");
                      return false;
                    }
                    else
                    {
                        $("#dependant_pr_{{$practise['id']}}").css("display", "none");
                        $(".save_four_blank_table_speaking_writing_form_{{$practise['id']}}").css("display", "block");
                        
                        if(!checkAns){
                            if (typeof data['user_Answer'][0] !== 'undefined') {
                                var result = data['user_Answer'][0]['text_ans'][0];
                            
                                console.log('4====>',result);
                                console.log(result);
                                // alert(data.length);
                                for(var i=0; i< 9; i++)
                                {
                                    if(i>0){

                                        $('.four_table.col_'+i+'_1').html(result[i]['col_1']).val(result[i]['col_1'])
                                        $('.four_table.col_'+i+'_2').html(predata[i-1])
                                        $('.four_table.col_'+i+'_3').html(result[i]['col_2']).val(result[i]['col_2'])
                                        $('.four_table.col_'+i+'_4').html(result[i]['col_3']).val(result[i]['col_3'])
                                    }
                                }


                              var i=0;
                              $('.four_table').each(function(key){
                                    if(key>3){
                                        if($(this).text()!=""){
                                            // $(this).removeAttr("contenteditable")
                                        }
                                    }else{
                                        // $(this).removeAttr("contenteditable")
                                    }
                              });

                              $( ".four_table_parent .table-row" ).last().remove();
                              // console.log(divcount);

                                // alert("1asd")
                            }else{
                                // alert("asd")
                                $("#dependant_pr_{{$practise['id']}}").css("display", "block");
                                $('.save_four_blank_table_speaking_writing_form_{{$practise['id']}}').fadeOut();
                                $('.audioparrent').fadeOut();
                                $('.temp').fadeOut();
                                $('.butttton').fadeOut();
                            }
                        }else{

                                    var result = <?php echo json_encode(isset($practise['user_answer'])?$practise['user_answer'][0]['text_ans'][0][0]:[]); ?>;
                                    console.log(result);
                              
                                    for(var i=0; i< 9; i++)
                                    {
                                        if(i>0){

                                            $('.four_table.col_'+i+'_1').html(result[i]['col_1']).val(result[i]['col_1'])
                                            $('.four_table.col_'+i+'_2').html(result[i]['col_2']).val(result[i]['col_2'])
                                            $('.four_table.col_'+i+'_3').html(result[i]['col_3']).val(result[i]['col_3'])
                                            $('.four_table.col_'+i+'_4').html(result[i]['col_4']).val(result[i]['col_4'])
                                        }
                                    }
                                  $( ".four_table_parent .table-row" ).last().remove();
                        }
                    }
                
   
                
                if(practiseId == "15567291835cc9cd5fd84e2"){
                    $('.save_four_blank_table_speaking_writing_form_{{$practise['id']}}').find('.textarea').each(function(){
                        if($(this).text()!=""){

                            $(this).removeAttr("contenteditable")
                        }
                        
                    });
                }
                }
               $('.cover-spin').fadeOut();
            }
        });

    }
    </script>
    <script type="text/javascript">

    $(window).on('load', function() {
  

        <?php if($practise['type'] == 'four_blank_table_speaking_writing'): ?>
            var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");
            if(practise_id){
                var x = getDependingPractises() ;
            }
        <?php endif; ?>
    })

    $(document).on('click','.four_blank_table_speaking_writingBtn{{$practise['id']}}' ,function() {
      $('.four_blank_table_speaking_writingBtn{{$practise['id']}}').attr('disabled','disabled');
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);
      setTextareaContent();
      $.ajax({
          url: '<?php echo URL('save_four_blank_table_speaking_writing_form'); ?>',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $('.save_four_blank_table_speaking_writing_form_{{$practise['id']}}').serialize(),
          success: function (data) {
                $('.four_blank_table_speaking_writingBtn{{$practise['id']}}').removeAttr('disabled');
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

     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script> -->
    <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>

    <script>
        var token = $('meta[name=csrf-token]').attr('content');
        var upload_url = "{{url('upload-audio')}}";
        var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
      /*$('.delete-icon').on('click', function() {
          $('.practice_audio').attr('src','');
          $(document).find('.stop-button').hide();
          $('.audioplayer-bar-played').css('width','0%');
          $('.delete-icon').hide();
          $('div.audio-element').css('pointer-events','none');

          var practise_id = $('.practise_id:hidden').val();
          $.ajax({
            url: '<?php //echo URL('delete-audio'); ?>',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {practice_id:practise_id},
            success: function (data) {
                $('.record-icon').show();
                $('.recordButton').show();
                $('.recordButton').attr('visible', true);
            }
        });
       });*/
   /*   setTimeout(function(){
        $('.delete-recording-{{$practise['id']}}-3').fadeIn();
      },2000)*/
    </script>
