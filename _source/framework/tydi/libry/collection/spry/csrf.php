<?php
//*** CSRFQ » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//
class CSRFQ {

	// ◇ property
	protected static $token;
	protected static $origin;
	protected static $maxRequests;
	protected static $timeWindow;
	protected static $databaseFile;




	// ◇ ==== construct →
	public function __construct() {
		self::tokenize();
	}




	// ◇ ==== tokenize → generate token
	public static function tokenize() {
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		self::$token = $_SESSION['csrf_token'];
	}




	// ◇ ==== token → return token
	public function token() {
		return self::$token;
	}




	// ◇ ==== verify → verify token
	public static function verifyToken($token) {
		return hash_equals(self::$token, $token);
	}




	// ◇ ==== verifyTokenPost → verify post token
	public static function verifyTokenPost() {
		$token = DataQ::isPost('csrf_token');
		return self::verifyToken($token);
	}




	// ◇ ==== verifyTokenGet → verify get token
	public static function verifyTokenGet() {
		$token = DataQ::isGet('csrf_token');
		return self::verifyToken($token);
	}




	// ◇ ==== verifyOrigin → verify origin
	public static function verifyOrigin() {
		$origin = $_SERVER['HTTP_ORIGIN'];
		if (Vars::hasData(self::$origin) && !empty($origin)) {
			return ($origin === self::$origin);
		}
		return false;
	}




	// ◇ ==== verifyReferrer → verify referrer headers
	public static function verifyReferrer($expectedReferrer = null) {
		$referrer = $_SERVER['HTTP_REFERER'];
		if (Vars::hasData($expectedReferrer) && !empty($referrer)) {
			return ($referrer === $expectedReferrer);
		} elseif (empty($expectedReferrer) && empty($referrer)) {
			return true;
		}
		return false;
	}




	// ◇ ==== validate → validate everything
	public static function validate($method, $referrer = null) {
		$isToken = false;
		if (strtoupper($method) === 'POST') {
			$isToken = self::verifyTokenPost();
		}
		if (strtoupper($method) === 'GET') {
			$isToken = self::verifyTokenGet();
		}
		$isOrigin = self::verifyOrigin();
		$isReferrer = self::verifyReferrer($referrer);
		if ($isToken && $isOrigin && $isReferrer) {
			return true;
		}
		return false;
	}




	// ◇ ==== setOrigin → set expected origin
	public static function setOrigin($origin) {
		if (Vars::hasData($origin)) {
			self::$origin = $origin;
			return true;
		}
		return false;
	}




	// ◇ ==== setLimiter → set rate limit
	public static function setLimiter($maxRequests = 15, $timeWindow = 60, $databaseFile = 'rate_limit.db') {
		if (Vars::hasData($maxRequests) && Vars::hasData($timeWindow) && Vars::hasData($databaseFile)) {
			self::$maxRequests = $maxRequests;
			self::$timeWindow = $timeWindow;
			self::$databaseFile = $databaseFile;
			return true;
		}
		return false;
	}




	// ◇ ==== limiter → request rate limit
	public static function limiter($header = true, $maxRequests = null, $timeWindow = null) {
		$ip = $_SERVER['REMOTE_ADDR'];

		if (!empty(self::$databaseFile)) {
			$databaseFile = ORIG['CLOUD'] . 'sqlite3' . DS;
			if (!FolderX::is($databaseFile)) {
				FolderX::Create($databaseFile);
			}
			$databaseFile .= self::$databaseFile;
		} else {
			OversightX('CSRF', 'Limiter :: Configuration Error');
		}
		$db = new SQLite3($databaseFile);
		$db->exec("CREATE TABLE IF NOT EXISTS limiter (ip TEXT PRIMARY KEY, tokens INTEGER, last_refill INTEGER)");

		$result = $db->query("SELECT tokens, last_refill FROM limiter WHERE ip = '$ip'");
		$row = $result->fetchArray(SQLITE3_ASSOC);

		if (!empty($maxRequests)) {
			$tokensPerInterval = $maxRequests;
		} else {
			$tokensPerInterval = self::$maxRequests;
		}

		if (!empty($timeWindow)) {
			$interval = $timeWindow; // in seconds
		} else {
			$interval = self::$timeWindow;
		}

		$tokens = $row ? $row['tokens'] : $tokensPerInterval;
		$lastRefillTime = $row ? $row['last_refill'] : time();

		$elapsedTime = time() - $lastRefillTime;
		$refillAmount = (int) ($elapsedTime / $interval);
		$tokens = min($tokens + $refillAmount, $tokensPerInterval);
		$lastRefillTime += $refillAmount * $interval;

		if ($row) {
			$db->exec("UPDATE limiter SET tokens = $tokens, last_refill = $lastRefillTime WHERE ip = '$ip'");
		} else {
			$db->exec("INSERT INTO limiter (ip, tokens, last_refill) VALUES ('$ip', $tokens, $lastRefillTime)");
		}

		$db->close();

		if ($tokens <= 0) {
			if ($header) {
				http_response_code(429);
				header('Content-Type: text/html; charset=utf-8');
				echo 'Rate limit exceeded. <br>Please try again later.';
				exit;
			}
			return true;
		}

		$tokens--;
		$db = new SQLite3($databaseFile);
		$db->exec("UPDATE limiter SET tokens = $tokens WHERE ip = '$ip'");
		$db->close();
		return false;
	}

} //> end of CSRFQ