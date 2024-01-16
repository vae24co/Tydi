<?php
/*** SentenceQ ~ Sentence Class » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © January 2023 | Apache License ***/

class SentenceQ {

	// ◇ ----- CALL • Non-Existent Method » Error
	public function __call($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- CALL_STATIC • Non-Existent Static Method » Error
	public static function __callStatic($method, $argument) {
		return ErrorX::is(__CLASS__, 'Method Unreachable', $method);
	}





	// ◇ ----- RECORD •
	public static function record($data, $action, $label = 'record') {

		// > Count
		$count = DataQ::countRow($data);

		// > String for Count
		if ($count === 0) {
			$countString = 'no';
		} elseif ($count == 1) {
			$countString = 'one';
		} elseif ($count > 1) {
			$countString = $count;
		}

		// * Message
		if ($count < 1) {
			$title = 'Not ' . ucwords($action);
			$message = ucwords($countString) . ' ' . FormatQ::pluralize($count, 'record') . ' ' . $action;
		} else {
			$title = 'Record ' . ucwords($action);
			$message = 'You ' . $action . ' ' . $countString . ' ' . FormatQ::pluralize($count, 'record');
		}

		// ... Return
		return ['title' => $title, 'message' => $message, 'count' => $count, 'data' => $data];
	}

} // End Of Class ~ SentenceQ