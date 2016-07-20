@extends('admin.layouts.master')
@section('content')
	<div id="page-wrapper">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                	@if(Session::has('fail'))
	                		<div class="alert alert-danger">{{Session::get('fail')}}
	                			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                		</div>
	                	@else
	                	@endif
	                	@if(Session::has('success'))
	                		<div class="alert alert-success">	                             	{{Session::get('success')}}
	                			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                		</div>
	                	@else
	                	@endif
	                	<div class="alert alert-success" id="success" style="display: none;"></div>
	                   View Neighborhood
	                   <button type="button" class="btn btn-primary btn-xs" style="float: right;" id="add_neighbor"><i class="fa fa-plus" aria-hidden="true"></i> Add Neighborhood</button>
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
	                                    <th>Name</th>
	                                    <th>Description</th>
	                                    <th>Image</th>
	                                    <th>Created By</th>
	                                    <th>Created At</th>
	                                    <th>Edit</th>
	                                    <th>Delete</th>
	                                </tr>
	                            </thead>
	                            <tbody>
		                            @if(count($neighborhood) > 0 )
		                            	@foreach($neighborhood as $neighbor)
			                            	<tr>
			                            		<td>{{$neighbor->id}}</td>
			                            		<td>{{$neighbor->name}}</td>
			                            		<td>{{$neighbor->description}}</td>
			                            		<td><img src="{{url('/')}}/public/dump_images/{{$neighbor->image}}" style="height: 50px; width: 73px;"></td>
			                            		<td>{{$neighbor->admin->username}}</td>
			                            		<td>{{ date("F jS Y",strtotime($neighbor->created_at->toDateString())) }}</td>
			                            		<td><button type="button" id="edit_{{$neighbor->id}}" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
			                            		<td><button type="button" id="del_{{$neighbor->id}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button></td>
			                                </tr>
		                            	@endforeach
		                            @else
		                            	<tr>
		                            		<td><label class="alert alert-warning">No data exists please create one.</label></td>
		                            	</tr>
	                            	@endif
	                            </tbody>
	                        </table>
	                        <span style="float: right;">{!!$neighborhood->render()!!}</span>
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
	<!-- Modal for add  -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 style="color: red;" id="error"></h4>
	        <h4 class="modal-title">Add Neighborhood</h4>
	      </div>
	      <div class="modal-body">
	      	<div style="background: transparent; display: none;" id="loader" align="center">
	      			<p>Please wait...</p>
		        	<img src="{{url('/')}}/public/img/reload.gif">
		    </div>
			<form role="form" id="add-modal-form" enctype="multipart/form-data" method="post" action="{{route('postneighborhood')}}">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input class="form-control" id="name" name="name" type="text" required="">
			  </div>
			  <div class="form-group">
			    <label for="description">Description</label>
			    <textarea class="form-control" id="description" name="description"></textarea>
			  </div>
			  <div class="form-group">
				<input type="file" name="image" class="form-control" required="" />			  	
			  </div>
			  <button type="submit" class="btn btn-primary btn-lg btn-block" id="postneighbor">Add Neighborhood</button>
			  <input type="hidden" name="_token" value="{{Session::token()}}"></input>
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
	        <h4 class="modal-title">Edit Neighborhood</h4>
	      </div>
	      <div class="modal-body">
		      <div style="background: transparent; display: none;" id="loaderEdit" align="center">
		      			<p>Please wait...</p>
			        	<img src="{{url('/')}}/public/img/reload.gif">
			  </div>
			<form role="form" id="edit-modal-form" enctype="multipart/form-data" method="post" action="{{route('editneighborhood')}}">
			  <div class="form-group">
			    <label for="nameEdit">Name</label>
			    <input class="form-control" id="nameEdit" name="nameEdit" type="text">
			  </div>
			  <div class="form-group">
			    <label for="descriptionEdit">Description</label>
			    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
			  </div>
			  <div class="form-group">
			  	<div id="imagePreview"></div>
			    <input type="file" name="image" id="image" class="form-control"/>
			  </div>
			  <input type="hidden" name="id" id="id"></input>
			  <button type="submit" class="btn btn-primary btn-lg btn-block" id="postEditneighbor">Save Changes</button>
			  <input type="hidden" name="_token" value="{{Session::token()}}"></input>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<!--Add new neighbor script-->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#add_neighbor').click(function(){
				//showing modal
				$('#myModal').modal({
					show: 'true'
				});
			});
		});
		/*$('#postneighbor').click(function(){
			var editorContent = tinyMCE.get('description').getContent();
			if ($.trim(editorContent) == '')
			{
			    sweetAlert("Oops...", "Description Field is required!", "error");
			    return false;
			}
			else
			{
			    return true;
			}

		});*/
		$(document).ready(function(){
			var baseUrl = "{{url('/')}}";
			@foreach($neighborhood as $neighbor)
				$('#edit_{{$neighbor->id}}').click(function(){
					$('#myModalEdit').modal({
						show: 'true'
					});
					$('#nameEdit').val("{{$neighbor->name}}");
					$('#id').val('{{$neighbor->id}}');
					$('#imagePreview').html('<img src="{{url("/")}}/public/dump_images/{{$neighbor->image}}" style="height: 100px; width: 100px;">');
				});
				// delete neighborhood
				$('#del_{{$neighbor->id}}').click(function(){
					$('.table').hide();
					$('#loaderBody').show();
					$.ajax({
						url: baseUrl+"/delete-neighborhood",
						type: "POST",
						data: {id: '{{$neighbor->id}}', _token: '{!!csrf_token()!!}'},
						success: function(data) {
							//console.log(data);
							//return;
							if (data!=0) 
							{
								location.reload();
							}
							else
							{
								$('#error').html('<i class="fa fa-times" aria-hidden="true"></i>'+' <strong>Sorry!</strong>'+' Could not delete this neighborhood now please try again later');
							}
						}
					});
				});
			@endforeach
		});
	</script>
	<script type="text/javascript">
		CKEDITOR.replace('description',
		{
		on :
		{
		instanceReady : function( ev )
		{
		this.dataProcessor.writer.setRules( '*',
		{
		indent : false,
		breakBeforeOpen : true,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : true
		});
		}}});
		CKEDITOR.replace('descriptionEdit',
		{
		on :
		{
		instanceReady : function( ev )
		{
		this.dataProcessor.writer.setRules( '*',
		{
		indent : false,
		breakBeforeOpen : true,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : true
		});
		}}});
	</script>
@endsection