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
            <h1>Bookings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bookings</li>
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
                <h3 class="card-title">All Bookings</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr no.</th>
                    <th>Attendee Name</th>
                    <th>UID</th>
                    <th>Attendee Type</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Member ship no.</th>
                    <th>Phone No.</th>
                    <th>Entry Status</th>
                    <th>Dinner Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($bookings as $key => $booking) 
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$booking->member_name}}</td>
                    <td>{{$booking->uid}}</td>
                    <td>{{$booking->mainattendee->title}}</td>
                    <td>{{$booking->email}}</td>
                    <td>{{$booking->event->title}}</td>
                    <td>{{$booking->membership_no}}</td>
                    <td>{{$booking->phone_no}}</td>
                    <td>@if($booking->entry_status == '1')
                      Attend
                    @else
                      Not-Attend
                    @endif
                    </td>
                    <td>@if($booking->dinner_status == '1')
                      Attend
                    @else
                      Not-Attend
                    @endif</td>
                    <td> <a href="#" data-id="{{$booking->id}}" class="showBookingDetails"><button type="button" class="btn btn-primary" ><i class="fas fa-eye"></i></button></a>
                    <a href="{{route('admin.resend.email',$booking->id)}}" class="resendemail"><button type="button" class="btn btn-primary" onclick="return confirm('Are you sure you want to Resend this Email to user : {{$booking->member_name}}?');" ><i class="fas fa-envelope"></i> Resend Email</button></a>
                    <a href="{{route('admin.download.pdf',$booking->id)}}" class="downloadpdf"><button type="button" class="btn btn-primary" ><i class="fas fa-download"></i> pdf</button></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr no.</th>
                    <th>Attendee Name</th>
                    <th>UID</th>
                    <th>Attendee Type</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Member ship no.</th>
                    <th>Phone No.</th>
                    <th>Entry Status</th>
                    <th>Dinner Status</th>
                    <th>Action</th>
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
   <div class="modal fade" id="showBookingDetails" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Booking Details</h3>
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
                      <label for="exampleInputEmail1" id="booking_event"></label>
                    </div>
                    </div> 
                    <div class="col-md-2">
                    <div class="form-group">     
                     <label for="exampleInputEmail1">Participate in Lucky DIP : </label>
                    </div>
                   </div>
                   <div class="col-md-1">
                      <label for="exampleInputEmail1" id="lucky_dip"></label>
                    </div>
                  </div>
                  <div id="bookingRow" >
                  </div>
                  <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Payment Method : <span id="payment_method" ></span></label>
                    </div>
                    </div> 
                    <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Amount Paid : <span id="amount_paid" ></span></label>
                    </div>
                   </div>
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">UID no : <span id="uid_no" ></span></label>
                    </div>
                   </div>
                  </div>
                  <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Transaction Source (Bank Name) : <span id="transaction_source" ></span></label>
                    </div>
                    </div> 
                    <div class="col-md-4">
                    <div class="form-group">
                     <label for="exampleInputEmail1">Transaction Number : <span id="transaction_number" ></span></label>
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
  </div>
  <script type="text/javascript">
    $(document).on('click', '.showBookingDetails', function(){
    var id = $(this).data('id'); 
    $('#bookingRow').html('');
      var formData = new FormData();
       formData.append( 'id',id);
       formData.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : "{{ route('admin.booking.details') }}",
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                            $('#showBookingDetails').modal('show');
                            $('#booking_event').text(response.data.event.title);
                            if (response.data.participate_in_lucky_dip == 'on') {
                               $('#lucky_dip').text('YES');
                            }else{
                                $('#lucky_dip').text('NO');
                            }
                            $('#payment_method').text(response.data.payment_method);
                            $('#amount_paid').text(response.data.amount_paid);
                            $('#uid_no').text(response.data.uid);
                            $('#transaction_source').text(response.data.transaction_source);
                            $('#transaction_number').text(response.data.transactio_number);
                            $.each(response.data.subattendeesdetails, function(index, value) {

                            var html = '<div class="row"  ><div class="col-md-2"><div class="form-group"><label for="exampleInputEmail1">'+value.subattendee.title+'</label>  </div></div><div class="col-md-2"><div class="form-group"> <label for="exampleInputEmail1">'+value.name+'</label> </div></div><div class="col-md-2"><div class="form-group"><label for="exampleInputEmail1">INR <span >'+value.subattendee.amount+'</span>/head</label> </div></div><div class="col-md-2"><div class="form-group"> '+(value.entry_status == 1 ? '<button type="button" class="btn btn-success"  >Attend</button>': '<button type="button" class="btn btn-secondary"  >Not-Attend</button>') +'</div> </div> <div class="col-md-2"><div class="form-group"> '+(value.dinner_status == 1 ? '<button type="button" class="btn btn-success"  >Attend</button>': '<button type="button" class="btn btn-secondary"  >Not-Attend</button>') +' </div></div> <div class="col-md-1"> <div class="form-group"> </div></div></div>';

                            $('#bookingRow').append(html);

                        });


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