<style>
.modal .answerkeyframe body{
    overflow-x:auto !important;
}
.self_marking_modal_popup textarea{
    pointer-events: none;
}
</style>
<div class="modal fade self_marking_modal_popup" id="selfMarking_{{$practise['id']}}" tabindex="-1" role="dialog" aria-labelledby="reviewmodallabel"
 data-keyboard="false"  aria-hidden="true">
        <div class="modal-dialog modal-xl review-modal">
            <div class="modal-content">
                <div class="modal-header flex-wrap">
                    <div
                        class="modal-header-top d-flex flex-wrap justify-content-between align-items-center mb-3 w-100">
                        <h5 class="modal-title flex-grow-1" id="reviewmodallabel">Give your marks</h5>
                        <?php
                        if(session::get('lastTaskName') !=""){
                            $topicDisplayText = explode("/",session::get('lastTaskName'));
                            ?>
                                <ul class="modal-header-breadcrumb mb-0 list-inline">
                                    <li class="list-inline-item">{{$topicDisplayText[0]}}</li>
                                    <li class="list-inline-item">{{$topicDisplayText[1]}}</li>
                                    <li class="list-inline-item part"></li>
                                </ul>
                            <?php
                        }?>


                    </div>
                    <!-- /. Modal Header top-->

                    <!-- <p>Read the text in your Course Book and answer the question. </p> -->
                </div>
                <div class="modal-body p-0 d-flex flex-wrap">
                    <div class="col-12 col-lg-5 assessment-answer p-0">
                        <div class="assessment-answer-heading text-center">
                            <h4>Answer Key</h4>
                        </div>
                        <div class="assessment-answer-heading-body scrollbar d-scrollbar">
                            @if(!empty($practise['answer_key']))
                            <div class=" mb-4 text-center" id="iframe_div" style="height:100%">
                                <iframe class="answerkeyframe" srcdoc="{{str_replace('overflow-x:hidden;','overflow-x:auto;',$practise['answer_key'])}}" style="height: inherit;"   width="100%" scrolling="yes" frameborder="0"></iframe>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 assessment-answer p-0">
                        <div class="assessment-answer-heading text-center">
                            <h4>Student Answer</h4>
                        </div>
                        <div class="assessment-answer-heading-body scrollbar d-scrollbar" id="practise_div" ></div>
                    </div>
                </div>

                <div class="success_popup" role="alert" style="display:none;text-align: center;color: green;"></div>
                <div class="error_popup" role="alert" style="display:none;text-align: center;color: red;"></div>

                <div class="modal-footer justify-content-center">
                   
                    <div class="marks-box d-flex align-items-center justify-content-center mr-4">
                        <span style="color:#d55b7d;">Marks:</span>
                        <form method="POST" class="student_self_mark_form_{{$practise['id']}}">
                            <input type="hidden" name="practise_id" value="{{$practise['id']}}">
                            <div class="form-group d-flex flex-wrap align-items-center ml-4 mb-0" style="margin-left: 0.0rem!important;">
                                <input type="text" class="disable_copy_paste form-control self_marks_input_{{$practise['id']}}" name="marks" id="self_marks_input" placeholder="00" autocomplete="false">
                                <span class="marks">/{!!$practise['mark']!!}</span>
                            </div>
                        </form>
                    </div>

                    <a href="#!" class="btn btn-primary student_self_mark_cancel_btn" id="student_self_mark_btn_{{$practise['id']}}">Submit</a>
                    <a href="#!" class="btn btn-dark student_self_mark_cancel_btn"  data-dismiss="modal" style="background-color:#2d445c;">Cancel</a>

                </div>
            </div>
        </div>
    </div>
    <script>
    <?php
 /*   $lastPractice=end($practises);
    if($lastPractice['id'] == $practise['id']){       
        $reviewPopup=true; 
    }else{
    }*/
        $reviewPopup=false; 
    ?>
    $( document ).ready(function() {
        $("#self_marks_input").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
            }
        });
        $(".self_marks_input_{{$practise['id']}}").on('keyup', function(e){
            var n = parseInt($(this).val());
            var max = parseInt("{{$practise['mark']}}"); 
            if (n > max 
                && e.keyCode !== 46
                && e.keyCode !== 8
                ) {
                    
                e.preventDefault();   
                $(this).val('');
            }
            if ($(this).val() < 0 
                && e.keyCode !== 46
                && e.keyCode !== 8
                ) {
                e.preventDefault();     
                $(this).val('');
            }
        });

        $("#student_self_mark_btn_{{$practise['id']}}").click(function(){

                var reviewPopup = '{!!$reviewPopup!!}';
                
                if($('.self_marks_input_{{$practise["id"]}}').val() === ""){
                    $('.error_popup').show().html("Please enter marks.").fadeOut(4000);
                    return false;
                }
                // alert("The paragraph was clicked.");
                $.ajax({
                    url: '<?php echo URL('save-student-self-marking'); ?>',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: $('.student_self_mark_form_{{$practise["id"]}}').serialize(),
                    success: function (data) {
                        console.log(data);
                       
                        if(data.success){
                            $('.error_popup').hide();
                            $('.success_popup').show().html(data.message).fadeOut(4000);

                            $('.alert-danger').hide();
                            $('.alert-success').show().html(data.message).fadeOut(4000);

                            if(reviewPopup == 1){
                                $("#selfMarking_{{$practise['id']}}").modal('toggle');
                                $("#reviewModal_{{$practise['id']}}").modal('toggle');
                            }
                            
                            setTimeout(function(){
                                $("#selfMarking_{{$practise['id']}}").modal('hide');
                            },1500)

                            // $(document).on('click', '.student_self_mark_cancel_btn', function(){
                                // alert($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type"));
                                // if($('.self_marking_modal_popup').find('.audio-player').find('.plyr__control--pressed').attr("type") == "button"){
                                //     $('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').trigger('click');
                                    $('.self_marking_modal_popup').find('.audio-player').find('.plyr__controls__item').attr('disabled',true);
                                // }
                            // });

                        } else {

                            $('.alert-success').hide();
                            $('.alert-danger').show().html(data.message).fadeOut(4000);

                            $('.success_popup').hide();
                            $('.error_popup').show().html(data.message).fadeOut(4000);
                        }
                    }
                });
        });

        setTimeout(function(){
            $('.part').each(function(){
                $(this).html($('.abc-tab .active').text())
            })
        },1000)
    });
    </script>
     <script type="text/javascript">
    $(document).ready(function(){
        $('.d-scrollbar').scrollbar();
    });


    $('.disable_copy_paste').bind("cut copy paste",function(e) {
         e.preventDefault();
     });

    $('.disable_copy_paste').keyup(function(e)
                                {
      if (/\D/g.test(this.value))
      {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
      }
    });
  </script>
  