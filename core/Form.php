<?php

namespace Core;

use Core\Form\InterfaceForm;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

abstract class Form implements InterfaceForm
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var Validation
	 */
	protected $validation;

	/**
	 * @var bool
	 */
	protected $hasErrors = false;

	/**
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Form constructor.
	 */
	public function __construct()
	{
		$this->validator = new Validator();
	}

	/**
	 * @param array $data
	 */
	public function load(array $data)
	{
		foreach ($data as $name => $value) {
			if (array_key_exists($name, $this->attributes())) {
				$this->$name = $value;
			}
		}
	}

	/**
	 * @return array
	 */
	public function attributes() :array
	{
		$attributes = [];

		$protepties = ((new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC));

		foreach ($protepties as $property) {
			$propertyName = $property->name;
			$attributes[$propertyName] = $this->$propertyName;
		}

		return $attributes;
	}

	/**
	 * @return bool
	 */
	public function validate() :bool
	{
		$this->validation = $this->validator->validate($this->attributes(), $this->rules());
		$this->hasErrors = $this->validation->fails();

		return !$this->hasErrors;
	}

	public function addError($attribute, $error)
	{
		$this->hasErrors = true;
		$this->errors[$attribute] = $error;
	}

	/**
	 * @return array
	 */
	public function errors(): array
	{
		if ($this->hasErrors) {
			return array_merge($this->validation->errors()->firstOfAll(), $this->errors);
		}

		return [];
	}
}
