<?php

namespace Core\Model\Search;

class Order
{
	const SORT_ASC = 'asc';

	const SORT_DESC = 'desc';

	public $id;

	public $defaultAttribute= 'id';

	public $defaultSort = self::SORT_ASC;

	protected $attribute;

	protected $attributes = [];

	protected $sort;

	public function __construct($attribute = 'id', $sort = self::SORT_ASC)
	{
		$this->attribute = array_key_exists($attribute, $this->attributes) ? $attribute : $this->defaultAttribute;

		$this->sort = in_array($sort, [self::SORT_ASC, self::SORT_DESC]) ? $sort : $this->defaultSort;
	}

	/**
	 * @return string
	 */
	public function get() :string
	{
		return $this->getCurrentAttribute() . ' ' . $this->getCurrentSort();
	}

	/**
	 * @return string
	 */
	public function getCurrentAttribute() :string
	{
		return $this->attribute;
	}

	/**
	 * @return string
	 */
	public function getCurrentSort() :string
	{
		return $this->sort;
	}

	/**
	 * @param $attribute
	 *
	 * @return string
	 */
	public function getDefaultAttributeSort($attribute) :string
	{
		return array_key_exists($attribute, $this->attributes) ? $this->attributes[$attribute] : self::SORT_ASC;
	}

	public function getOpositeSort()
	{
		return $this->sort == self::SORT_ASC ? self::SORT_DESC : self::SORT_ASC;
	}
}
