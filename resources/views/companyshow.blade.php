@extends('layouts.site')

@section('content')

<div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <br>
        <h3 class="text-muted"></h3>
        <nav>
          <ul class="nav nav-justified">
            <li><a href="{{route('main')}}">Главная</a></li>
            <li><a href="{{route('vacancy')}}">Вакансии</a></li>
            <li><a href="{{route('rubrics')}}">Рубрики</a></li>
            <li><a href="{{route('rezume')}}">Резюме</a></li>
            <li><a href="{{route('specialty')}}">Специальности</a></li>
            <li><a href="{{route('companyvacancies')}}">Работа в компаниях</a></li>
          </ul>
        </nav>
      </div>
      <br>
      <div class="row" id="vacancies-list">
          @foreach($companyvacancies as $vacancy)
            <div id="vacancy{{$vacancy->id}}" class="col-lg-offset-1">
              <h2>{{$company_name}} | {{$vacancy->title}}</h2>
              <p>{{$vacancy->description}}</p>
              <button class="btn btn-default btn-info">Посмотреть вакансию</button>
            </div>
          @endforeach
      </div>            
      <div class="the-return"></div>

    <script src="js/ie10-viewport-bug-workaround.js"></script>
@endsection    