<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	
<?php include('./header.php'); ?>


</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#59b6ec61;
		display: flex;
		align-items: center;
		background: url(assets/img/Admin.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #fff;
}

.btn-primary{
	background: #0a4d01;
	border: #0a4d01;
}

.btn-primary:hover{
	background: #159c02;
	border: #dfe200;
}

.link{
	color: #0a4d01;
}

.link:hover{
	color: #159c02;
}

</style>

<body>

  <main id="main" class=" bg-dark">
  		<div id="login-left">
  		</div>

  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="create_acc" >
					  	<center><h1>Create Account</h1></center>
                        <div class="form-group">
  							<label for="username" class="control-label">First Name</label>
  							<input type="text" name="firstname" class="form-control" required>
  						</div>
                        <div class="form-group">
  							<label for="username" class="control-label">Middle Initial</label>
  							<input type="text" name="middle" class="form-control" required>
  						</div>
                        <div class="form-group">
  							<label for="username" class="control-label">Last Name</label>
  							<input type="text" name="lastname" class="form-control" required>
  						</div> 
						<div class="form-group">
  							<label for="username" class="control-label">Account Username</label>
  							<input type="text" id="username" name="acc_name" class="form-control" required>
  						</div>
                        <div class="form-group">
                            <label for="" class="control-label">Department</label>
                                <select class="custom-select select2" name="course_id" required>
                                    <option></option>
                                        <?php 
                                            $course = $conn->query("SELECT * FROM courses order by course asc");
                                                while($row=$course->fetch_assoc()):?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['course'] ?></option>
                                                <?php endwhile; ?>
                                </select>
                        </div>  
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control" required>
  						</div>
						<div id="error_message">                                   
						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 mb-3 btn-primary">Create Account</button>
						</center>
  					</form>
  				</div>
  			</div>
  		</div>
  </main>

</body>

<script>
$('#create_acc').submit(function(e){
    e.preventDefault()
    // start_load()
    $.ajax({
        url:'ajax.php?action=signup2',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp == 1){
                location.replace('dept_login.php')
            }else{
                $('#error_message').html('<div class="alert alert-danger">Department account taken!</div>')
                // end_load()
            }
        }
    })
})

$('.select2').select2({
	placeholder:"Select Department",
    width:"100%"
})
</script>	
</html>