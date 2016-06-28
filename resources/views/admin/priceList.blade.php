@extends('admin.layouts.master')
@section('content')
	<div id="page-wrapper">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                	<div class="alert alert-success" id="success" style="display: none;"></div>
	                	<div class="alert alert-danger" id="errordiv" style="display: none;"></div>
	                   View Price List
	                   <button type="button" class="btn btn-primary btn-xs marginClass" id="add_category"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</button>
	                   <button type="button" class="btn btn-danger btn-xs marginClass" id="del_category" data-toggle="modal" data-target="#myModalDelCat"><i class="fa fa-trash" aria-hidden="true"></i> Delete Category</button>
	                   <button type="button" class="btn btn-primary btn-xs" style="float: right;" id="add_items"><i class="fa fa-plus" aria-hidden="true"></i> Add Items</button>
	                </div>
	                <!-- /.panel-heading -->
	                <div class="panel-body">
	                    <div class="table-responsive table-bordered">
	                    	<div style="background: transparent; display: none;" id="loaderBody" align="center">
								<p>Please wait...</p>
								<img src="{{url('/')}}/public/img/reload.gif">
							</div>
	                        <table class="table">
	                            <thead>
	                                <tr>
	                                    <th>#</th>
	                                    <th>Category</th>
	                                    <th>Item</th>
	                                    <th>Price</th>
	                                    <th>Created By</th>
	                                    <th>Created At</th>
	                                    <th>Edit</th>
	                                    <th>Delete</th>
	                                </tr>
	                            </thead>
	                            <tbody id="tablePriceList">
		                            @if(count($priceList) > 0)
		                            	@foreach($priceList as $item)
			                            	<tr>
				                            	<td>{{$item->id}}</td>
				                            	@if($item->categories != null)
				                            		<td>{{$item->categories->name}}</td>
				                            	@else
				                            		<td>No Categories are there in our record</td>
				                            	@endif
				                            	<td>{{ $item->item }}</td>
				                            	<td>{{$item->price}}</td>
				                            	<td>{{$item->admin->username}}</td>
				                            	<td>{{ date("F jS Y",strtotime($item->created_at->toDateString())) }}</td>
				                            	<td><button type="button" id="edit_{{$item->id}}" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
				                            	<td><button type="button" id="del_{{$item->id}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></td>
			                            	</tr>
		                            	@endforeach
		                            @else
		                            	<tr>
			                            	<td><label class="alert alert-warning">No data exists please create one.</label></td>
			                            </tr>
		                            @endif
	                            </tbody>
	                        </table>
	                        <span style="float: right;">{!!$priceList->render()!!}</span>
	                    </div>
	                    <!-- /.table-responsive -->
	                </div>
	                <!-- /.panel-body -->
	            </div>
	            <!-- /.panel -->
	        </div>
	        <!-- /.col-lg-6 -->
	    </div>
	</div>
	<div id="myModalDelCat" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 style="color: red;" id="errorDelete"></h4>
	        <h4 class="modal-title">Categories</h4>
	      </div>
	      <div class="modal-body">
	      	<div style="background: transparent; display: none;" id="loaderCatDel" align="center">
	      			<p>Please wait...</p>
		        	<img src="{{url('/')}}/public/img/reload.gif">
		    </div>
			<table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Image</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="tablePriceList">
	                @if(count($categories) > 0)
	                	@foreach($categories as $cat)
	                		<tr>
	                   			<td>{{$cat->id}}</td>
	                   			<td>{{$cat->name}}</td>
	                   			<td>{{$cat->image}}</td>
	                   			<td><button type="button" id="delCat_{{$cat->id}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                   			</tr>
	                	@endforeach
	                @else
	                	<tr>
	                		<td>
	                			No Categories
	                		</td>
	                	</tr>
	                @endif
                </tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<!-- Modal for add  -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 style="color: red;" id="error"></h4>
	        <h4 class="modal-title">Add Items</h4>
	      </div>
	      <div class="modal-body">
	      	<div style="background: transparent; display: none;" id="loader" align="center">
	      			<p>Please wait...</p>
		        	<img src="{{url('/')}}/public/img/reload.gif">
		    </div>
			<form role="form" id="add-modal-form">
				<div class="form-group">
				    <label for="categories">Categories</label>
				    @if(count($categories) > 0)
				    	<select class="form-control" id="category" required="">
				    		<option value="">Select Category</option>
					    	@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
					    	@endforeach
				    	</select>
				    @else
				    	<label class="alert alert-warning">No Categories.</label>
				    @endif
			  </div>
			  <div class="form-group">
			    <label for="name">Item Name</label>
			    <input class="form-control" id="name" name="name" type="text" required="">
			  </div>
			  <div class="form-group">
			    <label for="price">Price</label>
			    <input type="number" class="form-control" name="price" id="price" required=""></input>
			  </div>
			  <button type="button" class="btn btn-primary btn-lg btn-block" id="postItem">Add Item</button>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<!-- Modal for edit  -->
	<div id="myModalEdit" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 style="color: red;" id="errorEdit"></h4>
	        <h4 class="modal-title">Edit Item</h4>
	      </div>
	      <div class="modal-body">
		      <div style="background: transparent; display: none;" id="loaderEdit" align="center">
		      			<p>Please wait...</p>
			        	<img src="{{url('/')}}/public/img/reload.gif">
			  </div>
			<form role="form" id="edit-modal-form">
				<div class="form-group">
					<input type="text" readonly="" id="categoryEdit" class="form-control"></input>
				</div>
			  <div class="form-group">
			    <label for="nameEdit">Item Name</label>
			    <input class="form-control" id="nameEdit" name="nameEdit" type="text" required="">
			  </div>
			  <div class="form-group">
			    <label for="priceEdit">Price</label>
			    <input type="number" class="form-control" name="priceEdit" id="priceEdit" required=""></input>
			  </div>
			  <input type="hidden" name="id" id="id"></input>
			  <button type="button" class="btn btn-primary btn-lg btn-block" id="postEditItem">Save Changes</button>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<!-- Modal for add catgory -->
	<div id="myModalCat" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 style="color: red;" id="errorCat"></h4>
	        <h4 class="modal-title">Add Category</h4>
	      </div>
	      <div class="modal-body">
	      	<div style="background: transparent; display: none;" id="loaderCat" align="center">
	      			<p>Please wait...</p>
		        	<img src="{{url('/')}}/public/img/reload.gif">
		    </div>
			<form role="form" id="cat-modal-form">
			  <div class="form-group">
			    <label for="Catname">Category Name:</label>
			    <input class="form-control" id="Catname" name="name" type="text" required="">
			  </div>
			  <div class="form-group">
			  	<button type="button" class="btn btn-primary btn-lg btn-block" id="postCategory">Add Category</button>
			  </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			var baseUrl = "{{url('/')}}";
			//showing modal to add item
			$('#add_items').click(function(){
				$('#myModal').modal('show');
			});
			//save price item in databse
			$('#postItem').click(function(){
				var category = $('#category').val();
				var item = $('#name').val();
				var price = $('#price').val();
				//console.log(category);
				//return false;
				if ($.trim(category) && $.trim(item) && $.trim(price)) 
				{	
					$('#add-modal-form').hide();
					$('#loader').show();
					$.ajax({
						url: baseUrl+'/price-list',
						type: "POST",
						data: {category: category, item: item, price:price, _token: "{!! csrf_token() !!}"},
						success : function(data){
							if (data!=0) 
							{
								location.reload();
								$('#success').show();
								$('#success').html("<strong><i class='fa fa-check' aria-hidden='true'></i> Success!</strong> Item successfully added! <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
							}
							else
							{
								$('#loader').hide();
								$('#add-modal-form').show();
								$('#error').show();
								$('#error').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Could not be able to save your details now try again later');
							}
						}

					});
				}
				else
				{
					$('error').show();
					$('#error').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Please fill out all the fields correctly');
				}
			});
			//edit price item in database
			@foreach($priceList as $item)
				@if (isset($item->categories) && $item->categories!=null) 
				{
					$('#edit_{{$item->id}}').click(function(){
						//showing modal
						$('#id').val('{{$item->id}}');
						$('#categoryEdit').val("{{$item->categories->name}}");
						$('#nameEdit').val("{{$item->item}}");
						$('#priceEdit').val("{{$item->price}}");
						$('#myModalEdit').modal('show');
					});
				}
				@else 
				{
					$('#edit_{{$item->id}}').click(function(){
						//showing modal
						$('#id').val('{{$item->id}}');
						$('#categoryEdit').val('No Categories');
						$('#nameEdit').val('{{$item->item}}');
						$('#priceEdit').val('{{$item->price}}');
						$('#myModalEdit').modal('show');
					});
				}
				@endif
			@endforeach
			//post Edit item in databse
			$('#postEditItem').click(function(){
				var id = $('#id').val();
				var name = $('#nameEdit').val();
				var price = $('#priceEdit').val();
				if ($.trim(name) && $.trim(price)) 
				{
					$('#edit-modal-form').hide();
					$('#loaderEdit').show();
					$.ajax({
						url: baseUrl+'/edit-price-list',
						type:"POST",
						data: {id: id, name: name, price: price, _token:'{!!csrf_token()!!}'},
						success: function(data) {
							if (data!=0) 
							{
								location.reload();
								$('#success').show();
								$('#success').html("<strong><i class='fa fa-check' aria-hidden='true'></i> Success!</strong> Item successfully updated! <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>");
							}
							else
							{
								$('#loaderEdit').hide();
								$('#edit-modal-form').show();
								$('#errorEdit').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Could not be able to update your details now try again later');
							}
						}
					});
				}
				else
				{
					$('#errorEdit').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Please fill out all the fields correctly');
				}
			});
			//delete function
			@foreach($priceList as $item)
				$('#del_{{$item->id}}').click(function(){
					var id = '{{$item->id}}';
					$('.table').hide();
					$('#loaderBody').show();
					$.ajax({
						url : baseUrl+'/delete-price-item',
						type: "POST",
						data: {id: id, _token:'{!! csrf_token() !!}'},
						success: function(data) {
							if (data != 0) 
							{
								location.reload();
							}
							else
							{
								$('#errordiv').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Could not be able to update your details now try again later');
							}
						}
					});
				});
			@endforeach
			$('#add_category').click(function(){
				$('#myModalCat').modal('show');
			});
			//save category in databse
			$('#postCategory').click(function(){
				var name = $('#Catname').val();
				if ($.trim(name)) 
				{
					//console.log(name);
					$('#loaderCat').show();
					$('#cat-modal-form').hide();
					$.ajax({
						url: baseUrl+'/add-category',
						type: "POST",
						data: {name: name, _token: '{!! csrf_token() !!}'},
						success: function(data) {
							if (data != 0) 
							{
								//console.log(data)
								location.reload();
							}
							else
							{
								$('#loaderCat').hide();
								$('#cat-modal-form').show();
								$('#errorCat').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Could not be able to save category');
							}
						}
					});
				}
				else
				{
					$('#errorCat').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' All fileds are mandetory ');
				}
			});
			//del category
			if ({{  count($categories) }} > 0) 
			{
				@foreach($categories as $cats)
					$('#delCat_{{$cats->id}}').click(function(){
						$('.table').hide();
						$('#loaderCatDel').show();
						$.ajax({
							url: baseUrl+'/delete-category',
							type: "POST",
							data: {id: '{{$cats->id}}', _token: '{!!csrf_token()!!}'},
							success: function(data){
								if (data!=0) 
								{
									location.reload();
								}
								else
								{
									$('#errorDelete').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Error!</strong>'+' Cannot Delete this record try again later');
								}
							}
						});
					});
				@endforeach
			}
			else
			{
				console.log('No categories');
			}

		});
	</script>
@endsection