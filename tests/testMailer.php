<?php

/* 
 * The MIT License
 *
 * Copyright 2014 Gerald.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

include_once '../includes/config.inc';

function __autoload($class_name) {
    $filename = '../classes/'.$class_name . '.php';
    require_once $filename;
    
}

use \Mailer as Mailer;

 $mailFrom    = COMPANY_EMAIL;
 $mailTo      = MY_EMAIL;
 $mailSubject = VERIFIED_IPN_EMAIL_SUBJECT;
 $mailBody    = "test";

$mailer = new Mailer();
$mailer->sendMail($mailTo, $mailSubject, $mailBody, $mailFrom);
