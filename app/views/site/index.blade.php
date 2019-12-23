<?php

use Core\Model\Search\Order;

?>

@extends('layouts.app')

@section('content')
    @if ($tasks)
        <div class="col-md-12">
            <h2>Задачи</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Фото</th>
                        <th scope="col"><a href="/?order_by=name&order_sort=<?= $order->getCurrentAttribute() == 'name' ? $order->getOpositeSort() :  $order->getDefaultAttributeSort('name') ?>">Имя</a></th>
                        <th scope="col"><a href="/?order_by=email&order_sort=<?= $order->getCurrentAttribute() == 'email' ? $order->getOpositeSort() :  $order->getDefaultAttributeSort('email') ?>">Email</a></th>
                        <th scope="col">Описание</th>
                        <th scope="col"><a href="/?order_by=status&order_sort=<?= $order->getCurrentAttribute() == 'status' ? $order->getOpositeSort() :  $order->getDefaultAttributeSort('status') ?>">Статус</a></th>
                        @if ($auth->isAdministrator())
                            <th scope="col"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <th scope="row">{{ $task->id }}</th>
                            <td>
                                @if ($task->photo)
                                    <img src="/uploads/{{ $task->photo }}">
                                @endif
                            </td>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->email }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->status_label }}</td>
                            <td>
                                @if ($auth->isAdministrator())
                                    <a href="/update?id={{ $task->id }}">Редактировать</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <?= $pagination->getPaginator()->render() ?>
        </div>
    @endif
    <div class="col-md-6" style="padding-bottom:60px;">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputName">Имя</label>
                <input type="text" name="name" class="form-control @if ($errors['name']) is-invalid @endif" id="exampleInputName" aria-describedby="nameHelp" placeholder="Ваше имя">
                <div class="invalid-feedback"><?= $errors['name'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Email</label>
                <input type="email" name="email" class="form-control @if ($errors['email']) is-invalid @endif" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Ваш email">
                <div class="invalid-feedback"><?= $errors['email'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputDescription">Текст</label>
                <textarea name="description" id="exampleInputDescription" class="form-control @if ($errors['description']) is-invalid @endif" placeholder="Описание задачи"></textarea>
                <div class="invalid-feedback"><?= $errors['description'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Картинка</label>
                <input type="file" name="photo" id="exampleInputFile">
                @if ($errors['photo'])
                    <div class="invalid-feedback" style="display:block;"><?= $errors['photo'] ?></div>
                @endif
            </div>
            @if ($auth->isAdministrator())
                <div class="form-group form-check">
                    <input type="checkbox" name="status" value="complete" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Выполнена</label>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Добавить</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#preview" onclick="return false;">Предварительный просмотр</button>
        </form>
    </div>
    <div id="preview" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Предпросмотр</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    Имя: <span id="preview-name"></span>
                                </div>
                                <div class="col-md-6">
                                    Email: <span id="preview-email"></span>
                                </div>
                            </div>
                            <p id="preview-description">Modal body text goes here.</p>
                        </div>
                        <div class="col-md-6" id="preview-image-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#preview').on("show.bs.modal", function (e) {
            $("#preview-name").text($("#exampleInputName").val());
            $("#preview-email").text($("#exampleInputEmail").val());
            $("#preview-description").text($("#exampleInputDescription").val());
        })

        $("#exampleInputFile").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#preview-image-container").html("<img src='" + e.target.result + "' style='width:320px;height:240px;' />");
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

    </script>
@endsection
