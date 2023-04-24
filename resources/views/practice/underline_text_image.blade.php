<p>
	<strong>{{$practise['title']}}</strong>
</p>

<style>
	.owl-item > .item > .underline__box {
		min-height: 580px!important;
	}
	.owl-item > .item > .underline__box > div {
		position: absolute;
    width: 70%;
    bottom: 0;
    padding: 10px 0px;
	}
</style>
<?php
  // dd($practise);

$answerExists = false;
$encoded_answer = "";
$underline=array();
if(!empty($practise['user_answer'])){
  $answerExists = true;

  $user_answers = $practise['user_answer'][0];
  foreach ($user_answers as $key => $value) {
    $decoded_value = json_decode($value['underline']);
    array_push($underline, $decoded_value);
  }
}
?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
  @if(!empty($practise['question']))
    <div class="owl-carousel loop multiple-choice owl-theme">
      @foreach($practise['question'] as $key => $value)
      <?php
      //  pr();
        $exploded_q2 = explode('\n', $practise['question_2'][$key])
      ?>

        <div class="item  q{{$key}}" >
            <div class="underline__box">
                <h3>{{$exploded_q2[0]}}</h3>
                <input type="hidden" name="text_ans[0][{{$key}}][image]"  value="{{$value}}">
                <input type="hidden" name="text_ans[0][{{$key}}][title]" value="{{$exploded_q2[0]}}">
                <input type="hidden" name="text_ans[0][{{$key}}][text]" value="{{$exploded_q2[1]}}">
                <p class="underline_text_list_item" data-qno="{{$key}}">{{$exploded_q2[1]}}</p>
                <div class="text-center"  >
                    <img src="{{$value}}" alt="{{$value}}"   class="img-fluid">
                </div>
            </div>
        </div>
      @endforeach
    </div>

    <!-- /. List Button Start-->
    <div class="alert alert-success mt-4" role="alert" style="display:none"></div>
    <div class="alert alert-danger mt-4" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons mt-4">
        <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="0"   >Save</button>
        </li>
        <li class="list-inline-item"><button
                class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
        </li>
    </ul>
  @endif
</form>
			@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

				@include('practice.common.student_self_marking')

			@endif
			@php
				$lastPractice=end($practises);
			@endphp
			@if($lastPractice['id'] == $practise['id'])
				@include('practice.common.review-popup')
				@php
					$reviewPopup=true;
				@endphp
			@else
				@php
					$reviewPopup=false;
				@endphp
			@endif
<script>
$(document).ready(function(){
	var current_key = 0;
	var wordNumber;
	var pid = "<?php echo $practise['id'] ?>"
	$('.form_'+pid).find('.underline_text_list_item').each(function(key){
    var end=0;
    var k=0;

		var qno =$(this).attr('data-qno');
		var paragraph="";
		var str = $(this).text();
		var $this =$(this);
		str.replace(/[ ]{2,}/gi," ");
		$this.attr('data-total_characters', str.length);
		$this.attr('data-total_words', str.split(' ').length);

		var array = $this.first().text().split(' ');//split( /\s+/ );
    var words = array.filter(function (el) {
      return el.trim() != "";
    });
  	for(var i=0; i<words.length;i++){
			var word = $.trim(words[i].replace(/^\s+/,""));
			if(word !=""){
        wordNumber = k;
				if(i==0  ){
						end=word.length;
            var start = 0;
				} else {
          	end+=word.length;
          	end++;
				}
        var start = end-word.length
    		var iName= "text_ans[0]["+qno+"][underline]["+wordNumber+"][i]";
				var fColorName =  "text_ans[0]["+qno+"][underline]["+wordNumber+"][fColor]"
				var foregroundColorSpanName = "text_ans[0]["+qno+"][underline]["+wordNumber+"][foregroundColorSpan]";
				var wordName="text_ans[0]["+qno+"][underline]["+wordNumber+"][word]";
				var startName = "text_ans[0]["+qno+"][underline]["+wordNumber+"][start]";
				var endName = "text_ans[0]["+qno+"][underline]["+wordNumber+"][end]";
				paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
				$this.html(paragraph);
        k++;
			}
		}
	});


var answers = '<?php echo json_encode($underline,true) ?>';


	if( answers!==undefined && answers!==null ){
    var l=0;
    var parsedAnswers = jQuery.parseJSON(answers);
		$.each(jQuery.parseJSON(answers), function(key, value) {
	    $.each( value, function(k, v) {
	    	console.log(v);
        $('.form_'+pid).find('.q'+key).find('#'+v.i).addClass('bg-success');
	      $('.form_'+pid).find('.q'+key).find('#'+v.i).find('input').removeAttr('disabled');
 			});
		});
	}

	$('.form_'+pid).on( "click","span.highlight-text", function() {
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

	$('.form_'+pid).on('click','.submitBtn_'+pid ,function() {

		if($(this).attr('data-is_save') == '1'){
            $(this).closest('.active').find('.msg').fadeOut();
        }else{
            $(this).closest('.active').find('.msg').fadeIn();
        }
        
		var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
                    var fullView= $(".form_{{$practise['id']}}").html();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
					setTimeout(function(){
						$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.multiple-choice').css("width","1200px");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.multiple-choice').css("overflow-y","scroll");
					},500)
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }

		$('.submitBtn_'+pid).attr('disabled','disabled');
		var is_save = $(this).attr('data-is_save');
		$('.is_save:hidden').val(is_save);

		$.ajax({
				url: '<?php echo URL('save-underline-text'); ?>',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $('.form_'+pid).serialize(),
				success: function (data) {
					$('.submitBtn_'+pid).removeAttr('disabled');
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
});
</script>

<script src="{{asset('public/js/owl.carousel.js')}}"></script>


<!-- add on 1/12/2020 - Start -->
<script>
	$(document).ready(function() {
		$('.loop').owlCarousel({
		loop: false,
		autoHeight: true,
		margin: 30,
		responsive:{
			0: {
				items: 1,
			},
			768: {
				items: 3,
			},
			1024: {
				items: 3,
			},
			1100: {
				items: 3
			}			
		}
	})
 });
</script>
<!-- add on 1/12/2020 - End -->