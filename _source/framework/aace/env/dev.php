<?php
/*** Dev ~ Development Machine » alpha-0.0.23 • Tydi™ Framework → AO™ / @iamodao / www.osawere.com - © 2023 | Apache License ***/

if (VarX::hasData($base)) {
	$fusion = 'fusion.php';

	// ~ Staging
	$domain['odao'] = 'odao.co';
	$domain['aace'] = 'aace.co';


	// ~ Fusion::AACE
	if (StringX::in($base->domain, 'aace.' . $domain['odao'])) {
		$fusion = SD . 'aace' . DS . $fusion;
		$initialize['ario'] = URL::protocol() . '://aace.' . $domain['odao'] . '/ario';
	} elseif (StringX::end($base->domain, $domain['aace'])) {
		$fusion = SD . 'aace' . DS . $fusion;
		$initialize['ario'] = URL::protocol() . '://ario.'.$domain['aace'];
	}
}