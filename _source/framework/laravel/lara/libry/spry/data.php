<?php //*** oDataX » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Spry;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class oDataX {

	// • ==== create → make data ready for insert » array
	public static function create(array $input = null) {
		$input['puid'] = $input['puid'] ?? Str::random(20);
		$input['suid'] = $input['suid'] ?? Str::random(40);
		$input['tuid'] = $input['tuid'] ?? Str::random(70);
		$input['author'] = $input['author'] ?? 'ZERO';

		// TODO: make input safe for insert

		return $input;
	}





	// • ==== collection → ... » collection
	public static function collection(Collection $collection, $index = '0') {
		if (is_numeric($index)) {
			return $collection[$index];
		}
		return $collection;
	}

} //> end of oDataX