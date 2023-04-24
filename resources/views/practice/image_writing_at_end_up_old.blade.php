<p><strong>{!!$practise['title']!!}</strong></p>
@if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']))
    @php  $depend =explode("_",$practise['dependingpractiseid']); @endphp
    <div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;" data-value="{{$practise['id']}}">
        <p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
    </div>
@endif


<?php
  //pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = json_decode($practise['user_answer'][0][0][0], true);
  }

  $two_tabs = array();
  $i=0;
  if(!empty($practise['question_2'])){
    foreach ($practise['question_2'] as $key => $value) {
      if(str_contains($value,'{}')){
        $tabs = str_replace('{}','',$value );
        $two_tabs= explode('@@', $tabs);
      }
    }
  }

  if(!empty($practise['question'])){
    foreach ($practise['question'] as $key => $value) {
        $question_list[0] =  $value;
        $question_list[1] =  $value;
    }
  }

?>

<form class="save_image_writing_at_end_up_form_{{$practise['id']}}">
    <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
    <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
    <input type="hidden" class="is_save" name="is_save" value="">
    <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
    <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
    <input type="hidden" class="depend_task_id" name="depend_task_id" value="{{$depend[0]}}">
    <input type="hidden" class="depend_practise_id" name="depend_practise_id" value="{{$depend[1]}}">
    <input type="hidden" name="is_roleplay" value="true" >
    <input type="hidden" class="is_roleplay_submit" name="is_roleplay_submit" value="1">
   <div class="component-two-click mb-4">
      @if(!empty($two_tabs))
          <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
            @foreach($two_tabs as $key => $value)
              <a href="#!" class="btn btn-dark selected_option selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
            @endforeach
          </div>
      @endif
      <div class="two-click-content w-100">
        @if(!empty($question_list))
        <?php $answer_count=0; ?>
          @foreach($question_list as $k => $v)
          <?php $answer_count = $answer_count + $k; ?>
              <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$k}}" >
              <ul class="list-unstyled list-texthighlighted " id="{{$practise['id']}}">
                    <li class="list-item image_writing_at_end_up span_choice underline_text_list_item">
                    </li>
                </ul>
                      <div class="col-12 col-lg-6">
                          <picture class="picture">
                              <img src="{{$v}}" alt="" class="img-fluid">
                          </picture>
                      </div>
              </div>
            <?php $answer_count++ ?>
          @endforeach
        @endif
      </div>
  </div>
  <div class="alert alert-success" role="alert" style="display:none"></div>
	<div class="alert alert-danger" role="alert" style="display:none"></div>
      <ul>
        <li class="list-inline-item">
            <input type="button" class="save_btn image_writing_at_end_up_form_{{$practise['id']}} btn btn-primary" value="Save" data-is_save="0">
        </li>
        <li class="list-inline-item">
            <input type="button" class="submit_btn image_writing_at_end_up_form_{{$practise['id']}} btn btn-primary" value="Submit" data-is_save="1">
        </li>
    </ul>
</form>
<style>
.highlight { background-color: yellow }
</style>
<script>

var pid = "{{ $practise['id'] }}";

function highlight()
  {
    var current_key = 0;
        var wordNumber;
        var k=0;
        var end=0;
       // var pid = "{{ $practise['id'] }}";

        $('.save_image_writing_at_end_up_form_'+pid).find('.underline_text_list_item').each(function(key){
          //console.log('+++>>',key)
          var paragraph="";
          var str = $(this).text();
          var $this =$(this);
          str.replace(/[ ]{2,}/gi," ");
          $this.attr('data-total_characters', str.length);
          $this.attr('data-total_words', str.split(' ').length);

          var words = $this.first().text().split(' ');//split( /\s+/ );
            console.log('==>',$.trim( $this.first().text()))

          for(var i=0; i<words.length;i++){
            var word = $.trim(words[i].replace(/^\s+/,""));

            if(word !=""){
              if( key==0){
                wordNumber = k;

              }else{
                wordNumber = k+key;

              }

              if(i==0 && key==0){
                  end=word.length;
              }else{
                if(key>=1){
                  if(i==0){
                    end+=word.length;
                    end+= 3
                  } else{
                    end+=word.length;
                    end++;
                  }
                } else {
                  end+=word.length;
                  end++;
                }
              }
              var start = end-word.length
              var iName= "text_ans[0][0]["+wordNumber+"][i]";
              var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
              var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
              var wordName="text_ans[0][0]["+wordNumber+"][word]";
              var startName = "text_ans[0][0]["+wordNumber+"][start]";
              var endName = "text_ans[0][0]["+wordNumber+"][end]";
              paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
              $this.html(paragraph);
            }
            k++;
          }
          //var text = words.join( "</span> <span class='highlight-text'>" );
        });


  }



  $(document).ready(function(){


  //highlight();



$('.save_image_writing_at_end_up_form_'+pid).on( "click","span.highlight-text", function() {
		// alert()
		if($(this).hasClass('bg-success')){
			$( this ).removeClass( 'bg-success' );
			$(this).find('input').attr('disabled','disabled');
		} else {
			$( this ).addClass( 'bg-success' );
			$(this).find('input').removeAttr('disabled');
		}
		//console.log($(this).text())
		// $('.list-item').highlight($( this ).text() );
  });


});



$(function () {

$(".selected_option").click(function () {
    var content_key = $(this).attr('data-key');

    $('.selected_option').not(this).toggleClass('d-none');
    $('.selected_option_description_'+content_key).toggleClass('d-none');
    $('.selected_option_'+content_key).show();
    $(this).toggleClass('btn-bg');
  //  alert($('.selected_option_description:visible').length)
    if( $('.selected_option_description:visible').length>0 ){
      $('.is_roleplay_submit').val(0);
    }else{
      $('.is_roleplay_submit').val(1);
    }
  });

});

function getDependingPractise(){

        var topic_id= $(".save_image_writing_at_end_up_form_{{$practise['id']}}").find('.topic_id').val();
        var task_id=$(".save_image_writing_at_end_up_form_{{$practise['id']}}").find('.depend_task_id').val();
        var practise_id=$(".save_image_writing_at_end_up_form_{{$practise['id']}}").find('.depend_practise_id').val();

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

            if(data.question!=null && data.question!=undefined){

              var result =  data.question;
              var res1 = result.split("@@");
              var res = result.split("##");
              var i =0;

              $.each(res, function( index, value ) {
                  if(value !==""){
                      value = value.replace(document.location,"");
                      console.log(value);
                      $(".span_choice").html(value);
                      i= i+1;
                  }

              });



            }else{
              $("#dependant_pr_{{$practise['id']}}").css("display", "none");
              $(".save_image_writing_at_end_up_form_{{$practise['id']}}").css("display", "block");

            }
        }
    });

}

var practise_id=$("#dependant_pr_{{$practise['id']}}").data("value");

    if(practise_id){
        var x = getDependingPractise() ;


    }


function setTextareaContent(){
	$("span.textarea.form-control").each(function(){
		var currentVal = $(this).html();
		$(this).next().find("textarea").val(currentVal);
	})
}

$(document).on('click','.image_writing_at_end_up_form_{{$practise["id"]}}' ,function() {
  if($(this).attr('data-is_save') == '1'){
          $(this).closest('.active').find('.msg').fadeOut();
      }else{
          $(this).closest('.active').find('.msg').fadeIn();
      }
  $('.image_writing_at_end_up_form_{{$practise["id"]}}').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  setTextareaContent();
  $.ajax({
      url: '<?php echo URL('save-image-writing-at-end-up'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $(".save_image_writing_at_end_up_form_{{$practise['id']}}").serialize(),
      success: function (data) {
        $('.save_image_writing_at_end_up_form_{{$practise["id"]}}').removeAttr('disabled');
				if(data.success){
					$('.alert-danger').hide();
					$('.alert-success').show().html(data.message).fadeOut(8000);
				} else {
					$('.alert-success').hide();
					$('.alert-danger').show().html(data.message).fadeOut(8000);
        }
      }
  });
});

</script>

<script>
      $(window).on('load', function(){
        highlight();

        var answers='<?php echo !empty($practise["user_answer"])? json_encode($answers) :"" ?>';
        if( answers !=""){

          var parsedAnswer = JSON.parse(answers);
          if( parsedAnswer!==undefined && parsedAnswer!==null ){

            $.each(parsedAnswer, function(key, value) {
              
              $('.save_image_writing_at_end_up_form_'+pid).find('#'+key).addClass('bg-success');
              $('.save_image_writing_at_end_up_form_'+pid).find('#'+key).find('input').removeAttr('disabled');
            });
          }
        }

      })
</script>

<script src="{{asset('public/js/audio-recorder/WebAudioRecorder.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
