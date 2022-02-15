<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>
  <body>
    <table class="table table-bordered">
      <tr>
        <td><img src="{{asset('public/images/logo_with_headline.png')}}" style="height: 100px;" ></img>
        </td>
        </tr>
      <tr>
        <td><h2>Receipt</h2>
        </td>
      </tr>
      <tr>
        <td>
          Transaction no : {{$user['txno']}}
        </td>
      </tr>
      <tr>
          <td>
          Date : {{$user['date']}}
        </td>
      </tr>
      <tr>
        <td>
          Payment Method : {{ $user['payment_method']}}
        </td>
      </tr>
      <tr>
        <td>
          Attendee Name : {{$user['name']}}
        </td>
      </tr>
      <tr>
        <td>
          Email : {{$user['email']}}
        </td>
      </tr>
      <tr>
        <td>
          Phone no : {{$user['phone_no']}}
        </td>
      </tr>
      <tr>
        <td>
          Booking Id : {{$user['booking_id']}}
        </td>
      </tr>
      <tr>
        <td>
          Amount Paid : INR {{$user['amount_paid']}}
        </td>
      </tr>
      <tr>
        <td>
          Payment status : Success
        </td>
      </tr>
      <tr>
        <td>
          Note: This is system generated receipt
        </td>
      </tr>
    </table>
  </body>
</html>