<?php
//*** Session » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class Session {

	// ◇ ==== call → handler - undefined method » [error]
	public function __call($method, $argument) {
		return OversightX(__CLASS__, 'method unreachable', $method);
	}




	// ◇ ==== callStatic → handler - undefined static method » [error]
	public static function __callStatic($method, $argument) {
		return OversightX(__CLASS__, 'static method unreachable', $method);
	}




	// ◇ ==== getStatus →
	public function getStatus() {
		return session_status();
	}



	// ◇ ==== getID →
	public function getID() {
		return session_id();
	}




	// ◇ ==== getName →
	public function getName() {
		return session_name();
	}




	// ◇ ==== setID →
	public function setID($id) {
		// @NOTE: must call before session_start()
		$this->close();
		return session_id($id);
	}




	// ◇ ==== setName →
	public function setName($name) {
		// @NOTE: must call before session_start()
		$this->close();
		return session_name($name);
	}




	// ◇ ==== isActive →
	public function isActive() {
		$status = $this->getStatus();
		if ($status == PHP_SESSION_DISABLED || $status == PHP_SESSION_NONE) {
			return false;
		} elseif ($status == PHP_SESSION_ACTIVE) {
			return true;
		}
	}




	// ◇ ==== start → start/resume session
	public function start($id = null) {
		if (!headers_sent()) {
			if (!empty($id)) {
				$this->id($id);
			}
			if (!$this->isActive()) {
				return session_start();
			}
		}
		return false;
	}




	// ◇ ==== setVar → set session variable
	public function setVar($var, $value, $id = null) {
		$this->start($id);
		$_SESSION[$var] = $value;
		return true;
	}




	// ◇ ==== getVar → get session variable
	public function getVar($var, $id = null) {
		$this->start($id);
		if (isset($_SESSION[$var])) {
			return $_SESSION[$var];
		}
		return null;
	}




	// ◇ ==== isValue → check session variable's value
	public function isValue($var, $value, $strict = false, $id = null) {
		$this->start($id);
		if (isset($_SESSION[$var])) {
			if ($strict && $_SESSION[$var] === $value) {
				return true;
			} elseif (!$strict && $_SESSION[$var] == $value) {
				return true;
			}
		}
		return false;
	}




	// ◇ ==== rollback →  rollback to last active session information
	public function rollback() {
		if ($this->isActive()) {
			return session_reset();
		}
		return false;
	}




	// ◇ ==== close → close session write
	public function close() {
		return session_write_close();
	}




	// ◇ ==== abort → discard changes (while maintaining session on current page)
	public function abort() {
		if ($this->isActive()) {
			return session_abort();
		}
		return false;
	}




	// ◇ ==== destroy → destroy  (data associated with the current session)
	public function destroy() {
		if ($this->isActive() === true) {
			return session_destroy();
		}
		return false;
	}




	// ◇ ==== terminate →
	public function terminate() {
		if ($this->isActive() === true) {
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
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




	// ◇ ==== fresh → terminate & start fresh session
	public function fresh($id = null, $newid = null) {
		if (!empty($id)) {
			$this->start($id);
			$this->terminate();
			if (!empty($newid)) {
				return $this->start($newid);
			}
			return $this->start($id);
		} elseif (!empty($newid)) {
			$this->start();
			$this->terminate();
			return $this->start($newid);
		} else {
			$this->start();
			$this->terminate();
			return $this->start();
		}
	}




	// ◇ ==== expunge → expunge session (unset entire session variable or a particular variable in session)
	public function expunge($i = null) {
		if ($this->isActive() === true) {
			if (!empty($i)) {
				if (!empty($this->get($i))) {
					unset($_SESSION[$i]);
					return true;
				}
			} else {
				unset($_SESSION);
				session_unset();
				return true;
			}
		}
		return false;
	}

} //> end of Session