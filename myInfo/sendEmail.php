<?php

 // send html mail
 function send_htmlmail($fromEmail, $fromName, $toEmail, $toName, $subject, $message){

  $charset='utf-8'; // 문자셋 : UTF-8
  $body = iconv('utf-8', 'euc-kr', $message);  //본문 내용 UTF-8화
  $encoded_subject="=?".$charset."?B?".base64_encode($subject)."?=\n"; // 인코딩된 제목
  $to= "\"=?".$charset."?B?".base64_encode($toName)."?=\" <".$toEmail.">" ; // 인코딩된 받는이
  $from= "\"=?".$charset."?B?".base64_encode($fromName)."?=\" <".$fromEmail.">" ; // 인코딩된 보내는이

  $headers="MIME-Version: 1.0\n".
  "Content-Type: text/html; charset=euc-kr; format=flowed\n".
  "To: ". $to ."\n".
  "From: ".$from."\n".
  "Return-Path: ".$from."\n".
  "urn:content-classes:message\n".
  "Content-Transfer-Encoding: 8bit\n"; // 헤더 설정

  //send the email
  $mail_sent = @mail( $to, $encoded_subject, $body, $headers );
  //if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"

  return $mail_sent;
 }
 
?>