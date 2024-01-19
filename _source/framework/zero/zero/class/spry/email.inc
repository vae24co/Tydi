<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* EmailX ~ Email Utility • VERSION » alpha-0.0.5 ***/

class EmailX {
	private $fromDomain;
	private $fromName;
	private $fromUser;

	private $mail;




	//*----------- INITIALIZE -----------*//
	public function initialize(array $from, array $to, array $mail){
		if(!empty($from['domain'])){$this->fromDomain = $from['domain'];} else {$this->fromDomain = URLX::domain(ServerX::host());}
		if(!empty($from['user'])){$this->fromUser = $from['user'];} else {$this->fromUser = 'alert';}
		if(!empty($from['name'])){$this->fromName = $from['name'];} else {$this->fromName = '';}

		if(!empty($to['email'])){$toReceiver = $to['email'];}
		else {
			//TODO: Trigger Error!
		}
		if(!empty($to['name'])){$toReceiver = $to['name'].'<'.$toReceiver.'>';}
		$this->toReceiver = $toReceiver;

		if(empty($mail['subject'])){
			//TODO: Trigger Error!
		}
		if(empty($mail['message'])){
			//TODO: Trigger Error!
		}
		$this->mail = $mail;

		return true;
	}






	//*----------- SEND MAIL -----------*//
	public function sendMail(){
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=UTF-8';
		// $headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'From: '.$this->fromName.'<'.$this->fromUser.'@'.$this->fromDomain.'>';
		return mail($this->toReceiver, $this->mail['subject'], $this->mail['message'], implode("\r\n", $headers), '-fwebmaster@'.$this->fromDomain);
	}





	//*----------- TEST -----------*//
	function test(){

		$subject = 'ZERO SendMail, REF: '.mt_rand();

		$from = [
			'domain' => '',
			'user' => 'zero',
			'name' => 'ZERO™'
		];

		$to = [
			'email' => 'anthony@osawere.com',
			'name' => 'AO™'
		];

		$message = '<p>Hello <b>'.$to['name'].'</b>,<br><br>This is just an example mail triggered by ZERO powered software.</b><br>Please accept this mail as a confirmation that it works. We will never ask you to share this mail with anyone, but you can.<br><br><br>Kind Regards<br><b>'.$from['name'].'</b><br><i>Support Desk</i></p>';
		$mail = ['subject' => $subject, 'message' => $message];

		$this->initialize($from, $to, $mail);
		return $this->sendMail();
	}

} /*** End Of ~EmailX ***/