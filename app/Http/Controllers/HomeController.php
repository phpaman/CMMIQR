<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MainAttendee;
use Str;
use App\Events;
use App\SubAttendeeDetails;
use App\Bookings;
use App\Mail\BookingMail;
use QrCode;
use PDF;
use App\Sponsers;
use App\SubAttendees;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 function getCallbackUrl()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $uri = str_replace('/index.php','/',$_SERVER['REQUEST_URI']);
        return $protocol . $_SERVER['HTTP_HOST'] . $uri . '/confirmation';
    }
    
function verifyPayment($key,$salt,$txnid,$status)
   {
    $command = "verify_payment"; //mandatory parameter
    
    $hash_str = $key  . '|' . $command . '|' . $txnid . '|' . $salt ;
    $hash = strtolower(hash('sha512', $hash_str)); //generate hash for verify payment request

    $r = array('key' => $key , 'hash' =>$hash , 'var1' => $txnid, 'command' => $command);
        
    $qs= http_build_query($r);
    //for production
    //$wsUrl = "https://info.payu.in/merchant/postservice.php?form=2";
   
    //for test
    $wsUrl = "https://test.payu.in/merchant/postservice.php?form=2";
    
    try 
    {       
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSLVERSION, 6); //TLS 1.2 mandatory
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new Exception($sad);
        }
        curl_close($c);
        
        /*
        Here is json response example -
        
        {"status":1,
        "msg":"1 out of 1 Transactions Fetched Successfully",
        "transaction_details":</strong>
        {   
            "Txn72738624":
            {
                "mihpayid":"403993715519726325",
                "request_id":"",
                "bank_ref_num":"670272",
                "amt":"6.17",
                "transaction_amount":"6.00",
                "txnid":"Txn72738624",
                "additional_charges":"0.17",
                "productinfo":"P01 P02",
                "firstname":"Viatechs",
                "bankcode":"CC",
                "udf1":null,
                "udf3":null,
                "udf4":null,
                "udf5":"PayUBiz_PHP7_Kit",
                "field2":"179782",
                "field9":" Verification of Secure Hash Failed: E700 -- Approved -- Transaction Successful -- Unable to be determined--E000",
                "error_code":"E000",
                "addedon":"2019-08-09 14:07:25",
                "payment_source":"payu",
                "card_type":"MAST",
                "error_Message":"NO ERROR",
                "net_amount_debit":6.17,
                "disc":"0.00",
                "mode":"CC",
                "PG_TYPE":"AXISPG",
                "card_no":"512345XXXXXX2346",
                "name_on_card":"Test Owenr",
                "udf2":null,
                "status":"success",
                "unmappedstatus":"captured",
                "Merchant_UTR":null,
                "Settled_At":"0000-00-00 00:00:00"
            }
        }
        }
        
        Decode the Json response and retrieve "transaction_details" 
        Then retrieve {txnid} part. This is dynamic as per txnid sent in var1.
        Then check for mihpayid and status.
        
        */
        $response = json_decode($o,true);
        
        if(isset($response['status']))
        {
            // response is in Json format. Use the transaction_detailspart for status
            $response = $response['transaction_details'];
            $response = $response[$txnid];
            
            if($response['status'] == $status) //payment response status and verify status matched
                return true;
            else
                return false;
        }
        else {
            return false;
        }
    }
    catch (Exception $e){
        return false;   
    }
}


    public function index()
    {
        $categories = MainAttendee::with('subattendees')->where('visibility','on')->get();
        $events = Events::where('status','1')->get();
        return view('frontend.home',compact('categories','events'));
    }

    public function index2()
    {
        $categories = MainAttendee::with('subattendees')->where('visibility','on')->get();
        $events = Events::where('status','1')->get();
        $sponsers = Sponsers::where('status','1')->get();
        return view('frontend.new-home',compact('categories','events','sponsers'));
    }

    public function saveBooking(Request $request){
    session_start();

     $attendee_name = $request->attendee_name;
     $total_amount = $request->total_amount;
     $cat_amount = $request->cat_amount;
     
     $txnid = floor(time()-999999999);

    foreach($attendee_name as $key => $attendee){
        if($attendee != NULL){
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $uid = 'QR'.substr(str_shuffle($str_result), 
                       0,6);
                       
            $_SESSION['uid'] = $uid;   
            
            $booking = new Bookings;
            
            if (isset($request->membership_no[$key])) {
               $booking->membership_no = $request->membership_no[$key];
            }
            $booking->member_name = $attendee;
            $booking->events_id = $request->events;
            $booking->email = $request->attendee_email[$key];
            $booking->phone_no = $request->attendee_phone_no[$key];
            $booking->amount_paid = $cat_amount[$key];
            $booking->uid  = $uid;
            $booking->payment_method = 'payubiz';
            $booking->main_attendee_id = $request->attendee_id[$key];
            $booking->participate_in_lucky_dip = (isset($request->lucky_dip[$key]) ? 'on' : 'off');
            $booking->payment_status = 'initiated';
            $booking->member_type = $request->member_type;
            $booking->transactio_number = $txnid;
            $booking->save();
            
            $sub_aatnedees = $request['sub_attendee_'.$key];
            $sub_attendee_ids = $request['sub_attendee_id_'.$key];

            foreach($sub_aatnedees as $s => $subattend){
                if ($subattend != NULL) {
                $subattendee = new SubAttendeeDetails;
                $subattendee->bookings_id = $booking->id;
                $subattendee->name = $subattend;
                $subattendee->subattendee_id = $sub_attendee_ids[$s];
                $subattendee->save();
                }
            }
        }
    }


       $key="QMZ5Rc";
       $salt="dOvL9aME";
       
       $action = 'https://secure.payu.in/_payment';
       $html='';
       
       $main_attendee = MainAttendee::where('id',$request->attendee_id[0])->first();

       
       $amount = '1.0';
       $productinfo = 'QR-'.$main_attendee->title ;
       $firstname = $attendee_name[0] ;
       $email = $request->attendee_email[0] ;
       $udf5 = 'key_' . Str::random(40);


     if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
    
     $hash=hash('sha512', $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'||||||'.$salt);
        
     $_SESSION['salt'] = $salt; //save salt in session to use during Hash validation in response
     
    
     $html = '<form action="'.$action.'" id="payment_form_submit" method="post">
             @csrf
             <input type="hidden" id="udf5" name="udf5" value="'.$udf5.'" />
             <input type="hidden" id="surl" name="surl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="furl" name="furl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="curl" name="curl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="key" name="key" value="'.$key.'" />
             <input type="hidden" id="txnid" name="txnid" value="'.$txnid.'" />
             <input type="hidden" id="amount" name="amount" value="'.$amount.'" />
             <input type="hidden" id="productinfo" name="productinfo" value="'.$productinfo.'" />
             <input type="hidden" id="firstname" name="firstname" value="'.$firstname.'" />
             <input type="hidden" id="email" name="email" value="'.$email.'" />
             <input type="hidden" id="phone" name="phone" value="'.$request->attendee_phone_no[0].'" />
             <input type="hidden" id="hash" name="hash" value="'.$hash.'" />
             </form>
             <script type="text/javascript"><!--
                 document.getElementById("payment_form_submit").submit();    
             //-->
             </script>';

              return view('frontend.confirm',compact('html'));
    }
 
    }

    public function confirm(Request $request){
        
        session_start();
        $postdata = $request;
        $msg = '';
        $salt = "dOvL9aME"; //Salt already saved in session during initial request.
        // $uid = $_SESSION['uid'];

        if (isset($postdata ['key'])) {
            $key                =   $postdata['key'];
            $txnid              =   $postdata['txnid'];
            $amount             =   $postdata['amount'];
            $productInfo        =   $postdata['productinfo'];
            $firstname          =   $postdata['firstname'];
            $email              =   $postdata['email'];
            $udf5               =   $postdata['udf5'];  
            $status             =   $postdata['status'];
            $resphash           =   $postdata['hash'];
            //Calculate response hash to verify 
            $keyString          =   $key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
            $keyArray           =   explode("|",$keyString);
            $reverseKeyArray    =   array_reverse($keyArray);
            $reverseKeyString   =   implode("|",$reverseKeyArray);
            $CalcHashString     =   strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString)); //hash without additionalcharges
            
            //check for presence of additionalcharges parameter in response.
            $additionalCharges  =   "";
            
            If (isset($postdata["additionalCharges"])) {
               $additionalCharges=$postdata["additionalCharges"];
               //hash with additionalcharges
               $CalcHashString  =   strtolower(hash('sha512', $additionalCharges.'|'.$salt.'|'.$status.'|'.$reverseKeyString));
            }
            
            Bookings::where('transactio_number',$txnid)->update(['payment_status' => $status]);
            
            
            //Comapre status and hash. Hash verification is mandatory.
            if ($status == 'success') {
                
                $bookings = Bookings::with('subattendeesdetails.subattendee','event')->where('transactio_number',$txnid)->get();
                
                
                foreach($bookings as $booking){
                    $date = date('d-M-y');

                 $user = ['txno' => $booking->transactio_number,'date' => $date,'payment_method' => $booking->payment_method,'email' => $booking->email,'uid' => $booking->uid,'booking_id' => $booking->id,'booking_date' => date('d-M-y', strtotime($booking->created_at)),'amount_paid' => $booking->amount_paid,'name' => $booking->member_name,'phone_no' => $booking->phone_no];
             
                $url = url('/user/uid/'.$booking->uid);
                $bookingdetails = ['name' => $booking->member_name,'uid' => $booking->uid,'event_title' => $booking->event->title,'event_vanue' => $booking->event->venue,'event_date' => $booking->event->date,'event_start_time' => $booking->event->start_time,'url' => $url,'email' => $booking->email,'membership_no' => $booking->membership_no];
                $SubAttendeeDetails = $booking->subattendeesdetails;
                

                $receiptpdf = \PDF::loadView('frontend.pdf.receipt', compact('user'));
                $bookingpdf = \PDF::loadView('frontend.pdf.bookingdetails', compact('bookingdetails','SubAttendeeDetails'));

                //  $image = QrCode::format('png')->size(200)->generate($url);
                
                //EMAIL//
                $details = [
                'title' => 'Booking Details',
                'name' => $booking->member_name,
                'uid' => $booking->uid,
                'to' => $booking->email,
                //  'image' => $image
                ];

             \Mail::send('mail.booking', $details, function($message)use($details, $receiptpdf, $bookingpdf) {

                        $message->to($details["to"], $details["to"])

                                ->subject($details["title"])

                                ->attachData($receiptpdf->output(), "receipt.pdf")

                                ->attachData($bookingpdf->output(), "booking.pdf");

                    });
                
                   
                }
                return redirect('/home')->with('success','Thanking You! Transaction Successful,Payment Verified...Please check your registered Email. Booking Details are send to your Email.'); 
                
                
            }
            else {
                //tampered or failed
                return redirect('/home')->with('error','Payment failed for Hash not verified...');
            } 
        }
     else exit(0);
    }
    
    public function getInstructions(Request $request){
        $id = $request->id;
        $events = Events::where('id',$id)->first();
        return response()->json(['success' => true,'data' => $events]);
    }
    
    public function viewSponsorBooking(){
        $sponsers = Sponsers::where('status','1')->get();
         $events = Events::where('status','1')->get();
        return view('frontend.book_sponsor',compact('sponsers','events'));
    }
    
    public function saveSponsorBooking(Request $request){
        $sponsor_name = $request->sponsor_name;
        $sponsor_email = $request->sponsor_email;
        $sponsor_phone_no = $request->sponsor_phone_no;
        $event_id = $request->events;
        $total_amount = $request->total_amount;
        $main_attendee_id = MainAttendee::where('title','Sponsor')->first();
        $sponsor_type = $request->sponsor_type;
        $sponsub_attendee = $request->sponsub_attendee;
        
        foreach($sponsor_name as $key => $sponsor){
            if($sponsor != NULL){
                
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uid = 'QR'.substr(str_shuffle($str_result), 
                       0,6);
       $_SESSION['uid'] = $uid;  
       
        $booking = new Bookings;
        $booking->member_name = $sponsor;
        $booking->events_id = $event_id;
        $booking->email = $sponsor_email[$key];
        $booking->phone_no = $sponsor_phone_no[$key];
        $booking->amount_paid = $total_amount;
        $booking->payment_status = 'initated';
        $booking->uid = $uid;
        $booking->payment_method = 'payubiz';
        $booking->main_attendee_id = $main_attendee_id->id;
        $booking->sponsor_type = $sponsor_type[$key];
        $booking->save();
        
        foreach($sponsub_attendee as $sub){
            if ($sub != NULL) {
                $subattendee = new SubAttendeeDetails;
                $subattendee->bookings_id = $booking->id;
                $subattendee->name = $sub;
                $subattendee->save();
                }
        }
                
                
            }
            
        }
        
         $key="QMZ5Rc";
       $salt="dOvL9aME";

       $action = 'https://secure.payu.in/_payment';
       $html='';
       

       $txnid = floor(time()-999999999);;
       $amount = '1.0';
       $productinfo = 'QR-SPONSOR' ;
       $firstname = $booking->member_name ;
       $email = $booking->email ;
       $udf5 = 'key_' . Str::random(40);


     if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
    
     $hash=hash('sha512', $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'||||||'.$salt);
        
     $_SESSION['salt'] = $salt; //save salt in session to use during Hash validation in response
    
     $html = '<form action="'.$action.'" id="payment_form_submit" method="post">
             @csrf
             <input type="hidden" id="udf5" name="udf5" value="'.$udf5.'" />
             <input type="hidden" id="surl" name="surl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="furl" name="furl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="curl" name="curl" value="'.$this->getCallbackUrl().'" />
             <input type="hidden" id="key" name="key" value="'.$key.'" />
             <input type="hidden" id="txnid" name="txnid" value="'.$txnid.'" />
             <input type="hidden" id="amount" name="amount" value="'.$amount.'" />
             <input type="hidden" id="productinfo" name="productinfo" value="'.$productinfo.'" />
             <input type="hidden" id="firstname" name="firstname" value="'.$firstname.'" />
             <input type="hidden" id="email" name="email" value="'.$email.'" />
             <input type="hidden" id="phone" name="phone" value="'. $booking->phone_no.'" />
             <input type="hidden" id="hash" name="hash" value="'.$hash.'" />
             </form>
             <script type="text/javascript"><!--
                 document.getElementById("payment_form_submit").submit();    
             //-->
             </script>';

              return view('frontend.confirm',compact('html'));
    }   
        
    }
    
    public function getSubattendee(Request $request){
        $id = $request->id;
        $sub_attendee = SubAttendees::where('main_attendee_id',$id)->where('status','1')->get();
        
        return response()->json(['success' => true,'data' => $sub_attendee]);
    }

}
