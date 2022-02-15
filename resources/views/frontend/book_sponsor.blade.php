<!DOCTYPE html>
<html>
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap, style , Responsive CSS Files  -->
<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css')}}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('public/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/responsive.css')}}">
<!-- Font Awesome 5 KIT Script -->
<script src="https://kit.fontawesome.com/a282321041.js" crossorigin="anonymous"></script>
<title>CMMI QR | Booking</title>
<style>
ul.breadcrumb {
  padding: 10px 16px;
  list-style: none;
  background-color: #eee;
}
ul.breadcrumb li {
  display: inline;
  font-size: 18px;
}
ul.breadcrumb li+li:before {
  padding: 8px;
  color: black;
  content: "/\00a0";
}
ul.breadcrumb li a {
  color: #0275d8;
  text-decoration: none;
}
ul.breadcrumb li a:hover {
  color: #01447e;
  text-decoration: underline;
}
</style>
</head>
<body>
    <section class="page-section">
            <!-- Navigation-->
            <div class="payment-page">
            	@include('frontend.layouts.navbar')
              <div class="container-fluid">
              	@if(session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
              @endif
              @if(session()->has('error'))
                  <div class="alert alert-danger">
                      {{ session()->get('error') }}
                  </div>
              @endif
              <!--EVENT SECTION-->
              <table class="table table-bordered" style="background: #2c4a6b;">
                    <tr>
                        <td>
                            
                          <select name="event_id" id="attendee_events" style="background-color: #f9f2f2;">>
				              @foreach($events as $event)
				             <option value="{{$event->id}}">{{$event->title}},{{$event->venue}},{{$event->date}},{{$event->start_time}}</option>
				             @endforeach
				        </select>  
                        </td>
                        <td style="color: #ffff;">
                            Instructions :
                        </td>
                        <td id="event_instructions" style="color: #ffff;">{{$events[0]['instructions']}}</td>
                    </tr>
                    </table>
                    <!--END EVENT SECTION-->
                    <!--BREADCRUMB-->
                    <ul class="breadcrumb">
                      <li><a href="{{route('index2')}}">Home</a></li>
                      <li>Booking as Event Sponsor</li>
                    </ul>
                    <!--END BREADCRUMB-->
                    <!--START BODY-->
                    <div class="custom-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                       <div class="modal-body">
                         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                             <div class="panel panel-default member-block  ">
                              <div class="panel-heading" role="tab" id="heading">
                                <h4 class="panel-title">
                                <a role="button" >
                                  <h3>Type of Sponsor's </h3>
                                </a>
                              </h4>
                              </div>
                               <div id="collapse" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="heading">
                                   <form method="POST" class="sponsor_form" action="{{route('frontend.sponsor.booking')}}">
                                        @csrf
                                        <input type="hidden" name="events" value="{{$events[0]['id']}}" id="hidden_event_id" >
                                <div class="panel-body">
                                  @foreach($sponsers as $s => $sponser)
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                         <div class="outer-text"> <input class="sponsor_title_checkbox" id="sponsor_title_check_{{$sponser->id}}" data-id="{{$sponser->id}}" type="checkbox"></div> {{$sponser->type_of_sponser}} 
                                        </div>
                                      </div>
                                      <input type="hidden" name="sponsor_type" value="{{$sponser->id}}" >
                                      <div class="col-sm-12 col-md-3">
                                        <input class="sponsor_input_{{$sponser->id}}" type="text" name="sponsor_name[]" readonly="readonly" placeholder="Enter {{$sponser->type_of_sponser}} Full Name">
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                        <input class="sponsor_input_{{$sponser->id}}" type="text" name="sponsor_email[]" readonly="readonly" placeholder="Enter {{$sponser->type_of_sponser}} Email">
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                         <div class="inner-form">
                                        <input class="sponsor_input_{{$sponser->id}}" type="text" name="sponsor_phone_no[]" readonly="readonly" placeholder="Enter Phone no">
                                        <label>₹<span id="sponsor_amount_{{$sponser->id}}">{{$sponser->amount}}</span></label>
                                      </div>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                         <div class="outer-text"></div>  	Souvier Ads Coloured : {{$sponser->souvier_ads_coloured}} 
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-2">
                                        Digital Banner : {{$sponser->digital_banner}}
                                      </div>
                                      <div class="col-sm-12 col-md-1">
                                        Coupons : {{$sponser->coupons}} 
                                      </div>
                                      <div class="col-sm-12 col-md-6">
                                         <div class="inner-form">
                                        Remarks : {{$sponser->remarks}} 
                                      </div>
                                      </div>
                                    </div>
                                    <div class="new_sponsor_row_{{$sponser->id}}" >
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                         <button id="add_more_sponsor_attendee_{{$sponser->id}}" type="button" style="display:none;" class="btn site-btn add_more_sponser_sub_attend" data-id="{{$sponser->id}}" data-title="{{$sponser->type_of_sponser}}" ><i class="fas fa-plus" ></i>Add More Attendees : upto <span id="sponsor_coupon_{{$sponser->id}}" >{{$sponser->coupons}}</span></button>
                                        </div>
                                      </div>
                                      </div>
                                    @endforeach
                                </div>
                                <div class="text-left">
                                <div class="check-wrap">
                                    <div class="inner-form">
                                        <input type="checkbox" required="required"> By checking this, you agree our <a href="#"> Terms & Conditions</a>
                                    </div>
                                </div>
                                <div class="payment-wrap">
                                	<input type="hidden" id="total_amount" name="total_amount" value="00.00">
                                  <h4>Total: ₹<span id="show_total_amount" >00.00</span></h4>
                                  <button type="submit" class="btn site-btn">Pay Now</button>
                                </div>
                                </div>
                                </form>
                              
                              </div>
                              
                              </div>
                              
                              </div>
                              </div>
                              </div>
                              </div>
                              </div>
                                </div>
              </div>
    </section>
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('public/js/jquery-3.3.1-min.js')}}"></script>
    <script src="{{ asset('public/js/bootstrap.bundle.min.js')}}"></script>
    <!--Custom JS-->
    <script type="text/javascript" src="{{ asset('public/js/custom.js')}}"></script>
    <script type="text/javascript">
     $(document).on('click', '.removeButton', function(){
         var id = $(this).data('id');
         var amount = $(this).data('amount');
       $('#new_row_id'+id).remove();
       
        var total_amount = $('#total_amount').val();
    
        var total = parseInt(total_amount) - parseInt(amount); 
    
        $('#total_amount').val(total);
        $('#show_total_amount').text(total);
       
     });
     
     
     $(document).on('click', '.remove_sponsor_button', function(){
        var id = $(this).data('id');
        var sponsor_id = $(this).data('sponsor');
        
        
        $('#new_sponser_row_id'+id).remove();
        
        var coupons = $('#sponsor_coupon_'+sponsor_id).text();
        
        var new_coupon = parseFloat(coupons) + 1;
        
        $('#sponsor_coupon_'+sponsor_id).text(new_coupon); 
         
     });
     
     
     
     
  	$(document).ready(function(){
  	    
    
    $('.card-header').on("click", function(){
        var id = $(this).attr('data-target');
        if($(id).hasClass('show')){
            $(this).find('.icons').removeClass('fa-arrow-alt-circle-down').addClass('fa-arrow-alt-circle-up');
            console.log($(this).find('.icons').attr('class'));
        }else{
            $(this).find('.icons').removeClass('fa-arrow-alt-circle-up').addClass('fa-arrow-alt-circle-down');
            console.log($(this).find('.icons').attr('class'));
        }
    });
    
    $('.add_more_sub_attendees').on("click", function(){
        var id = $(this).data('id');
        var amount = $(this).data('amount');
        var title = $(this).data('title');
        var category_id = $(this).data('category_id');
        var key = $(this).data('key');
        var uniq = Date.now();
        

        var total_amount = $('#total_amount').val();
    
        var total = parseInt(total_amount) + parseInt(amount); 
    
        $('#total_amount').val(total);
        $('#show_total_amount').text(total);
        
        var html = '<div id="new_row_id'+uniq+'" class="row"><input type="hidden" name="sub_attendee_id_'+key+'[]" value="'+id+'"> <div class="col-sm-12 col-md-3"><div class="inner-form"> <input class="sub_attendee_checkbox" data-id="'+id+'" data-category="'+category_id+'" checked disabled="disabled" type="checkbox">'+title+'</div> </div><div class="col-sm-12 col-md-3"><input class="sub_attendee_input_'+id+'" type="text" name="sub_attendee_'+key+'[]" placeholder="Enter '+title+' Name"> </div> <div class="col-sm-12 col-md-3"> <a href="#" data-id="'+uniq+'" data-amount="'+amount+'" class="btn btn-danger removeButton"><i class="fas fa-minus" ></i> Remove</a></div> <div class="col-sm-12 col-md-3"> <div class="inner-form last-wrap"> <label>₹<span id="sub_attendee_amount_'+id+'">'+amount+'</span></label> </div> </div></div>';
        
        $('.new_row_'+id).append(html);
        
        
    });
    
    
    
     $('.add_more_sponser_sub_attend').on("click", function(){
        var id = $(this).data('id');
        var title = $(this).data('title');
        var uniq = Date.now();
        
        var coupons = $('#sponsor_coupon_'+id).text();
        
        if(coupons != '0'){
        var html = '<div id="new_sponser_row_id'+uniq+'" class="row"> <div class="col-sm-12 col-md-3"><input class="sub_attendee_input_'+id+'" type="text" name="sponsub_attendee[]" placeholder="Enter '+title+'s Sub Attendee Name"> </div><div class="col-sm-12 col-md-3"><button class="btn btn-danger remove_sponsor_button" data-sponsor="'+id+'" type="button" data-id="'+uniq+'"  ><i class="fas fa-minus"></i> Remove</button> </div></div>';
        
        $('.new_sponsor_row_'+id).append(html);
        
        var new_coupon = parseFloat(coupons) - 1;
        $('#sponsor_coupon_'+id).text(new_coupon);
        
        }
        
    });
 
 $('.title_checkbox').on("click", function(){
 	 
   var id = $(this).data('id');

    if(this.checked){
   $('.input_'+id).prop('readonly',false);
   $('.input_'+id).prop('required',true);

    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();

    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);

    }else{
   $('.input_'+id).prop('readonly',true);
   $('.input_'+id).prop('required',false);
    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) - parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);


    }

 });
 
  $('.sponsor_title_checkbox').on("click", function(){
 	 
   var id = $(this).data('id');

    if(this.checked){
   $('.sponsor_input_'+id).prop('readonly',false);
   $('.sponsor_input_'+id).prop('required',true);

    var amount = $('#sponsor_amount_'+id).text();

   
    var total_amount = $('#total_amount').val();

    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
    
    $('#add_more_sponsor_attendee_'+id).show();

    }else{
   $('.sponsor_input_'+id).prop('readonly',true);
   $('.sponsor_input_'+id).val('');
   $('.sponsor_input_'+id).text('');
   $('.sponsor_input_'+id).prop('required',false);
    var amount = $('#sponsor_amount_'+id).text();

    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) - parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
    $('#add_more_sponsor_attendee_'+id).hide();


    }

 });
 
 
 
 

 $('.sub_attendee_checkbox').on("click", function(){
  var id = $(this).data('id');
  var category_id = $(this).data('category');
  if(this.checked){
   $('.sub_attendee_input_'+id).prop('readonly',false);
   $('.sub_attendee_input_'+id).prop('required',true);
   
   $('#add_more_button_'+id).show();

   if($('#title_check_'+category_id).prop('checked') == false){
    var amount = $('#amount_'+category_id).text();
    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);

   }

   $('#title_check_'+category_id).prop('checked',true);
   $('.input_'+category_id).prop('readonly',false);

   var sub_amount = $('#sub_attendee_amount_'+id).text();
   var total_amount = $('#total_amount').val();
   var total = parseInt(total_amount) + parseInt(sub_amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);


    }else{
   $('.sub_attendee_input_'+id).prop('readonly',true);
   $('.sub_attendee_input_'+id).prop('required',false);
   
   $('#add_more_button_'+id).hide();
    var sub_amount = $('#sub_attendee_amount_'+id).text();
   var total_amount = $('#total_amount').val();
   var total = parseInt(total_amount) - parseInt(sub_amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);

    }
 });
 
 
  $('#attendee_events').on('change', function() {
    var id = $(this).val();
    
    var formData = new FormData();
    formData.append('id', id);
    formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : '{!! route('event.get.instructions') !!}',
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                            $('#event_instructions').text('');
                            $('#event_instructions').text(response.data.instructions); 
                            $('#hidden_event_id').val(response.data.id);
                        }
                        else
                        {
                            $("#error_message").html(response.data);
                        }
                    },
                    error : function(data){
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function(index, value) {

                            $("#"+index+"_error").text(value);

                        });
                    }

                });
                return false;
   });
});



  </script>
</body>
</html>