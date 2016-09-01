@extends('layouts.master')

@section('title',$title)

@section('content')
<div class="container-fluid">

	<div class="row" style="text-align: center;">
		<h1>Todo List <small style="font-size: 12px;">by <a target="_blank" href="http://anjir.esy.es">ALFI SYARI</a></small></h1>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="float: none;display: inline-block;margin-top:30px;">
			<div class="panel panel-default">
				<div class="panel-body">
					<form name="todo-form" id="todo-from">
						<input name="todo-input" placeholder="ADD SOMETHING TO DO" class="todoinput"></input>
					</form>
				</div>
			</div>
			<small id="log">...</small>
			<hr/>
			<div class="panel panel-default">
				<div class="panel-body">
					<ul id="todo-container">
						@define $i=1;
						@foreach($todos as $todo) 
							<li data-id="{{$todo->id}}">{!!"<span data-id=\"".$todo->id."\">".$todo->name."</span>"!!} 
								<div class="action">
									<button class="edit-btn" data-id="{{$todo->id}}"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="done-btn" data-id="{{$todo->id}}"><i class="glyphicon glyphicon-ok"></i></button>
								</div>
							</li>
							@define $i++;
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style type="text/css"></style>
@endsection

@section('script')
<script type="text/javascript">
	$(function(){

		$("#todo-from").on('submit',function(e){
			e.preventDefault();
			var name = $("input[name='todo-input']").val();
			if(name == ""){
				$("input[name='todo-input']").focus();
				alert('isi dulu bang!');
				return false;
			}

			$.ajax({
				type : "POST",
				data : {name : name},
				url  : "{{ route('todo.insert') }}",
				dataType : "json",
				beforeSend: function(e){
					$("#log").html("Inserting..");
				},
				error : function(error){
					$v = $.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
					resetLog();
				},
				success : function(data){
					resetLog();
					$("input[name='todo-input']").val("");
					var count=$("#todo-container li").length;
					count++;
					$("#todo-container").append("<li data-id=\""+data.todo.id+"\"><span data-id=\""+data.todo.id+"\">"+data.todo.name+ "</span>"+
								"<div class=\"action\">"+
									"<button class=\"edit-btn\" data-id=\""+data.todo.id+"\"><i class=\"glyphicon glyphicon-pencil\"></i></button>"+
									"<button class=\"done-btn\" data-id=\""+data.todo.id+"\"><i class=\"glyphicon glyphicon-ok\"></i></button>"+
								"</div>"+
							"</li>");
				}
			})
		});



		$("body").on('click','.done-btn',function(e){
			var id= $(this).attr('data-id');
			if(typeof id == undefined){
				alert("something wrong!!");return false;
			}

			$.ajax({
				type :"POST",
				url : "{{route('todo.done')}}",
				data:{id:id},
				dataType: 'json',
				beforeSend: function(e){
					$("li[data-id='"+id+"']").css('background-color','rgba(183, 72, 58, 0.27)');
					$("#log").html("loading..");
				},
				error : function(error){
					$("li[data-id='"+id+"']").css('background-color','#FFF');
					$v = $.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
					resetLog();
				},
				success : function(data){
					$("li[data-id='"+id+"']").fadeOut(300);
					setTimeout(function(){
						$("li[data-id='"+id+"']").remove();
					},500);
					resetLog();
				}
			});
		});

		$("body").on('click','.edit-btn',function(){
			var id= $(this).attr('data-id');
			if(typeof id == undefined){
				alert("something wrong!!");return false;
			}

			$.ajax({
				type :"GET",
				url : "{{url('todo/')}}"+id,
				dataType: 'json',
				beforeSend: function(e){
					$("#log").html("loading..");
				},
				error : function(error){
					$v = $.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
					resetLog();
				},
				success : function(data){
					resetLog();
					swal({
					  title: "Edit",
					  text: "What will you do then?",
					  type: "input",
					  showCancelButton: true,
					  closeOnConfirm: true,
					  animation: "slide-from-top",
					  inputValue: data.todo.name,
					  inputPlaceholder: "Do something"
					},
					function(inputValue){
						if (inputValue === "" || inputValue === false) {
						    return false;
						}
						update(id,inputValue);
					});
				}
			});
		});

		var update = function(id,name){
			$.ajax({
				type:"POST",
				url:"{{route('todo.update')}}",
				data:{id:id,name:name},
				dataType:'json',
				beforeSend: function(e){
					$("#log").html("updating..");
				},
				error : function(error){
					$v = $.parseJSON(error.responseText);
					alert(error.statusText+", "+$v.message);
					resetLog();
				},
				success :function(data){
					resetLog();
					$("ul#todo-container li[data-id='"+data.todo.id+"'] span").html(data.todo.name);
				}
			});
		} 
		var resetLog = function(){
			$("#log").html("....");
		}
	});
</script>
@endsection
