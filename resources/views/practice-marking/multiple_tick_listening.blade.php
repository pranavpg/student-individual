
          <p>
          <strong><?php
          echo $practise['title'];
          ?></strong>
        </p>
          <form class="save_multi_tick_form_{{$practise['id']}}">
          <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
          <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
          <input type="hidden" class="is_save" name="is_save" value="">
          <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
          @if( !empty( $practise['audio_file'] ) )
					  @include('practice.common.audio_player')
					@endif

          <?php
          //echo '<pre>'; print_r($practise);
          if(strpos($practise['question'],' #@')){
            $class= 'multiple-check';
            $checkSize=" ";
            $practise['question'] =  str_replace("1 #@","@@",$practise['question']);
            $exploded_question  =  explode("@@", $practise['question']);
          }else{
            $class='multiple-check d-flex flex-wrap';
            $checkSize="w-25";
            if(isset($practise['options']) && !empty($practise['options'])){
              foreach($practise['options'] as $item){
                $exploded_question[] = $item[0];
              }
            }else{
              $exploded_question  =  explode("@@", $practise['question']);

            }
          }
            $i=1;
             //echo '<pre>'; print_r($practise);
           ?>
            <div class="{{$class}}">
          @if(isset($practise['user_answer'][0]) && !empty($practise['user_answer'][0]))
              @foreach($practise['user_answer'][0] as $item)
                  <div class="custom-control custom-checkbox {{$checkSize}}">
                      <input type="checkbox" class="custom-control-input" id="cc{{$i}}"   name="checkBox[]" value="{{$item['name']}}" <?php if($item['checked']==true){echo "checked"; } ?>>
                      <label class="custom-control-label" for="cc{{$i}}">
                     <?php echo $item['name']; ?></label>
                          <input type="hidden" name="question[]" value="{{$item['name']}}">
                  </div>
                  <?php $i++;?>
              @endforeach
          @else
            @foreach($exploded_question as $item)
              @if(!empty($item))
                  <div class="custom-control custom-checkbox {{$checkSize}}">
                      <input type="checkbox" class="custom-control-input" id="cc{{$i}}"   name="checkBox[]" value="{{$item}}">
                      <label class="custom-control-label" for="cc{{$i}}">
                      <?php echo $item ?> </label>
                          <input type="hidden" name="question[]" value='{{$item}}'>
                  </div>
                  <?php $i++;?>
                  @endif
              @endforeach
          @endif
          </div>
      </form>
    
      <script src="{{ asset('public/js/audioplayer.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<script src="{{ asset('public/js/audioplayer.js') }}"></script>
