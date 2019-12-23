<?php

namespace App\Models\Search\Order;

use Core\Model\Search\Order;

class TaskSearchOrder extends Order
{
	protected $attributes = [
		'name' => self::SORT_ASC,
		'email' => self::SORT_ASC,
		'status' => self::SORT_DESC,
	];
}
