<?php //*** oControllerAPI » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Controller;

use App\Http\Controllers\Controller;
use Zero\Spry\oInputX;
use Zero\Spry\oAPIResponseX;
use Zero\Spry\oAPIValidateX;
use Zero\Service\oAuthService;
use Zero\Service\oSessionService;

class oControllerAPI extends Controller {

	// • ==== property
	protected $bearerToken;
	protected $sessionToken;





	// • ==== grabTokens → ... »
	protected function grabToken() {
		$this->bearerToken = oInputX::bearerToken('HEADER');
		$this->sessionToken = oInputX::sessionToken('HEADER');
		return;
	}





	// • ==== evaluate → ... »
	protected function evaluate(){
		return (new oAPIValidateX());
	}





	// • ==== response → ... »
	protected function response(){
		return (new oAPIResponseX());
	}





	// • ==== session → ... »
	protected function session(){
		return (new oSessionService());
	}





	// • ==== auth → ... »
	protected function auth(){
		return (new oAuthService());
	}


} //> end of oControllerAPI