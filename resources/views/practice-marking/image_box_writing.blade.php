<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
// dd($practise);
  $answerExists = false;
  $q_top = array();
  $q_bottom = array();
  if(!empty($practise['user_answer'])){
      $answerExists = true;
      $answers = $practise['user_answer'];

  }

  if(!empty($practise['question'])){
    $q_top = $practise['question'];
  }
  if(!empty($practise['question_2'])){
    $q_bottom = $practise['question_2'];
  }
  if($practise['type']=='image_two_box_writing'){
    $width="100%";
  }else{
    //$width='175px';
    $width='';
  }
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
<?php
      if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid'])){
        $depend =explode("_",$practise['dependingpractiseid']);
      ?>
        <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
        <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
      <?php } ?>
   <?php
        // dd($q_bottom);
        if(!empty($q_bottom)){


            $bottom_option = explode('#!',$q_bottom[0]);
            $bottom_option = explode('#%',$bottom_option[0]);

            if(count($bottom_option)==2){
            ?>

             <div style="text-align: center;margin-bottom: 29px;">
                  <button class="btn btn-primary" id='openmodel'>{{$bottom_option[0]}}</button>
            </div>

             <div class="modal fade" id="myModalImage" role="dialog">
                  <div class="modal-dialog">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      
                      <div class="modal-header">
                      
                        <h4 class="modal-title">{{$bottom_option[0]}}</h4>
                      </div>
                      <div class="modal-body">
                        {!!$bottom_option[1]!!}
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                    
                  </div>
                </div>

       <?php } 
      } ?>
    <div class="image-box__writting row mx-auto">

      <?php 

        if(isset($practise['dependingpractiseid'])){

            $exploded_question1= explode('#@',$practise['depending_practise_details']['question']);
            if (strpos($exploded_question1[1], '@@') !== false) {

                        $exploded_question  =  explode('@@',$exploded_question1[1]);
                        $col = $exploded_question1[0];
                        $row = substr($exploded_question1[1],1,1);
                         ?>
                        <div class="multiple-draw row mb-5">
                            @foreach($exploded_question as $key=>$item)

                            <?php
                            //pr($practise);
                                $load_image = ( ( isset($practise['dependingpractise_answer']) && array_key_exists($key, $practise['dependingpractise_answer']) ) ? $practise['dependingpractise_answer'][$key] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['dependingpractise_answer'][$key] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
                                  //file_put_contents(end($filename), file_get_contents('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png'));
                                  @$rawImage = file_get_contents($load_image);
                                  if($rawImage)
                                  {
                                    file_put_contents("./public/images/draw/".end($filename),$rawImage);
                                    $load_image = asset('/public/images/draw/').'/'.end($filename);
                                  }

                                }
                            ?>

                            <input type="hidden" id="drawimage_{{$key}}" name="drawimage[{{$key}}]" value="{{$load_image}}"  class="drawimage">
                            <input type="hidden" id="drawimagefinal_{{$key}}"  value="{{$load_image}}"  class="drawimagefinal">
                            
                               
                               

                            <div id="svgid_{{$key}}" style="display: none"></div>

                            <div class="col-3 draw-box mb-4">
                                <div class="draw-heading text-center">
                                    <h3>{{$item}}</h3>
                                </div>
                                <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
                                    @if( !empty($load_image) || $load_image !== "" || $load_image !== " ")
                                        <a href="#!" class="d-flex align-items-end openmodal" data-toggle="modal" data-target="#drawModal_{{$key}}" id="getdrawImage_{{$key}}">
                                            <img src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencil" class="img-fluid">
                                            <p id="text-info_{{$key}}">{{ $load_image == "" ? 'Click here to draw' : "" }}</p>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="modal" id="drawModal_{{$key}}" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true" data-img="{{$load_image}}" data-finalimg="{{$load_image}}" data-value="{{$key}}">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                    <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="color: #30475e">{{$item}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="fs-container">
                                                <div class="backgrounds" id="canvas__{{$key}}"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger close_popup"  data-key="{{$key}}">Close</button>
                                            <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}" data-value="{{$key}}"  data-dismiss="modal">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </div>

            <?php }else{

                        $exploded_question1= explode('#@',$practise['depending_practise_details']['question']);
                        $exploded_question  =  explode('@@',$exploded_question1[1]);
                        $col = $exploded_question1[0];
                        $row = substr($exploded_question1[1],1,1);
                         ?>
                        <div class="multiple-draw row mb-5">
                            @for($i=0;$i<$exploded_question[0];$i++)

                            <?php
                            //pr($practise);
                                $load_image = ( ( isset($practise['dependingpractise_answer']) && array_key_exists($i, $practise['dependingpractise_answer']) ) ? $practise['dependingpractise_answer'][$i] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['dependingpractise_answer'][$i] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
                                  //file_put_contents(end($filename), file_get_contents('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png'));
                                  @$rawImage = file_get_contents($load_image);
                                  if($rawImage)
                                  {
                                    file_put_contents("./public/images/draw/".end($filename),$rawImage);
                                    $load_image = asset('/public/images/draw/').'/'.end($filename);
                                  }

                                }
                            ?>

                            <input type="hidden" id="drawimage_{{$i}}" name="drawimage[{{$i}}]" value="{{$load_image}}"  class="drawimage">
                            <input type="hidden" id="drawimagefinal_{{$i}}"  value="{{$load_image}}"  class="drawimagefinal">
                            
                               
                               

                            <div id="svgid_{{$i}}" style="display: none"></div>

                            <div class="col-6 draw-box mb-6">
                                        @if(isset($load_image) && $load_image)
                                            <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
                                                @if( !empty($load_image) || $load_image !== "" || $load_image !== " ")
                                                        
                                                        <img src="{{ isset($load_image) && $load_image !== "" ? $load_image :'' }}" alt="Pencil" class="img-fluid">
                                                        <p id="text-info_{{$i}}">{{ $load_image == "" ? 'Click here to draw' : "" }}</p>
                                                   
                                                @endif
                                            </div>
                                    @endif
                                <?php 
                                    $ans = "";
                                    if(!empty($answers)){
                                        $ans = $answers[$i][0];

                                    }
                                ?>
                                <div class="">
                                    <span class="textarea form-control form-control-textarea spandata fillblanks" id="{{$i}}" role="textbox"  disabled  contenteditable="true" placeholder="Write here..." style="width: 305px;margin-bottom: 15px;" >{{$ans}}</span>

                                    <div style="display:none">
                                      <input type="text" name="text_ans[{{$i}}][]" class="text_ans" id="text_{{$i}}" value="{{$ans}}">
                                    </div>

                                </div>
                            </div>

                            @endfor
                        </div>
                        <script type="text/javascript">
                            $('.spandata').keyup(function(){
                                $('#text_'+$(this).attr("id")).val($(this).html())
                            });
                        </script>
                        <style type="text/css">
                            .textarea{
                              border-bottom: 1px solid gray;
                              outline: none;
                              margin-top: 20px;
                            }
                            .textarea[contenteditable="true"]:empty:not(:focus):before {
                              content: attr(placeholder)
                            }

                        </style>
            <?php }
       
                   
        }

      ?>


      @if(!empty($q_top))
        @foreach($q_top as $key => $value)
        <?php
          $bottom_option = explode(' @@ ',$q_bottom[$key]);
          //pr($bottom_option);
        ?>
        <div class="col-6 writting mb-6 mb-2">
          <picture class="picture mb-3 ">
              <img src="{{$value}}" alt="" width="{{$width}}" class="img-fluid img-thumbnail">
          </picture>
          <!-- Component - Form Control-->
          @if(!empty($bottom_option))
            @foreach($bottom_option as $k => $v)
              @if($practise['type']=='image_two_box_writing')
              <p class="mb-0"><strong>{{ str_replace('2#@', '', $v)}} </strong></p>
              @endif
             
             

             
              <div class="form-group">
                <span class="textarea form-control form-control-textarea " role="textbox"  disabled contenteditable placeholder="Write here..."><?php if ($answerExists) {echo  !empty($answers[$key][$k])? str_replace(" ","&nbsp;",$answers[$key][$k]) :'';}?></span>

                <div style="display:none">
                  <textarea name="text_ans[{{$key}}][{{$k}}]">
                  <?php
                      if ($answerExists) {
                        echo  !empty($answers[$key][$k])? str_replace(" ","&nbsp;",$answers[$key][$k]) :'';
                      }
                  ?>
                  </textarea>
                </div>
              </div>
            @endforeach
          @endif

        </div>
      @endforeach
    @endif
  </div>

</form>

<script>
function setTextareaContent(){
  $('.form_{{$practise["id"]}}').find("span.textarea.form-control").each(function(){
    var currentVal = $(this).html();
    $(this).next().find("textarea").val(currentVal);
  });
}

    setTimeout(function(){
      // $('#cover-spin').fadeIn();
      getSpeakingMultipleDependency();
    },5000);
    
    function getSpeakingMultipleDependency(){

      var topic_id= $(".form_{{$practise['id']}}").find('.topic_id').val();
      var task_id=$(".form_{{$practise['id']}}").find('.depend_task_id').val();
      var practise_id=$(".form_{{$practise['id']}}").find('.depend_practise_id').val();
      var dependent_ans = '<?php echo !empty($user_ans)?json_encode($user_ans):"" ?>';
      console.log('d====>',dependent_ans)
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
        if(data.question!=null && data.question!=undefined){
          $('.form_{{$practise["id"]}}').find('.first-question').remove()
          $('.previous_practice_answer_exists_{{$practise["id"]}}').show();
          $('#dependant_pr_{{$practise["id"]}}').hide();
        } else {
          $('.previous_practice_answer_exists_{{$practise["id"]}}').hide();
          $('#dependant_pr_{{$practise['id']}}').show();
        }
        }
      });
    }
$('#openmodel').click(function(){
    $('#myModalImage').modal("show")
    return false;
})
</script>
