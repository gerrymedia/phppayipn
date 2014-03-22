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
class Listener {
    
    public function __construct() {
        print "Hello";
    }
    
    public function returnFirstResponse($ipnMessage){
        
        // @ipnMessage: PayPal HTTP POSTs your listener an IPN message that notifies you an event (payment via button or API)
        
        // this function returns an empty HTTP 200 response.
        
    }
    
    private function returnHttpPostPaypal($data){
        
        /* Your listener HTTP POSTs the complete, unaltered message back to PayPal.
        * Note: This message must contain the same fields, in the same order, as the 
        * original IPN from PayPal, all preceded by cmd=_notify-validate. 
        * Further, this message must use the same encoding as the original.
        */
        
    }
    
    private function processResponseToHttpPost($paypalResponse){
        
        // PayPal sends a single word back - either VERIFIED (if the message matches 
        // the original) or INVALID (if the message does not match the original).
        
        /*
         * Upon receipt of a VERIFIED response, your back-office process can parse 
         * the contents of the IPN message and respond appropriately - print a packing 
         * list, enable a digital download, etc.
         */
        
    }
}
