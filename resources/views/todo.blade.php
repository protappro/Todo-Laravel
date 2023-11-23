<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<title>Hello, world!</title>
	<style>
		table tr td{
    		background-color: #f4f4f4a3;
		}
		table tr.is_complete td{
    		background-color: #cecece;
		}
		table tr.is_complete td:nth-child(3){
		    text-decoration-line: line-through;
		    color: #6c757d!important;
		}
		table tr.is_complete td:nth-child(4){
		    text-decoration-line: line-through;
		    color: #6c757d!important;
		}
	</style>
</head>
<body>
	<div class="d-flex flex-column flex-md-row align-items-center justify-content-between p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal text-info">Magic Mind</h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark text-decoration-none" href="#">Home</a>
			<a class="p-2 text-dark text-decoration-none" href="#">Contact</a>
			<a class="p-2 text-dark text-decoration-none" href="#">Interview</a>
			<a class="btn btn-outline-danger" href="{{ route('auth.logout') }}">Logout</a>
		</nav>
	</div>
	<div class="row justify-content-center mt-5">
		<div class="col-lg-6">
			@if(session()->has('success'))
			<div class="alert alert-success">
				{{ session()->get('success') }}
			</div>
			@endif

			@if ($errors->any())
			@foreach ($errors->all() as $error)
			<div class="alert alert-danger">
				{{$error}}
			</div>
			@endforeach
			@endif
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-10"> 
				<h2>All Todos</h2>
			</div>
			<div class="col-2 float-right">
				<button type="button" class="btn btn-sm btn-primary add_todo_details float-right" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa fa-plus"></i> Add Todo</button>
			</div>
			<div class="col-12">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover todo-table">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">#</th>
									<th scope="col" width="40%">Name</th>
									{{-- <th scope="col">Created at</th> --}}
									<th scope="col">Status</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($lists as $key => $list)
								@php
								$status = "Complete";
								$color = 'success';
								$className = 'is_complete';
								if($list->is_completed === 0){
									$status = "Not Complete";
									$color = 'secondary';
									$className = '';
								}
								@endphp
								<tr class='{{$className}}'>
									<td>
										<div class="form-check">
											<input class="form-check-input todo_check_{{$list->id}}" type="checkbox" value="{{ $list->is_completed == 1 ? 0 : 1}}" onchange="complateList('{{$list->id}}')" {{ $list->is_completed == 1 ? "checked" : ""}} data-todo_id="{{$list->id}}">
										</div>
									</td>
									<td>{{$key+1}}</td>
									<td>
										<div>
											<span class="title_{{$list->id}} w-100 d-block">{{$list->title}}</span>
											<em><small>Date : {{date("d-m-Y", strtotime($list->created_at))}}</small></em>
										</div>										
									</td>
									<td><span class='badge bg-{{$color}} status_{{$list->id}}' data-status="{{$list->is_completed}}">{{$status}}</span></td>
									<td>
										<button class="btn btn-sm btn-info text-white edit-todo-btn" data-bs-toggle="modal" data-form_name="Edit" data-todo_id="{{$list->id}}" {{ $list->is_completed == 1 ? "disabled" : ""}}><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>										
										<button class="btn btn-sm btn-danger delete-btn" id="delete-btn_{{$list->id}}" data-todo_id="{{$list->id}}" {{ $list->is_completed == 1 ? "disabled" : ""}}><i class="fa fa-trash" aria-hidden="true"></i></button>
									</td>
								</tr>
								@empty
								<tr><td>No data found</td></tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title text-capitalize" id="exampleModalLabel">Add Todo</h3>
				</div>
				<form id="add_todo_form" action="{{ route('add-todo') }}">
					@csrf
					<div class="modal-body p-0">  
						<div class="card-body" style="padding: 1rem 2.25rem;">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group mb-0">
												<div class="font-size-lg mb-0"> Title </div>
												<input class="form-control form-control-sm" type="text" id="title" autocomplete="off" name="title" value="" />
												<input type="hidden" name="todo_id" class="_todo_id">
												<input type="hidden" name="status" class="_status">
											</div>
										</div>
									</div>   
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn btn-danger font-weight-bold" data-bs-dismiss="modal">Close
						</button>
						<button type="submit" class="btn btn-primary font-weight-bold add_form_btn">Save changes
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		$(".add_form_btn").click(function (e) { 
			e.preventDefault();
			var formData = $('#add_todo_form').serialize();
			var url = $('#add_todo_form').attr('action');

			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: url,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				data: formData,
				success: function (res) {
					console.log(res);
					if(res.status){
						toastr.success(res.msg);
						setInterval( function(){
							window.location.reload();
						}, 1500);
					} else {
						toastr.error(res.msg)
					}
				},
			});
		});

		$(".edit-todo-btn").click(function (e) {
			e.preventDefault();
			var todo_id = $(this).data('todo_id');
			var title = $('.title_'+todo_id).text();
			var status = $('.status_'+todo_id).data('status');
			var form_name = $(this).data('form_name') + ' Todo';
			var myModalEl = document.getElementById('exampleModal')
			myModalEl.addEventListener('shown.bs.modal', function (event) { 
			  $("#exampleModalLabel").text(form_name);
			  $("#title").val(title);
			  $('._todo_id').val(todo_id);
			  $('._status').val(status);
			})
		    $('#exampleModal').modal('show');
		});

		$(".delete-btn").click(function (e) {			
			var todo_id = $(this).data('todo_id');
			Swal.fire({
			  title: "Are you sure to delete this?",
			  showCancelButton: true,
			  confirmButtonText: "Delete",
			}).then((result) => {
			  /* Read more about isConfirmed, isDenied below */
			  if (result.isConfirmed) {			    
				deleteTodoList(todo_id);
			  }
			});
		})

		function complateList(id){
			$.ajax({
				type: "get",
				dataType: "json",
				url: '{{ route('complete-todo') }}',
				cache: false,
				data: {is_complete: $(".todo_check_"+id).val(), id: id},
				success: function (res) {
					if(res.status){
						toastr.success(res.msg);
						setInterval( function(){
							window.location.reload();
						}, 1500);
					} else {
						toastr.error(res.msg)
					}
				},
			});
		}

		function deleteTodoList(id) {
			jQuery.ajax({
				type: "DELETE",
				dataType: "json",
				url: '{{ route('delete-todo') }}',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				cache: false,
				data: {todo_id: id},
				success: function (res) {
					if(res.status){
						toastr.success(res.msg);
						$('#delete-btn_'+id).closest("tr").remove();
					} else {
						toastr.error(res.msg)
					}
				},
			});
		}
	</script>
</body>
</html>