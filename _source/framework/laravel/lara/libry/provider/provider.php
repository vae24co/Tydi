<?php //*** oProvider » Tydi™ Framework © 2023 ∞ AO™ • @iamodao • www.osawere.com ∞ Apache License ***//

namespace Zero\Provider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Zero\Zero;

class oProvider extends Model {

	use HasFactory;

	// • ==== property
	protected $connection;
	protected $table;
	protected $fillable = [];
	protected $primaryKey = 'auid';

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';





	// • ==== construct → handled » error
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$connectionName = Zero::getProperty('connectionName');
		if (!empty($connectionName)) {
			$this->setConnection($connectionName);
		}
	}

} //> end of oProvider