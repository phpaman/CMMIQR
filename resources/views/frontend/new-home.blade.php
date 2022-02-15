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
              <table class="table table-bordered" style="background: #2c4a6b;">
                    <tr>
                        <td>
                          <select id="attendee_events" style="background-color: #f9f2f2;">
				              @foreach($events as $event)
				             <option value="{{$event->id}}">{{$event->title}},{{$event->venue}},{{$event->date}},{{$event->start_time}}</option>
				             @endforeach
				        </select>  
                        </td>
                        <td style="color: #ffff;">
                            Instructions :
                        </td>
                        <td id="event_instructions" style="color: #ffff;">{{$events[0]['instructions']}}
                        </td>
                    </tr>
                </table>
                
                <div class="custom-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                          	<form method="POST" action="{{ route('frontend.save.booking') }}" >
                             @csrf
                             <input type="hidden" name="events" value="{{$events[0]['id']}}" id="hidden_event_id" >
                          	@foreach($categories as $key => $category)
                              @if($category->title == 'Sponsor')
                              
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                            <a href="{{route('view.sponsor.booking')}}"><button type="button" class="btn btn-success"><i class="fas fa-donate"></i> Click here to Sponsor event  </button></a>
                                        </div>
                                      </div>
                                    </div>
                              @else
                               <div class="panel panel-default member-block  {{$key != '0' ? 'inner-member-block' : ''}}">
                              <div class="panel-heading" role="tab" id="heading{{$key}}">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                  <h3>{{$category->title}} <i class="fas fa-chevron-down"></i></h3>
                                </a>
                              </h4>
                              
                              </div>
                              <div id="collapse{{$key}}" class="panel-collapse collapse in {{$key == '0' ? 'show' : ''}}" role="tabpanel" aria-labelledby="heading{{$key}}">
                                <div class="panel-body">
                                    @if($category->title == 'Member (CMMI or IME)')
                                 <div class="row">
                                     <div class="col-sm-12 col-md-6">
                                        <div class="inner-form">
                                          <select name="member_type" style="background-color: #f9f2f2;">
                                              <option value="cmmi">CMMI</option>
                                              <option value="imei">IMEI</option>
                                             </select>
                                         </div>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" name="cat_amount[]" id="cat_amount_{{$category->id}}" value="0" >
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                         <div class="outer-text">1. <input class="title_checkbox" id="title_check_{{$category->id}}" data-id="{{$category->id}}" type="checkbox"></div> {{$category->title}} 
                                         @if($category->title == 'Member (CMMI or IME)')
                                           <input class="input_{{$category->id}}" type="text" name="membership_no[]" readonly="readonly" placeholder="Enter Member ship no.">
                                          @endif
                                        </div>
                                      </div>
                                      <input type="hidden" name="attendee_id[]" value="{{$category->id}}" >
                                      <div class="col-sm-12 col-md-3">
                                        <input class="input_{{$category->id}}" type="text" name="attendee_name[]" readonly="readonly" placeholder="Enter {{$category->title}} Full Name">
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                        <input class="input_{{$category->id}}" type="text" name="attendee_email[]" readonly="readonly" placeholder="Enter {{$category->title}} Email">
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                         <div class="inner-form">
                                        <input class="input_{{$category->id}}" type="text" name="attendee_phone_no[]" readonly="readonly" placeholder="Enter Phone no">
                                        <label>₹<span id="amount_{{$category->id}}">{{$category->amount}}</span></label>
                                      </div>
                                      </div>
                                    </div>
                                    
                                    @foreach($category->subattendees as $sub)
                                    <input type="hidden" name="sub_attendee_id_{{$key}}[]" value="{{$sub->id}}">
                                    <div class="row">
                                      <div class="col-sm-12 col-md-3">
                                        <div class="inner-form">
                                          <input class="sub_attendee_checkbox" data-id="{{$sub->id}}" data-category="{{$category->id}}" type="checkbox">{{$sub->title}} 
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                        <input class="sub_attendee_input_{{$sub->id}}" type="text"  readonly="readonly" name="sub_attendee_{{$key}}[]" placeholder="Enter {{$sub->title}} Name">
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                          <div class="inner-form">
                                      <a href="#" id="add_more_button_{{$sub->id}}" style="display:none;" class="btn site-btn add_more_sub_attendees" data-id="{{$sub->id}}" data-category_id="{{$category->id}}" data-key="{{$key}}" data-amount="{{$sub->amount}}" data-title="{{$sub->title}}" ><i class="fas fa-plus" ></i> Add More</a>
                                      </div>
                                      </div>
                                      <div class="col-sm-12 col-md-3">
                                         <div class="inner-form last-wrap">
                                        <label>₹<span id="sub_attendee_amount_{{$sub->id}}">{{$sub->amount}}</span></label>
                                      </div>
                                      </div>
                                    </div>
                                    <div class="new_row_{{$sub->id}}"></div>
                                    @endforeach
                                    <div class="row">
                                      <div class="col-sm-9">
                                        <div class="inner-form cart-form">
                                          <input  name="lucky_dip[]" type="checkbox"> I Wish To Participate In Lucky Dip.
                                        </div>
                                      </div>
                                      <div class="col-sm-3">
                                          
                                      </div>
                                    </div>
                                </div>
                              </div>
                               <input type="hidden" class="key" value="{{$key}}" name="key" >
                              @endif
                               <div id="appended_category_{{$category->id}}" ></div>
                              <div class="row">
                              <div class="col-sm-9">
                                  <button type="button" class="btn btn-primary add_more_category" id="add_more_category_{{$category->id}}" data-id="{{$category->id}}"  data-title="{{$category->title}}" data-amount="{{$category->amount}}" style="display:none;"  ><i class="fas fa-plus"></i>Add More {{$category->title}}</button>
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
    </section>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('public/js/jquery-3.3.1-min.js')}}"></script>
    <script src="{{ asset('public/js/bootstrap.bundle.min.js')}}"></script>
    <!--Custom JS-->
    <script type="text/javascript" src="{{ asset('public/js/custom.js')}}"></script>
    <script type="text/javascript">
     $(document).on('click', '.sub_attendee_checkbox', function(){
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
    
    
    var cat_amount = $('#cat_amount_'+category_id).val();
    var cat_total_amount = parseInt(cat_amount) + parseInt(sub_amount); 
   $('#cat_amount_'+category_id).val(cat_total_amount);


    }else{
   $('.sub_attendee_input_'+id).prop('readonly',true);
   $('.sub_attendee_input_'+id).prop('required',false);
   
   $('#add_more_button_'+id).hide();
    var sub_amount = $('#sub_attendee_amount_'+id).text();
   var total_amount = $('#total_amount').val();
   var total = parseInt(total_amount) - parseInt(sub_amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
    
     var cat_amount = $('#cat_amount_'+category_id).val();
    var cat_total_amount = parseInt(cat_amount) + parseInt(sub_amount); 
   $('#cat_amount_'+category_id).val(cat_total_amount);

    }
 });
    
    $(document).on('click', '.title_checkbox', function(){
 	 
   var id = $(this).data('id');

    if(this.checked){
   $('.input_'+id).prop('readonly',false);
   $('.input_'+id).prop('required',true);

    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();

    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
    
    $('#add_more_category_'+id).show();
    
    var category_amount = $('#cat_amount_'+id).val();
    var cat_total = parseInt(category_amount) + parseInt(amount); 
    $('#cat_amount_'+id).val(cat_total);
    
    

    }else{
   $('.input_'+id).prop('readonly',true);
   $('.input_'+id).prop('required',false);
    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) - parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
     $('#add_more_category_'+id).hide();
     $('#appended_category_'+id).html('');
     
     
     var category_amount = $('#cat_amount_'+id).val();
    var cat_total = parseInt(category_amount) - parseInt(amount); 
    $('#cat_amount_'+id).val(cat_total);


    }

 });
    
    $(document).on('click', '.remove_category_div', function(){
        
        var id = $(this).data('id');
        
        $('#append_div_'+id).remove();
        
        
    });
    
   
    
     $(document).on('click', '.removeButton', function(){
         var id = $(this).data('id');
         var amount = $(this).data('amount');
         var category_id = $(this).data('category_id');
       $('#new_row_id'+id).remove();
       
        var total_amount = $('#total_amount').val();
    
        var total = parseInt(total_amount) - parseInt(amount); 
    
        $('#total_amount').val(total);
        $('#show_total_amount').text(total);
        
         var category_amount = $('#cat_amount_'+category_id).val();
         var cat_total = parseInt(category_amount) - parseInt(amount); 
          $('#cat_amount_'+category_id).val(cat_total);
        
        
       
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
        
        var category_amount = $('#cat_amount_'+category_id).val();
        var cat_total = parseInt(category_amount) + parseInt(amount); 
        $('#cat_amount_'+category_id).val(cat_total);
        
        
        var html = '<div id="new_row_id'+uniq+'" class="row"><input type="hidden" name="sub_attendee_id_'+key+'[]" value="'+id+'"> <div class="col-sm-12 col-md-3"><div class="inner-form"> <input class="sub_attendee_checkbox" data-id="'+id+'" data-category="'+category_id+'" checked disabled="disabled" type="checkbox">'+title+'</div> </div><div class="col-sm-12 col-md-3"><input class="sub_attendee_input_'+id+'" type="text" name="sub_attendee_'+key+'[]" placeholder="Enter '+title+' Name"> </div> <div class="col-sm-12 col-md-3"> <a href="#" data-id="'+uniq+'" data-category_id="'+category_id+'" data-amount="'+amount+'" class="btn btn-danger removeButton"><i class="fas fa-minus" ></i> Remove</a></div> <div class="col-sm-12 col-md-3"> <div class="inner-form last-wrap"> <label>₹<span id="sub_attendee_amount_'+id+'">'+amount+'</span></label> </div> </div></div>';
        
        $('.new_row_'+id).append(html);
        
        
    });
    
    
    
     $('.add_more_sponser_sub_attend').on("click", function(){
        var id = $(this).data('id');
        var title = $(this).data('title');
        var uniq = Date.now();
        
        var coupons = $('#sponsor_coupon_'+id).text();
        
        if(coupons != '0'){
        var html = '<div id="new_sponser_row_id'+uniq+'" class="row"> <div class="col-sm-12 col-md-3"><input class="sub_attendee_input_'+id+'" type="text" name="sponsor_sub_attendee[]" placeholder="Enter '+title+'s Sub Attendee Name"> </div><div class="col-sm-12 col-md-3"><button class="btn btn-danger remove_sponsor_button" data-sponsor="'+id+'" type="button" data-id="'+uniq+'"  ><i class="fas fa-minus"></i> Remove</button> </div></div>';
        
        $('.new_sponsor_row_'+id).append(html);
        
        var new_coupon = parseFloat(coupons) - 1;
        $('#sponsor_coupon_'+id).text(new_coupon);
        
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
   $('.sponsor_input_'+id).prop('required',false);
    var amount = $('#sponsor_amount_'+id).text();

    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) - parseInt(amount); 

    $('#total_amount').val(total);
    $('#show_total_amount').text(total);
    $('#add_more_sponsor_attendee_'+id).hide();


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
   
   
   $('.add_more_category').on('click', function() {
       
         var title = $(this).data('title');
         var id = $(this).data('id');
         var amount = $(this).data('amount');
         var key = $('.key').val();
        
        var formData = new FormData();
         formData.append('id', id);
         formData.append('_token', "{{ csrf_token() }}");
         $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : '{!! route('member.get.sub_attendees') !!}',
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        
                      if(response.success == true)
                        {
                            var sub_attendee_html = '';
                             var uniq = Date.now();
                            
                            var new_key = parseInt(key) + 1; 
                            
                            $('.key').val(new_key);
                            
                             $.each( response.data, function( i, sub ) {
 
                            sub_attendee_html +=  '<input type="hidden" name="sub_attendee_id_'+new_key+'[]" value="'+sub.id+'"> <div class="row"><div class="col-sm-12 col-md-3"> <div class="inner-form"> <input class="sub_attendee_checkbox" data-id="'+sub.id+id+'" data-category="'+uniq+'" type="checkbox">{{$sub->title}} </div></div> <div class="col-sm-12 col-md-3"> <input class="sub_attendee_input_'+sub.id+id+'" type="text"  readonly="readonly" name="sub_attendee_'+new_key+'[]" placeholder="Enter '+sub.title+' Name"></div> <div class="col-sm-12 col-md-3"><div class="inner-form"> <a style="display:none;" href="#" id="add_more_button_'+sub.id+'"  class="btn site-btn add_more_sub_attendees" data-id="'+sub.id+id+'" data-category_id="'+uniq+'" data-key="'+i+'" data-amount="'+sub.amount+'" data-title="'+sub.title+'" ><i class="fas fa-plus" ></i> Add More</a></div></div><div class="col-sm-12 col-md-3"><div class="inner-form last-wrap"><label>₹<span id="sub_attendee_amount_'+sub.id+id+'">'+sub.amount+'</span></label></div></div></div><div class="new_row_'+sub.id+id+'"></div>';   
                         
                        });
                        
                       
                        
                        var html = '<input type="hidden" name="cat_amount[]" id="cat_amount_'+uniq+'" value="0" ><div id="append_div_'+uniq+'"  class="panel-collapse collapse in show" role="tabpanel" ><div class="panel-body"><div class="row"><div class="col-sm-12 col-md-2"><button type="button"  class="btn btn-danger remove_category_div" data-id="'+uniq+'" >Remove</button></div></div> <div class="row"><div class="col-sm-12 col-md-3"><div class="inner-form"><div class="outer-text"> <input class="title_checkbox" id="title_check_'+uniq+'" data-id="'+uniq+'" type="checkbox"></div>'+ title +' '+ 
                        (title == 'Member (CMMI or IME)' ? '<input class="input_'+uniq+'" type="text" name="membership_no[]" readonly="readonly" placeholder="Enter Member ship no.">': '') +' </div> </div>  <input type="hidden" name="attendee_id[]" value="'+id+'" ><div class="col-sm-12 col-md-3"> <input class="input_'+uniq+'" type="text" name="attendee_name[]" readonly="readonly" placeholder="Enter '+ title +' Full Name">  </div> <div class="col-sm-12 col-md-3"> <input class="input_'+uniq+'" type="text" name="attendee_email[]" readonly="readonly" placeholder="Enter '+ title +' Email"> </div> <div class="col-sm-12 col-md-3">  <div class="inner-form"><input class="input_'+uniq+'" type="text" name="attendee_phone_no[]" readonly="readonly" placeholder="Enter Phone no"><label>₹<span id="amount_'+uniq+'">'+amount+'</span></label> </div></div></div>'+sub_attendee_html+' <div class="row"><div class="col-sm-9"><div class="inner-form cart-form"><input name="lucky_dip[]" type="checkbox"> I Wish To Participate In Lucky Dip. </div> </div></div> </div> </div>';
                        
                        $('#appended_category_'+id).append(html);
                        
                        document.getElementById('add_more_category_'+id).scrollIntoView();
                            
                        }
                
                    },
                    error : function(data){
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function(index, value) {

                            $("#"+index+"_error").text(value);

                        });
                    }

                });
   });
});




  </script>
</body>
</html>