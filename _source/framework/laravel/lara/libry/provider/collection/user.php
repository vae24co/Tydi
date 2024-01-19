<?php //*** oUserCollection » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Provider\Collection;

use Zero\Provider\oProvider;
use Zero\Spry\oDebugX;

class oUserCollection extends oProvider {

	// • ==== property
	protected $table = 'ouser';
	protected $fillable = [
		'puid', 'suid', 'tuid', 'author',
		'osession', 'oinitialization', 'name', 'username', 'phone', 'email',
		'password', 'pin', 'dob', 'gender', 'nationality', 'location', 'ref',
		'type', 'status', 'sessions', 'lastseen'
	];





	// • ==== session → ... »
	public function sessions() {
		return $this->hasMany(oSessionCollection::class, 'osession', 'puid');
	}





	// • ==== initialization → ... »
	public function initializations() {
		return $this->hasMany(oSessionCollection::class, 'oinitialization', 'puid');
	}





	// // • ==== findUserBySession → ... »
	// public function findUserBySession($sessionToken) {

	// 	// $o = $this->sessions()->where('token', '=', $sessionToken)->first();
	// 	$o = $this->sessions()->find(1);
	// 	oDebugX::exit($o);

	// }




	// • ==== findUserByBearer → ... »
	// public function findUserByBearer($bearerToken) {
	// }

} //> end of oUserCollection