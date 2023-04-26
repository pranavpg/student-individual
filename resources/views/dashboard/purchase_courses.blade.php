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
<style type="text/css">
       #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: none;
        }
        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }
        @keyframes  spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 40px;
            height: 40px;
            border-style: solid;
            border-color: black;
            border-top-color: transparent;
            border-width: 4px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
        .course-selection>.section>.row {
            border: 1px solid #ccc;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .validationMessage {
            color: red
        }
        .page-loader-wrapper {
            z-index: 99999999;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(111, 89, 89, .4);
            overflow: hidden;
            text-align: center;
        }
        .page-loader-wrapper .loader {
            position: relative;
            top: calc(50% - 30px);
        }
        .loading-img-spin { 
            position: absolute;
            top: 50%;
            left: 50%;
            width: 180px;
            height: 80px;
            margin: -100px 0 20px -75px;
        }



        .cc-modal .modal-close .close-modal {
            position: absolute;
            cursor: pointer;
            top: -16px;
            right: -11px;
            height: 34px;
            width: 34px;
            background: #fafafa;
            border: 1px solid #3a3f44;
            border-radius: 50%;
            font-size: 11px;
            color: #05080b;
            z-index: 5;
            transition: .4s;
        }

        .cc-modal .modal-body .form-group {
              margin-bottom: 1.5rem;
          }

          .cc-modal .modal-body .form-group label {
          font-size: 15px;
      }

      .cc-modal .modal-body .form-group input {
    height: 36px;
    font-size: 15px;
}


    </style>
 <main class="">
   <div class="student-new-div">
     <div class="container">
       <div class="logo-section d-flex align-items-center text-center">
         <a href="javascript:void(0)" class="btn btn-sm back-btn"> Back </a> 
         <a href="javascript:void(0)" class="mx-auto"> <img src="https://imperial-english.com/uktour/images/logo-text.png" width="180"></a> 
         <h6>StudentId: {{$student_id}} </h6> 
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
         <button  type="button" class="btn btn-md btn-light mr-4 btn-trial" id="try">Try Out</button>
         <button type="button" class="btn btn-md btn-danger btn-purchase-model" id="enroll">Enroll Now</button>
       </div>
     </div>
   </div>
 </main>
 <!--------------------->
 <div class="modal cc-modal fade" id="paymentModel" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-close">
           <button type="button" data-dismiss="modal" aria-label="Close" class="close-modal">
            <i class="fas fa-times"></i>
           </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <!-- <label for="username">Full name (on the card)</label> -->
              <input type="text" class="form-control" name="fullName" id="cardname" placeholder="Full name (on the card)">
              <span class="cardnameError p-error"></span>
          </div>
          <div class="form-group">
              <label for="cardNumber">Card number</label>
              <div class="input-group">
                  <input type="text" class="form-control cc-number" name="cardNumber" id="cardNumber" placeholder="Card Number">
                  <div class="input-group-append">
                      <span class="input-group-text text-muted">
                      <i class="fab fa-cc-visa fa-lg pr-1"></i>
                      <i class="fab fa-cc-amex fa-lg pr-1"></i>
                      <i class="fab fa-cc-mastercard fa-lg"></i>
                      </span>
                  </div>
              </div>
              <span class="cardNumberError p-error"></span>
          </div>
         <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label><span class="hidden-xs">Expiration</span> </label>
                    <div class="input-group">
                        <select class="form-control" name="month" id="month">
                            <option value="">MM</option>
                            @foreach(range(1, 12) as $month)
                                <option value="{{$month}}">{{$month}}</option>
                            @endforeach
                        </select>
                        <!-- <span class="monthError p-error"></span> -->
                        <select class="form-control" name="year" id="year">
                            <option value="">YYYY</option>
                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>

                    </div>
                       <span class="yearError p-error"></span>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                  <input type="number" class="form-control" onKeyPress="if(this.value.length==4) return false;" placeholder="CVV" name="cvv" id="cvv">
                  <span class="cvvError p-error"></span>
              </div>
            </div>
        </div>
            <button class="subscribe btn btn-primary btn-block btn-purchase" style="margin-bottom: 12px;"> Confirm </button>
            <span class="commonError" style="color:red;display: none;font-size:12px;"> </span>
       </div>
    </div>
   </div>
  </div>
 <!---------------------->
 <script type="text/javascript">
 $(document).on('click','.purchase_course',function(){
   let id = this.id;
   $(this).toggleClass("active");
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
  $(document).on('click','.btn-purchase-model',function(){
    var total_price = $(".total_price").text();
    var converted_total = parseInt(total_price);
    if(converted_total > 9)
    {
       $("#paymentModel").modal('show');
    }
    else
    {
        alert("Please selecr course");
    }
  });
  $(document).on('click','.btn-trial',function(){
    var ids =  $('.purchase_course.active').map(function(){
         return $(this).attr('id');
    }).get();
    var subscription_type = "trial";
    var total_price = $(".total_price").text();
    var converted_total = parseInt(total_price);
    var student_id = "edfe";
    if(converted_total > 9)
    {
        purchase_course(student_id,ids,converted_total,subscription_type);
    }
    else
    {
        alert("Please selecr course");
    }

  });
  // $(document).on('click','.btn-purchase',function(){
    
  //   var ids =  $('.purchase_course.active').map(function(){
  //        return $(this).attr('id');
  //   }).get();
  //   var subscription_type = "purchase";
  //   var total_price = $(".total_price").text();
  //   var converted_total = parseInt(total_price);
  //   var student_id = "edfe";
  //   var card_details = {};
  //   card_details['cardname']   = $("#cardname").val();
  //   card_details['cardNumber'] = $("#cardNumber").val();
  //   card_details['month']      = $("#month").val();
  //   card_details['year']       = $("#year").val();
  //   card_details['cvv']        = $("#cvv").val();
  //   if(converted_total > 9)
  //   {
  //      // $("#paymentModel").modal('show');
  //       purchase_course(student_id,ids,converted_total,subscription_type,);
  //   }
  //   else
  //   {
  //       alert("Please selecr course");
  //   }
    
  // });
  function purchase_course(student_id,ids,converted_total,subscription_type)
  {
      $("#try").attr("disabled", true);
      $("#enroll").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: '{{ URL("purchase") }}',
        data : {
                  _token: "{{ csrf_token() }}",
                  total_price: converted_total,
                  level_id:ids,
                  subscription_type:subscription_type
               },
        dataType: "json",
        success: function(res) {
                 $("#try").attr("disabled", false);
                 $("#enroll").attr("disabled", false);
        }
      });
     console.log(ids);
  }
 </script>
 <script>
  function payViaStripe() {
  // get stripe payment intent
  const stripePaymentIntent = "wfhgyuiwergfuyrfg_rfhgiuehrg_gwfygfygregf";//document.getElementById("stripe-payment-intent").value;
  // execute the payment
  stripe
      .confirmCardPayment(stripePaymentIntent, {
          payment_method: {
                  card: cardElement,
                  billing_details: {
                      "email": "pranav.gevariya@gmail.com",
                      "name":  "pranav gevariya",
                      "phone": "9998616126"
                  },
              },
          })
          .then(function(result) {
              // Handle result.error or result.paymentIntent
              if (result.error) {
                  console.log(result.error);
              } else {
                  console.log("The card has been verified successfully...", result.paymentIntent.id);
                  // [call AJAX function here]
              }
          });
  } 
 </script>
     <script type="">

      var txtCardNumber = document.querySelector(".cc-number");
        txtCardNumber.addEventListener("input", onChangeTxtCardNumber);

        function onChangeTxtCardNumber(e) {   
            var cardNumber = txtCardNumber.value;
         
            // Do not allow users to write invalid characters
            var formattedCardNumber = cardNumber.replace(/[^\d]/g, "");
            formattedCardNumber = formattedCardNumber.substring(0, 16);
          
            // Split the card number is groups of 4
            var cardNumberSections = formattedCardNumber.match(/\d{1,4}/g);
            if (cardNumberSections !== null) {
                formattedCardNumber = cardNumberSections.join(' '); 
            }
          
            console.log("'"+ cardNumber + "' to '" + formattedCardNumber + "'");
          
            // If the formmattedCardNumber is different to what is shown, change the value
            if (cardNumber !== formattedCardNumber) {
                txtCardNumber.value = formattedCardNumber;
            }
        }

    </script>
    <script type="text/javascript">
             $('.btn-purchase').click(function(){
                $('.commonError').fadeOut();
                var submitFlag = false;
                if($('#cardname').val() == ""){
                    submitFlag = false;
                    $('.cardnameError').text("Please enter name.");
                    $('.cardnameError').css("color","red");
                    $('.cardnameError').fadeIn();
                }else{
                    submitFlag = true;
                    $('.cardnameError').fadeOut();
                }
                if($('#cardNumber').val() == ""){
                    submitFlag = false;
                    $('.cardNumberError').text("Please enter card number.");
                     $('.cardNumberError').css("color","red");
                    $('.cardNumberError').fadeIn();
                }else{
                    submitFlag = true;
                    $('.cardNumberError').fadeOut();
                }
                if($('#month').val() == ""){
                    submitFlag = false;
                    $('.yearError').css("color","red");
                    $('.yearError').text("Please select Expiration.");
                    $('.yearError').fadeIn();
                }else{
                    submitFlag = true;
                    $('.yearError').fadeOut();
                }

                if($('#year').val() == ""){
                    submitFlag = false;
                    $('.yearError').css("color","red");
                    $('.yearError').text("Please select Expiration.");
                    $('.yearError').fadeIn();
                }else{
                    submitFlag = true;
                    $('.yearError').fadeOut();
                }

                if($('#cvv').val() == ""){
                    submitFlag = false;
                    $('.cvvError').css("color","red");
                    $('.cvvError').fadeIn();
                    $('.cvvError').text("Please enter CVV.");
                }else{
                    submitFlag = true;
                    $('.cvvError').fadeOut();
                }
                var ids =  $('.purchase_course.active').map(function(){
                   return $(this).attr('id');
                }).get();
                var total_price = $(".total_price").text();
                var converted_total = parseInt(total_price);
                if(submitFlag){

                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:"POST",
                        url:'{{ URL("purchase") }}',
                        data: {'fullName':$('#cardname').val(),'cardNumber':$('#cardNumber').val(),'month':$('#month').val(),'year':$('#year').val(),'cvv':$('#cvv').val(),'subscription_type':'purchase','level_id':ids,'total_price':converted_total},
                        dataType:'json',
                        beforeSend: function () {
                            $("#cover-spin").show();
                        },
                        complete: function () {
                            $("#cover-spin").hide();
                        },
                        success:function(res){
                            if(typeof(res.data)!=="undefined"){
                                $('.commonError').fadeIn();
                                $('.commonError').text(res.data.error);
                                return false;
                            }
                            if(res.error){
                                $('#paymentModel').modal("hide");
                                //$('#failMsg').modal("show");
                                alert('fail');
                            }else{
                               $('#paymentModel').modal("hide");
                               alert('done')
                            }
                        }
                    });

                }
            });
    </script>
@endsection
