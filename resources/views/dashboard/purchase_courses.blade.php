@extends('layouts.app')
@section('content')
<style type="">
.student-new-div{
  background-color: #315171;
  color: #fff;
  padding-top: 5rem;
  padding-bottom: 5rem;
  min-height: 100vh;
}
.logo-section{
  margin-bottom: 5rem;
}
.lev-box{
  padding: 1rem;
  color: #fafafa;
  border: 1px solid #eee;
  border-radius: 15px;
  margin-bottom: 1.5rem;
}
.lev-box[readonly]{
  pointer-events: none;
  opacity: .5;
}
.lev-box:hover{
  background-color: #f6f8fb3d;
}
.lev-box.active{
  background-color: #f6f8fb3d;
}
.box-heading .course-name{
  color: #d5d5d5;
}
.box-price .lev-status{
  color: #d5d5d5;
}
.btn.back-btn{
  border: 1px solid #d5d5d5;
  color: #d5d5d5;
  font-size: 14px;
  line-height: 14px;
  width: 55px;
}
.btn.back-btn:hover{
  border: 1px solid #d5d5d5;
  background-color: #d5d5d5;
  color: #315171;
}
</style>
 <main class="">
   <div class="student-new-div">
     <div class="container">
       <div class="logo-section d-flex align-items-center text-center">
         <a href="javascript:void(0)" class="btn btn-sm back-btn"> Back </a> 
         <a href="javascript:void(0)" class="mx-auto"> <img src="https://imperial-english.com/uktour/images/logo-text.png" width="180"></a> 
       </div>
       <div class="row">
        @foreach($available_courses['courses'] as $key => $value)
         @php
           $payment_class = "";
           if($value['student_course_status'] == "paid"){
             $payment_status = "Enrolled";
             $payment_class = "readonly";
           } 
           elseif($value['student_course_status'] = "paid" == "unpaid"){
             $payment_status = "trial";
           }
           else{
             $payment_status = "Not Enrolled";
           }
         @endphp
         <div class="col-12 col-md-6">
           <a href="javascript:void(0)" class="lev-box d-flex align-items-center justify-content-between purchase_course" id="{{$value['level_id']}}" {{$payment_class}}>
             <div class="box-heading">
               <h6 class="mb-0 course-name">{{$value['coursetitle']}}</h6>
               <h4>{{$value['leveltitle']}}</h4>
             </div>
             <div class="box-price d-flex">
               <h5 class="lev-status mr-4 mr-lg-5 mb-0">{{$payment_status}}</h5>
               <h4 class="mb-0">&#163;<span class="price">{{$value['price']}}</span></h4>
             </div>
           </a>
         </div>
        @endforeach
       </div>
       <div class="mt-4 text-center">
         <h4 class="mb-4">Total : <span class="ml-2 total_price">0</span></h4>
         <a href="javascript:void(0)" class="btn btn-md btn-light mr-4 btn-trial">Try Out</a>
         <a href="javascript:void(0)" class="btn btn-md btn-danger btn-purchase">Enroll Now</a>
       </div>
     </div>
   </div>
 </main>
 <script type="">
   $(".lev-box").click(function(){
   	$(this).toggleClass("active");
   });
 </script>
 <script type="text/javascript">
 $(document).on('click','.purchase_course',function(){
   let id = this.id;
   if($('#'+id).hasClass('active')){ 
      var price  = $('#'+id).find(".price").text();
      var total_price = $(".total_price").text();
      var converted_price = parseInt(price);
      var converted_total = parseInt(total_price);
      var final_total = converted_price + converted_total;
      $(".total_price").text(final_total);
   }
   else
   {
      var price  = $('#'+id).find(".price").text();
      var total_price = $(".total_price").text();
      var converted_price = parseInt(price);
      var converted_total = parseInt(total_price);
      if(converted_price > converted_total)
      {
           alert("something went to wrong");
           window.location = '{{ URL("/purchase_course") }}';
      }
      else
      {
           var final_total = converted_total - converted_price;
      }
      $(".total_price").text(final_total);
   }
  });
  $(document).on('click','.btn-trial',function(){
      //alert('trial');
    var ids =  $('.purchase_course.active').map(function(){
        return $(this).attr('id');
    });
    console.log(ids[0]);
    alert()
  });
  $(document).on('click','.btn-purchase',function(){
      alert('purchase');
  });
 </script>
@endsection
