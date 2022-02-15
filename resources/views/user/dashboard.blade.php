@extends('user.layouts.app')

@section('content')
<style type="text/css">
  .modal-dialog {
    max-width: 1200px !important;
  }
         
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- /.card -->
            <div class="row">
              <div class="col-md-12">
                <!-- DIRECT CHAT -->
                <div class="card card-primary">
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
                  <div class="card-header ">
                    <h3 class="card-title">User Unique Identification numbers (UID)</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                      <div class="input-group">
                        <input type="text" name="uid" id="uid_no" value="{{ isset($id) ? $id : '' }}" placeholder="Enter Attendee's UID No...." class="form-control">
                        <span class="input-group-append">
                          <button type="button" id="search_uid" class="btn btn-warning">Search</button>
                        </span>
                      </div>
                      <span id="error_message" >
                  </span>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!--/.direct-chat -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Bookings</span>
                <span class="info-box-number">{{$bookings}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Events</span>
                <span class="info-box-number">{{$events}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
       <!-- DETAIL MODAL -->
    <!--  MODAL -->
   <div class="modal fade" id="userDetailsModel" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Attendee Booking Detail's | uid no : <span id="user_uid"></span> | Event : <span id="events" ></span> </h3>
              </div>
              <div class="container">
              <!-- /.card-header -->
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home"><button class="btn btn-primary active"> Entry</button> </a></li>
                <li><a data-toggle="tab" href="#dinner"><button class="btn btn-primary active">Dinner</button></a></li>
              </ul>

              <div class="tab-content">
              <div id="home" class="tab-pane fade in active show">
                <!-- form start -->
              <form method="POST" action="{{route('user.update.details')}}" id="entry_form">
                @csrf
                <input type="hidden" name="type" value="entry">
                <input type="hidden" name="uid" class="attendee_uid" >
                <table id="new_data" class="table table-bordered">
                    
                    </table>
                    
                  <!--<div class="row">-->
                  <!-- <div class="col-md-4">-->
                  <!--  <div class="form-group">-->
                  <!--   <label for="exampleInputEmail1">Event : <span class="event_details"></span></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-md-4">-->
                  <!--  <div class="form-group">-->
                  <!--   <label for="exampleInputEmail1">Participate in Lucky DIP : <span class="lucky_dip"></span></label>-->
                  <!--  </div>-->
                  <!-- </div>-->
                  <!-- <div class="col-md-4">-->
                  <!--  <div class="form-group">-->
                  <!--   <label for="exampleInputEmail1">Amount Paid : INR <span class="amount_paid"></span></label>-->
                  <!--  </div>-->
                  <!--  </div> -->
                  <!--</div>-->
                  <!--<div class="row">-->
                  <!--   <div class="col-md-1">-->
                  <!--    <input type="checkbox" class="form-control main_attendee_checkbox" name="main_attendee[]">-->
                  <!--  </div>-->
                  <!-- <div class="col-md-2">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_name" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div> -->
                  <!--  <div class="col-md-1">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_type" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-md-2">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_membership_no" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-md-3">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_email" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-md-2">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_phone" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-md-1">-->
                  <!--  <div class="form-group">-->
                  <!--   <label class="main_attendee_amount" for="exampleInputEmail1"></label>-->
                  <!--  </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                  <!--<div id="sub_attendees_div" >-->
                  <!--</div>-->
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit Entry Details</button>
                </div>
              </form>
              </div>
              <div id="dinner" class="tab-pane fade">
                <form method="POST" action="{{route('user.update.details')}}" id="dinner_form">
                @csrf
                <input type="hidden" name="type" value="dinner">
                <input type="hidden" name="uid" class="attendee_uid" >
                
                <table id="dinner_new_data" class="table table-bordered">
                    
                    </table>
                <div class="card-body">
                  
                   <div id="sub_attendees_dinner_div">
                   </div>
                </div>
                <!-- /.card-body -->
                
                
                
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit Dinner Details</button>
                </div>
              </form>
              </div>
            </div>
              
            </div>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">

$("document").ready(function(){

$("#search_uid").trigger("click");
});

 $(document).on('click', '.sub_attendee_checkbox', function(){
    var id = $(this).data('id');

    if(this.checked){
      $('#sub_attendee_'+id).val(id);
    }else{
      $('#sub_attendee_'+id).val('');
    }
 });

 $(document).on('click', '.sub_dinner_attendee_checkbox', function(){
    var id = $(this).data('id');

    if(this.checked){
      $('#sub_dinner_attendee_'+id).val(id);
    }else{
      $('#sub_dinner_attendee_'+id).val('');
    }

 });


 


    $(document).on('click', '#search_uid', function(){
    var uid = $('#uid_no').val();
    $("#new_data").html('');
    $("#dinner_new_data").html('');
    $('.main_attendee_checkbox').prop('checked',false);
    $('.main_attendee_dinner_checkbox').prop('checked',false);

    var formData = new FormData();
       formData.append( 'uid',uid);
       formData.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : "{{ route('user.detail') }}",
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                            $('#userDetailsModel').modal('show'); 
                            $('#events').text(response.data.event.title);
                            $('.main_attendee_name').text(response.data.member_name);
                            $('.main_attendee_type').text(response.data.mainattendee.title);
                            $('.main_attendee_membership_no').text(response.data.membership_no);
                            $('.main_attendee_email').text(response.data.email);
                            $('.main_attendee_phone').text(response.data.phone_no);
                            $('.main_attendee_amount').text('INR '+response.data.mainattendee.amount);

                            // if(response.data.entry_status == '1'){
                            //  $('.main_attendee_checkbox').prop('checked',true);
                            // }
                            if(response.data.dinner_status == '1'){
                             $('.main_attendee_dinner_checkbox').prop('checked',true);
                            }

                            // if (response.data.participate_in_lucky_dip == 'on') {
                            //   $( ".lucky_dip" ).text('Yes');
                            // } 
                            // else
                            // {
                            //   $( ".lucky_dip" ).text('No');
                            // }
                            $('#user_uid').text(uid);
                            $('.attendee_uid').val(uid);
                            
                            var html = '<tr> <th>  Mark <th> Attendee Name  </th><th>  Type</th><th>Membership no. </th><th>Email</th><th>Phone </th> </tr> <tr> <td><input type="checkbox" '+(response.data.entry_status == '1' ? 'checked ' : '') +' class="form-control main_attendee_checkbox" name="main_attendee[]"></td> <td class="main_attendee_name">'+response.data.member_name+'</td> <td class="main_attendee_type">'+response.data.mainattendee.title+'</td> <td class="main_attendee_membership_no">'+response.data.membership_no+'</td> <td class="main_attendee_email">'+response.data.email+' </td> <td class="main_attendee_phone">'+response.data.phone_no+'</td></tr>';
                            
                            var dinner_html = '<tr> <th>  Mark <th> Attendee Name  </th><th>  Type</th><th>Membership no. </th><th>Email</th><th>Phone </th> </tr> <tr> <td><input type="checkbox" '+(response.data.dinner_status == '1' ? 'checked ' : '') +' class="form-control main_attendee_dinner_checkbox" name="main_attendee[]"></td> <td class="main_attendee_name">'+response.data.member_name+'</td> <td class="main_attendee_type">'+response.data.mainattendee.title+'</td> <td class="main_attendee_membership_no">'+response.data.membership_no+'</td> <td class="main_attendee_email">'+response.data.email+' </td> <td class="main_attendee_phone">'+response.data.phone_no+'</td></tr>';

                         $.each(response.data.subattendeesdetails, function(index, value) {
                               
                           

                            html = html+'<tr><input type="hidden" id="sub_attendee_'+value.id+'" value="'+(value.entry_status == '1' ? value.id : '') +'" name="sub_attendee_id[]"><td><input type="checkbox" class="form-control sub_attendee_checkbox" '+(value.entry_status == '1' ? 'checked="checked" ': '') +' data-id="'+value.id+'" name="enter_subattendee[]"></td> <td id="sub_attendee_name">'+value.name+'</td><td id="sub_attendee_type">'+value.subattendee.title+'</td> <td></td> <td></td><td></td></tr>';
                            
                             dinner_html = dinner_html+'<tr><input type="hidden" id="sub_dinner_attendee_'+value.id+'" value="'+(value.dinner_status == '1' ? value.id : '') +'" name="sub_attendee_id[]"><td><input type="checkbox" class="form-control sub_dinner_attendee_checkbox" '+(value.dinner_status == '1' ? 'checked="checked" ': '') +' data-id="'+value.id+'" name="enter_subattendee[]"></td> <td id="sub_attendee_name">'+value.name+'</td><td id="sub_attendee_type">'+value.subattendee.title+'</td> <td></td> <td></td><td></td></tr>';

                        });
                        
                         $("#new_data").html(html);
                         $("#dinner_new_data").html(dinner_html)

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
      
   } ) ;

 $(document).on('submit', 'form#entry_form', function(){
    var formData = new FormData(this);
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : this.attr('action'),
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                            $('#userDetailsModel').modal('show'); 
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
      
   } ) ;



  </script>


  @endsection