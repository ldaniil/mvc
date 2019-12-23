<?php

namespace Core;

class Pagination
{
	public $page;

	public $perpage;

	public $offset;

	public $itemCount;

	protected $paginator;

	public function __construct($itemCount, $perpage)
	{
		$this->page = 1;
		$this->perpage = (int)$perpage;
		$this->itemCount = $itemCount;

		$this->paginator = new \Zebra_Pagination();
		$this->paginator->records($this->itemCount);
		$this->paginator->records_per_page($this->perpage);

		$this->page = $this->paginator->get_page();
		$this->offset = ($this->page - 1) * $this->perpage;
	}

	public function getPaginator()
	{
		return $this->paginator;
	}
}
