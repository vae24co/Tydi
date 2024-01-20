<?php //*** oCollectionX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Collection;

class oCollectionX {

	// • ==== toArray → ... »
	public static function toArray($collection) {
		$data = $collection->toArray();
		if (oArrayX::isMultiWithOne($data)) {
			return $data[0];
		}
		return $data;
	}





	// • ==== isOkay → handle checks for collection - model » boolean
	public static function isOkay($result) {
		if (is_numeric($result)) {
			if ($result > 0) {
				return true;
			}
		} elseif ($result !== null && $result !== false) {
			return true;
		} elseif ($result instanceof Collection) {
			if ($result->isNotEmpty()) {
				return true;
			}
		}
		return false;
	}



} //> end of oCollectionX