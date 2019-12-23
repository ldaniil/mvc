<?php

namespace Core\Form;

interface InterfaceForm
{
	public function validate() :bool;

	public function rules() :array;

	public function errors(): array;
}
