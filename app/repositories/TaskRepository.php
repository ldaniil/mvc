<?php

namespace App\Repositories;

use App\Models\TaskModel;
use App\Models\Search\Criteria\TaskSearchCriteria;
use App\Models\Search\Order\TaskSearchOrder;
use Core\Pagination;

class TaskRepository
{
	/**
	 * @param TaskModel $task
	 * @param           $status
	 *
	 * @return TaskModel
	 */
	public function setStatus(TaskModel $task, $status) :TaskModel
	{
		$task->status = $status;
		$task->update();

		return $task;
	}

	/**
	 * @param TaskModel $task
	 *
	 * @return TaskModel
	 */
	public function update(TaskModel $task) :TaskModel
	{
		$task->update();

		return $task;
	}

	/**
	 * @param string $name
	 * @param string $email
	 * @param string $description
	 *
	 * @return TaskModel
	 * @throws \Exception
	 */
	public function create(string $name, string $email, string $description, $photoName = null) :TaskModel
	{
		$task = new TaskModel();

		$task->name = $name;
		$task->email = $email;
		$task->description = $description;

		if ($photoName) {
			$task->photo = $photoName;
		}

		if ($task->insert()) {
			return $task;
		}

		throw new \Exception('Task don\'t create');
	}

	/**
	 * @param $id
	 *
	 * @return \TaskModel|bool
	 */
	public function findById($id)
	{
		return (new TaskModel)
			->find($id);
	}

	/**
	 * @param TaskSearchCriteria $criteria
	 * @param TaskSearchOrder    $order
	 * @param                    $pagination
	 */
	public function findAll(TaskSearchCriteria $criteria, TaskSearchOrder $order, Pagination $pagination)
	{
		return (new TaskModel)
			->orderby($order->get())
			->limit($pagination->offset, $pagination->perpage)
			->findAll();
	}

	/**
	 * @param TaskSearchCriteria $criteria
	 *
	 * @return int
	 */
	public function findCount(TaskSearchCriteria $criteria) :int
	{
		$result = (new TaskModel())->select('COUNT(*) as count')->find();
		return $result->count;
	}
}
