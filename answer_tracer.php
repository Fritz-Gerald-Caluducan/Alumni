<?php include 'admin/db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM survey_set where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}

?>
<header class="masthead">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
						<h3 class="text-white text-uppercase font-italic">Tracer Form</h3>
                        <hr class="divider my-4" />			
                    <div class="col-md-12 mb-2 justify-content-center">
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>

<div class="col-lg-12">
	<div class="row pt-3 pb-3 justify-content-center">
		<div class="col-md-3">
			<div class="card card-outline card-primary">
				<div class="card-header text-center">
					<h3 class="card-title"><b>Survey Details</b></h3>
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Title: <b><?php echo $stitle ?></b></p>
						<p class="mb-0">Description:</p>
						<small><?php echo $description; ?></small>
						<p>Start: <b><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
						<p>End: <b><?php echo date("M d, Y",strtotime($end_date)) ?></b></p>

					</div>
					<hr class="border-success">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card card-outline card-success">
				<div class="card-header text-center">
					<h3 class="card-title"><b>Survey Questionaire</b></h3>
				</div>
				<form action="" id="manage-tracer">
					<input type="hidden" name="survey_id" value="<?php echo $id ?>">
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM questions where survey_id = $id order by abs(order_by) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['question'] ?></h5>	
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">	
							<?php
								if($row['type'] == 'radio_opt'):
									foreach(json_decode($row['frm_option']) as $k => $v):
							?>
							<div class="icheck-success">
		                        <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
		                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		                     </div>
								<?php endforeach; ?>
						<?php elseif($row['type'] == 'check_opt'): 
									foreach(json_decode($row['frm_option']) as $k => $v):
							?>
							<div class="icheck-success">
		                        <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
		                        <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		                     </div>
								<?php endforeach; ?>
						<?php else: ?>
							<div class="form-group">
								<textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Write Something Here..." ></textarea>
							</div>
						<?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
				</form>
				<div class="card-footer border-top border-success">
					<div class="d-flex w-100 justify-content-center">
						<button class="btn btn-primary mx-3" form="manage-tracer">Submit Answer</button>
						<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=tracer'">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-tracer').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=save_answer',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Thank You.",'success')
					setTimeout(function(){
						location.href = 'index.php?page=tracer'
					},2000)
				}
			}
		})
	})
</script>