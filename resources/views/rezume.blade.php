@extends('layouts.site')

@section('content')
<!-- ajax script-->
        <script type="text/javascript">                        
            //data for update
            $(document).on('click','.edit_modal',function(){
                $(".js-ajax-php-json-update")[0].reset();
                var rezume_id = $(this).val();
                $.get('http://localhost/rezume/' + rezume_id, function (dataForEdit){
                    console.log(dataForEdit);
                    $("#id").val(dataForEdit.id);
                    $("#jobname").val(dataForEdit.jobname);
                    $("#vacancy").val(dataForEdit.vacancy);
                    $("#experience").val(dataForEdit.experience);
                    $("#fullname").val(dataForEdit.fullname);
                    $("#educationlevel").val(dataForEdit.educationlevel);
                    $("#educationname").val(dataForEdit.educationname);
                    $("#skills").val(dataForEdit.skills);
                    $("#contacts").val(dataForEdit.contacts);
                });
            });
            //create
            $("document").ready(function(){              
              $(".js-ajax-php-json-create").submit(function(){
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
                  url: "http://localhost/addrezume", 
                  data: data,
                  success: function(data) {         
                    var rezume = '<li id="rezume'+data.id+'">';
                    rezume+='<h3>'+data.jobname+'</h3>\n';
                    rezume+='<button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal">Изменить</button>\n';
                    rezume+='<button class="btn btn-danger delete_rezume" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>\n';
                    rezume+='</li>';                                                                     
                    $(".js-ajax-php-json-create")[0].reset();
                    $("#rezumes-list").append(rezume);                    
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
                  url: "http://localhost/editrezume",
                  data: data,
                  success: function(data) {                        
                    var rezume = '<li id="rezume'+data.id+'">';
                    rezume+='<h3>'+data.jobname+'</h3>\n';
                    rezume+='<button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal">Изменить</button>\n';
                    rezume+='<button class="btn btn-danger delete_rezume" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>\n';
                    rezume+='</li>';                                                                     
                    $(".js-ajax-php-json-update")[0].reset();                    
                    $("#rezume" + data.id).replaceWith( rezume );
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
            $(document).on('click','.delete_rezume',function(){
                var rezume_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "DELETE",
                    url: 'http://localhost/deleterezume/' + rezume_id,
                    success: function (data) {
                        $("#rezume" + rezume_id).remove();
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
            <li><a href="{{route('vacancy')}}">Вакансии</a></li>
            <li><a href="{{route('rubrics')}}">Рубрики</a></li>
            <li class="active"><a>Резюме</a></li>
            <li><a href="{{route('specialty')}}">Специальности</a></li>
            <li><a href="{{route('companyvacancies')}}">Работа в компаниях</a></li>
          </ul>
        </nav>
      </div>
      <br>
      @if(isset($_SESSION['user']))
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#createModal">Добавить резюме</a>
      @endif      
      <br>      
      <br>
      <ul id="rezumes-list">
          @foreach($rezumes as $rezume)
            <li id="rezume{{$rezume->id}}">
                <h3>{{$rezume->jobname}}</h3>
                @if(isset($_SESSION['user']))
                    <button class="btn btn-info edit_modal" data-toggle="modal" value="{{$rezume->id}}" data-target="#updateModal">Изменить</button>
                    <button class="btn btn-danger delete_rezume" data-toggle="modal" value="{{$rezume->id}}" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>
                @endif
            </li>            
          @endforeach
      </ul>     
      <!-- Create modal start -->
<div class="modal fade" hidden="true" id="createModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-filled">
                <div class="panel-body">
                    <form class="js-ajax-php-json-create" action="http://localhost/addrezume" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Добавление резюме</h4><br>
                        <!-- -->
                        <div class="form-group">
                            <input class="form-control" name="jobname"
                            placeholder="Введите название работы. Например:водитель" required="" type="text">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="vacancy" required="">
                                <option selected value="">Нажмите для выбора вакансии</option>
                                @foreach($vacancies as $vacancy)
                                    <option value="{{$vacancy->name}}">{{$vacancy->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="experience" required="">
                                <option selected value="">Выберите опыт работы</option>
                                <option value="Профессионал (стаж более 5 лет)">Профессионал (стаж более 5 лет)</option>
                                <option value="Специалист (стаж 3-5 лет)">Специалист (стаж 3-5 лет)</option>
                                <option value="Работник (стаж 1-2 года)">Работник (стаж 1-2 года)</option>
                                <option value="Новичок (стаж до 1 года)">Новичок (стаж до 1 года)</option>
                                <option value="Стажер, практикант (опыта нет)">Стажер, практикант (опыта нет)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="fullname"
                            placeholder="Введите Ваше полное имя" required="" type="text">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="educationlevel" required="">
                                <option selected value="">Выберите уровень образования</option>
                                <option value="среднее">среднее</option>
                                <option value="училище, лицей">училище, лицей</option>
                                <option value="техникум, колледж">техникум, колледж</option>
                                <option value="неполное высшее">неполное высшее</option>
                                <option value="высшее">высшее</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="educationname"
                            placeholder="Специальность по диплому" required="" type="text">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="skills"
                            placeholder="Навыки" required="" type="text">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="contacts"
                            placeholder="Ваш телефон" required="" type="text">
                        </div>
                        <!-- -->
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
      <!-- Create modal end -->      
      <!-- Update modal start -->
<div class="modal fade" hidden="true" id="updateModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-filled">
                <div class="panel-body">
                    <form class="js-ajax-php-json-update" action="http://localhost/editrezume" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Изменение резюме</h4><br>
                        <!-- -->
                        <input type="hidden" id="id" name="id" value="0">
                        <div class="form-group">
                            <input class="form-control" id="jobname" name="jobname"
                            placeholder="Введите название работы. Например:водитель" required="" type="text">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="vacancy" name="vacancy" required="">
                                <option selected value="">Нажмите для выбора вакансии</option>
                                @foreach($vacancies as $vacancy)
                                    <option value="{{$vacancy->name}}">{{$vacancy->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="experience" name="experience" required="">
                                <option selected value="">Выберите опыт работы</option>
                                <option value="Профессионал (стаж более 5 лет)">Профессионал (стаж более 5 лет)</option>
                                <option value="Специалист (стаж 3-5 лет)">Специалист (стаж 3-5 лет)</option>
                                <option value="Работник (стаж 1-2 года)">Работник (стаж 1-2 года)</option>
                                <option value="Новичок (стаж до 1 года)">Новичок (стаж до 1 года)</option>
                                <option value="Стажер, практикант (опыта нет)">Стажер, практикант (опыта нет)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="fullname" name="fullname"
                            placeholder="Введите Ваше полное имя" required="" type="text">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="educationlevel" name="educationlevel" required="">
                                <option selected value="">Выберите уровень образования</option>
                                <option value="среднее">среднее</option>
                                <option value="училище, лицей">училище, лицей</option>
                                <option value="техникум, колледж">техникум, колледж</option>
                                <option value="неполное высшее">неполное высшее</option>
                                <option value="высшее">высшее</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="educationname" name="educationname"
                            placeholder="Специальность по диплому" required="" type="text">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="skills" name="skills"
                            placeholder="Навыки" required="" type="text">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="contacts" name="contacts"
                            placeholder="Ваш телефон" required="" type="text">
                        </div>
                        <!-- -->
                        <div class="form-group" id="login-errors">
                            <span class="help-block"><strong id="form-login-errors"></strong></span>
                        </div>
                        {{csrf_field()}}
                        <div>
                            <button class="btn btn-login right" content="{{ csrf_token() }}" name="csrf-token">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                
      <!-- Update modal end -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
@endsection    