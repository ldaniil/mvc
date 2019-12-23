<?php

namespace App\Services;

use App\Forms\TaskForm;
use App\Forms\TaskUpdateForm;
use App\Models\php;
use App\Models\TaskModel;
use App\Repositories\TaskRepository;
use Core\Application;
use Core\Exception\ValidateException;
use Gumlet\ImageResize;

class TaskService
{
	CONST MAX_PHOTO_WIDTH = '320';

	CONST MAX_PHOTO_HEIGHT = '240';

	/**
	 * @param TaskForm $form
	 *
	 * @return php
	 * @throws ValidateException
	 */
	public function createFromForm(TaskForm $form) :TaskModel
	{
		if ($form->validate()) {
			$photoName = null;

			if ($form->photo && $form->photo['error'] == 0) {
				$photo = new ImageResize($form->photo['tmp_name']);

				if ($photo->getSourceWidth() > self::MAX_PHOTO_WIDTH || $photo->getDestHeight() > self::MAX_PHOTO_HEIGHT) {
					$photo->resizeToBestFit( self::MAX_PHOTO_WIDTH, self::MAX_PHOTO_HEIGHT );
				}

				$extensions = [
					IMAGETYPE_GIF => 'gif',
					IMAGETYPE_JPEG => 'jpg',
					IMAGETYPE_PNG => 'png'
				];

				$photoName = md5(microtime()) . '.' . $extensions[$photo->source_type];
				$photo->save($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $photoName);
			}

			$taskRepository = new TaskRepository();
			$task = $taskRepository->create($form->name, $form->email, $form->description, $photoName);

			if ($form->status && Application::getInstance()->getAuth()->isAdministrator()) {
				$taskRepository->setStatus($task, $form->status);
			}

			return $task;
		}

		throw new ValidateException();
	}

	public function updateFromForm(TaskModel $task, TaskUpdateForm $form) :TaskModel
	{
		if ($form->validate() ) {
			$task->description = $form->description;
			$task->status = $form->status ?? TaskModel::STATUS_NEW;

			$taskRepository = new TaskRepository();
			return $taskRepository->update($task);
		}

		throw new ValidateException();
	}
}
