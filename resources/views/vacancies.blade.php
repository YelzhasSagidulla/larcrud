@extends('layouts.site')

@section('content')
<!-- ajax script-->
        <script type="text/javascript">
            //Show values for editmodal
            $(document).on('click','.edit_modal',function(){
                $(".js-ajax-php-json-update")[0].reset();
                var vacancy_id = $(this).val();
                $.get('http://localhost/vacancy/' + vacancy_id, function (dataForEdit){
                    console.log(dataForEdit);
                    $("#id").val(dataForEdit.id);
                    $("#name").val(dataForEdit.name);
                    $("#description").val(dataForEdit.description);
                    $("#contacts").val(dataForEdit.contacts);
                    $("#address").val(dataForEdit.address);
                })
            });
            //Show values for deletemodal
            $(document).on('click','.delete_modal',function(){
                var vacancy_id = $(this).val();
                $.get('http://localhost/vacancy/' + vacancy_id, function (dataForDelete){
                    console.log(dataForDelete);                    
                    $("#id").val(dataForDelete.id);
                    $("#name").val(dataForDelete.name);
                    $("#description").val(dataForDelete.description);
                    $("#contacts").val(dataForDelete.contacts);
                    $("#address").val(dataForDelete.address);
                })
            });
            //create
            $("document").ready(function(){              
              $(".js-ajax-php-json").submit(function(){
                var data = {
                };
                data = $(this).serialize() + "&" + $.param(data);                
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token2"]').attr('content')
                    }
                });
                $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "http://localhost/addvacancy", //Relative or absolute path to response.php file
                  data: data,
                  success: function(data) {
                    var vacancy = '<div id="vacancy'+data.id+'" class="col-lg-4">';
                    vacancy += '<h2>'+data.name+'</h2>';
                    vacancy += '<p>'+data.description+'</p>';
                    vacancy += '<p><button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal" content="{{ csrf_token() }}">Изменить</button>\n';
                    vacancy += '<button class="btn btn-danger delete_vacancy" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button></p>';
                    vacancy += '</div>';                                                          
                    $(".js-ajax-php-json")[0].reset();
                    $("#vacancies-list").append(vacancy);                    
                    $('#createModal').modal('hide');
                  }
                });
                return false;
              });              
            });
            //update
            $("document").ready(function(){              
              $(".js-ajax-php-json-update").submit(function(){
                var data = {
                };
                data = $(this).serialize() + "&" + $.param(data);                
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "http://localhost/editvacancy", //Relative or absolute path to response.php file
                  data: data,
                  success: function(data) {                        
                    var vacancy = '<div id="vacancy'+data.id+'" class="col-lg-4">';
                    vacancy += '<h2>'+data.name+'</h2>';
                    vacancy += '<p>'+data.description+'</p>';
                    vacancy += '<p><button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal">Изменить</button>\n';
                    vacancy += '<button class="btn btn-danger delete_vacancy" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button></p>';
                    vacancy += '</div>';                    
                    $(".js-ajax-php-json-update")[0].reset();                    
                    //$("updateModal").hide();
                    $("#vacancy" + data.id).replaceWith( vacancy );
                    $('#updateModal').modal('hide');
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }       
                });
                return false;
              });              
            });
            //delete
            $(document).on('click','.delete_vacancy',function(){
                var vacancy_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "DELETE",
                    url: 'http://localhost/deletevacancy/' + vacancy_id,
                    success: function (data) {
                        $("#vacancy" + vacancy_id).remove();
                        console.log(data);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        </script>
<!-- ajax script -->

<div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <br>
        <h3 class="text-muted"></h3>
        <nav>
          <ul class="nav nav-justified">
            <li><a href="{{route('main')}}">Главная</a></li>
            <li class="active"><a>Вакансии</a></li>
            <li><a href="{{route('rubrics')}}">Рубрики</a></li>
            <li><a href="{{route('rezume')}}">Резюме</a></li>
            <li><a href="{{route('specialty')}}">Специальности</a></li>
            <li><a href="{{route('companyvacancies')}}">Работа в компаниях</a></li>
          </ul>
        </nav>
      </div>
      <br>
      @if(isset($_SESSION['user']))
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#createModal">Добавить вакансию</a>
      @endif
      <div class="row" id="vacancies-list">
          @foreach($vacancies as $vacancy)
            <div id="vacancy{{$vacancy->id}}" class="col-lg-4">
              <h2>{{$vacancy->name}}</h2>
              <p>{{$vacancy->description}}</p>
              @if(isset($_SESSION['user']))
                <p><button class="btn btn-info edit_modal" data-toggle="modal" value="{{$vacancy->id}}" data-target="#updateModal">Изменить</button>
                  <button class="btn btn-danger delete_vacancy" data-toggle="modal" value="{{$vacancy->id}}" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button></p>
              @else
                <p><a class="btn btn-info" href="#" role="button">Подробнее</a></p>
              @endif
            </div>
          @endforeach
      </div>            
      <!-- Модальное окно добавить -->
<div class="modal fade" hidden="true" id="createModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-filled">
                <div class="panel-body">
                    <form class="js-ajax-php-json" action="http://localhost/addvacancy" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Добавить вакансию</h4><br>
                        <div class="createRez"></div>
                        <div class="form-group">
                            <input class="form-control" name="name"
                            placeholder="Введите название" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" name="description"
                            placeholder="Введите описание" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" name="contacts"
                            placeholder="Введите номер" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" name="address"
                            placeholder="Введите адрес" required="" type="text">
                        </div>
                        
                        <div class="form-group" id="login-errors">
                            <span class="help-block"><strong id="form-login-errors"></strong></span>
                        </div>
                        {{csrf_field()}}
                        <div>
                            <button class="btn btn-login right" content="{{ csrf_token() }}" name="csrf-token">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- Модальное окно добавить -->
      <!-- Модальное окно изменить -->
<div class="modal fade" hidden="true" id="updateModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-filled">
                <div class="panel-body">
                    <form class="js-ajax-php-json-update" action="http://localhost/editvacancy" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Изменить вакансию</h4><br>
                        <div class="editRez"></div>
                        <input type="hidden" id="id" name="id" value="0">
                        <div class="form-group">
                            <input class="form-control" id="name" name="name"
                            placeholder="Введите название" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" id="description" name="description"
                            placeholder="Введите описание" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" id="contacts" name="contacts"
                            placeholder="Введите номер" required="" type="text">
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" id="address" name="address"
                            placeholder="Введите адрес" required="" type="text">
                        </div>
                        
                        <div class="form-group" id="login-errors">
                            <span class="help-block"><strong id="form-login-errors"></strong></span>
                        </div>
                        {{csrf_field()}}
                        <div>
                            <button class="btn btn-login right" id="btn-save" content="{{ csrf_token() }}" name="csrf-token2">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- Модальное окно изменить -->
      <div class="the-return"></div>

    <script src="js/ie10-viewport-bug-workaround.js"></script>
@endsection    