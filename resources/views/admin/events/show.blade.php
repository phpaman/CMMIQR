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
            <h1>Events</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Events</li>
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
                <h3 class="card-title">All Events</h3>
                <a href="#" data-toggle="modal" data-target="#addEvent"><button type="button" class="btn btn-primary float-sm-right"><i class="fas fa-plus"></i> Add</button></a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr no.</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Show</th>
                    <th>Bookings</th>

                  </tr>
                  </thead>
                  <tbody>
                   @foreach($events as $key => $event) 
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$event->title}}</td>
                    <td>{{ date("d-M-Y", strtotime($event->date))}}</td>
                    <td>{{$event->venue}}</td>
                    <td>{{ date("g:i a", strtotime($event->start_time))}}</td>
                    <td>
                    	@if($event->status == '1')
                    	<button type="button" class="btn btn-success" >Upcoming</button>
                        @else
                        <button type="button" class="btn btn-secondary" >Finished</button>
                        @endif
                    </td>
                    <td> <a href="#" data-id="{{$event->id}}" class="event_instructions"><button type="button" class="btn btn-primary" ><i class="fas fa-eye"></i></button></a></td>
                    <td> <a href="{{route('admin.bookings')}}"><button type="button" class="btn btn-secondary" ><i class="fas fa-eye"></i></button></a></td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr no.</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Show</th>
                    <th>Bookings</th>
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
                <h3 class="card-title">Add New Event</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.save.event')}}">
                @csrf
                <div class="card-body">
                 <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" required="required" name="title" id="exampleInputEmail1" placeholder="Enter Event Title">
                  </div>
                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Venue</label>
                    <input type="text" class="form-control" required="required" name="venue" id="exampleInputEmail1" placeholder="Enter Event Venue">
                  </div>
                </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" class="form-control" required="required" name="date" id="exampleInputEmail1" placeholder="Enter Event Date">
                  </div>
                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Start Time</label>
                    <input type="time" class="form-control" required="required" name="start_time" id="exampleInputEmail1" >
                  </div>
                </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Instructions</label>
                    <textarea type="text" class="form-control" required="required" name="instructions" id="exampleInputEmail1" placeholder="Enter Event Instructions"></textarea> 
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
    <!-- EDIT MODAL -->
    <!--  MODAL -->
   <div class="modal fade" id="editEvent" tabindex="-1" role="dialog" aria-labelledby="applicantModal">
        <div class="modal-dialog" style="max-width: 1200;" >
        <div class="modal-content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Event Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{route('admin.update.events')}}">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="card-body">
                 <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" required="required" name="title" id="edit_title" placeholder="Enter Event Title">
                  </div>
                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Venue</label>
                    <input type="text" class="form-control" required="required" name="venue" id="edit_venue" placeholder="Enter Event Venue">
                  </div>
                </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" class="form-control" required="required" name="date" id="edit_date" placeholder="Enter Event Date">
                  </div>
                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Start Time</label>
                    <input type="time" class="form-control" required="required" name="start_time" id="edit_start_time" >
                  </div>
                </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Instructions</label>
                    <textarea type="text" class="form-control" required="required" name="instructions" id="edit_instructions" placeholder="Enter Event Instructions"></textarea> 
                  </div>
                 </div>
                  </div>
                  <div class="row" >
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select class="form-control" name="status">
                      <option id="upcoming" value="1" >Upcoming</option>
                      <option id="finished" value="0" >Finished</option>
                    </select> 
                  </div>
                 </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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