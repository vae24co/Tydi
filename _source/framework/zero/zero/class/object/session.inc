<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* oSession ~ Session Utility • VERSION » alpha-0.0.1 ***/

class oSession {

	#CALL •
	public function __call($method, $argument){
		$error['code'] = 'CE501SE';
		$error['object'] = __CLASS__.' » '.$method.'()';
		$error['extra'] = __FILE__;
		$error['summary'] = 'Method Unreachable ~ '.$argument;
		return oErrorX($error);
	}


	#CLOSE • Close session write
	public function close(){
		return session_write_close();
	}


	#STATUS • PHP Session Status
	public function status(){
		$o = session_status();
		if($o == PHP_SESSION_DISABLED || $o == PHP_SESSION_NONE){
			return false;
		}
		elseif($o == PHP_SESSION_ACTIVE){
			return true;
		}
	}


	#ID • Get/Set SESSION ID
	public function id($id=''){
		if(empty($id)){return session_id();}
		else {
			//* NOTE: must call before session_start()
			$this->close();
			return session_id($id);
		}
	}


	#NAME • Get/Set SESSION NAME
	public function name($name=''){
		if(empty($name)){return session_name();}
		else {
			//* NOTE: must call before session_start()
			$this->close();
			return session_name($name);
		}
	}


	#START • Start/Resume PHP Session
	public function start($id=''){
		if(!headers_sent()){
			if(!empty($id)){$this->id($id);} #change session id
			if(!$this->status()){return session_start();}
		}
		return false;
	}


	#ROLLBACK •  rollback to last active session information
	public function rollback(){
		if($this->status()){return session_reset();}
		return false;
	}


	#DESTROY • destroys all data associated with the current session
	public function destroy(){
		if($this->status() === true){
			return session_destroy();
		}
		return false;
	}


	#TERMINATE • Terminate php session
	public function terminate(){
		if($this->status() === true){
			$_SESSION = array();
			if(ini_get("session.use_cookies")){
				$params = session_get_cookie_params();
				setcookie(
					session_id(),
					'',
					time() - 42000,
					$params["path"],
					$params["domain"],
					$params["secure"],
					$params["httponly"]
				);
			}
			session_unset();
			session_destroy();
			return true;
		}
		return false;
	}


	#FRESH • Terminate & start fresh php session
	public function fresh($id='', $newid=''){
		if(!empty($id)){
			$this->start($id);
			$this->terminate();
			if(!empty($newid)){
				return $this->start($newid);
			}
			return $this->start($id);
		}
		elseif(!empty($newid)){
			$this->start();
			$this->terminate();
			return $this->start($newid);
		}
		else {
			$this->start();
			$this->terminate();
			return $this->start();
		}
	}


	#ABORT • maintain session yet discard session changes on current page
	public function abort(){
		if($this->status()){return session_abort();}
		return false;
	}


	#IS • Get/Set SESSION VALUE - $_SESSION['value']
	public function is($i='', $v='', $id=''){
		if(!empty($i)){
			if(!empty($id)){$this->start($id);}
			if(!empty($v)){$_SESSION[$i] = $v; return true;} #set session value
			elseif(isset($_SESSION[$i])){return $_SESSION[$i];}
			return false;
		}
		else {
			#TODO ~ trigger HALT error
		}
	}


	#GET • Get SESSION VALUE - $_SESSION['value']
	public function get($i='', $id=''){
		if(!empty($id)){return $this->is($i, '', $id);}
		return $this->is($i);
	}


	#EXPONGE • unset entire session variable or a particular variable in session's
	public function exponge($i=''){
		if($this->status() === true){
			if(!empty($i)){
				if(!empty($this->get($i))){
					unset($_SESSION[$i]);
					return true;
				}
			}
			else {
				unset($_SESSION);
				session_unset();
				return true;
			}
		}
		return false;
	}

} /*** End Of ~oSession ***/