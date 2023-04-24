<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<link rel="stylesheet" href="{{ asset('public/literally/css/literallycanvas.css') }}">
<style>
.literally {
  width: 100%;
  height: 100%;
  position: relative;
  background-color: #fff !important
}
.literally .lc-picker{
  background-color: transparent !important
}
.literally .horz-toolbar{
  background-color: transparent !important
}
.draw_img_full_screen {
    width: 100%;
}
.draw_img_full_screen img {
    width: 100%;
}
.draw-image > a::before {
    background: none;
}
.draw-image > a::after {
    background: none;
}
.lc-font-settings{
    background-color: #30475e !important
}
.special {
    position: absolute !important;
    left: -83px !important;
}
</style>
<p>
<strong><?php
echo $practise['title'];
?></strong>
</p>
<?php
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
    }
    if(!empty($practise['question_2'])){
      foreach ($practise['question_2'] as $key => $value) {
        if(str_contains($value,'{}')){
            $options = str_replace('{}','',$value);
            $exp_options = explode('@@', $options);
        }
      }
    }
  ?>
<form class="form{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  <input type="hidden" class="is_roleplay" name="is_roleplay" value="true">
  <div class="component-two-click mb-4">
    @if(!empty($exp_options))
      <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
        @foreach($exp_options as $key => $value)
          <a href="javascript:void(0)" class="btn mb-4 btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
        @endforeach
      </div>
    @endif
    @if(!empty($exp_options))

      <div class="two-click-content w-100">
        <?php $i=0; ?>
        @foreach($exp_options as $key => $value)
        <?php
      //  pr($practise);
            $load_image =  !empty($practise['user_answer'][$i][1])    ? $practise['user_answer'][$i][1] : ""  ;
            if(!empty($load_image)){
              $filename =  explode('/', $practise['user_answer'][$i][1] );
              $local_path = asset('/public/images/draw/').'/'.end($filename);
              @$rawImage = file_get_contents($load_image);
              if($rawImage)
              {
                file_put_contents("./public/images/draw/".end($filename),$rawImage);
                $load_image = asset('/public/images/draw/').'/'.end($filename);
              }
            }
        ?>
          <div class="content-box multiple-choice d-none selected_option_description_{{$key}}" id="police">
            <div class="w-75 mr-auto ml-auto mb-4">
                <div class="draw-image mb-4">
                  <img  src="{{ $practise['question'][$key] }}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain; padding:10px;"  class="mr-n4 img-fluid" id="saved_image">
                </div>
            </div>
            <div class="draw-image d-flex align-items-center justify-content-center mb-4">
                <input type="hidden" name="drawimage[{{$i}}][0]" class="audio_path{{$i}} audiopath" value="{{!empty($practise['user_answer'][$i][0])?$practise['user_answer'][$i][0]:''}}">
                <input type="hidden" id="drawimage_{{$i}}" name="drawimage[{{$i}}][1]" value="{{ $load_image }}" class="drawimage">
                <input type="hidden"  name="drawimage[{{$i+1}}]" value="##">
              <div id="svgid_{{$key}}" style="display: none"></div>
                <a href="#!" class="d-flex align-items-end openmodal" data-toggle="modal" data-target="#drawModal_{{$key}}" id="getdrawImage_{{$key}}">
                    <img  src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencil" crossOrigin="Anonymous" class="mr-n4 img-fluid" id="saved_image">
                </a>
            </div>
            <div class="modal" id="drawModal_{{$key}}" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true"  data-img="{{$load_image}}" data-value="{{$key}}">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
                        <div class="modal-header">
                            <h4 class="modal-title" style="color: #30475e"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="fs-container">
                                <div class="backgrounds" id="canvas__{{$key}}"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-no-border" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}"  data-dismiss="modal">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="audio-player d-flex flex-wrap justify-content-end">
              @include('practice.common.audio_record_div',['key'=>$i])
              <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$i}}" name="draw_image_speaking_single_image_{{$i}}" value="0">

            </div>
          </div>
          <?php $i+=2; ?>
        @endforeach
      </div>
    @endif
  </div>
</form>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
    $(".selected_option").on('click',function () {
      var content_key = $(this).attr('data-key');
      $('.selected_option').not(this).toggleClass('d-none');
      $('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.selected_option_'+content_key).show();
      $(this).toggleClass('btn-bg');
    });
  var canvas ={};
  var newImage = new Image();
  $(document).ready(function () {
    $('.modal').on('show.bs.modal', function(){
      var id = $(this).data('value');
      if(id==0){
        var canvasid = id;
      }else{
        var canvasid = id+1;
      }
      var answer_image = $(this).data('img');
      var saved_image_path =$("#drawimage_"+canvasid).val();
      if(saved_image_path!==undefined && (saved_image_path.includes('http') || saved_image_path=="")){
        $(".canvasSave_{{$practise['id']}}").attr('data-id',id)
        newImage.id = 'canvasimg_'+id
        newImage.src = answer_image;
        var question_image = $(this).data('wimg');
        var watermarkImage = new Image();
        watermarkImage.src = question_image;

        if(answer_image==""){
          var bg_img = watermarkImage
          var x_axis = 120;
          var y_axis = 100;
          var scaleimg = 0.5
        }else{
          var bg_img=newImage;
          var x_axis = 50;
          var y_axis = 20;
          var scaleimg = 0.8;
        }
        setTimeout(() => {
            canvas[id] =  LC.init( document.getElementsByClassName('backgrounds')[id],
            {
              imageURLPrefix: '{{ asset('public/literally/img') }}',
              toolbarPosition: 'top',
              defaultStrokeWidth: 2,
              strokeWidths: [1, 2, 3, 5, 30],
              keyboardShortcuts: false,
            });
            canvas[id].saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scaleimg}));
            window.dispatchEvent(new Event('resize'));
            
        }, 300);
      }
    });
    $(document).bind('touchmove', function (e) {
      if (e.target === document.documentElement) {
          return e.preventDefault();
      }
    });
  });
</script>
