@extends('layouts.master')

@section('title','To do list alfi')

@section('style')
	<style type="text/css">
		ul{ padding:0; list-style: none;}
		ul li { font-size: 15px; text-align: left; padding:15px 20px; text-transform: uppercase;position: relative; }
		ul li:hover{ background-color: #FDFDFD; }
		.panel{border:none;box-shadow: 1px 2px 3px -1px rgba(0,0,0,.20); border-radius: 0;padding:0;}
		.action { float: right; position: absolute; right: 20px; top: 15px; }
		.action button{ position: relative; background: none;border:none; outline: none;cursor: pointer; }
		input{outline: none;width: 100%;padding:15px 20px;border:none; font-size: 20px;}
		button.add-btn,button.update-btn{ position: absolute; right: 35px;top:20px; border:0; background:none; outline: none; }
	</style>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$(".add-btn").click(function(){
			var name = $("input[name='input-todolist']").val();
			if(name == ""){ 
				alert('isi dulu bang.');
				$("input[name='input-todolist']").focus(); 
				return false;
			}
			
			$.ajax({
				type : "POST",
				url : '{{ route("todo.add") }}',
				data : { todo : name },
				dataType :'json',
				error : function(error){
                    $v=$.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
				},
				success : function(data){
					count = $("#todo-container li").length;
					count++;
					$("input[name='input-todolist']").val("").attr('data-id','');
					$("#todo-container").append("<li>"+count+". "+data.todo.name+" <div class=\"action\"> <button class=\"edit-btn\" data-id=\""+data.todo.id+"\"><i class=\"glyphicon glyphicon-pencil\"></i></button></div></li>");
				}
			});
		});

		$("body").on('click','.edit-btn',function(){
			$id = $(this).attr('data-id');
			$.ajax({
				type:"GET",
				url : "{{ url('/') }}"+"/todo/"+$id,
				dataType :'json',
				error : function(error){
                    $v=$.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
				},
				success :function(data){
					$(".add-btn").fadeOut();
					$(".update-btn").fadeIn();
					$("input[name='input-todolist']").val(data.todo.name).attr('data-id',data.todo.id);
				}
			});
		});
	});
</script>
@endsection
@section('content')
	<h1 class="text-center">TO DO LIST</h1>
	<div class="row" style="text-align: center;margin-top: 50px;">
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="float: none;display: inline-block;">
			<div class="panel panel-default" style="">
				<div class="panel-body" style="padding:0">
					<input type="text" name="input-todolist"></input><button class="add-btn" name="addbutton"><i class="glyphicon glyphicon-plus-sign"></i></button><button style="display: none;" class="update-btn" name="updatebutton"><i class="glyphicon glyphicon-pencil"></i></button>
				</div>
			</div>
			<hr/>
			<div class="panel panel-default" style="">
				<div class="panel-body" style="padding:0">
					<ul id="todo-container">
						@define $i = 1;
						@foreach($todos as $todo)
						<li>{{$i.". ".$todo->name}} <div class="action"> <button class="edit-btn" data-id="{{$todo->id}}"><i class="glyphicon glyphicon-pencil"></i></button></div></li>
							@define $i++;
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection