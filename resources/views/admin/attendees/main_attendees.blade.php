@extends('admin.layouts.app')

@section('content')  

<style type="text/css">
  .modal-dialog {
    max-width: 1200px !important;
  }
  .count {
    width: 55px !important;
  }
         
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendees</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Main Attendees</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
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
              <div class="card-header">
                <h3 class="card-title">Main Attendees</h3>
                <a href="#" data-toggle="modal" data-target="#addMainAttendee"><button type="button" class="btn btn-primary float-sm-right"><i class="fas fa-plus"></i> Add More</button></a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr no.</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Add Booking</th>
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($attendees as $key => $attendee) 
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$attendee->title}}</td>
                    <td>@if($attendee->status == '1')
                      Active
                      @else
                      In-Active
                      @endif
                    </td>
                    <td> <a href="#" class="editCategoryinfo" data-id="{{$attendee->id}}" data-name="{{$attendee->title}}" data-visible="{{$attendee->visibility}}" data-amount="{{$attendee->amount}}" ><button type="button" class="btn btn-info " ><i class="fas fa-edit"></i>Edit info</button></a>
                    </td>
                    <td>
                      <a href="#" class="addBookings" data-id="{{$attendee->id}}" data-name="{{$attendee->title}}" data-visible="{{$attendee->visibility}}" data-amount="{{$attendee->amount}}" ><button type="button" class="btn btn-success " ><i class="fas fa-plus"></i> Add</button></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr no.</th>
                    <th>Title</th>
                    <th>Status</th>
                     <th>Edit</th>
                     <th>Add Booking</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   <!--  MODAL -->
   <div class="modal fade" id="addMainAttendee" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" style="max-width: 800px;" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Main Attendee</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.save.mainattendees')}}">
                @csrf
                <div class="card-body">
                  <div class="row" >
                    <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" required="required" name="title" id="exampleInputEmail1" placeholder="Enter Main Attendee Title">
                  </div>
                </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
        </div>
        </div>
    </div>
     <!-- EDIT INFO MODAL -->
   <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog"  >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><h3 class="card-title title_name"></h3> Add Category Information </h3>
              </div>
              <form method="POST" action="{{route('admin.save.category')}}">
                @csrf
                <input type="hidden" name="id" id="attendee_id">
                <div class="card-body">
                <div class="row" >
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="card-title title_name" for="exampleInputEmail1">Title</label>
                  </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" required="required" name="attendee_amount" id="attendee_amount" placeholder="Enter Amount">
                  </div>
                </div>
                </div>
                <div class="row" >
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="card-title" for="exampleInputEmail1">Is Visible on Frond-End?</label>
                  </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" class="form-control"  name="visibility" id="visibility" >
                  </div>
                </div>
                </div>
                 <div class="row" >
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Add Sub Attendee :-</label>
                  </div>
                </div>
                </div>
                <div class="row" id="intial_rows" >
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control" required="required" name="sub_attendee[]"  id="exampleInputEmail1" placeholder="Enter Sub Attendee Title (eg:Spouse/child)">
                  </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" required="required" name="amount[]" id="exampleInputEmail1" placeholder="Enter Amount">
                  </div>
                </div>
                </div>
                <div class="add_new_subattendee"></div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                  </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <button type="button" id="addMoreSubAttendee" class="btn btn-success"><i class="fas fa-plus"></i> Add More Sub Addendee</button>
                </div>
                </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
        </div>
        </div>
    </div>

    <!-- BOOKING MODAL -->
    <!--  MODAL -->
   <div class="modal fade" id="addNewBooling" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Booking</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.save.booking')}}">
                @csrf
                <input type="hidden" name="main_attendee_id" id="main_attendeebooking_id" value="">
                <div class="card-body">
                  <div class="row">
                   <div class="col-md-1">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Event :</label>
                    </div>
                    </div> 
                    <div class="col-md-5">
                    <div class="form-group">
                     <select class="form-control eventselectoptions" name="events_id" >
                      </select>
                    </div>
                    </div> 
                    <div class="col-md-1">
                      <input type="checkbox" checked  class="form-control" name="lucky_dip">
                    </div>
                    <div class="col-md-5">
                    <div class="form-group">
                      
                     <label for="exampleInputEmail1">Participate in Lucky DIP.</label>
                    </div>
                   </div>
                  </div>
                  <div id="bookingRow" >
                  </div>
                  <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Payment Method</label>
                     <select class="form-control" name="payment_method" >
                      <option>Select</option>
                       <option value="cash">Cash</option>
                       <option value="cheque">Cheque</option>
                       <option value="draft">Draft</option>
                       <option value="imps">IMPS</option>
                       <option value="neft">NEFT</option>
                       <option value="rtgs">RTGS</option>
                     </select>
                    </div>
                    </div> 
                    <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Amount Paid</label>
                     <input type="text" class="form-control" readonly="readonly" id="input_amount_paid" name="amount_paid" value="400" >
                    </div>
                   </div>
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">UID no.</label>
                     <input type="text" class="form-control" readonly="readonly" id="unique_uid" name="uid" >
                    </div>
                   </div>
                  </div>
                  <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Transaction Source (Bank Name)</label>
                     <input type="text" class="form-control" name="transaction_source" placeholder="optional">
                    </div>
                    </div> 
                    <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Transaction Number</label>
                     <input type="text" class="form-control" name="transactio_number" placeholder="optional" >
                    </div>
                   </div>
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Remark</label>
                     <input type="text" class="form-control"  name="remark" placeholder="optional" >
                    </div>
                   </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
        </div>
        </div>
    </div>
    <!-- Main content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    function uniqId() {
     return Math.round(new Date().getTime() + (Math.random() * 100));
   }

  $(document).on('click', '.remove_button', function(){
    var id = $(this).data('id');
      $('#'+id+'').remove();
   });

  $(document).on('click', '.checksubattendee', function(){
    var id = $(this).data('id');
    if(this.checked){
      $('#'+id+'').show();
      $('#input_id_'+id).prop('disabled', false);
      var paid_amount = $('#input_amount_paid').val();
      var sub_amount = $('#sub_attenee_amount_txt_'+id).text();

      var total = parseInt(paid_amount) + parseInt(sub_amount); 

      $('#input_amount_paid').val(total);

    }else{
       $('#'+id+'').hide();
       $('#subattendeeRow_'+id).html('');
       $('#input_id_'+id).prop('disabled', true);
       var paid_amount = $('#input_amount_paid').val();
      var sub_amount = $('#sub_attenee_amount_txt_'+id).text();

      var total = parseInt(paid_amount) - parseInt(sub_amount); 

      $('#input_amount_paid').val(total);
    }
    
   });

  $(document).on('click', '.subattandeeAddMore', function(){
    var id = $(this).data('id');
    var title = $(this).data('title');
    var amount = $(this).data('amount');
    
    var paid_amount = $('#input_amount_paid').val();

      var total = parseInt(paid_amount) + parseInt(amount); 

      $('#input_amount_paid').val(total);
    

    var uniq = uniqId();
    
    var html = '<div class="row" id="sub_row_'+uniq+'"><div class="col-md-1"><div class="form-group"> <input type="checkbox" checked  class="form-control" name="member_check" >  </div></div><div class="col-md-2"> <div class="form-group"> <label for="exampleInputEmail1">'+title+'</label>  </div></div> <div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" required="required" name="subattendee_name[]" id="exampleInputEmail1" placeholder="Enter Name"><input type="hidden" name="subattendee_id[]" value="'+id+'"></div></div><div class="col-md-2"><div class="form-group"> <label for="exampleInputEmail1">INR '+amount+'/head</label> </div> </div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger removesubRow" data-id="'+uniq+'" data-amount="'+amount+'" ><i class="fas fa-minus" ></i> Remove</button></div></div><div class="col-md-1"><div class="form-group"></div></div><div class="col-md-2"><div class="form-group"></div></div></div>';

    $('#subattendeeRow_'+id).append(html);
   });

$(document).on('click', '.removesubRow', function(){
    var id = $(this).data('id');
    var amount = $(this).data('amount');
    $('#sub_row_'+id).remove();

    var paid_amount = $('#input_amount_paid').val();

      var total = parseInt(paid_amount) - parseInt(amount); 

      $('#input_amount_paid').val(total);



  });

  
     
     

    $( ".editCategoryinfo" ).click(function() {

       var id = $(this).data('id');
       var title = $(this).data('name');
       var amount = $(this).data('amount');
       var visible = $(this).data('visible');

       if (visible == 'on') {
        $( "#visibility" ).prop( "checked", true );
      }else{
        $( "#visibility" ).prop( "checked", false );
      }
      
       $('.title_name').text(' ');
       $('.title_name').text(title+' :-');
       $('#attendee_id').val(id);
       $('#attendee_amount').val(amount);
       $(".add_new_subattendee").html('');

       var formData = new FormData();
       formData.append( 'id',id);
       formData.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : "{{ route('admin.edit.categorydetails') }}",
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                          if(response.data == ''){
                            $('#addCategory').modal('show'); 

                          }else{
                            $('#addCategory').modal('show'); 
                            $('#intial_rows').remove();
                            $.each( response.data, function( key, value ) {
                            var html = '<div class="row" id="'+key+'" ><div class="col-md-6"><div class="form-group"><input type="text" class="form-control sub_attendee_'+key+'" required="required" value="'+value.title+'" name="sub_attendee[]" id="exampleInputEmail1" placeholder="Enter Sub Attendee Title (eg:Spouse/child)"></div></div><div class="col-md-4"><div class="form-group"><input type="text" class="form-control sub_attendee_amount_'+key+'" required="required" value="'+value.amount+'" name="amount[]" id="exampleInputEmail1" placeholder="Enter Amount"></div></div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger remove_button"  data-id="'+key+'" ><i class="fas fa-minus"></i> Remove</button></div></div> </div>';
                            $(".add_new_subattendee").append(html);

                          });

                          }

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

    $("#addMoreSubAttendee").click(function(){

      var key = uniqId();
       var html = '<div class="row" id="'+key+'" ><div class="col-md-6"><div class="form-group"><input type="text" class="form-control sub_attendee_'+key+'" required="required" name="sub_attendee[]" id="exampleInputEmail1" placeholder="Enter Sub Attendee Title (eg:Spouse/child)"></div></div><div class="col-md-4"><div class="form-group"><input type="text" class="form-control sub_attendee_amount_'+key+'" required="required" name="amount[]" id="exampleInputEmail1" placeholder="Enter Amount"></div></div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger remove_button"  data-id="'+key+'" ><i class="fas fa-minus"></i> Remove</button></div></div> </div>';

       $(".add_new_subattendee").append(html);

    });

    $(".addBookings").click(function(){
      var id = $(this).data('id');
      $('#bookingRow').html('');

      var formData = new FormData();
       formData.append( 'id',id);
       formData.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : "{{ route('admin.add.newbookingData') }}",
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                          $('.eventselectoptions').find('option').remove();
                          $('#addNewBooling').modal('show'); 
                          $('#bookingRow').append(response.html);
                          $('#main_attendeebooking_id').val(id);
                          $('#input_amount_paid').val(response.data.amount);
                          $('#unique_uid').val(response.uid);
                          var options = '<option>Choose an Event</option>';
                           $.each(response.events, function(index, value) {
                             options += '<option value="'+value.id+'">'+value.title+'</option>';

                        });
                           $('.eventselectoptions').append(options);


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



    



  </script>
  @endsection
