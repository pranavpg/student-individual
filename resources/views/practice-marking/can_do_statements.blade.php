<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// pr(json_encode($practise));
$answerExists = false;
if(!empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];
}
if(!empty($practise['question'])){
  $question_list = explode(PHP_EOL,$practise['question']);
}
?>
<?php //dd($practise); ?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <div class="ieuks-vvvdc d-flex d-md-none"><img src="{{ asset('public/images/vdfeimg.jpg') }}" alt="vvdf"></div>
  <div class="table-container text-center ieuktbl-candossmnt-cntnr">
      <div class="table table-can ieuktbl-candossmnt">
          <div class="table-heading thead-dark d-flex justify-content-between">
              <div
                  class="d-flex justify-content-center align-items-center th w-33">
                  Can do statements</div>
              <div
                  class="d-flex flex-wrap justify-content-center align-items-center th w-33 p-0 table-split">
                  <div class="row w-100 border-bottom">
                      <div class="col-6 split-box">Very well</div>
                      <div class="col-6 split-box text-right">With dificulty</div>
                  </div>
                  <div class="row text-center w-100">
                      <div class="w-25 split-box border-right">1</div>
                      <div class="w-25 split-box border-right">2</div>
                      <div class="w-25 split-box border-right">3</div>
                      <div class="w-25 split-box">4</div>
                  </div>
              </div>
              <div
                  class="d-flex justify-content-center align-items-center th w-33">
                  Evidence / Topic</div>
          </div>
          <?php //echo '<pre>'; print_r($question_list); ?>
          @if(!empty($question_list))
            @foreach($question_list as $key => $value)

              <div class="table-row thead-dark d-flex justify-content-between">
                
                @if(!str_contains($value,'@@'))
          <div class="d-flex justify-content-left align-items-left td border-left w-33 wm-1001 p-3 ieuksm-cdstvvfd" title="Can do statements">
                <span style="text-align: left !important;">{{str_replace('@@','',$value)}}</span>
            </div>
                @else
          <div class="d-flex justify-content-left align-items-left td border-left w-33 wm-1001 p-3 ieuksm-ttlvvdf">
                <span style="text-align: left; font-weight:700;">{{str_replace('@@','',$value)}}</span>
          </div>
                @endif
                  <div class="d-flex justify-content-center align-items-center p-0 td w-33">
                    @if(!str_contains($value,'@@'))

                      <div class="d-flex h-100 w-100">
                        <input type="hidden" name="text_ans[{{$key}}][question]" value="{{$value}}">
                        <?php for ($i=1; $i <=4 ; $i++) { ?>

                          <div class="col-3 ieuk-vvdfrbtn p-3 d-flex align-items-center justify-content-center {{ ($i<4)?'border-right':''}}" title="{{$i}}">

                              <div class="custom-control custom-radio">
                                  <input type="radio"
                                  id="customRadio{{$key}}_{{$i}}"
                                  name="text_ans[{{$key}}][selection]"
                                  value="{{$i}}" {{ ($answerExists && $answers[$key]['selection'] ==$i)?"checked":""}}
                                  class="custom-control-input">
                                  <label class="custom-control-label" for="customRadio{{$key}}_{{$i}}"></label>
                              </div>
                          </div>
                        <?php } ?>

                      </div>
                      @else
                        <input type="hidden" name="text_ans[{{$key}}][question]" value="{{$value}}">
                        <input type="hidden" name="text_ans[{{$key}}][selection]" value="-1">
                        <input type="hidden" name="text_ans[{{$key}}][extra_text]" value="">
                      @endif
                  </div>
                   <div class="d-flex justify-content-center align-items-center td w-33" title="Evidence / Topic: ">
                  <?php
                          if ($answerExists)
                          {
                             $ans=  !empty($answers[$key]['extra_text'])?$answers[$key]['extra_text']:'';
                          }else{
                            $ans='';                         
                          }
                        ?>
                         @if(!str_contains($value,'@@'))
                    <span class="textarea form-control form-control-textarea stringProper" role="textbox" contenteditable disabled placeholder="Write here...">{!!$ans!!}</span>
                      @endif
                    <div style="display:none">
                      <textarea name="text_ans[{{$key}}][extra_text]">
                      <?php
                          if ($answerExists)
                          {
                            echo  !empty($answers[$key]['extra_text'])?$answers[$key]['extra_text']:'';
                          }
                      ?>
                      </textarea>
                    </div>
                  </div>
              </div>
            @endforeach
          @endif
      </div>
  </div>
  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  
</form>
<script>
function setTextareaContent(){
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
    var currentVal = $(this).html();
    var currentVal = $(this).html();
    var regex = /<br\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "\n");
    var regex = /<\/div\s*[\/]?>/gi;
    currentVal=currentVal.replace(regex, "");
    var regex = /&nbsp;/gi;
    currentVal=currentVal.replace(regex, "");
    $(this).next().find("textarea").val(currentVal);
  });
}
</script>
