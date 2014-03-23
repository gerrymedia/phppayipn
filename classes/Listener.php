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
    
    public function returnFirstResponse(){
        
        // @ipnMessage: PayPal HTTP POSTs your listener an IPN message that notifies you an event (payment via button or API)
        
        // this function returns an empty HTTP 200 response.
        
        return header('HTTP/1.1 200 OK'); 
                
      }
    
    public function returnHttpPostPaypal($data){
        
        /* Your listener HTTP POSTs the complete, unaltered message back to PayPal.
        * Note: This message must contain the same fields, in the same order, as the 
        * original IPN from PayPal, all preceded by cmd=_notify-validate. 
        * Further, this message must use the same encoding as the original.
        */
        
        // read the post from PayPal system and add 'cmd'
       
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
        }
        foreach ($data as $key => $value) {
                if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                        $value = urlencode(stripslashes($value));
                } else {
                        $value = urlencode($value);
                }
                $req .= "&$key=$value";
        }

        // Post IPN data back to PayPal to validate the IPN data is genuine
        // Without this step anyone can fake IPN data
        
        if(USE_SANDBOX == true) {
	$postBackBaseURL = "ssl://www.sandbox.paypal.com";
        } else {
	$postBackBaseURL = "ssl://www.paypal.com";
        }

       // Set up the acknowledgement request headers
        $header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";                    // HTTP POST request
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        // Open a socket for the acknowledgement request
        $fp = fsockopen($postBackBaseURL, 443, $errno, $errstr, 30);

        // Send the HTTP POST request back to PayPal for validation
        fputs($fp, $header . $req);
                
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
            
            if (strcmp ($res, "VERIFIED") == 0) {
                
                    
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

            } else {

              
                     // Send an email announcing the IPN message is INVALID
                        $mail_From    = COMPANY_EMAIL;
                        $mail_To      = MY_EMAIL;
                        $mail_Subject = INVALID_IPN_EMAIL_SUBJECT;
                        $mail_Body    = $req;
                        
                        $mailer = new Mailer();
                        $mailer->sendMail($mail_To, $mail_Subject, $mail_Body, $mail_From);
                        
                  
            }
        }
        
         fclose($fp);  // Close the file
         
    }
}
