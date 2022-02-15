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
            <h1>Sponser's</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sponsers</li>
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
                <h3 class="card-title">All Sponsers</h3>
                <a href="#" data-toggle="modal" data-target="#addEvent"><button type="button" class="btn btn-primary float-sm-right"><i class="fas fa-plus"></i> Add</button></a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr no.</th>
                    <th>Type of Sponsor</th>
                    <th>Suggested Donor Coupons</th>
                    <th>Amount in INR</th>
                    <th>Remark</th>
                    <th>Souvenir ads coloured</th>
                    <th>Display of digital banner</th>
                    <th>Add Booking</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($sponsers as $key => $sponser)
                      <tr>
                          <td>{{$key +1}}</td>
                          <td>{{$sponser->type_of_sponser}}</td>
                          <td>{{$sponser->coupons}}</td>
                          <td>{{$sponser->amount}}</td>
                          <td>{{$sponser->remarks}}</td>
                          <td>{{$sponser->souvier_ads_coloured}}</td>
                          <td>{{$sponser->digital_banner}}</td>
                          <td><button class="btn btn-primary addBooking" data-id="{{$sponser->id}}" data-coupons="{{$sponser->coupons}}" data-type="{{$sponser->type_of_sponser}}" data-amount="{{$sponser->amount}}" >Add</button></td>
                      </tr> 
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                   <th>Sr no.</th>
                    <th>Type of Sponsor</th>
                    <th>Suggested Donor Coupons</th>
                    <th>Amount in INR</th>
                    <th>Remark</th>
                    <th>Souvenir ads coloured</th>
                    <th>Display of digital banner</th>
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
   <div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" style="max-width: 1200;" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Sponser</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.save.sponser')}}">
                @csrf
                
                <div class="intial_card">
                <div class="card-body">
                 <div class="row" >
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Type of Sponser</label>
                    <input type="text" class="form-control" required="required" name="type_of_sponser[]" id="exampleInputEmail1" placeholder="Enter sponser Type">
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Souvenir ads coloured</label>
                    <select class="form-control" name="souvier_ads_coloured[]" >
                        <option value="full page" >Full page</option>
                        <option value="half page">Half page</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Display of digital banner</label>
                    <select class="form-control" name="digital_banner[]" >
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                  </div>
                </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Suggested Donor Coupons</label>
                    <input type="number" class="form-control" required="required" name="coupons[]" id="exampleInputEmail1" placeholder="Enter suggested donor coupons">
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Amount in INR</label>
                    <input type="number" class="form-control" required="required" name="amount[]" id="exampleInputEmail1" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Remarks</label>
                    <textarea type="text" class="form-control" required="required" name="remarks[]" id="exampleInputEmail1" placeholder="Enter Remarks"></textarea> 
                  </div>
                 </div>
                  </div>
                </div>
                <!-- /.card-body -->
                </div>
                <div class="addedcards" >
                    
                </div>
                
                
                
                <div class="card-footer">
                    <button type="button" id="add_more_sponser" class="btn btn-success"><i class="fas fa-plus" ></i>Add More</button>
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
    <!-- EDIT MODAL -->
    <!--  MODAL -->
   <div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" style="max-width: 1200;" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Booking : <span class="sponser_title" ></span> </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.booking.sponser')}}">
                @csrf
                <div class="card-body">
                <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                   <label for="exampleInputEmail1">Event</label>  
                   <select name="event_id" class="form-control" >
                       @foreach($events as $event)
                       <option value="{{$event->id}}">{{$event->title}}</option>
                       @endforeach
                   </select>
                      </div>
                </div>
                
                 <div class="col-md-2">
                  <div class="form-group">
                   <label for="exampleInputEmail1">Participate in lucku dip?</label>  
                   
                      </div>
                </div>
                 <div class="col-md-1">
                  <div class="form-group">
                   <input type="checkbox" class="form-control" name="lucky_dip" >
                      </div>
                </div>
               </div>
                 <div class="row" >
                 <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Sposner Name</label>
                    <input type="text" class="form-control" required="required" name="main_sponser" id="edit_title" placeholder="Enter Event Sponser name">
                  </div>
                 </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" required="required" name="email" id="edit_venue" placeholder="Enter sponser's Email">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="number" class="form-control" required="required" name="phone" id="edit_venue" placeholder="Enter Sponser's phone">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Amount/INR</label>
                    <input type="number" class="form-control" id="sponser_amount" readonly name="amount" >
                  </div>
                </div>
                  </div>
                  <div class="sub_attendees" >
                      
                  </div>
                  <div class="row" >
                  <div class="col-md-6">
                     <!--<input type="hidden" value="1" id="np_of_remaining_coupons" >-->
                     <button class="btn btn-success add_sub_attendees" type="button" ><i class="fas fa-plus" ></i>Add More Attendee :<span class="no_of_coupons"></span> Coupons</button>
                  </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-4">
                  <div class="form-group">
                   <label for="exampleInputEmail1">Transaction source</label>  
                   <input type="text" name="transaction_source" id="transaction_source" class="form-control" Placeholder="Enter Transaction Source">
                      </div>
                </div>
                 <div class="col-md-4">
                  <div class="form-group">
                   <label for="exampleInputEmail1">Transactio number</label>  
                    <input type="text" name="transactio_number" id="transactio_number" class="form-control" placeholder="Enter Transaction Number" >
                      </div>
                      </div>
                      <div class="col-md-4">
                  <div class="form-group">
                   <label for="exampleInputEmail1">Remark</label>  
                    <input type="text" name="remark" class="form-control" id="remark" placeholder="Enter Remarks" >
                      </div>
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
  
  function uniqId() {
  return Math.round(new Date().getTime() + (Math.random() * 100));
}
  
   $(document).on('click', '#add_more_sponser', function(){
       var id = uniqId();
       
       var html = '<div class="card-body '+id+'"><div class="row" > <div class="col-md-4"><div class="form-group"> <label for="exampleInputEmail1">Type of Sponser</label><input type="text" class="form-control" required="required" name="type_of_sponser[]" id="exampleInputEmail1" placeholder="Enter sponser Type"> </div> </div><div class="col-md-4"> <div class="form-group"> <label for="exampleInputEmail1">Souvenir ads coloured</label><select class="form-control" name="souvier_ads_coloured[]" ><option value="full page" >Full page</option><option value="half page" >Half page</option></select></div> </div><div class="col-md-4"> <div class="form-group"><label for="exampleInputEmail1">Display of digital banner</label> <select class="form-control" name="digital_banner[]" > <option value="yes" >Yes</option> <option value="no" >No</option> </select></div> </div></div> <div class="row" ><div class="col-md-4"><div class="form-group"> <label for="exampleInputEmail1">Suggested Donor Coupons</label><input type="number" class="form-control" required="required" name="coupons[]" id="exampleInputEmail1" placeholder="Enter suggested donor coupons"> </div></div><div class="col-md-4"><div class="form-group"><label for="exampleInputEmail1">Amount in INR</label> <input type="number" class="form-control" required="required" name="amount[]" id="exampleInputEmail1" ></div></div><div class="col-md-3"><div class="form-group"><label for="exampleInputEmail1">Remarks</label> <textarea type="text" class="form-control" required="required" name="remarks[]" id="exampleInputEmail1" placeholder="Enter Event Instructions"></textarea>  </div> </div><div class="col-md-1"><button type="button" class="btn btn-danger remove_cards" data-id="'+id+'"  ><i class="fas fa-minus" ></i> Remove</button> </div>      </div></div>';
       
       $('.addedcards').append(html);
   });
   
   $(document).on('click', '.remove_cards', function(){
       var id = $(this).data('id');
       
       $('.'+id).remove();
   });
   
   $(document).on('click', '.addBooking', function(){
       var id = $(this).data('id');
       var type = $(this).data('type');
       var coupons = $(this).data('coupons');
       var amount = $(this).data('amount');
        
       
       $('#addBookingModal').modal('show');
       $('.sponser_title').text(type);
       $('.no_of_coupons').text(coupons);
       $('#sponser_amount').val(amount);
   });
   
    $(document).on('click', '.add_sub_attendees', function(){
        
      var id = $('.no_of_coupons').text();
      
      if(id != '0'){
      var html = '<div class="row" id="sub_'+id+'" ><div class="col-md-4"> <div class="form-group"><label for="exampleInputEmail1">Attendee Name</label><input type="text" class="form-control" required="required" name="sub_attendee_name[]" id="edit_title" placeholder="Enter Attendee name"> </div> </div><div class="col-md-4"> <button type="button" class="btn btn-danger remove_sub" data-id="'+id+'"><i class="fas fa-minus" ></i>Remove</button></div></div>';
      
      $('.sub_attendees').append(html);
      var new_id = parseFloat(id) - 1;
      $('.no_of_coupons').text(new_id);
      }
       
      
   });
   
   $(document).on('click', '.remove_sub', function(){
       var id = $(this).data('id');
       
       $('#sub_'+id).remove();
       
       var remain = $('.no_of_coupons').text();
       var new_id = parseFloat(remain) + 1;
      $('.no_of_coupons').text(new_id);
       
       
   });
   
   
   
   
   
   
   
  
  
    $(document).on('click', '.event_instructions', function(){
     var id = $(this).data('id');
     var formData = new FormData();
       formData.append( 'id',id);
       formData.append('_token', "{{ csrf_token() }}")
                $.ajax({
                    method      : 'POST',
                    data        : formData,
                    url         : "{{ route('admin.edit.events') }}",
                    processData : false, // Don't process the files
                    contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                    dataType    : 'json',
                    success     : function(response){
                        if(response.success == true)
                        {
                            $('#editEvent').modal('show'); 
                            $('#edit_title').val(response.data.title);
                            $('#edit_venue').val(response.data.venue);
                            $('#edit_date').val(response.data.date);
                            $('#edit_start_time').val(response.data.start_time);
                            $('#edit_instructions').val(response.data.instructions);
                            $('#edit_id').val(id);
                            if (response.data.status == '1') {
                              $('#upcoming').prop('selected',true);
                            }else{
                              $('#finished').prop('selected',true);
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
   });
  </script>
  @endsection