@extends('layouts.app')

@section('content')
    <div class="col-md-6" style="padding-bottom:60px;">
        <h2>Редактирование задачи</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputName">Имя</label>
                <input type="text" name="name" value="{{ $task->name }}" class="form-control @if ($errors['name']) is-invalid @endif" id="exampleInputName" aria-describedby="nameHelp" placeholder="Ваше имя" disabled>
                <div class="invalid-feedback"><?= $errors['name'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Email</label>
                <input type="email" name="email" value="{{ $task->email }}" class="form-control @if ($errors['email']) is-invalid @endif" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Ваш email" disabled>
                <div class="invalid-feedback"><?= $errors['email'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputDescription">Текст</label>
                <textarea name="description" id="exampleInputDescription" class="form-control @if ($errors['description']) is-invalid @endif" placeholder="Описание задачи">{{ $task->description }}</textarea>
                <div class="invalid-feedback"><?= $errors['description'] ?></div>
            </div>
            @if ($auth->isAdministrator())
                <div class="form-group form-check">
                    <input type="checkbox" name="status" value="complete" class="form-check-input" id="exampleCheck1" @if ($task->status == 'complete') checked @endif>
                    <label class="form-check-label" for="exampleCheck1">Выполнена</label>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
