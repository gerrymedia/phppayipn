<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//namespace Mailer;

/**
 * Description of Mailer
 *
 * @author Gerald
 */
class Mailer {
    //put your code here
    
    public function sendMail($mailTo, $mailSubject, $mailBody, $mailFrom) {
       
        mail($mailTo, $mailSubject, $mailBody, $mailFrom);

    }
}