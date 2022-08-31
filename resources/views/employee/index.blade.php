@extends('layout.master')


@section('body')

	<!-- Add Modal -->
	<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <form id="addEmployeeForm" method="post" enctype="multipart/form-data">
		      <div class="modal-body">

		      	<ul id="addErrorList" class="alert alert-warning d-none">
		      	</ul>

	        	<div class="form-group">
	        		<label for="">Name</label>
	        		<input type="text" name="name" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label for="">Phone</label>
	        		<input type="text" name="phone" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label for="">Image</label>
	        		<input type="file" name="image" class="form-control-file">
	        	</div>
		      </div>

		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save</button>
		      </div>
	      </form>

	    </div>
	  </div>
	</div>

	<!-- Edit Modal -->
	<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <form id="editEmployeeForm" method="post" enctype="multipart/form-data">
		      <div class="modal-body">

		      	<ul id="updateErrorList" class="alert alert-warning d-none">
		      	</ul>

	        	<input type="hidden" name="id" id="editId" value="" class="form-control">
	        	<div class="form-group">
	        		<label for="">Name</label>
	        		<input type="text" name="name" id="editName" value="" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label for="">Phone</label>
	        		<input type="text" name="phone" id="editPhone" value="" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label for="">Image</label>
	        		<input type="file" name="image" class="form-control-file">
	        		<img src="" id="editImage" width="100" alt="">
	        	</div>
		      </div>

		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Update</button>
		      </div>
	      </form>

	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Delete Employee</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <div class="modal-body">
	      	<h4>Are you want to delete?</h4>
	      	<input type="hidden" id="deletingID" value="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
	        <button type="button" id="deleteModalBtn" class="btn btn-primary">Yes, Delete</button>
	      </div>

	    </div>
	  </div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>Ajax Image Crud
							<a href="" class="btn btn-primary float-right" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</a>
						</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Image</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									{{-- <tr>
										<td width="5%">1</td>
										<td>Siam</td>
										<td>000000</td>
										<td>Image</td>
										<td width="20%">
											<button type="button" value="" class="btn  btn-info mr-1">Edit</button>
											<button type="button" value="" class="btn  btn-danger">Delete</button>
										</td>
									</tr> --}}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('scripts')

	<script>
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		// -------------- Add Employee ----------------
		// $(document).on('submit', '#addEmployeeForm', function(){
		$(document).on('submit', '#addEmployeeForm', function(e){
			// console.log(e);
			e.preventDefault();
			// event.preventDefault();

			var formData = new FormData($('#addEmployeeForm')[0]);
			// console.log(formData);

			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '/employee/add',
				data: formData,
				contentType: false,
				processData: false,
				success:function(res){
					// console.log(res);
					if(res.status == 400){
						$('#addErrorList').html('');
						$('#addErrorList').removeClass('d-none');
						$.each(res.errors, function(key, err_value){
							$('#addErrorList').append('<li>'+err_value+'</li>');
						});
					}
					else{
						$('#addErrorList').html('');
						$('#addErrorList').addClass('d-none');
						$('#addEmployeeForm').find('input').val('');
						$('#addEmployeeModal').modal('hide');

						showEmployee();
						// alert(res.message);
						alertify.set('notifier','position', 'top-right');
						alertify.success(res.message);
					}
				}
			});
		});
		// -------------- End Add Employee ----------------

		// -------------- Show Employee ----------------
		function showEmployee(){
			$.ajax({
				type:'GET',
				dataType:'JSON',
				url:'/employee/all',
				success:function(res){
					// console.log(res);
					// console.log(res.employee);
					$('tbody').html('');
					$.each(res.employee, function(key, value){
						$('tbody').append('<tr>\
										<td width="5%">'+value.id+'</td>\
										<td>'+value.name+'</td>\
										<td>'+value.phone+'</td>\
										<td>\
											<img src="'+value.image+'" width="100" alt="">\
										</td>\
										<td width="20%">\
											<button type="button" value="'+value.id+'" class="edit_btn btn btn-info mr-1" >Edit</button>\
											<button type="button" value="'+value.id+'" class="delete_btn btn btn-danger">Delete</button>\
										</td>\
									</tr>');
					});
				}
			});
		}
		showEmployee();
		// -------------- End Show Employee ----------------

		// -------------- Edit Employee ----------------
		$(document).on('click', '.edit_btn', function(e){
			e.preventDefault();

			var edit_id = $(this).val();
			// alert(edit_id);
			// console.log(edit_id);
			$('#editEmployeeModal').modal('show');

			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '/employee/edit/'+edit_id,
				success:function(res){
					// console.log(res);
					// console.log(res.employee.name);

					if(res.status == 400){
						// alert(res.message);
						alertify.set('notifier','position', 'top-right');
						alertify.success(res.message);
						$('#editEmployeeModal').modal('hide');
					}
					else{
						$('#editId').val(res.employee.id);
						$('#editName').val(res.employee.name);
						$('#editPhone').val(res.employee.phone);
						$('#editImage').attr('src', res.employee.image);
					}
				}
			});
		});
		// -------------- End Edit Employee ----------------

		// -------------- Update Employee ----------------
		$(document).on('submit', '#editEmployeeForm', function(e){
			// console.log(e);
			e.preventDefault();
			// event.preventDefault();

			var editFormData = new FormData($('#editEmployeeForm')[0]);

			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '/employee/update',
				data: editFormData,
				contentType: false,
				processData: false,
				success:function(res){
					// console.log(res);

					if(res.status == 400){
						$('#updateErrorList').html('');
						$('#updateErrorList').removeClass('d-none');
						$.each(res.errors, function(key, err_value){
							$('#updateErrorList').append('<li>'+err_value+'</li>');
						});
					}
					else{
						$('#updateErrorList').html('');
						$('#updateErrorList').addClass('d-none');
						$('#editEmployeeForm').find('input').val('');
						$('#editEmployeeModal').modal('hide');

						showEmployee();
						// alert(res.message);
						alertify.set('notifier','position', 'top-right');
						alertify.success(res.message);
					}
				}
			});
		});
		// -------------- End Update Employee ----------------

		// -------------- Delete Employee ----------------
		$(document).on('click', '.delete_btn', function(e){
			e.preventDefault();

			var delete_id = $(this).val();
			// alert(delete_id);

			$('#deletingID').val(delete_id);
			$('#deleteEmployeeModal').modal('show');
		});

		$(document).on('click', '#deleteModalBtn', function(e){
			e.preventDefault();

			// var id = delete_id;
			// // alert(delete_id);
			// console.log(delete_id);

			var id = $('#deletingID').val();
			// alert(id);

			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '/employee/delete/'+id,
				success:function(res){
					console.log(res);
					if(res.status == 400){
						showEmployee();
						$('#deleteEmployeeModal').modal('hide');
						// alert(res.message);
						alertify.set('notifier','position', 'top-right');
						alertify.success(res.message);
					}
					else if(res.status == 200){
						showEmployee();
						$('#deleteEmployeeModal').modal('hide');
						// alert(res.message);
						alertify.set('notifier','position', 'top-right');
						alertify.success(res.message);
					}
				}
			});
		});
		// -------------- End Delete Employee ----------------


	</script>

@endsection