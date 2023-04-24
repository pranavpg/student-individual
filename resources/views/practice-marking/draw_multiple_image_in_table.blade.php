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
                                $load_image = ( ( isset($practise['user_answer']) && array_key_exists($key, $practise['user_answer']) ) ? $practise['user_answer'][$key] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['user_answer'][$key] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
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
                                        <a href="#!" class="d-flex align-items-end" data-toggle="modal" data-target="#drawModal_{{$key}}" id="getdrawImage_{{$key}}">
                                            <img src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencil" class="img-fluid">
                                            <p id="text-info_{{$key}}">{{ $load_image == "" ? 'Click here to draw' : "" }}</p>
                                        </a>
                                    @endif
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
                                $load_image = ( ( isset($practise['user_answer']) && array_key_exists($i, $practise['user_answer']) ) ? $practise['user_answer'][$i] : "" );
                                if(!empty($load_image)){
                                  $filename =  explode('/', $practise['user_answer'][$i] );
                                  $local_path = asset('/public/images/draw/').'/'.end($filename);
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
                                <div class="draw-image d-flex align-items-center justify-content-center mb-4 img-thumbnail">
                                    @if( !empty($load_image) || $load_image !== "" || $load_image !== " ")
                                        <a href="#!" class="d-flex align-items-end ieuks-ctdbtn" data-toggle="modal"  id="getdrawImage_{{$i}}">
                                            <img src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencil" class="img-fluid">
                                            <p id="text-info_{{$i}}">{{ $load_image == "" ? 'Click here to draw' : "" }}</p>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endfor
                        </div>
            <?php }
        ?>
    </form>