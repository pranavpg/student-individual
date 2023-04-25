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
      .lev-check{
        position: absolute;
        visibility: hidden;
      }
      .lev-box{
      padding: 1rem;
      /*position: absolute;*/
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
                 elseif($value['student_course_status'] == "unpaid"){
                   $payment_status = "Trial";
                 }
                 else{
                   $payment_status = "Not Enrolled";
                 }
               @endphp
              <div class="col-12 col-md-6 purchase_course" id="{{$value['level_id']}}">
                <input type="checkbox" name="level_check" class="lev-check" id="{{$value['level_id']}}" value="{{$value['price']}}">
                <label for="one" class="lev-box d-flex align-items-center justify-content-between" {{$payment_class}} id="{{$value['level_id']}}">
                  <div class="box-heading">
                    <h6 class="mb-0 course-name">{{$value['coursetitle']}}</h6>
                    <h4>{{$value['leveltitle']}}</h4>
                  </div>
                  <div class="box-price d-flex">
                    <h5 class="lev-status mr-4 mr-lg-5 mb-0">{{$payment_status}}</h5>
                    <h4 class="mb-0">&#163;<span class="price">{{$value['price']}}</span></h4>
                  </div>
                </label>
              </div>
            @endforeach
          </div>
          <div class="mt-4 text-center">
            <h4 class="mb-4">Total : <span class="ml-2 total_price">0</span></h4>
            <a href="" class="btn btn-md btn-light mr-4">Try Out</a>
            <a href="" class="btn btn-md btn-danger">Enroll Now</a>
          </div>
       </div>
    </div>
    </main>
    <script type="">
      // $(".lev-box").click(function(){
      //   $(this).toggleClass("active");
      // });
    </script>
    <script type="text/javascript">
      $(document).on('click','.lev-box',function(){
        //$(this).toggleClass("active");
        let id = this.id;
        if($(this).is(':checked')) {
           alert(id);
           var price  = $('#'+id).find(".price").text();
           var total_price = $(".total_price").text();
           var converted_price = parseInt(price);
           var converted_total = parseInt(total_price);
           $(this).attr('value', 'true');
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
           $(this).attr('value', 'false');
        }
      });
    </script>
@endsection