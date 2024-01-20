<?php //*** oInitializationCollection » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Provider\Collection;

use Zero\Provider\oProvider;
use Zero\Spry\oVariableX;
use Zero\Spry\oRandomX;
use Zero\Spry\oDataX;
use Zero\Spry\oClientX;
use Zero\Spry\oCollectionX;

class oInitializationCollection extends oProvider {

	// • ==== property
	protected $table = 'oinitialization';
	protected $fillable = [
		'puid', 'suid', 'tuid', 'author',
		'ouser', 'token', 'ip', 'isp', 'agent', 'os', 'device', 'api', 'app', 'status'
	];





	// • ==== session → ... »
	public function sessions() {
		return $this->hasMany(oSessionCollection::class, 'oinitialization', 'puid');
	}





	// • ==== user → ... »
	public function user() {
		return $this->belongsTo(oUserCollection::class, 'ouser', 'puid');
	}





	// • ==== create → ... »
	public function create(array $input = []) {
		$input = oDataX::create($input);
		oVariableX::setIfNot($input['token'], oRandomX::token());
		oVariableX::setIfNot($input['ip'], oClientX::ip());
		oVariableX::setIfNot($input['isp'], oClientX::isp($input['ip']));
		return parent::create($input);
	}





	// • ==== isToken → ... »
	public function isToken($token) {
		return parent::where('token', '=', $token)->exists();
	}





	// • ==== isTokenValid → ... » boolean
	public function isTokenValid($token) {
		$status = parent::where('token', '=', $token)->value('status');
		if(oCollectionX::isOkay($status)){
			if($status === 'INITIALIZED' || $status === 'AUTHENTICATED'){
				return true;
			}
		}
		return false;
	}





	// • ==== findByToken → ... »
	public function findByToken($token) {
		return parent::where('token', '=', $token)->first();
	}





	// • ==== findTokenByToken → ... »
	public function findTokenByToken($token) {
		return parent::where('token', '=', $token)->value('token');
	}





	// • ==== findStatusByToken → ... »
	public function findStatusByToken($token) {
		return parent::where('token', '=', $token)->value('status');
	}

} //> end of oInitializationCollection