<p>
  <strong>{{$practise['title']}}</strong>
</p>
<style>

</style>
<?php
//dd($practise);
$answerExists = false;
if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
  $answerExists = true;
  $answers = json_decode($practise['user_answer'][0][0], true);
}
$getColorData  =  explode('#%', $practise['question']);
$colorArray = explode('/@', $getColorData[0]);
$colorTextArray = explode('@@',$colorArray[0]);
//dd($colorTextArray);
//$colorCodeArray = explode('@@',$colorArray[1]);
$colorCodeArray =  explode('@@',$colorArray[1]); //['#A9FFD4', '#FFF4BB'];
$fColorArray = ['-1145286', '-6053068'];
if(isset($practise['dependingpractise_answer'][0])){


        // $practise['dependingpractise_answer'][0] = str_replace("\n"," ", $practise['dependingpractise_answer'][0]);
        // $practise['dependingpractise_answer'][0] = str_replace("\r"," ", $practise['dependingpractise_answer'][0]);
        // dd($practise['dependingpractise_answer'][0]);
        $displayTextArray = explode(PHP_EOL, $practise['dependingpractise_answer'][0]);


}else{
  $getColorData[1] = str_replace("  ", " ",$getColorData[1]);
  $displayTextArray =   explode("<br><br>", $getColorData[1]);
}
//dd($colorCodeArray);

$displayTextArray = array_filter($displayTextArray);
$displayTextArray = array_merge($displayTextArray);
// dd($displayTextArray);
// dd($displayTextArray);


?>
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practice_type" name="practice_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">


  <div
      class="pickcolor__heading row d-flex w-100 flex-wrap align-items-start align-items-md-center mb-2 mb-md-4">
      <div class="col-md-2 col-12">
          <p><strong>Pick a colour</strong></p>
      </div>
     
      @if(!empty($colorCodeArray))
        @foreach($colorCodeArray as $colorKey => $colorValue)
        <?php
          $colorCode = "background-color:".$colorValue;
        ?>
          <div class="col-md-5 col-6">
              <p class="d-flex flex-wrap  align-items-center">
                  <span class="change-color {{($colorKey==0)?'fColorActive':''}} mr-2" data-fcolor="{{$fColorArray[$colorKey]}}"  style="{{$colorCode}}"></span>
                  <strong>{{$colorTextArray[$colorKey]}}</strong>
              </p>
          </div>
        @endforeach
      @endif

  </div>
 <div id="appendhtmlnew"></div>
  <!-- /. Pick color heading-->

  <div class="multiple-choice multiple-choice__custom mb-4 q0">
    @if(!empty($displayTextArray))
      @foreach($displayTextArray as $key => $value)
        @if( !empty(trim($value)) )

          <p class="underline_text_list_item"  data-qno="{{$key}}">{!! trim($value) !!}</p>

        @endif
      @endforeach
    @endif
  </div>

  <!-- /. List Button Start-->

    <div class="alert alert-success" role="alert" style="display:none"></div>
    <div class="alert alert-danger" role="alert" style="display:none"></div>
    <ul class="list-inline list-buttons">
        <li class="list-inline-item"><button class="save_btn btn btn-primary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button
                class="submit_btn btn btn-primary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
        </li>
    </ul>
</form>




<style>
.highlight { background-color: yellow }
</style>
<script>
    var checkcolot = false;
$(document).ready(function(){
  var current_key = 0;
  var wordNumber;
  var end=0;
  var k=0;
  var pid = "<?php echo $practise['id'] ?>"
  var colors = '<?php echo json_encode($colorCodeArray); ?>';
  var colorsArray = JSON.parse(colors);

  // console.log(colorsArray);
  $('.form_'+pid).find('.underline_text_list_item').each(function(key){
    // if(k>0){
    //   k=k+1;
    // }

    //alert()
    var qno =0; //$(this).attr('data-qno')
    var paragraph="";
    var str = $(this).text();
    var $this =$(this);
    str.replace(/[ ]{2,}/gi," ");
    $this.attr('data-total_characters', str.length);
    $this.attr('data-total_words', str.split(' ').length);

    var words = $this.first().text().trim().split(' ');//split( /\s+/ );

    for(var i=0; i<words.length;i++){
          var word = words[i];
          if(word !=""){
            wordNumber = k;

            // if( i==0 && key==0 ) {
            //    end=word.length;
            // } else {
            //    end+=word.length;
            //    end++;
            // }

            if(i==0 && key==0){
            //  console.log(words[i],'i===>',i)
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
                // end++;
              }
            }

            var start = end-word.length
            var iName= "text_ans[1]["+qno+"]["+wordNumber+"][i]";
            var fColorName =  "text_ans[1]["+qno+"]["+wordNumber+"][fColor]"
            var foregroundColorSpanName = "text_ans[1]["+qno+"]["+wordNumber+"][foregroundColorSpan]";
            var wordName="text_ans[1]["+qno+"]["+wordNumber+"][word]";
            var startName = "text_ans[1]["+qno+"]["+wordNumber+"][start]";
            var endName = "text_ans[1]["+qno+"]["+wordNumber+"][end]";
            paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
            $this.html(paragraph);
            //alert(paragraph)
          }
          k++;
    }
  });


  var answers='<?php echo !empty($practise["user_answer"])?$practise["user_answer"][0][0]:"" ?>';
  if(answers!=""){
    var parsedAnswer = JSON.parse(answers);
    if( parsedAnswer!==undefined && parsedAnswer!==null ){
      $l=0;
    //  console.log('ans===>',parsedAnswer)
      $.each(parsedAnswer, function(key, value) {
  //      console.log('key===>',key)
          $.each( value, function(k, v) {
            console.log(key,'===>k', value)
             if(k=='fColor'){
                 // alert(v)
                if(v =='-1758164' || v== '-1145286'){
                  $('.form_'+pid).find('.q0').find('#'+value.i).addClass('bg-success1');

                  // $('.form_'+pid).find('.q0').find('#'+value.i).css('background-color',"");
                  $('.form_'+pid).find('.q0').find('#'+value.i).css('background-color',colorsArray[0]);
                  // $(this).css('background-color',colorsArray[0]);

                } else {
                  $('.form_'+pid).find('.q0').find('#'+value.i).addClass('bg-opinion');
                  $('.form_'+pid).find('.q0').find('#'+value.i).css('background-color',colorsArray[1]);
                }
               $('.form_'+pid).find('.q0').find('#'+value.i).attr('fColor',v)
               $('.form_'+pid).find('.q0').find('#'+value.i + ' .fColor').attr('value',v)
             }
             $('.form_'+pid).find('.q0').find('#'+value.i).find('input').removeAttr('disabled');
          });
          $l++
      });
    }
  }

  $('.form_'+pid).on( "click","span.highlight-text", function() {

      var fcolor = $('.fColorActive').attr('data-fcolor')
      if($(this).hasClass('bg-success1')){
        $( this ).removeClass( 'bg-success1' );
        $( this ).css( 'background-color',"");
        $(this).find('input').attr('disabled','disabled');
      }
      else if($(this).hasClass('bg-opinion')){
        $( this ).removeClass( 'bg-opinion' );
        $(this).find('input').attr('disabled','disabled');
        $( this ).css( 'background-color',"");
      }
      else {
        // alert(fcolor);

        if(fcolor=="-1145286" || fcolor == '-1758164'){
          $( this ).addClass( 'bg-success1' );
          $(this).css('background-color',colorsArray[0]);

          $(this).find('input.fColor').val(fcolor);
        } else{
          $(this).addClass( 'bg-opinion' );
          $(this).css('background-color',colorsArray[1]);

          // console.log();
          // $( this ).addClass( 'bg-opinion' );
          $(this).find('input.fColor').val('-6053068');
        }
        $(this).find('input').removeAttr('disabled');
      }
    //console.log($(this).text())
    // $('.list-item').highlight($( this ).text() );
  });

  function setTextareaContent(pid){
    $('.form_'+pid).find("span.textarea.form-control").each(function(){
      var currentVal = $(this).html();
      $(this).next().find("textarea").val(currentVal);
    });
  }
  $('.form_'+pid).on('click','.submitBtn_'+pid ,function() {
    if(!checkcolot){
      alert("Please Pick a colour.")
      return false
    }
    $('.submitBtn_'+pid).attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    setTextareaContent(pid);
    $.ajax({
        url: '<?php echo URL('save-underline-text-multi-color'); ?>',
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
    return false;
  });
});


$('.change-color').on('click', function() {

  checkcolot = true;


  $('.change-color').removeClass('fColorActive');
  $('.change-color').css('border','none');
  $(this).css('border','1px solid black');
  $(this).addClass('fColorActive');
})
</script>
