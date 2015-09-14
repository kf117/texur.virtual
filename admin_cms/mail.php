<?php

include((dirname(__FILE__))."/functions/inc/class.phpmailer.php");
                
                $mail = new PHPMailer(true);
		$mail->CharSet = "UTF-8";
		$mail->Sender = "noreply@chat.callcom.co.nz";
		$mail->From = "noreply@chat.callcom.co.nz";
		$mail->FromName = "Colegio Heraldos del Evangelio";
		$mail->Subject = 'Resumen informativo';
		$mail->AddReplyTo("noreply@chat.callcom.co.nz","Chat Transcript");
                
                
		$mail->Body = "hola";
                
                $mail->IsHTML(TRUE);
		
                $mail->AddAddress( "lucianov.vitetti@gmail.com" );
               
		if ( isset($data['use_smtp']) && $data['use_smtp'] == 1 ) {
			$mail->IsSMTP();
			$mail->Host = $data['host'];
			$mail->Port = $data['port'];
			
			if ($data['username'] != '' && $data['password'] != '') {			
				$mail->Username = $data['username'];
				$mail->Password = $data['password'];
				$mail->SMTPAuth = true;
			}
		}

		
		$mail->Send();
		
		$mail->ClearAddresses();
?> 
