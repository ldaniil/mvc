@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form method="POST">
            <div class="form-group">
                <label for="exampleInputLogin">Логин</label>
                <input type="text" name="login" value="<?= $old['login'] ?>" class="form-control @if ($erros['login']) is-invalid @endif" id="exampleInputLogin" aria-describedby="emailHelp" placeholder="Введите логин">
                <div class="invalid-feedback"><?= $erros['login'] ?></div>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" name="password" class="form-control @if ($erros['password']) is-invalid @endif" id="exampleInputPassword1" placeholder="Введите пароль">
                <div class="invalid-feedback"><?= $erros['password'] ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
