@extends('frontend.layouts.app')
@section('content')  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
                      </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card">
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
              <!-- /.card-header -->
              <div class="card-body">
              	<div class="col-md-12">
                @foreach($categories as $key => $category)
               <div class="card card-primary">
               	<div class="card-header"  data-toggle="collapse" data-target="#demo{{$key}}">
               <h3 class="card-title">{{$category->title}}</h3>
               <button type="button" class="btn btn-success float-right"  ><i class="fas fa-plus"></i>Add More {{$category->title}}</button>
               <span class="icons float-right fas fa-arrow-alt-circle-up"></span>
              </div>
               	<div id="demo{{$key}}" class="card-body collapse {{$key == '0' ? 'show' : ''}}">
               	<form method="POST" action="{{ route('frontend.save.booking') }}" >
                  @csrf

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <select class="form-control" name="events[]">
                            @foreach($events as $event)
                            <option value="{{$event->id}}">{{$event->title}},{{$event->venue}},{{$event->date}},{{$event->start_time}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input"  name="lucky_dip[]" type="checkbox">
                          <label class="form-check-label">I Wish To Participate In Lucky Dip.</label>
                        </div>
                      </div>
                    </div>
                  </div>

               	<div class="row">
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input title_checkbox" id="title_check_{{$category->id}}" data-id="{{$category->id}}" type="checkbox">
                          <label class="form-check-label">{{$category->title}}</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                     @if($category->title == 'Member')
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input input_{{$category->id}}" type="text" name="membership_no[]" readonly="readonly" placeholder="Enter Member ship no.">
                        </div>
                      </div>
                      @endif
                    </div>
                    <input type="hidden" name="attendee_id[]" value="{{$category->id}}" >
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input input_{{$category->id}}" type="text" name="attendee_name[]" readonly="readonly" placeholder="Enter {{$category->title}} Full Name">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input input_{{$category->id}}" type="text" name="attendee_email[]" readonly="readonly" placeholder="Enter {{$category->title}} Email">
                        </div>
                      </div>
                    </div><div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input input_{{$category->id}}" type="text" name="attendee_phone_no[]" readonly="readonly" placeholder="Enter Phone no">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">Amount : INR <span id="amount_{{$category->id}}">{{$category->amount}}</span></label>
                        </div>
                      </div>
                    </div>
                  </div>	
                @foreach($category->subattendees as $sub)
                <input type="hidden" name="sub_attendee_id_{{$key}}[]" value="{{$sub->id}}">
                  <div class="row">
                    <div class="col-sm-4">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input sub_attendee_checkbox" data-id="{{$sub->id}}" data-category="{{$category->id}}" type="checkbox">
                          <label class="form-check-label">{{$sub->title}}</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input sub_attendee_input_{{$sub->id}}" type="text"  readonly="readonly" name="sub_attendee_{{$key}}[]" placeholder="Enter {{$sub->title}} Name">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">Amount : INR <span id="sub_attendee_amount_{{$sub->id}}">{{$sub->amount}}</span></label>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach  
               	</div>
               </div>
               @endforeach
               </div>
               <div class="row">
                    <div class="col-sm-4">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" required="required" type="checkbox">
                          <label class="form-check-label">Terms & conditions.</label>
                        </div>
                      </div>
                    </div>
                  </div>
               <div class="row">
                    <div class="col-sm-1">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">Total Amount : </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">INR <input type="text" id="total_amount" readonly="readonly" name="total_amount" value="00.00"></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <!-- checkbox -->
                      <div class="form-group">
                        <div class="form-check">
                          <button class="btn btn-success" type="submit" >Pay</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
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
 
 $('.title_checkbox').on("click", function(){
 	 
   var id = $(this).data('id');

    if(this.checked){
   $('.input_'+id).prop('readonly',false);
   $('.input_'+id).prop('required',true);

    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();

    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);

    }else{
   $('.input_'+id).prop('readonly',true);
   $('.input_'+id).prop('required',false);
    var amount = $('#amount_'+id).text();

    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) - parseInt(amount); 

    $('#total_amount').val(total);

    }

 });

 $('.sub_attendee_checkbox').on("click", function(){
  var id = $(this).data('id');
  var category_id = $(this).data('category');
  if(this.checked){
   $('.sub_attendee_input_'+id).prop('readonly',false);
   $('.sub_attendee_input_'+id).prop('required',true);

   if($('#title_check_'+category_id).prop('checked') == false){
    var amount = $('#amount_'+category_id).text();
    var total_amount = $('#total_amount').val();
    var total = parseInt(total_amount) + parseInt(amount); 

    $('#total_amount').val(total);
   }

   $('#title_check_'+category_id).prop('checked',true);
   $('.input_'+category_id).prop('readonly',false);

   var sub_amount = $('#sub_attendee_amount_'+id).text();
   var total_amount = $('#total_amount').val();
   var total = parseInt(total_amount) + parseInt(sub_amount); 

    $('#total_amount').val(total);

    }else{
   $('.sub_attendee_input_'+id).prop('readonly',true);
   $('.sub_attendee_input_'+id).prop('required',false);
    var sub_amount = $('#sub_attendee_amount_'+id).text();
   var total_amount = $('#total_amount').val();
   var total = parseInt(total_amount) - parseInt(sub_amount); 

    $('#total_amount').val(total);
    }
 });


 

});
  </script>
  @endsection
  

 

