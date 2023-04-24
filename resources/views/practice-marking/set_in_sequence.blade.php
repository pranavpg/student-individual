<p><strong>{!!$practise['title']!!}</strong></p>
<?php
//pr($practise);
  $answerExists = false;
  if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
    $answerExists = true;
    $answers = $practise['user_answer'][0];

  }
  $exp_question = explode(PHP_EOL, $practise['question']);

  //pr($practise);
?>
<style>
.percentage_background.active{
  background-color: grey;
}
</style>
<!-- Compoent - Two click slider-->
<form class="form_{{$practise['id']}}">
  <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
  <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
  <input type="hidden" class="is_save" name="is_save" value="">
  <input type="hidden" class="practise_type" name="practise_type" value="{{$practise['type']}}">
  <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">

  <div class="set_sequence mb-5">
    @if(!empty($exp_question))
      <ul class="list-inline d-flex flex-wrap justify-content-between text-center mb-2">
        @foreach($exp_question as $key => $value)
          <li class="list-inline-item flex-grow-1"><a href="javascript:void(0)" data-val ="{{$value}}" class="sequence_option">{{$value}}</a></li>
        @endforeach
      </ul>
    @endif
      <div class="sequence-box">
        <?php
          $last_key = array_key_last($exp_question);
          $first_key = array_key_first($exp_question);
          // echo $last_key;die;
        ?>
            <div class="row justify-content-md-center mb-2">
       	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4"></div>
       	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
       		<div class="row">
       			<div class="col-12 col-lg-12 col-md-12 mr-0 list-inline-item">
              <span class="sequence__number text-center">0%</span>
            </div>
            @foreach($exp_question as $key => $value)
	            <div class="col-12 col-lg-12 col-md-12 mr-0 list-inline-item text-center mb-2">
	              <a href="javascript:void(0)" class="percentage_background {{($key==0)?'active':''}}">
	                {{($answerExists)?$answers[$key]:""}}
	              </a>
	  	          <input type="hidden" name="options[]" value="{{($answerExists)?$answers[$key]:""}}">
	            </div>
            @endforeach
            <div class="col-12 col-lg-12 col-md-12 mr-0 list-inline-item">
              <span class="sequence__number text-center">100%</span>
            </div>
          </div>
        </div>
       	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4"></div>
      </div>
    </div>
  </div>

  <div class="alert alert-success" role="alert" style="display:none"></div>
  <div class="alert alert-danger" role="alert" style="display:none"></div>
  <!-- <ul class="list-inline list-buttons">
      <li class="list-inline-item"><button type="button" class="btn btn-secondary submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}"
              data-toggle="modal" data-is_save="0" data-target="#exitmodal">Save</button>
      </li>
      <li class="list-inline-item"><button type="button"
              class="btn btn-secondary submitBtn submitBtn_{{$practise['id']}}" data-pid="{{$practise['id']}}" data-is_save="1">Submit</button>
      </li>
  </ul> -->
</form>

<script>

    // check if an element exists in array using a comparer function
    // comparer : function(currentElement)

    Array.prototype.inArray = function(comparer) {
        for(var i=0; i < this.length; i++) {
            if(comparer(this[i])) return true;
        }
        return false;
    };

    // adds an element to the array if it does not already exist using a comparer
    // function
    Array.prototype.pushIfNotExist = function(element, comparer) {
        if (!this.inArray(comparer)) {
            this.push(element);
        }
    };
    var selected_option = [];

    <?php if(isset($practise['user_answer']) && !empty($practise['user_answer'])): ?>
        var answers = <?php echo json_encode($practise['user_answer'][0]);?>;

        for (let index = 0; index < answers.length; index++) {
            const element = answers[index];
            selected_option.indexOf(element) === -1 ? selected_option.push(element) : console.log("This item already exists ", element);
        }
        //console.log("users answers: ", selected_option.join(","));
    <?php endif; ?>




  $('.percentage_background').on('click', function(){
    $('.percentage_background').removeClass('active');
    $(this).addClass('active');
      $('.percentage_background').removeAttr('style');
  });

  $('.sequence_option').on('click', function() {
        var val = $.trim($(this).attr('data-val'));
        
        if($.inArray(val, selected_option) !== -1)
        {
            console.log("This item already exists : ", val);
            $('.percentage_background').each(function(i){
                if($(this).next().val() == val)
                {
                    $(this).next().val('');
                    //$(this).removeClass('active');
                    $(this).html('');
                    //return false
                }
            })

            $('.percentage_background.active').css("background-color", "white");
            $('.percentage_background.active').html(val);
            $('.percentage_background.active').next().val(val)
            selected_option.indexOf(val) === -1 ? selected_option.push(val) : console.log("This item already exists ", val);
        }
        else
        {
            $('.percentage_background.active').css("background-color", "white");
            $('.percentage_background.active').html(val);
            $('.percentage_background.active').next().val(val)
            selected_option.indexOf(val) === -1 ? selected_option.push(val) : console.log("This item already exists ", val);
        }
        // if(selected_option.indexOf(val) === -1){
        //     debugger;
        //     $('.percentage_background.active').css("background-color", "white");
        //     $('.percentage_background.active').html(val);
        //     $('.percentage_background.active').next().val(val)
        //     selected_option.push(val)
        // }
        // else
        // {
        //     $('.percentage_background.active').html('');
        //     $('.percentage_background.active').next().val('');
        //     $('.percentage_background').removeClass('active');
        //     $('.percentage_background').removeAttr('style');
        //     console.log("This item already exists : ", val);
        // }
  });
  $(document).on('click','.submitBtn_{{$practise["id"]}}' ,function() {
    $('.submitBtn').attr('disabled','disabled');
    var is_save = $(this).attr('data-is_save');
    $('.is_save:hidden').val(is_save);
    $.ajax({
      url: '<?php echo URL('save-set-in-sequence'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.form_{{$practise["id"]}}').serialize(),
      success: function (data) {
        $('.submitBtn_{{$practise["id"]}}').removeAttr('disabled');
  			if(data.success){
  				$('.alert-danger').hide();
  				$('.alert-success').show().html(data.message).fadeOut(4000);
  			} else {
  				$('.alert-success').hide();
  				$('.alert-danger').show().html(data.message).fadeOut(4000);
  			}
      }
    });
  });
</script>
