<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
   //pr($practise);
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'];
      //pr($answers);
    }
    $question_list = array();
    if(!empty($practise['question_2'])){
    //  pr(explode(PHP_EOL,$practise['question_2'][2]));
      foreach ($practise['question_2'] as $key => $value) {
        if(str_contains($value,'{}')){
          $options = str_replace('{}','',$value);
          $exp_options = explode('@@', $options);
        } else {
          $exploded_val =  preg_split('/<br[^>]*>/i', $value);

          if(count($exploded_val)>1){
            array_push($question_list, $exploded_val[0]);
            array_push($question_list, $exploded_val[2]);

          }else{

            array_push($question_list, $exploded_val[0]);
          }
        }
      }
    }
    $i=-1;
    $question =array();
    foreach ($question_list as $key => $value) {
      if($value=="##"){
        $i++;
      } else{
        $question[$i][$key]=$value;
      }
    }

  ?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" name="is_roleplay" value="true" >
  <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">

  <!-- Compoent - Two click slider-->
  <div class="component-two-click mb-4">

      @if(!empty($exp_options))
        <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
          @foreach($exp_options as $key => $value)
            <a href="javascript:void(0)" class="btn btn-dark selected_option_{{$practise['id']}} selected_option_{{$practise['id']}}_{{$key}}" data-key="{{$key}}">{{$value}}</a>
          @endforeach
        </div>
      @endif
      <div class="two-click-content w-100">
        @if(!empty($question))
          <?php
            $j = 0;
            $hh = 0;
            $count=0;
            $last_key = array_key_last($question);
          ?>
          @foreach($question as $key=> $que)
            <div  {{$key}} class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$practise['id']}}_{{$key}}"  >
              <div class="draw-image draw-image__small mb-5">
                <img style="margin-top:15px;margin-bottom:15px;" width="100%" height="100%" src="{{isset($practise['question'])?isset($practise['question'][$key])?$practise['question'][$key]:'':''}}" />
              </div>
              <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$hh}}" name="audio_reading_{{$hh}}" value="0">
              <?php   $hh = $hh+2;?>
              @include('practice.common.audio_record_div',['key'=>($key==0)?$key:$key+1])
                <?php $kk=0; ?>
              @foreach($que as $k => $v)
                @if(!str_contains($v,'@@'))
                  <p>{!! $v !!}</p>
                @else
                  <p class="mb-0">{{ str_replace('@@','', $v) }}</p>
                  <!-- Component - Form Control-->
                  <div class="form-group">
                    <span class="textarea form-control form-control-textarea" role="textbox"
                      contenteditable placeholder="Write here...">
                      <?php
                      if ($answerExists)
                      {
                          echo  !empty($answers[$j]['text_ans'][$kk])?nl2br($answers[$j]['text_ans'][$kk]):"";
                      }
                      ?>
                    </span>
                    <div style="display:none">
                      <textarea  name="user_answer[{{$j}}][text_ans][{{$kk}}]" class="main-answer-input">
                        <?php
                            if ($answerExists)
                            {
                              echo  !empty($practise['user_answer'][$j]['text_ans'][$kk])?$practise['user_answer'][$j]['text_ans'][$kk]:"";
                            }
                        ?>
                      </textarea>
                    </div>
                  </div>
                  <?php $kk++; ?>
                @endif

              @endforeach

            </div>
            <input type="hidden" name="user_answer[{{$j}}][audio_exists]" value="{{ !empty($practise['user_answer'][$j]['path'])?1:0}}">
            <input type="hidden" name="user_answer[{{$j}}][path]" class="audio_path{{$j}}" value="{{!empty($practise['user_answer'][$j]['path'])?$practise['user_answer'][$j]['path']:''}}">
            <?php $j++;
              if($last_key!=$key ){
            ?>
              <input type="hidden" name="user_answer[{{$j}}]" value="##">
            <?php } $j++; $count++;?>
          @endforeach
        @endif
      </div>
  </div>
  <p></p>
  <!-- ./ Compoent - Two click slider Ends-->

  <!-- /. List Button Start-->
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="submit_btn btn btn-primary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
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
  <script>
  $(function () {
    $(".selected_option_{{$practise['id']}}").click(function () {
      var pid  = "{{$practise['id']}}";
      var content_key = $(this).attr('data-key');
      $('.selected_option_'+pid).not(this).toggleClass('d-none');
      $('.selected_option_description_'+pid+'_'+content_key).toggleClass('d-none');
      $('.selected_option_'+pid+'_'+content_key).show();
      $(this).toggleClass('btn-bg');
      //  alert($('.selected_option_description:visible').length)
      // if( $('.selected_option_description:visible').length>0 ){
      //   $('.is_roleplay_submit').val(0);
      // } else {
       $('.is_roleplay_submit').val(0);
      // }
    });
  });
     // $(function () {

     //        $(".selected_option").click(function () {
     //            var content_key = $(this).attr('data-key');
     //            if( $('.selected_option_description:visible').length>0 ){
     //              $('.is_roleplay_submit').val(0);
     //            }else{
     //              $('.is_roleplay_submit').val(1);
     //            } 
     //        });
     //    });

  function setTextareaContent(){
    $("span.textarea.form-control").each(function(){
      var currentVal = $(this).html();
      $(this).next().find("textarea").val(currentVal);
    })
  }

  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {

    $('.submitBtn').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent();
     var reviewPopup = '{!!$reviewPopup!!}';
      var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
      if(markingmethod =="student_self_marking"){
        if($(this).attr('data-is_save') == '1'){                    
            $('#practise_div').html("");
            var fullView= $(".form_{{$practise['id']}}").clone(true);
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
            $("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find(".textarea").attr("contenteditable",false);
        }
      }
      if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');
      }
    $.ajax({
        url: '<?php echo URL('save-single-image-writing-at-end-speaking'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: $('.form_{{$practise["id"]}}').serialize(),
        success: function (data) {
          $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
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
  var token = $('meta[name=csrf-token]').attr('content');
  var upload_url = "{{url('upload-audio')}}";
  var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
 /* $(document).on('click','.delete-icon', function() {
    $('.practice_audio').attr('src','');

    $('.audioplayer-bar-played').css('width','0%');
    $(this).hide();
    $('div.audio-element').css('pointer-events','none');
    //$('.submitBtn').attr('disabled','disabeld');
    var practise_id = $(this).find('a').attr('data-pid');
    $(this).parent().find('.record-icon').show();
    $(this).parent().find('.stop-button').hide();
    $.ajax({
        url: '<?php //echo URL('delete-audio'); ?>',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {practice_id:practise_id},
        success: function (data) {

        }
    });
  });*/
  </script>
  <script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
