<p><strong>{!! $practise['title'] !!}</strong></p>
<?php
if(isset($practise['is_roleplay']) ) {
    $jsondata = array();
    $userAns = array();
    if(isset($practise['user_answer'])){
        foreach($practise['user_answer'] as $key=>$data){
            if(isset($data[1][0])){
                if($data[1][0] != "#"){
                    array_push($jsondata,$data[1][0]);
                }
            }
        }
        $userAns = $practise['user_answer'];
    }
    $tempArray = array();
    foreach($userAns as $key=>$tempdata){
        if($tempdata!="##"){
            $tempArray[] =  $tempdata;
        }
    }
    $explode_question = explode( '##', $practise['question'] );
    $groups         = explode( '@@', $explode_question[0] );
    $s=0;
    ?>
        <form class="form_{{$practise['id']}}">
            <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
            <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
            <input type="hidden" class="is_save" name="is_save" value="">
            <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
            <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
            <div class="component-two-click mb-4">
                <div class="two-click d-flex flex-wrap justify-content-center mb-4 w-100">
                    @foreach($groups as $key => $value)
                        <a href="#!" class="btn btn-dark selected_option  selected_option_{{$practise['id']}} selected_option_{{$key}}" data-key="{{$key}}">{{$value}}</a>
                    @endforeach
                </div>
                <div class="two-click-content w-100">
                    <?php   $p=0; ?>
                    @foreach($groups as $k => $v)
                        @php
                            $s++;
                            $inner_content      = explode( '#@', $explode_question[$s]);
                            $question_textarea  = explode( PHP_EOL, $inner_content[1]);
                        @endphp
                        <div class="content-box multiple-choice d-none selected_option_description selected_option_description_{{$practise['id']}} selected_option_description_{{$k}}">
                            <?php 
                                foreach($question_textarea as $innerkey=>$values) {
                                    if(str_contains($values,'@@')) {
                                        echo $outValue = preg_replace_callback('/@@/',function ($m) use(&$userAns,&$innerkey,&$p,&$k)  {

                                                $valueOrignal = "";
                                                if(!empty($userAns) && isset($userAns[$p][0][$innerkey])){
                                                    $valueOrignal = $userAns[$p][0][$innerkey];
                                                }
                                                $str = '<div class="component-control-box enter_disable " style="width: 95%;display: inline-flex;">
                                                          <span class="textarea form-control form-control-textarea" role="textbox" disabled contenteditable="" placeholder="Write here...">'.nl2br($valueOrignal).'</span>
                                                          <div style="display:none">
                                                              <textarea name="user_answer['.$k.']['.$innerkey.'][text_ans]" placeholder="Enter text here..."></textarea>
                                                          </div>
                                                      </div><br>';
                                            return $str;
                                        }, $values);
                                    } else {
                                        echo $outValue = ' <br><div style="color: black;">'.$values.'</div> <br>';
                                    }
                                    echo "<br>";
                                }
                                $p = $p+2;
                            ?>
                            <ul class="list-unstyled list-texthighlighted">
                                <li  class="list-item underline_text_list_item" style="font-weight: 500 !important;">
                                    {!! $inner_content[0] !!}
                                </li>
                            </ul>
                            <?php 
                            ?>
                                <input type="hidden" class="selected_json_{{$practise['id']}} selected_json_temp " value="{{isset($tempArray[$k])?isset($tempArray[$k][1])?$tempArray[$k][1][0]:'':''}}">
                            <?php 
                            ?>

                        </div>

                    @endforeach
                </div>
            </div>
            <div class="alert alert-success" role="alert" style="display:none"></div>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <ul class="list-inline list-buttons">
              <li class="list-inline-item"><button class="btn btn-secondary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
              </li>
              <li class="list-inline-item"><button
                      class="btn btn-secondary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
              </li>
            </ul>
        </form>
        <script>
            var userAns = '<?php echo addslashes(json_encode($jsondata)) ;?>';
            function setTextareaContent(pid){
                $('.form_'+pid).find("span.textarea.form-control").each(function(){
                    var currentVal = $(this).html();
                    $(this).next().find("textarea").val(currentVal);
                });
            }
            function openpopupRolePlay(){
                $("#selfMarking_{{$practise['id']}}").find(".selected_option").click(function() {
                    var content_key = $(this).attr('data-key');
                    $("#selfMarking_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
                    $("#selfMarking_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
                    $("#selfMarking_{{$practise['id']}}").find('.selected_option_description_' + content_key).show();
                    $("#selfMarking_{{$practise['id']}}").find(this).toggleClass('btn-bg');
                    if ($("#selfMarking_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
                        $("#selfMarking_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
                    } else {
                        $("#selfMarking_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
                    }
                });
            }
            $(document).ready(function(){
                var pid = "<?php echo $practise['id'] ?>"
                $(".form_{{$practise['id']}}").find(".selected_option").click(function() {
                    var content_key = $(this).attr('data-key');
                    $(".form_{{$practise['id']}}").find('.selected_option').not(this).toggleClass('d-none');
                    $(".form_{{$practise['id']}}").find('.selected_option_description_' + content_key).toggleClass('d-none');
                    $(".form_{{$practise['id']}}").find('.selected_option_description_' + content_key).show();
                    $(".form_{{$practise['id']}}").find(this).toggleClass('btn-bg');
                    if ($(".form_{{$practise['id']}}").find('.selected_option_description:visible').length > 0) {
                        $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(0);
                    } else {
                        $(".form_{{$practise['id']}}").find('.is_roleplay_submit').val(1);
                    }
                });
                $(".form_{{$practise['id']}}").on( "click","span.highlight-text", function() {
                    if($(this).hasClass('bg-success')){
                        $( this ).removeClass( 'bg-success' );
                        $(this).find('input').attr('disabled','disabled');
                    } else {
                        $( this ).addClass( 'bg-success' );
                        $(this).find('input').removeAttr('disabled');
                    }
                });

                var current_key     = 0;
                var pid             = "<?php echo $practise['id'] ?>"
                var wordNumber;
                var temp = 0;
                $('.form_'+pid).find('.underline_text_list_item').each(function(key) {
                    var end             = 0;
                    var k               = 0;
                    var qno =0; 
                    var paragraph="";
                    var str = $(this).text();
                    var $this =$(this);
                    str.replace(/[ ]{2,}/gi," ");
                    $this.attr('data-total_characters', str.length);
                    $this.attr('data-total_words', str.split(' ').length);
                    var words = $this.first().text().trim().split(' ');//split( /\s+/ );
                    for(var i=0; i<words.length;i++) {
                        var word = words[i].replace(/^\s+/,"");
                        if(word !=""){
                            wordNumber = k;
                            if(i==0 && key==0) {
                                end=word.length;
                            }else{
                                end+=word.length;
                                end++;
                            }
                            
                            if(i==0 && key==1) {
                                end = end-1;
                            }
                            var start                   = end-word.length
                            var iName                   = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][i]";
                            var fColorName              = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][fColor]"
                            var foregroundColorSpanName = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][foregroundColorSpan][mColor]";
                            var wordName                = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][word]";
                            var startName               = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][start]";
                            var endName                 = "text_ans["+temp+"][1]["+qno+"]["+wordNumber+"][end]";
                            paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+">\
                                <input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+">\
                                <input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'>\
                                <input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'>\
                                <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" >\
                                <input type='hidden' disabled name="+startName+" class='start' value="+start+" >\
                                <input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word+"</span>"
                            $this.html(paragraph);
                        }
                        k++;
                    }
                    temp++;
                });
                var d=0;
                $('.selected_json_temp').each(function(){
                    var answers = $(this).val();
                    if( answers !=""){
                        var parsedAnswer = JSON.parse(answers);
                        if( parsedAnswer!==undefined && parsedAnswer!==null ){
                            $.each(parsedAnswer, function(key, value) {
                                 $('.selected_option_description_'+d).find('#'+value.i).addClass('bg-success');
                                 $('.selected_option_description_'+d).find('#'+value.i).find('input').removeAttr('disabled');
                            });
                           
                        }
                    }
                     d++;
                });
            });
        </script>
    <?php
}else{ //end role play
    $jsondata = array();
    $userAns = array();
    if(isset($practise['user_answer'])){
        foreach($practise['user_answer'] as $key=>$data){
            if(isset($data[1][0])){
                if($data[1][0] != "#"){
                    array_push($jsondata,$data[1][0]);
                }
            }
            
        }
        $userAns = $practise['user_answer'];
    }
    if( !empty($practise['question'] ) ) {
        $explode_question = explode( '#@', $practise['question'] );
        $explode_question_underline = explode( '@@', $explode_question[0]);
        $question_underline = explode( PHP_EOL, $explode_question_underline[0]);

        $explode_question_writing = explode( '@@', $explode_question[1]);

       }
    $answerExists = false;
    if(!empty($practise['user_answer'])){
        $answerExists = true;
    	$encoded_answer = isset($practise['user_answer'][1])?$practise['user_answer'][1][0]:"";
    }
    ?>
    <form class="form_{{$practise['id']}}">
      <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
      <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
      <input type="hidden" class="is_save" name="is_save" value="">
      <input type="hidden" class="practise_type" name="practice_type" value="{{$practise['type']}}">
      <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
      <div class="multiple-choice">
          <div class="box row d-flex align-items-end mb-4">
              <div class="col-12 col-md-12 form-group mb-0 ">
                <div id="writing_at_end_up_main_div_15505106005c6aea082a05f">
                <?php 
                    $ques = explode(PHP_EOL, $explode_question[1]);
                    foreach ($ques as $key => $value) {
                        if(str_contains($value,'@@')) {
                            $newAnswer = (!empty($userAns))? $userAns[0] : [];
                            echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key, &$ans, &$data, &$value, &$k, &$newAnswer) {
                                $valAns = (isset($newAnswer[$key]))? $newAnswer[$key] : "";
                                $str =' <div class="writing_at_end_upform-group-label">
                                       <label class="writing_at_end_up_label"></label><textarea type="text" class="form-control writing_at_end_up_form-control" name="blanks[]" id="writeingBox_0" placeholder="Write here..." value="" rows="1" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 26px;">'.$valAns.'</textarea></div>
                                        ';
                                $k++;
                                return $str;
                            }, $value);
                        }else{
                            ?>
                                @if(!empty($value))
                                <input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="">
                                @endif
                                {!!$value!!}
                            <?php
                        }
                    }
                ?>
              </div>
              </div>
          </div> 
          @if(!empty($question_underline))
          <div class="box mb-4 q0">
            @foreach($question_underline as $key => $value)
                @if(!empty(trim($value)))
                      <p class="underline_text_list_item"  data-qno="{{$key}}">{{ str_replace( '<br>','', $value ) }}</p>
                @endif
            @endforeach
          </div> 
          @endif
      </div>
      <div class="alert alert-success" role="alert" style="display:none"></div>
      <div class="alert alert-danger" role="alert" style="display:none"></div>
      <ul class="list-inline list-buttons">
          <li class="list-inline-item"><button class="btn btn-secondary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
          </li>
          <li class="list-inline-item"><button
                  class="btn btn-secondary submitBtn_{{$practise['id']}}" data-is_save="1" data-pid="{{$practise['id']}}" >Submit</button>
          </li>
      </ul>
    </form>
<style type="text/css">
    *[contenteditable]:empty:before {
        content: "\feff";
    }
    .appendspan {
        color:red;
    }
</style>
    <script>
    $(document).ready(function(){
    	var current_key = 0;
    	var wordNumber;
    	var end=0;
        var k=0;
    	var pid = "<?php echo $practise['id'] ?>"
    	$('.form_'+pid).find('.underline_text_list_item').each(function(key){
                var paragraph="";
                var str = $(this).text();
                var $this =$(this);
                str.replace(/[ ]{2,}/gi," ");
                $this.attr('data-total_characters', str.length);
                $this.attr('data-total_words', str.split(' ').length);
                var newWord = $this.first().text().trim()
                var words   = newWord.split(' ');
                for(var i=0; i<words.length;i++){
                    var word = words[i];
                    console.log(word);
                    wordNumber = k;
                    if(word.trim()!=""){
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
                            }
                        }
                        var start = end-word.length
                        var iName= "text_ans[0][0]["+wordNumber+"][i]";
                        var fColorName =  "text_ans[0][0]["+wordNumber+"][fColor]"
                        var foregroundColorSpanName = "text_ans[0][0]["+wordNumber+"][foregroundColorSpan]";
                        var wordName="text_ans[0][0]["+wordNumber+"][word]";
                        var startName = "text_ans[0][0]["+wordNumber+"][start]";
                        var endName = "text_ans[0][0]["+wordNumber+"][end]";
                        paragraph+="<span class='highlight-text' id="+wordNumber+" data-key="+key+" data-wordlength="+word.length+"><input type='hidden' class='i' disabled name="+iName+" value="+wordNumber+"><input type='hidden' class='fColor' disabled name="+fColorName+" value='-1145286'><input type='hidden' class='foregroundColorSpan' disabled name="+foregroundColorSpanName+" value='-1145286'> <input type='hidden' class='word' disabled name="+wordName+" value="+words[i]+" ><input type='hidden' disabled name="+startName+" class='start' value="+start+" ><input disabled type='hidden' name="+endName+" value="+parseInt(end)+" class='end'>"+word.replace(/^\s+/,"")+"</span>"
                        $this.html(paragraph);
                    }
                    k++;
                }
    	});
    	var answers='<?php echo !empty($practise["user_answer"][1])?$practise["user_answer"][1][0]:"" ?>';
        if(answers!=""){
          	var parsedAnswer = JSON.parse(answers);
          	if( parsedAnswer!==undefined && parsedAnswer!==null ){
              $l=0;
          		$.each(parsedAnswer, function(key, value) {
             			$.each( value, function(k, v) {
             				console.log(value.i)
             				 $('.form_'+pid).find('#'+value.i).addClass('bg-success');
             				 $('.form_'+pid).find('#'+value.i).find('input').removeAttr('disabled');
             			});
                  $l++
          		});
          	}
        }
    	$('.form_'+pid).on( "click","span.highlight-text", function() {
    		if($(this).hasClass('bg-success')){
    			$( this ).removeClass( 'bg-success' );
    			$(this).find('input').attr('disabled','disabled');
    		} else {
    			$( this ).addClass( 'bg-success' );
    			$(this).find('input').removeAttr('disabled');
    		}
    	});
    	function setTextareaContent(pid){
    		$('.form_'+pid).find("span.textarea.form-control").each(function(){
    			var currentVal = $(this).html();
    			$(this).next().find("textarea").val(currentVal);
    		});
    	}
    });
    </script>
    <?php 
} ?>
