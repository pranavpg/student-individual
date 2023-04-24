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
</style> 

<p> <strong> {!! $practise['title'] !!} </strong> </p>
<?php 
 // pr($practise);
  $data[$practise['id']]['dependentpractice_ans'] = !empty($practise['dependingpractise_answer'])?1:0;
  $data[$practise['id']]['is_dependent'] = !empty($practise['is_dependent']) ? 1 : 0;
  $style="";
	if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == 1 && !empty($practise['dependingpractiseid']) ){
  		$depend =explode("_",$practise['dependingpractiseid']);
		  $style= "display:none"; 
?>
		<div id="dependant_pr_{{$practise['id']}}" style="margin-top:15px; border: 2px dashed gray; border-radius: 12px; display:none">
			<p style="margin: 15px;">In order to do this task you need to have completed
			<strong>Practice {{$depend[2]}} <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
		</div>
<?php
  }  
?>  
<div class="previous_practice_answer_exists_{{$practise['id']}}" style="{{$style}}">
  <?php

    $load_image="";
     
    if(!empty($practise['question_2'])){
      foreach ($practise['question_2'] as $key => $value) {
        if(str_contains($value,'{}')){
            $options = str_replace('{}','',$value);
            $exp_options = explode('@@', $options);
        }
      }
    }
    if(empty($practise['is_roleplay']) ){
      $load_image = ( !empty($practise['user_answer']) && $practise['user_answer'][1] !== "") ? $practise['user_answer'][1] : "";
      if(!empty($load_image)){
        $filename =  explode('/', $practise['user_answer'][1]);
        @$rawImage = file_get_contents($load_image);
        if($rawImage)
        {
            file_put_contents("./public/images/draw/".end($filename),$rawImage);
            $load_image = asset('/public/images/draw/').'/'.end($filename);
        }
      }
    }
    $watermarkimage = !empty($practise['question'][0])?$practise['question'][0]:"";
    if(!empty($watermarkimage)){
        $noImage = false;
        $filenameWatermark =  explode('/', $watermarkimage);
        @$rawImageWatermark = file_get_contents($watermarkimage);
        if($rawImageWatermark)
        {
            file_put_contents("./public/images/draw/".end($filenameWatermark),$rawImageWatermark);
            $watermarkimage = asset('/public/images/draw/').'/'.end($filenameWatermark);
        }
        $scale_img="0.4";
        $x_axis = "170";
        $y_axis = "100";
        $style="object-fit:contain;height:300px;width:400px;";
    } 
    else if(!empty($practise['dependingpractise_answer'][0]) && empty( $load_image ) ){
      $noImage = false;
      $filenameWatermark =  explode('/', $practise['dependingpractise_answer'][0]);
      @$rawImageWatermark = file_get_contents($practise['dependingpractise_answer'][0]);
      if($rawImageWatermark) {
        file_put_contents("./public/images/draw/".end($filenameWatermark),$rawImageWatermark);
        $watermarkimage = asset('/public/images/draw/').'/'.end($filenameWatermark);
        $load_image = asset('/public/images/draw/').'/'.end($filenameWatermark);
      }
      $scale_img="0.4";
      $x_axis = "170";
      $y_axis = "100";
      $style="object-fit:contain;height:400px;width:500px;";
    } else {
        $noImage = true;
        $scale_img="0.8";
        $x_axis = "50";
        $y_axis = "50";
        $watermarkimage = asset('public/images/icon-pencil.svg');
        $style="object-fit:contain;height:100px;width:100px;";
    }
    $answerExists = false;
    if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
      $answerExists = true;
      $scale_img="0.8";
      $x_axis = "50";
      $y_axis = "50";
    }
  //  pr($practise);
  ?>
  <form class="form{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    
    <!-- Compoent - Two click slider-->
    @if(!empty($practise['is_roleplay'])  && $practise['is_roleplay']==1)
      @include('practice.draw_image_speaking_roleplay')
    @else
    <input type="hidden" name="drawimage[0]" class="audio_path0 audiopath" value="{{!empty($practise['user_answer'][0])?$practise['user_answer'][0]:''}}">
    <input type="hidden" id="drawimage_{{$practise['id']}}" name="drawimage[1]" value="{{ $load_image }}" class="drawimage">
                        
    <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
          @if(isset($practise['user_answer'][1]) && $practise['user_answer'][1] !== "")
              <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                  <img  src="{{ $load_image }}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain;height:400px;width:500px;"  class="mr-n4 img-fluid" id="saved_image">
              </a>
          @elseif(!empty($practise['dependingpractise_answer']))
              <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                  <img  src="{{$load_image}}" alt="Pencil" crossOrigin="Anonymous" style="object-fit:contain;height:400px;width:500px;"  class="mr-n4 img-fluid" id="saved_image">
              </a>
          @else 
              <a href="#!" class="d-flex align-items-end ieuks-ctdbtn" data-toggle="modal" data-target="#drawModal" id="getdrawImage">
                  <img  src="{{$watermarkimage}}" style="{{$style}}" alt="Pencil1" class="mr-n4 pencil-img">
                  <span id="text-info">Click here to draw</span>
              </a>
          @endif
  
      </div>
      <div class="audio-player d-flex flex-wrap justify-content-end">
          @include('practice.common.audio_record_div',['key'=>0])
          <input type="hidden" class="deleted_audio_{{$practise['id']}}_0" name="draw_image_speaking" value="0">

      </div>
      
      <div class="modal" id="drawModal" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="fs-container">
                          <div class="backgrounds" id="canvas__{{$practise['id']}}"></div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-center">
                      <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}"  data-dismiss="modal">Save changes</button>
                      <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>
    @endif
    <!-- ./ Compoent - Two click slider Ends-->

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
   <!--  <ul class="list-inline list-buttons">
      <li class="list-inline-item">
        <input type="button" class="submitBtn_{{$practise['id']}} btn btn-secondary" value="Save" data-is_save="0">
      </li>
      <li class="list-inline-item">
          <input type="button" class="submitBtn_{{$practise['id']}} btn btn-secondary" value="Submit" data-is_save="1">
      </li>
    </ul> -->
  </form>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>
<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script>
if(data==undefined ){
  var data=[];
}
var token = $('meta[name=csrf-token]').attr('content');
var upload_url = "{{url('upload-audio')}}";
var workerDirPath = "{{asset('public/js/audio-recorder/')}}";
data["{{$practise['id']}}"]= {"dependentpractice_ans": "{{$data[$practise['id']]['dependentpractice_ans']}}" };
	
	data["{{$practise['id']}}"]["is_dependent"] = "{{$data[$practise['id']]['is_dependent']}}"; 
	if(data["{{$practise['id']}}"]["is_dependent"]==1){
		
		if(data["{{$practise['id']}}"]["dependentpractice_ans"]==0 ){
			$(".previous_practice_answer_exists_{{$practise['id']}}").hide();
			$("#dependant_pr_{{$practise['id']}}").show();
		} else {
      $(".previous_practice_answer_exists_{{$practise['id']}}").show();
			$("#dependant_pr_{{$practise['id']}}").hide();
		}
	}
</script>


@if(!empty($practise['is_roleplay']) && $practise['is_roleplay']==1)
  <script>
   
    $(".selected_option").click(function () {
      
      var content_key = $(this).attr('data-key');
      $('.selected_option').not(this).toggleClass('d-none');
      $('.selected_option_description_'+content_key).toggleClass('d-none');
      $('.selected_option_'+content_key).show();
      $(this).toggleClass('btn-bg'); 
      if( $('.selected_option_description:visible').length>0 ){
        $('.is_roleplay_submit').val(0);
      } else {
        $('.is_roleplay_submit').val(1);
      }
    });

    var canvas ={};
    var newImage = new Image();
    $(document).ready(function () {  
      $('.modal').on('show.bs.modal', function(){
        var id = $(this).data('value');
        var dataid = $(this).data('id');
        var canvasid = dataid;     
        var answer_image = $(this).data('img');
        var saved_image_path =$("#drawimage_"+canvasid).val();
        
        if(saved_image_path!==undefined && (saved_image_path.includes('http') || saved_image_path=="")){
      
          $(".canvasSave_{{$practise['id']}}").attr('data-id',canvasid)
        
          newImage.id = 'canvasimg_'+canvasid
          newImage.src = answer_image;
 

          var question_image = $(this).data('wimg');
          var watermarkImage = new Image();
          watermarkImage.src = question_image;

          if(answer_image==""){
            var bg_img = watermarkImage
            var x_axis = 50;
            var y_axis = 20;
            var scaleimg = 0.7
          }else{
            var bg_img=newImage;
            var x_axis = 50;
            var y_axis = 20;
            var scaleimg = 0.7;
          }
    
          setTimeout(() => {
              canvas[canvasid] =  LC.init( document.getElementsByClassName('backgrounds')[id],
              {
                imageURLPrefix: '{{ asset('public/literally/img') }}',
                toolbarPosition: 'top',
                defaultStrokeWidth: 2,
                strokeWidths: [1, 2, 3, 5, 30],
                keyboardShortcuts: false,
              });
              canvas[canvasid].saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scaleimg}));
              window.dispatchEvent(new Event('resize'));
              
          }, 300);
        }
      });


      // disable scrolling on touch devices so we can actually draw
      $(document).bind('touchmove', function (e) {
        if (e.target === document.documentElement) {
            return e.preventDefault();
        }
      });


      $(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {
 
        $('.drawimage:hidden').val('');
        var id = parseInt($(".canvasSave_{{$practise['id']}}").attr('data-id'));
        var image =  canvas[id].canvasForExport().toDataURL().split(',')[1];
        var dataURL = "data:image/png;base64,"+image
        if(id==0){
          var imageid = id
        }else{
          var imageid =id 
        }
        var lastaudio = $('#audiopath'+imageid).val();
        // $('.audiopath:hidden').val('');
        // $('#audiopath'+imageid).val(lastaudio);
        $("#drawimage_"+imageid).val(dataURL);
        $("#getdrawImage_"+id).find('img').attr('src', dataURL);
        $("#getdrawImage_"+id).find('img').css({'height':'400px', "width":"500", "object-fit":"content"})
        $("#text-info").text('');
        $("#getdrawImage_"+id).closest('img').addClass('img-fluid m-2');
      });

    });
  </script>
@else
<script>
  var canvas;
    var answer_image = "{{ $load_image }}";
    var newImage = new Image();
    newImage.src = answer_image;


    $(document).ready(function () {
        // disable scrolling on touch devices so we can actually draw
        $(document).bind('touchmove', function (e) {
            if (e.target === document.documentElement) {
                return e.preventDefault();
            }
        });
        $('#drawModal').on('show.bs.modal', function(){
            $(".canvasSave_{{$practise['id']}}").removeAttr("disabled");
            var saved_image_path = $('#getdrawImage').find('img').prop('src');
            var flag = true
           
            if(answer_image==""){    
             
                var x_axis="{{ (!$noImage)?$x_axis:'170' }}";
                var y_axis="{{ (!$noImage)?$y_axis:'80' }}"; 
                var scale_img = 0.6;
                if(saved_image_path.includes('http') || saved_image_path==""){
                    var newImage = new Image();
                    newImage.src = answer_image;
                    var watermarkImage = new Image();
                    //   watermarkImage.src = "{{ $watermarkimage }}";
                    watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";

                    var bg_img = watermarkImage
                }else{
                    var flag = false
                }
            } else {
                var x_axis="{{!empty($x_axis)?$x_axis:'10'}}"; 
                var y_axis="{{!empty($y_axis)?$y_axis:'10'}}"; 
                var scale_img = "{{!empty($scale_img)?$scale_img:'0.9'}}";  
                if(saved_image_path.includes('http') || saved_image_path==""){
                    var newImage = new Image();
                    newImage.src = answer_image;
                    var watermarkImage = new Image();
                    //watermarkImage.src = "{{ $watermarkimage }}";
                    watermarkImage.src = "{{ (!$noImage)?$watermarkimage:'' }}";

                    var bg_img=newImage;
                } else {
                    var flag = false
                }
            }
            
            if (flag){
                setTimeout(() => {

                    canvas =  LC.init(document.getElementsByClassName('backgrounds')[0],
                    {
                        // imageURLPrefix: '{{ asset('public/literally/img') }}',
                        // toolbarPosition: 'top',
                        // defaultStrokeWidth: 2,
                        // strokeWidths: [1, 2, 3, 5, 30],
                        //  imageSize : { scale: 0.6},
                        // keyboardShortcuts: false,
                        // watermarkImage: watermarkImage,
                        // watermarkScale: 0.4
                        imageURLPrefix: '{{ asset('public/literally/img') }}',
                        toolbarPosition: 'top',
                        defaultStrokeWidth: 2,
                        strokeWidths: [1, 2, 3, 5, 30],
                        keyboardShortcuts: false,

                    });
                    canvas.saveShape(LC.createShape('Image', {x: x_axis, y: y_axis, image: bg_img,  scale: scale_img}));
                    window.dispatchEvent(new Event('resize'));
                }, 450);
            }
        });
    });


    $(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {

        $(".canvasSave_{{$practise['id']}}").attr('disabled','disabled');
        // check if //domain.com or http://domain.com is a different origin
        if (/^([\w]+\:)?\/\//.test(answer_image) && answer_image.indexOf(location.host) === -1) {
          document.getElementById("saved_image").crossOrigin = "anonymous";
          newImage.crossOrigin = "Anonymous"; // or "use-credentials"
        }

        var image=  canvas.canvasForExport().toDataURL().split(',')[1];
        var dataURL = "data:image/png;base64,"+image
        newImage.src = dataURL;

        $("#drawimage_{{$practise['id']}}").val(dataURL);
        $("#getdrawImage").find('img').attr('src', dataURL);
        $("#getdrawImage").find('img').css({'height':'400px', "width":"500", "object-fit":"content"})
        $("#text-info").text('');
        $("#getdrawImage").closest('img').addClass('img-fluid m-2');
    });
</script>
@endif
<script>
  
  /*  draw_image_writing_email jquery save image */
  $(document).on('click',".submitBtn_{{$practise['id']}}" ,function() {
      var is_save = $(this).attr('data-is_save');
      $('.is_save:hidden').val(is_save);

      $.ajax({
          url: "{{url('save-draw-image-speaking')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'POST',
          data: $(".form{{$practise['id']}}").serialize(),
          success: function (data) {
          $(".submitBtn_{{$practise['id']}}").removeAttr('disabled');
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
<style type="text/css">
    .main-audio-record-div .delete-icon-left {
        position: absolute !important;
        left: -72px !important;
        top: 49% !important;
        transform: translateY(-50%) !important;
    }


</style>