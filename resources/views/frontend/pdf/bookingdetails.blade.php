<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>
  <body>
    <table class="table table-bordered">
      <tr><td><img src="{{asset('public/images/logo_with_headline.png')}}" style="height: 100px;" ></img></td></tr>
      <tr><td>Event Name : {{$bookingdetails['event_title']}},{{$bookingdetails['event_vanue']}},{{$bookingdetails['event_date']}},{{$bookingdetails['event_start_time']}}</td>
      </tr>
      <tr>
        <td>
         Event Date & Time: {{$bookingdetails['event_date']}} , {{$bookingdetails['event_start_time']}}
        </td>
      </tr>
      <tr>
        <td>
         Event Location: {{$bookingdetails['event_vanue']}}
        </td>
      </tr>
      <tr>
        <td>
          UID :  {{$bookingdetails['uid']}}
        </td>
      </tr>
      <tr>
        <td>
          Member Name: {{$bookingdetails['name']}}
        </td>
      </tr>
      <tr>
          <td>
          Membership Number: {{$bookingdetails['membership_no']}}    
          </td>
      </tr>
      <tr>
        <td>
          <div class="visible-print text-center">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($bookingdetails['url'])) !!} ">
        </div>
      </td>
      </tr>
      <tr>
        <td>
         Event Supported by: 
        </td>
      </tr>
      <tr>
        <td>
        <img></img>
        </td>
        <td>
        <img></img>
        </td>
        <td>
        <img></img>
        </td>
        <td>
        <img></img>
        </td>
      </tr>
      <tr>
          <td>
         For any queries, please contact us on office@cmmi.co.in or call us on +91 98195 33239 / 98218 39084
          </td>
      </tr>
      <tr>
          See you at the Event!!!
      </tr>
    </table>
  </body>
</html>