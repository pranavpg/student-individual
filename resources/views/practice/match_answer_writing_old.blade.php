        <?php //dd($practise['user_answer']); exit; ?>
        <p><strong>{{ $practise['title'] }}</strong></p>
        <style>
            .bg-list-light-red {
                background-color: #ffcccb;
            }
        </style>
        @php
            $color_array =  array("bg-list-light-yello", "bg-list-purple", "bg-list-pink", "bg-list-navy", 'bg-list-yellow', 'bg-list-light-green', 'bg-list-light-danger','bg-list-light-pink','bg-list-light-blue','bg-list-light-red');
            //dd($practise['user_answer']);
            $q1 = $practise['question'][0];
            $q2 = $practise['question_2'];
            $explode_question = explode( '#@', $q1);
            $explode_question_header = explode( '@@', $explode_question[0]);
            $practise['question'][0] = $explode_question[1];
            //dd($practise['question']);
            $answerExists = false;
            if(isset($practise['user_answer'])){
                $answerExists = true;
                //dd($practise['user_answer']);
                if(array_key_exists('text_ans', $practise['user_answer']))
                {
                    $user_ans = explode(';',$practise['user_answer'][0]['text_ans']);
                    array_pop($user_ans);
                }
                else
                {
                    $user_ans = explode(';',$practise['user_answer'][0]);
                    array_pop($user_ans);
                    $right = array(); $left = array();
                    foreach ($user_ans as $key => $value) {
                        if($value !== " " && $value !== "")
                        {
                            $x = (int)$value;
                            $left[$key] = $color_array[$key];
                            $right[$x] = array('color'=>$color_array[(int)$key], 'val'=>(int)$key);
                        }
                    }
                }
            }

        @endphp

<form class="save_match_answer_writing_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <div class="match-answer mb-2">
        <div class="row">
            <div class="col-md-6 match-answer__block">
                <h3>
                    {{$explode_question_header[0]}}
                </h3>
            </div>
            <div class="col-md-6 match-answer__block">
                <h3>
                    {{$explode_question_header[1]}}
                </h3>
            </div>
        </div>

        <div class="match-answer__block">
            <ul class="list-unstyled row">
                @foreach ($practise['question'] as $key=>$value)
                        <li class="list-item col-12 col-md-6 bg-list-light-gray question_option {{ ( $answerExists && isset($left[$key]) ) ? $left[$key].' confirmed active-bg': '' }} question_option_{{$key}}   " id="{{$key}}" data-class="{{$color_array[$key]}}" >
                            {!! $value !!}
                        </li>
                        <li class="list-item col-12 col-md-6 list-item-2 bg-list-light-gray answer_option {{ ( $answerExists && isset($right[$key]) ) ? $right[$key]['color'] : "" }} answer_option_{{$key}} " id="{{$key}}">
                            <strong>{!! !empty($q2[$key])?$q2[$key]:"" !!}</strong>
                            <?php $value = ( $answerExists && isset($right[$key]) ) ? $right[$key]['val'] : "";  ?>
                            <input type="hidden" name="text_ans[]" {{ ( $answerExists && isset($right[$key]) ) ? "value=$value" : "" }}>
                        </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- /. Component Match Answer End -->
    <div class="form-slider p-0 mb-4">
        <div class="component-control-box focus">
            <span class="textarea form-control form-control-textarea" role="textbox" contenteditable="" placeholder="Write here...">
                @if($answerExists == true)
                    {{ $practise['user_answer'][1][0] }}
                @endif
            </span>
            <div style="display:none">
               <input type="hidden" name="text_ans_block" id="text_ans" value="{{ ($answerExists==true) ? $practise['user_answer'][1][0] : "" }}">
            </div>
        </div>
    </div>

    <!--Component Form Slider End-->
    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item">
            <button type="button" class="save_btn btn btn-primary submitMatchAnswerWritingBtn_{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
        </li>
        <li class="list-inline-item">
            <button type="button" class="submit_btn btn btn-primary submitMatchAnswerWritingBtn_{{$practise['id']}}" data-toggle="modal" data-is_save="1" data-target="#exitmodal" >Submit</button>
        </li>
    </ul>
</form>

<script>





    $(document).ready(function()
    {

        function setTextareaContent(){
            $(".save_match_answer_writing_{{$practise['id']}}").find("span.textarea.form-control").each(function(){
                var currentVal = $(this).html();
                $(this).next().find("input:hidden").val(currentVal);
            })
        }

        $.fn.removeClassStartingWith = function (filter) {
            $(this).removeClass(function (index, className) {
                return (className.match(new RegExp("\\S*" + filter + "\\S*", 'g')) || []).join(' ')
            });
            return this;
        };




        $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').on('click', function() {

            if($(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").hasClass('confirmed')) {
            //  alert()

                $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("active-bg");
                $(this).addClass('active-bg')
                var bg_color = $(this).attr('data-class');
                $(".save_match_answer_writing_{{$practise['id']}}").find('.answer_option').removeClass(bg_color);
                    $(this).toggleClass(bg_color);
                }
                else
                {
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-yello active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-purple active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-pink active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-navy active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-yellow active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-green active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-danger active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-pink active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").removeClass("bg-list-light-red active-bg");
                    $(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").addClass('bg-list-light-gray');
                    $(this).addClass('active-bg');
                    var bg_color = $(this).attr('data-class');
                    $(this).toggleClass(bg_color );
            }

        });

            $(".save_match_answer_writing_{{$practise['id']}}").find('.answer_option').on('click', function() {
                var $this= $(this)

                if($(".save_match_answer_writing_{{$practise['id']}}").find(".question_option").hasClass('active-bg')){
                if( $(this).hasClass('bg-list-light-yello')) {
                    $(this).removeClass('bg-list-light-yello');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-light-yello').removeClass('bg-list-light-yello').removeClass('confirmed').removeClass('active-bg');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-purple')) {
                    $(this).removeClass('bg-list-purple');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-purple').removeClass('bg-list-purple').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-pink')) {
                    $(this).removeClass('bg-list-pink');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-pink').removeClass('bg-list-pink').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-navy')) {
                    $(this).removeClass('bg-list-navy');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-navy').removeClass('bg-list-navy').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-navy')) {
                    $(this).removeClass('bg-list-navy');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-navy').removeClass('bg-list-navy').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }

                else if( $(this).hasClass('bg-list-yellow')) {
                    $(this).removeClass('bg-list-yellow');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-yellow').removeClass('bg-list-yellow').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-light-green')) {
                    $(this).removeClass('bg-list-light-green');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-light-green').removeClass('bg-list-light-green').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-light-danger')) {
                    $(this).removeClass('bg-list-light-danger');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-light-danger').removeClass('bg-list-light-danger').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-light-pink')) {
                    $(this).removeClass('bg-list-light-pink');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-light-pink').removeClass('bg-list-light-pink').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else if( $(this).hasClass('bg-list-light-red')) {
                    $(this).removeClass('bg-list-light-red');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.bg-list-light-red').removeClass('bg-list-light-red').removeClass('confirmed');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option').addClass('bg-list-light-gray');
                    $(this).find('input').removeAttr('value');;
                }
                else {
                    var chosen_option = $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.active-bg').attr('data-class');
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.answer_option').removeClass(chosen_option);
                    $(this).addClass(chosen_option);
                    $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.'+chosen_option).addClass('confirmed');
                    var selected_answer = $(".save_match_answer_writing_{{$practise['id']}}").find('.question_option.'+chosen_option).attr('id');
                    $(this).find('input:hidden').val(selected_answer);
                }
                } else {
                    $('.alert-success').hide();
                    $('.alert-danger').show().html("Please select any question.").fadeOut(8000);
                }
            });

        $('.submitMatchAnswerWritingBtn_{{$practise['id']}}').on('click',function(e) {
              if($(this).attr('data-is_save') == '1'){
                  $(this).closest('.active').find('.msg').fadeOut();
              }else{
                  $(this).closest('.active').find('.msg').fadeIn();
              }
              
            e.preventDefault();
            setTextareaContent();
            var is_save = $(this).attr('data-is_save');
            $('.is_save:hidden').val(is_save);


            $.ajax({
                url: "{{url('save-match-answer-writing')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: $(".save_{{$practise['type']}}_{{$practise['id']}}").serialize(),
                success: function (data) {
                    $(".submitMatchAnswerWritingBtn_{{$practise['id']}}").removeAttr('disabled');

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
    })
</script>
