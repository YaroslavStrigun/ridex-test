@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.setting.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label> Url callback для TelegramBot</label>
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-expanded="false">
                            Действие <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="document.getElementById('url_callback_bot')" value = {{ url('') }}>Вставить url</a></li>
                            <li><a href="#">Отрправить url</a></li>
                            <li><a href="#">Информация о настройке</a></li>
                        </ul>
                    </div>
                    <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{ $url_callback_bot ?? '' }}">
                </div>
            </div>
                <button class="btn btn-primary">Сохранить</button>
        </form>

    </div>
@endsection
