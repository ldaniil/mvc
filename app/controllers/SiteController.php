<?php

namespace App\Controllers;

use App\Forms\TaskForm;
use App\Forms\TaskUpdateForm;
use App\Models\Search\Criteria\TaskSearchCriteria;
use App\Models\Search\Order\TaskSearchOrder;
use App\Repositories\TaskRepository;
use Core\Controller;
use App\Services\TaskService;
use Core\Pagination;
use Core\Exception\ValidateException;

class SiteController extends Controller
{
	public function index()
	{
		$repository = new TaskRepository();

		$criteria = new TaskSearchCriteria();
		$order = new TaskSearchOrder($this->request->get('order_by', 'id'), $this->request->get('order_sort', TaskSearchOrder::SORT_DESC));

		$count = $repository->findCount($criteria);
		$pagination = new Pagination($count, 3);

		$tasks = $repository->findAll($criteria, $order, $pagination);

		return $this->render('site/index', [
			'tasks' => $tasks,
			'order' => $order,
			'pagination' => $pagination
		]);
	}

	public function createTask()
	{
		$taskForm = new TaskForm();
		$taskForm->load($this->request->request->all());
		$taskForm->photo = $_FILES['photo'];

		try {
			$taskService = new TaskService;
			$taskService->createFromForm($taskForm);

			$this->redirect('/', ['success' => 'Новая задача добавлена!']);
		} catch (ValidateException $e) {
			$this->redirect('/', ['errors' => $taskForm->errors()]);
		}
	}

	public function taskForm()
	{
		$id = $this->request->get('id');

		if ($id && $this->auth->isAdministrator()) {
			$repository = new TaskRepository();

			if ($task = $repository->findById($id)) {
				return $this->render('site/task_form', ['task' => $task]);
			}
		}

		return $this->redirect('/');
	}

	public function updateTask()
	{
		$id = $this->request->get('id');

		if ($id && $this->auth->isAdministrator()) {
			$repository = new TaskRepository();

			if ($task = $repository->findById($id)) {
				$taskForm = new TaskUpdateForm();
				$taskForm->load($this->request->request->all());

				try {
					$taskService = new TaskService;
					$taskService->updateFromForm($task, $taskForm);

					$this->redirect('/', ['success' => 'Задача сохранена!']);
				} catch (ValidateException $e) {
					return $this->redirect('/update?id=' . $task->id, ['errors' => $taskForm->errors()]);
				}
			}
		}

		return $this->redirect('/');
	}
}
