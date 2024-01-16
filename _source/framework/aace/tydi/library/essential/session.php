<?php
/* Session ~ Session Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License */

class Session {

	// * CALL • Trigger on non existing method
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}



	// * CLOSE • Close Session Write
	public function close() {
		return session_write_close();
	}



	// * STATUS • Session Status » Boolean
	public function status() {
		$status = session_status();
		if ($status == PHP_SESSION_DISABLED || $status == PHP_SESSION_NONE) {
			return false;
		} elseif ($status == PHP_SESSION_ACTIVE) {
			return true;
		}
	}



	// * ID • Session ID (Get/Set)
	public function id($id = '') {
		if (empty($id)) {
			return session_id();
		} else {
			// ~ NOTE: Call before session_start()
			$this->close();
			return session_id($id);
		}
	}



	//* NAME • Session Name (Get/Set)
	public function name($name = '') {
		if (empty($name)) {
			return session_name();
		} else {
			// ~ NOTE: Call before session_start()
			$this->close();
			return session_name($name);
		}
	}



	// * START • Start/Resume Session
	public function start($id = '') {
		if (!headers_sent()) {
			// ~ To Change Session ID
			if (!empty($id)) {
				$this->id($id);
			}

			if (!$this->status()) {
				return session_start();
			}
		}

		return false;
	}



	// * ROLLBACK •  rollback to last active session information
	public function rollback() {
		if ($this->status()) {
			return session_reset();
		}
		return false;
	}



	// * ABORT • Discard Changes (While maintaing session on current page)
	public function abort() {
		if ($this->status()) {
			return session_abort();
		}
		return false;
	}



	// * DESTROY • Destroy  (Data associated with the current session)
	public function destroy() {
		if ($this->status() === true) {
			return session_destroy();
		}
		return false;
	}



	// * TERMINATE • Terminate Session
	public function terminate() {
		if ($this->status() === true) {
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





	// ◇ ----- IS • Get/Set Session Value »
	public function is($var, $value = '', $id = '') {
		if (VarX::isNotEmpty($var)) {
			if (VarX::isNotEmpty($id)) {
				$this->start($id);
			}

			// * Set Session Value
			if (VarX::isNotEmpty($value)) {
				$_SESSION[$var] = $value;
				return true;
			}

			// * Get Session Value
			elseif (isset($_SESSION[$var])) {
				return $_SESSION[$var];
			}
		}

		return false;
	}





	// * VALUE • Session Value (Get $_SESSION['value'])
	public function value($i = '', $id = '') {
		if (!empty($id)) {
			return $this->is($i, '', $id);
		}
		return $this->is($i);
	}



	// * FRESH • Terminate & Start Fresh Session
	public function fresh($id = '', $newid = '') {
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



	// * EXPUNGE • Expunge Session (Unset Entire Session variable or a particular variable in session)
	public function expunge($i = '') {
		if ($this->status() === true) {
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

} // end of class ~ Session