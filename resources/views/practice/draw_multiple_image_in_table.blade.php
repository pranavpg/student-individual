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
    .cover-spin{
      display: none !important;
    }
  </style>


<p>
<strong><?php
echo $practise['title'];
//pr($practise);
?></strong>



</p>
    <form class="save_draw_img_writing_form_{{$practise['id']}}">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <?php 
            $exploded_question1= explode('#@',$practise['question']);
            if (strpos($exploded_question1[1], '@@') !== false) {

                        $exploded_question  =  explode('@@',$exploded_question1[1]);
                        $col = $exploded_question1[0];
                        $row = substr($exploded_question1[1],1,1);
                         ?>
                        <div class="multiple-draw row mb-5">
                            @foreach($exploded_question as $key=>$item)

                            <?php
                            //pr($practise);
                                $load_image = ( ( isset($practise['user_answer']) && array_key_exists($key, $practise['user_answer']) ) ? $practise['user_answer'][$key] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['user_answer'][$key] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
                                  //file_put_contents(end($filename), file_get_contents('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png'));
                                  @$rawImage = file_get_contents($load_image);
                                  if($rawImage)
                                  {
                                    file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
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
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="color: #30475e">{{$item}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="fs-container">
                                                <div class="backgrounds" id="canvas__{{$key}}"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}" data-value="{{$key}}" data-dismiss="modal">Save changes</button>
                                            <button type="button" class="btn btn-cancle close_popup"  data-key="{{$key}}">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </div>

            <?php }else{

                        $exploded_question1= explode('#@',$practise['question']);
                        $exploded_question  =  explode('@@',$exploded_question1[1]);
                        $col = $exploded_question1[0];
                        $row = substr($exploded_question1[1],1,1);
                         ?>
                        <div class="multiple-draw row mb-5">
                            @for($i=0;$i<$exploded_question[0];$i++)

                            <?php
                            //pr($practise);
                                $load_image = ( ( isset($practise['user_answer']) && array_key_exists($i, $practise['user_answer']) ) ? $practise['user_answer'][$i] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['user_answer'][$i] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
                                  //file_put_contents(end($filename), file_get_contents('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-6-1.png'));
                                  @$rawImage = file_get_contents($load_image);
                                  if($rawImage)
                                  {
                                    file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
                                    $load_image = asset('/public/images/draw/').'/'.end($filename);
                                  }

                                }
                            ?>

                            <input type="hidden" id="drawimage_{{$i}}" name="drawimage[{{$i}}]" value="{{$load_image}}"  class="drawimage">
                            <input type="hidden" id="drawimagefinal_{{$i}}"  value="{{$load_image}}"  class="drawimagefinal">
                            
                               
                               

                            <div id="svgid_{{$i}}" style="display: none"></div>

                            <div class="col-6 draw-box mb-6">
                                <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
                                    @if( !empty($load_image) || $load_image !== "" || $load_image !== " ")
                                        <a href="#!" class="d-flex align-items-end openmodal ieuks-ctdbtn" data-toggle="modal" data-target="#drawModal_{{$i}}" id="getdrawImage_{{$i}}">
                                            <img src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencil" class="img-fluid">
                                            <p id="text-info_{{$i}}">{{ $load_image == "" ? 'Click here to draw' : "" }}</p>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="modal" id="drawModal_{{$i}}" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true" data-img="{{$load_image}}" data-finalimg="{{$load_image}}" data-value="{{$i}}">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="color: #30475e"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="fs-container">
                                                <div class="backgrounds" id="canvas__{{$i}}"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-danger close_popup" data-key="{{$i}}">Close</button>
                                            <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}" data-value="{{$i}}" data-dismiss="modal">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endfor
                        </div>
            <?php }
        ?>


       
        <!--Component Form Slider End-->
        <div class="alert alert-success" role="alert" style="display:none"></div>
        <div class="alert alert-danger" role="alert" style="display:none"></div>
        <ul class="list-inline list-buttons">

            <li class="list-inline-item">
            <input type="button" class="save_btn draw_img_writing_btn_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
            </li>
            <li class="list-inline-item">
                <input type="button" class="submit_btn draw_img_writing_btn_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
            </li>
        </ul>
    </form>

    <!-- Modal -->
<!-- dependency: React.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{ asset('public/literally/js/literallycanvas.js') }}"></script>

<script type="text/javascript">
var canvas={};

var newImage = new Image();
  $(document).ready(function () {
      $(".close_popup").on('click', function(){
          var key = $(this).attr('data-key');
          $('.drawimagefinal:hidden').val('');
          $('#drawModal_'+key).modal('toggle')
      })
    $('.modal').on('show.bs.modal', function(){
       
      var id = $(this).attr('data-value');
      var saved_image_path = $('#drawimagefinal_'+id).val();
      if(saved_image_path!==undefined && (saved_image_path.includes('http') || saved_image_path=="")){
        var answer_image = $(this).attr('data-finalimg');
        newImage.id = 'canvasimg_'+id
        newImage.src = answer_image;
        setTimeout(() => {
            canvas[id] =  LC.init( document.getElementsByClassName('backgrounds')[id],
            {
                imageURLPrefix: '{{ asset("public/literally/img") }}',
                toolbarPosition: 'top',
                defaultStrokeWidth: 2,
                strokeWidths: [1, 2, 3, 5, 30],
                keyboardShortcuts: false
            });
            canvas[id].saveShape(LC.createShape('Image', {x: 0, y: 0, image: newImage, scale:0.7}));
            window.dispatchEvent(new Event('resize'));
        }, 100);
      }
    });


    // disable scrolling on touch devices so we can actually draw
    $(document).bind('touchmove', function (e) {
      if (e.target === document.documentElement) {
          return e.preventDefault();
      }
    });

    $(document).on('click',".canvasSave_{{$practise['id']}}" ,function() {
        $('.drawimagefinal:hidden').val('');
   
      
        var id = $(this).attr('data-value');
      if(id!==undefined){
        var image =  canvas[id].canvasForExport().toDataURL().split(',')[1];
        var dataURL = "data:image/png;base64,"+image
        $('#canvasimg_'+id).attr('src',dataURL)
        $('#drawModal_'+`${id}`).attr('data-img',dataURL);
        $('#drawModal_'+`${id}`).attr('data-finalimg',dataURL);
        
        $('#drawimage_'+`${id}`).val(dataURL);
        $('#drawimagefinal_'+`${id}`).val(dataURL);
        $("#getdrawImage_"+`${id}`).find('img').attr('src', dataURL);
        $("#text-info_"+`${id}`).text('');
        $("#getdrawImage_"+`${id}`).closest('img').addClass('img-fluid m-2');
      }
    });
  });

  $(document).on('click',".draw_img_writing_btn_{{$practise['id']}}" ,function() {
     if($(this).attr('data-is_save') == '1'){
        $(this).closest('.active').find('.msg').fadeOut();
    }else{
        $(this).closest('.active').find('.msg').fadeIn();
    }
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    // setTextareaContent();
    $.ajax({
      url: "{{url('save-draw-multiple-image-table-new')}}",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $(".save_draw_img_writing_form_{{$practise['id']}}").serialize(),
      success: function (data) {
      $(".draw_img_writing_btn_{{$practise['id']}}").removeAttr('disabled');
          if(data.success){
              $('.alert-danger').hide();
              $('.alert-success').show().html(data.message).fadeOut(8000);
          }else{
              $('.alert-success').hide();
              $('.alert-danger').show().html(data.message).fadeOut(8000);
          }
      }
    });
  });
</script>
