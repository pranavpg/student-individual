
<div class="component-two-click mb-4">
<input type="hidden" name="is_roleplay" value="true" >
                        <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
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
                // pr($practise);
                    $load_image =  !empty($practise['user_answer'][$i][1])    ? $practise['user_answer'][$i][1] : ""  ;
                    if(!empty($load_image)){
                        $filename =  explode('/', $practise['user_answer'][$i][1] );
                        $local_path = asset('/public/images/draw/').'/'.end($filename);
                        @$rawImage = file_get_contents($load_image);
                        if($rawImage)
                        {
                        file_put_contents(public_path("images/draw/".end($filename)),$rawImage);
                        $load_image = asset('/public/images/draw/').'/'.end($filename);
                        }
                    }
                ?>
                <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$key}}" id="police">
                    <div class="draw-image d-flex align-items-center justify-content-center mb-4">
                        <input type="hidden" name="drawimage[{{$i}}][0]" class="audio_path{{$i}} audiopath" value="{{!empty($practise['user_answer'][$i][0])?$practise['user_answer'][$i][0]:''}}">
                        <input type="hidden" id="drawimage_{{$i}}" name="drawimage[{{$i}}][1]" value="{{ $load_image }}" class="drawimage">
                        <input type="hidden"  name="drawimage[{{$i+1}}]" value="##">
                        
        
                        <div id="svgid_{{$key}}" style="display: none"></div>


                        @if( !empty(trim($load_image)) && $load_image !== "" && $load_image !== " ")
                            <a href="#!" class="d-flex align-items-end openmodal" data-toggle="modal" data-target="#drawModal_{{$i}}" id="getdrawImage_{{$i}}">
                                <img  src="{{ isset($load_image) && $load_image !== "" ? $load_image : asset('public/images/icon-pencil.svg') }}" alt="Pencilsd" crossOrigin="Anonymous" style="object-fit:contain;height:400px;width:500px;"  class="mr-n4 img-fluid" id="saved_image">
                            </a>
                        @else
                            <a href="#!" class="d-flex align-items-end openmodal" data-toggle="modal" data-target="#drawModal_{{$i}}" id="getdrawImage_{{$i}}">
                            <img src="{{$watermarkimage}}" style="object-fit:contain;height:400px;width:500px;" alt="Pencil" class="mr-n4">
                            </a>
                        @endif
                    </div>
                    <div class="modal" id="drawModal_{{$i}}" tabindex="-1" aria-labelledby="drawModalLabel" aria-hidden="true" data-wimg="{{$watermarkimage}}" data-img="{{$load_image}}" data-id="{{$i}}" data-value="{{$key}}">
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
                                    <button type="button" class="btn btn-primary canvasSave_{{$practise['id']}}"  data-dismiss="modal">Save changes</button>
                                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="audio-player d-flex flex-wrap justify-content-end">
                        @include('practice.common.audio_record_div',['key'=>$i])

                        <input type="hidden" class="deleted_audio_{{$practise['id']}}_{{$i}}" name="audio_reading_{{$i}}" value="0">
                    </div>
                </div>
                <?php $i+=2; ?>
            @endforeach
        </div>
    @endif
  </div>