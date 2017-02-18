@extends('layouts.site')

@section('content')
<!-- ajax script-->
        <script type="text/javascript">                                  
            //data for update
            $(document).on('click','.edit_modal',function(){
                $(".js-ajax-php-json-update")[0].reset();
                var specialty_id = $(this).val();
                $.get('http://localhost/specialty/' + specialty_id, function (dataForEdit){
                    console.log(dataForEdit);
                    $("#id").val(dataForEdit.id);
                    $("#name").val(dataForEdit.name);
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
                  url: "http://localhost/addspecialty", 
                  data: data,
                  success: function(data) {         
                    var specialty = '<li id="specialty'+data.id+'">';
                    specialty+='<h3>'+data.name+'</h3>\n';
                    specialty+='<button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal">Изменить</button>\n';
                    specialty+='<button class="btn btn-danger delete_specialty" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>\n';
                    specialty+='</li>';                                                                     
                    $(".js-ajax-php-json-create")[0].reset();
                    $("#specialties-list").append(specialty);                    
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
                  url: "http://localhost/editspecialty",
                  data: data,
                  success: function(data) {                        
                    var specialty = '<li id="specialty'+data.id+'">';
                    specialty+='<h3>'+data.name+'</h3>\n';
                    specialty+='<button class="btn btn-info edit_modal" data-toggle="modal" value="'+data.id+'" data-target="#updateModal">Изменить</button>\n';
                    specialty+='<button class="btn btn-danger delete_specialty" data-toggle="modal" value="'+data.id+'" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>\n';
                    specialty+='</li>';                                                                     
                    $(".js-ajax-php-json-update")[0].reset();                    
                    $("#specialty" + data.id).replaceWith( specialty );
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
            $(document).on('click','.delete_specialty',function(){
                var specialty_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "DELETE",
                    url: 'http://localhost/deletespecialty/' + specialty_id,
                    success: function (data) {
                        $("#specialty" + specialty_id).remove();
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
            <li><a href="{{route('rezume')}}">Резюме</a></li>
            <li class="active"><a>Специальности</a></li>
            <li><a href="{{route('companyvacancies')}}">Работа в компаниях</a></li>
          </ul>
        </nav>
      </div>
      <br>
      @if(isset($_SESSION['user']))
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#createModal">Добавить специальность</a>
      @endif      
      <br>      
      <br>
      <ul id="specialties-list">
          @foreach($specialties as $specialty)
            <li id="specialty{{$specialty->id}}">
                <h3>{{$specialty->name}}</h3>
                @if(isset($_SESSION['user']))
                    <button class="btn btn-info edit_modal" data-toggle="modal" value="{{$specialty->id}}" data-target="#updateModal">Изменить</button>
                    <button class="btn btn-danger delete_specialty" data-toggle="modal" value="{{$specialty->id}}" data-target="#deleteModal" content="{{ csrf_token() }}" name="csrf-token">Удалить</button>
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
                    <form class="js-ajax-php-json-create" action="http://localhost/addspecialty" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Добавить специальность</h4><br>
                        <div class="form-group">
                            <input class="form-control" name="name"
                            placeholder="Введите название" required="" type="text">
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
      <!-- Create modal end -->
      <!-- Update modal start -->      
<div class="modal fade" hidden="true" id="updateModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel panel-filled">
                <div class="panel-body">
                    <form class="js-ajax-php-json-update" action="http://localhost/editspecialty" id="registerForm" method="post" name="registerForm">
                        <h4 class="modal-title">Изменить специальность</h4><br>
                        <input type="hidden" id="id" name="id" value="0">
                        <div class="form-group">
                            <input class="form-control" name="name" id="name"
                            placeholder="Введите название" required="" type="text">
                        </div>                                                                        
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