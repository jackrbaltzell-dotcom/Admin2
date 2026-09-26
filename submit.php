<?php
require_once __DIR__.'/common.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: contact.php');exit;}
$d=data();
$inq=json_decode(file_get_contents(INQUIRIES_FILE),true) ?: [];
$item=[
'name'=>trim($_POST['name']??''),
'email'=>trim($_POST['email']??''),
'business'=>trim($_POST['business']??''),
'service'=>trim($_POST['service']??''),
'message'=>trim($_POST['message']??''),
'created'=>date('Y-m-d H:i:s')
];
$inq[]=$item;
file_put_contents(INQUIRIES_FILE,json_encode($inq,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),LOCK_EX);
$text="New Project Enquiry\n--------------------\nName: {$item['name']}\nEmail: {$item['email']}\nBusiness/Website: {$item['business']}\nService: {$item['service']}\n\nMessage:\n{$item['message']}";
header('Location: https://wa.me/'.preg_replace('/\D+/','',$d['settings']['whatsapp']).'?text='.rawurlencode($text));
exit;
