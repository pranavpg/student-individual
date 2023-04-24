// $(".close-course-icon").click(function () {
//     $(".course-book").toggleClass("fullscreen");
//     $(".speaking-course").toggleClass("d-flex");
// });
// $(document).on('click', '.open_task', function(){
//   $('.navigation').removeClass('active');
//   $(this).addClass('active');
//   if($(this).parent().find('a.opened').length){
//   } else {
//     $(".course-book").toggleClass("fullscreen");
//     $(".speaking-course").toggleClass("d-flex");
//   }
//
//   $(this).addClass('opened')
//   var task_id = $(this).attr('data-task_id');
//   var course_id = $(this).attr('data-course_id');
//   var level_id = $(this).attr('data-level_id');
//   var topic_id = $(this).attr('data-topic_id');
//   $.ajax({
//       url: get_task_details_url,
//       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//       type: 'POST',
//     //  dataType:"JSON",
//       data:{task_id, course_id, level_id, topic_id} ,
//       success: function (data) {
//
//           $('#task_desc_frame').attr('srcdoc',data)
//           $('#task_desc_frame').height(600);
//           $('#task_desc_frame').width(470);
//       }
//   });
// });

$(document).on('click','.threeBlankTableBtn' ,function() {
  $('.threeBlankTableBtn').attr('disabled','disabled');
  if($(this).attr('data-is_save') == '1'){
    $(this).closest('.active').find('.msg').fadeOut();
  }else{
    $(this).closest('.active').find('.msg').fadeIn();
  }
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);

  $.ajax({
      url: save_three_blank_table_url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('.save_three_blank_table_form').serialize(),
      success: function (data) {
        $('.threeBlankTableBtn').removeAttr('disabled');

          $('.alert-success').show().html(data.message).fadeOut(8000);
          // $('#task_desc_frame').attr('srcdoc',data)
          // $('#task_desc_frame').height(600);
          // $('#task_desc_frame').width(470);
      }
  });

});
var is_save = $(this).attr('data-is_save');
$('.is_save:hidden').val(is_save);
$(document).ready(function() {
var topic_id= $('.save_three_blank_table_form').find('.topic_id').val();
var task_id=$('.save_three_blank_table_form').find('.task_id').val();
var practise_id=$('.save_three_blank_table_form').find('.practise_id').val();

  $.ajax({
      url: get_three_blank_table_url,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data:{
        topic_id,
        task_id,
        practise_id
      },
      dataType:'JSON',
      success: function (data) {
        var result = data[0][0]
        console.log('====>',result);
        for(var i=0; i< result.length; i++){
          if(i>0){

            $('.col_'+i+'_1').val(result[i]['col_1'])
            $('.col_'+i+'_2').val(result[i]['col_2'])
            $('.col_'+i+'_3').val(result[i]['col_3'])
          }
        }
      }
  });
})
