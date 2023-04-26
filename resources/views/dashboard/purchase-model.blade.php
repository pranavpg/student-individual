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
            <button class="subscribe btn btn-primary btn-block submitdata" style="margin-bottom: 12px;"> Confirm </button>
            <span class="commonError" style="color:red;display: none;font-size:12px;"> </span>
       </div>
    </div>
   </div>