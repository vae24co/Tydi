<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* MailQ ~ Mail Utility • VERSION » alpha-0.0.1 ***/

class MailQ {

	#SEND • Send email using PHP Mail (return FALSE|YEAP]
	public static	function send($data, $type = 'HTML'){
		if($type == 'DEFAULT'){
			if(mail($data['to'], $data['subject'], $data['message']) === true){
				return true;
			}
		} elseif($type == 'iHTML'){
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';
			$headers[] = 'From: '.$data['firm'].'<alert@'.$data['domain'].'>';
			if(mail($data['to'], $data['subject'], $data['message'], implode("\r\n", $headers), '-fwebmaster@'.$data['domain']) === true){
				return true;
			}
		}
		return false;
	}

} /*** End Of ~MailQ ***/