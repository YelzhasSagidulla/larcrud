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
            <li class="active"><a>Работа в компаниях</a></li>
          </ul>
        </nav>
      </div>
      <br>
      <h2>Работа по компаниям</h2>
      <div class="row" id="vacancies-list">
          @foreach($companynames as $companyname)
          <a href="{{ route('companyshow',['company_name'=>$companyname->name]) }}">
            <div id="" class="col-lg-4">
              <h2> 
                @foreach($companyvacancies2 as $vacancy)
                    @if($vacancy->id==$companyname->id)
                        {{$companyname->name}} ({{$vacancy->child_count}})
                    @endif
                @endforeach</h2>              
            </div>
          </a>
          @endforeach
      </div>             
      <div class="the-return"></div>

    <script src="js/ie10-viewport-bug-workaround.js"></script>
@endsection    