<?php include('db_connect.php');?>


<div class="container-fluid">
	
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			
			<form action="" id="manage_tracer">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<h1>New Survey</h1>
						<div class="form-group">
							<label for="" class="control-label">Title</label>
							<input type="text" name="title" class="form-control form-control-sm" required value="<?php echo isset($stitle) ? $stitle : '' ?>">
						</div>

						<?php if($_SESSION['login_type'] == 2): ?>

							<!-- <div class="form-group">
							<label for="" class="control-label">Department</label> -->
							<?php
								// if(isset($_SESSION['login_dept_id'])){
								// 	$dept = $conn->query("SELECT * FROM dept_bio where id = " .$_SESSION['login_dept_id']);
								// 	while($row=$dept->fetch_assoc());
								// 	// $_SESSION["c_id"] = $row['course_id'];
								// }
										
									$department = $conn->query("SELECT d.*, c.course as course from dept_bio d inner join courses c on d.course_id = c.id where d.id = " .$_SESSION['login_dept_id']);
									while($row=$department->fetch_assoc()):?>

							<input type="hidden" name="department_id" class="form-control form-control-sm" readonly value="<?php echo $row['course_id'] ?>">
							<?php endwhile; ?>
							<!-- </div> -->
						<?php endif; ?>

						<div class="form-group">
							<label for="" class="control-label">Start</label>
							<input type="date" name="start_date" class="form-control form-control-sm" required value="<?php echo isset($start_date) ? $start_date : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">End</label>
							<input type="date" name="end_date" class="form-control form-control-sm" required value="<?php echo isset($end_date) ? $end_date : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Description</label>
							<textarea name="description" id="" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=tracer_list'">Cancel</button>
				</div>
			</form>
			<button class="btn btn-warning mr-2" type="button" onclick="location.href = 'index.php?page=tracer_list'">Survey List</button>
		</div>
	</div>
</div>
<script>
	$('#manage_tracer').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_survey',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=tracer_list')
					},1500)
				}
			}
		})
	})
</script>


<!-- <style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	
	$('#manage-question').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_question',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_question').click(function(){
		start_load()
		var cat = $('#manage-question')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='question']").val($(this).attr('data-question'))
		end_load()
	})
	$('.delete_question').click(function(){
		_conf("Are you sure to delete this question?","delete_question",[$(this).attr('data-id')])
	})
	function delete_question($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_question',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script> -->