<?php 
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
$contact = new Contactlist();
echo $contact->totalContact();