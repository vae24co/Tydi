<?php //*** oJourneyLog » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Provider\Log;

use Zero\Provider\oProvider;
use Zero\Spry\oVariableX;
use Zero\Spry\oDataX;
use Zero\Spry\oClientX;

class oJourneyLog extends oProvider {

	// • ==== property
	protected $table = 'stat_journey';
	protected $fillable = [
		'puid', 'suid', 'tuid', 'author',
		'ouser', 'osession', 'oinitialization', 'title', 'module', 'action', 'description', 'route', 'ip'
	];





	// • ==== create → ... »
	public function create(array $input = []) {
		$input = oDataX::create($input);
		oVariableX::setIfNot($input['route'], app('request')->path());
		oVariableX::setIfNot($input['ip'], oClientX::ip());
		if (empty($input['title'])) {
			$title = '';
			if (isset($input['module'])) {
				$title .= ucwords($input['module']) . ' ';
			}
			if (isset($input['action'])) {
				$title .= ucwords($input['action']) . ' ';
			}
			$title = trim($title);
			$input['title'] = $title;
		}
		return parent::create($input);
	}

} //> end of oJourneyLog