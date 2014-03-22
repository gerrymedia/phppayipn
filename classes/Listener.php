<?php

/*
 * MIT License
 *
 * 
 * 
 */

/**
 * Listener class provides the methods for receiving and responding to Paypal
 *
 * @author Gerald
 */

use \Mailer as Mailer;

class Listener {
    
    public function __construct() {
        //print "Hello";
    }
    
    public function returnFirstResponse($postData){
        
        // @ipnMessage: PayPal HTTP POSTs your listener an IPN message that notifies you an event (payment via button or API)
        
        // this function returns an empty HTTP 200 response.
        
        header('HTTP/1.1 200 OK'); 
                
        $data = array();
        
        foreach($postData as $key => $value){
            $value = urlencode(stripslashes($value));
            $data[$key] = $value;
        }
        
        $this->returnHttpPostPaypal($data);               
        
        
    }
    
    private function returnHttpPostPaypal($data){
        
        /* Your listener HTTP POSTs the complete, unaltered message back to PayPal.
        * Note: This message must contain the same fields, in the same order, as the 
        * original IPN from PayPal, all preceded by cmd=_notify-validate. 
        * Further, this message must use the same encoding as the original.
        */
        
        $postBackBaseURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_notify-validate&";
        
        $postBackURI = $postBackBaseURL;
        
        $req = http_build_query($data);
        
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $req,
            ),
        );
        
        $context  = stream_context_create($options);
        
         // Open a socket for the acknowledgement request
        $fp = fsockopen(ENV, 443, $errno, $errstr, 30);
  
        // make the http post
        $postRequest = file_get_contents($postBackBaseURL, false, $context);
        
        // process the response
        $this->processResponseToHttpPost($fp, $req);
        
    }
    
    private function processResponseToHttpPost($fp, $req){
        
        // PayPal sends a single word back - either VERIFIED (if the message matches 
        // the original) or INVALID (if the message does not match the original).
        
        /*
         * Upon receipt of a VERIFIED response, your back-office process can parse 
         * the contents of the IPN message and respond appropriately - print a packing 
         * list, enable a digital download, etc.
         */
        while (!feof($fp)) { 
            
            $res = fgets($fp, 1024);
            
            switch ($paypalResponse) {
                case strcmp ($res, "VERIFIED") == 0:
                    
                      // Send an email announcing the IPN message is VERIFIED
                        $mail_From    = COMPANY_EMAIL;
                        $mail_To      = MY_EMAIL;
                        $mail_Subject = VERIFIED_IPN_EMAIL_SUBJECT;
                        $mail_Body    = $req;
                        
                        $mailer = new Mailer();
                        $mailer->sendMail($mail_To, $mail_Subject, $mail_Body, $mail_From);
                        

                    //Check that the payment_status is Completed.

                    //If the payment_status is Completed, check the txn_id against the previous 
                    //PayPal transaction that you processed to ensure the IPN message is not a duplicate.

                    //Check that the receiver_email is an email address registered in your PayPal account.

                    /*
                     * Check that the price (carried in mc_gross) and the currency (carried in mc_currency) 
                     * are correct for the item (carried in item_name or item_number).
                     * 
                     */

                    /*
                     * Once you have completed these checks, IPN authentication is complete. 
                     * Now, you can update your database with the information provided and initiate 
                     * any back-end processing that's appropriate.
                     */

                     //do something here

                    break;

                default:
                    
                     // Send an email announcing the IPN message is INVALID
                        $mail_From    = COMPANY_EMAIL;
                        $mail_To      = MY_EMAIL;
                        $mail_Subject = INVALID_IPN_EMAIL_SUBJECT;
                        $mail_Body    = $req;
                        
                        $mailer = new Mailer();
                        $mailer->sendMail($mail_To, $mail_Subject, $mail_Body, $mail_From);
                        
                    break;
            }
        }
        
    }
}
