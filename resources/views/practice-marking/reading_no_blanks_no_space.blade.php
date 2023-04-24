<p>
  <strong><?php
    // dd($practise);
  echo $practise['title'];
  ?></strong>
</p>
<style type="text/css">

  *[contenteditable]:empty:before
{
    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
}


.appendspan {
 color:red;
}

</style>
          <form class="save_reading_no_blank_no_space_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
              <?php 

                if (strpos($practise['question'], '#!') !== false) {
                    $Tapescript  =  explode("#!", $practise['question']);
                    $modelLable  =  explode("#%", $Tapescript[0]);
                    $exploded_question  =  explode(PHP_EOL, $Tapescript[1]);
                }else{
                    $exploded_question  =  explode(PHP_EOL, $practise['question']);
                }
                // dd($exploded_question);
              if( isset($practise['user_answer']) && !empty($practise['user_answer'])){
                $practise['user_answer'][0] = str_replace("&nbsp;", " ",$practise['user_answer'][0]);
                $usrAns = explode(';',$practise['user_answer'][0]);

              }
              $i=0 ; $k=0;
              // echo '<pre>'; print_r( $usrAns); exit;
              if (strpos($practise['question'], '#!') !== false) {
              ?>

                  <div style="text-align: center;">
                        <button class="btn btn-info" id="openmodal" style="margin-bottom: 16px;">{{$modelLable[0]}}</button>
                  </div>
                <?php } ?>
              <div class="paragraph-noun text-left">
                @foreach($exploded_question as $key=> $item)

                        <?php $questions  = explode("<br>",$item); ?>
                        @foreach($questions as $question)

                            @if(strpos($question,"@@"))
                                <?php
                                    $question = str_replace('@@','***@@',$question);
                                    $exQuestion= explode('@@',$question);
                                    // dd($exQuestion);
                                ?>
                                <ul class="list-inline">

                                       @foreach($exQuestion as $eq)
                                            @if(strpos($eq,"***"))
                                                <li class="list-inline-item1">
                                                  <?php
                                                  if(isset($usrAns[$i])){
                                                    $ans= $usrAns[$i++];

                                                  }else{
                                                    $ans= "";
                                                  }
                                                 
                                                  ?>

                                                <?php echo str_replace('***','<span class="resizing-input1" style="margin-left: -4px;">
                                                                                          <span contenteditable="true" class="enter_disable spandata fillblanks stringProper">'.$ans.'</span>
                                                                                           <input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox['.$k++.']" value="'.$ans.'">
                                                                                  </span>',$eq);  ?>

                                                </li>
                                            @else
                                                {{$eq}}
                                            @endif
                                        @endforeach

                                </ul>
                            @else
                               @if($question == '@@')
                               <?php
                                    $question = str_replace('@@','***@@',$question);
                                    $exQuestion= explode('@@',trim($question));
                                ?>
                                      <ul class="list-inline">

                                        @foreach($exQuestion as $eq)
                                          @if(isset($eq) && !empty($eq))
                                              <li class="list-inline-item1">
                                                <?php
                                                if(isset($usrAns[$i])){
                                                  $ans= $usrAns[$i++];

                                                }else{
                                                  $ans= "";
                                                }
                                                ?>
                                              <?php echo str_replace('***','<span class="resizing-input1" style="margin-left: -4px;">
                                                                                       <span contenteditable="true" class="enter_disable spandata fillblanks stringProper">'.$ans.'</span>
                                                                                      <input type="hidden" class="form-control form-control-inline appendspan" name="writeingBox['.$k++.']" value="'.$ans.'">
                                                                              </span>',$eq);  ?>

                                              </li>

                                @endif
                                        @endforeach
                                      </ul>
                               @else
                               <p>{!!$question!!}</p>
                              @endif

                            @endif

                        @endforeach

                @endforeach
              </div>
      </form>
        <?php  if (strpos($practise['question'], '#!') !== false) { ?>
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
                  <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">{!! $modelLable[0] !!}</h4>
                  </div>
                  <div class="modal-body">{!! $modelLable[1] !!}</div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
        <?php } ?>
      <script>
  $(document).ready(function(){
        setTimeout(function(){
        $('.appendspan').each(function(){
            $(this).closest('.resizing-input1').find('.enter_disable').text("")
            $(this).closest('.resizing-input1').find('.enter_disable').text($(this).val())
        });
        },500)
  })

  $(document).on('keyup','.spandata',function(){
      $(this).next().val($(this).html())
    })
  function CommonAnsSet(){
    $('.spandata').each(function(){
      $(this).next().val( $(this).html() )
    })
  }
  $(document).ready(function(){
    $('#openmodal').click(function(){
        $('#myModal').modal("show")
        return false;
    })
  });
</script>
