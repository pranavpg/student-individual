        <?php //echo '<pre>'; print_r($practise); exit;

// dd($practise);
        ?>
        <p>
          <strong><?php
          echo $practise['title'];
          $checkbox_width='w-25';
          
          ?></strong>
        </p>
          <form class="save_multi_tick_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          <div class="multiple-check d-flex flex-wrap">
          <?php 
         
          if(str_contains($practise['question'],'1 #@')){
            $checkbox_width='w-100';
          
          }
          $exploded_question  =  explode("@@", $practise['question']); $i=1;
          $exploded_question = array_filter($exploded_question);
          $exploded_question = array_merge($exploded_question);
// dd($exploded_question);
          
          ?>
          @if(isset($practise['user_answer'][0]) && !empty($practise['user_answer'][0]))
              @foreach($practise['user_answer'][0] as $item)
                  <div class="custom-control custom-checkbox {{$checkbox_width}}">
                      <input type="checkbox" class="custom-control-input" id="cc{{$i}}"   name="checkBox[]" value="{{$item['name']}}" <?php if($item['checked']==true){echo "checked"; } ?>>
                      <label class="custom-control-label" for="cc{{$i}}"> {{str_replace('1 #@','',$item['name'])}}</label>
                          <input type="hidden" name="question[]" value="{{str_replace('1 #@','',$item['name'])}}">
                  </div>
                  <?php $i++;?>
              @endforeach
          @else
            @foreach($exploded_question as $item)
                  <div class="custom-control custom-checkbox {{$checkbox_width}}">
                      <input type="checkbox" class="custom-control-input" id="cc{{$i}}"   name="checkBox[]" value="{{$item}}">
                      <label class="custom-control-label" for="cc{{$i}}">
                          {{str_replace('1 #@','',$item)}}</label>
                          <input type="hidden" name="question[]" value='{{str_replace('1 #@','',$item)}}'>
                  </div>
                  <?php $i++;?>
              @endforeach
          @endif 
          </div>
                 
          <div class="alert alert-success" role="alert" style="display:none"></div>
				  <div class="alert alert-danger" role="alert" style="display:none"></div>
        <!-- <ul class="list-inline list-buttons">
            <li class="list-inline-item">
              <a href="#!" class="btn btn-secondary"
                    data-toggle="modal" data-target="#exitmodal">Save</a>
                    <input type="button" class="multiTickBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
             <input type="button" class="multiTickBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">

            </li>
        </ul> -->
        
      </form>
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
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
      $(document).on('click',".multiTickBtn_{{$practise['id']}}" ,function() {
        $(".multiTickBtn_{{$practise['id']}}").attr('disabled','disabled');
        var is_save = $(this).attr('data-is_save');
        $('.is_save:hidden').val(is_save);
        // setTextareaContent();
        $.ajax({
            url: "{{url('save-multiple-tick')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: $(".save_multi_tick_form_{{$practise['id']}}").serialize(),
            success: function (data) {
              $(".multiTickBtn_{{$practise['id']}}").removeAttr('disabled');

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
<script src="{{ asset('public/js/audioplayer.js') }}"></script>