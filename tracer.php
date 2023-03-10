<?php include 'admin/db_connect.php' ?>
<?php 
$answers = $conn->query("SELECT distinct(survey_id) from answers where user_id ={$_SESSION['login_id']}");
$ans = array();
while($row=$answers->fetch_assoc()){
	$ans[$row['survey_id']] = 1;
}
?>

<header class="masthead">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end mb-4 page-title">
                        <h3 class="text-white font-italic text-uppercase">Tracer Form</h3>
                        <hr class="divider my-4" />

                    <div class="col-md-12 mb-2 justify-content-center">
                    </div>                        
                    </div>
                    
                </div>
            </div>
        </header>

<div class="container mt-3 pt-2">
<div class="col-lg-12">
	<!-- <div class="d-flex w-100 justify-content-center align-items-center mb-2">
		<label for="" class="text-white">Find Survey</label>
		<div class="input-group input-group-sm col-sm-5">
          <input type="text" class="form-control" id="filter" placeholder="Enter keyword...">
          <span class="input-group-append">
            <button type="button" class="btn btn-primary btn-flat" id="search">Search</button>
          </span>
        </div>
	</div> -->
	<div class="card pt-2 m-auto">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend shadow rounded">
                        <span class="input-group-text" id="filter-field"><i class="fa fa-search"></i></span>
                      </div>
                      <input type="text" class="form-control" id="filter" placeholder="Find Survey" aria-label="Filter" aria-describedby="filter-field">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btn-block btn-md" id="search">Search</button>
                </div>
            </div>
            
        </div>
    </div>
	<div class=" w-100 text-white" id='ns' style="display: none"><center><b>No Result.</b></center></div>
	<div class="row pt-4 pb-5">
		<?php 
		// $survey = $conn->query("SELECT * FROM survey_set where '".date('Y-m-d')."' between date(start_date) and date(end_date) order by rand() ");

		// $survey = $conn->query("SELECT s.*, a.id as aid from survey_set s inner join alumnus_bio a on s.department_id = a.course_id where s.department_id = 0 or a.id = '" .$_SESSION['login_alumnus_id']."' and '".date('Y-m-d')."' between date(start_date) and date(end_date) order by rand() ");

		$survey = $conn->query("SELECT a.*, s.* from alumnus_bio a inner join survey_set s on a.course_id = s.department_id or s.department_id = '0' where a.id = '" .$_SESSION['login_alumnus_id']."' and '".date('Y-m-d')."' between date(start_date) and date(end_date) order by rand() ");
		
		while($row=$survey->fetch_assoc()):?>

		<div class="col-md-4 py-1 px-2 survey-item">
			<div class="card card-outline card-primary">
              <div class="card-header text-center bg-warning">
                <h3 class="card-title"><?php echo ucwords($row['title']) ?></h3>

                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div> -->
              </div>
              <div class="card-body" style="display: block;">
               <?php echo $row['description'] ?>
               <div class="row">
               	<hr class="border-primary">
               	<div class="d-flex justify-content-center w-100 text-center">
               		<?php if(!isset($ans[$row['id']])): ?>
               			<a href="index.php?page=answer_tracer&id=<?php echo $row['id'] ?>" class="btn btn-md badge badge-success pt-2"><i class="fa fa-pen-square"></i> Take Survey</a>
               		<?php else: ?>
               			<p class="text-primary border-top border-primary">Done</p>
               		<?php endif; ?>
               	</div>
               </div>
              </div>
            </div>
		</div>
	<?php endwhile; ?>
	</div>
</div>
</div>
<script>
	function find_survey(){
		start_load()
		var filter = $('#filter').val()
			filter = filter.toLowerCase()
			console.log(filter)
		$('.survey-item').each(function(){
			var txt = $(this).text()
			if((txt.toLowerCase()).includes(filter) == true){
				$(this).toggle(true)
			}else{
				$(this).toggle(false)
			}
			if($('.survey-item:visible').length <= 0){
				$('#ns').show()
			}else{
				$('#ns').hide()
			}
		})
		end_load()
	}
	$('#search').click(function(){
		find_survey()
	})
	$('#filter').keypress(function(e){
		if(e.which == 13){
		find_survey()
		return false;
		}
	})
</script>