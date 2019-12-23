<?php

namespace App\Models;

use Core\Model;

class TaskModel extends Model
{
	const STATUS_NEW = 'new';

	const STATUS_COMPLETE = 'complete';

	public $table = 'task';

	public function __get($arrtibute) {
		if ($arrtibute == 'status_label') {
			if ($this->status == self::STATUS_COMPLETE)
			{
				return 'Выполнена';
			} else {
				return 'Новая';
			}
		}

		return parent::__get($arrtibute);
	}
}
