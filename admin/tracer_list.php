<?php include('db_connect.php');?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h1>Survey List</h1>
                <div class="card-tools">
                    <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="index.php?page=new_tracer"><i class="fa fa-plus"></i> Add New Survey</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table tabe-hover table-bordered" id="list">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($_SESSION['login_type'] == 1): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM survey_set order by date(start_date) asc,date(end_date) asc ");
                        while($row= $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <th class="text-center"><?php echo $i++ ?></th>
                            <td><b><?php echo ucwords($row['title']) ?></b></td>
                            <td><b class="truncate"><?php echo $row['description'] ?></b></td>
                            <td><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
                            <td><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
                            <td class="text-center">
                                <!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                                </button>
                                <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_survey" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                                </div> -->
                                <div class="btn-group">
                                    <a href="index.php?page=edit_tracer&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
                                    <i class="fas fa-edit"></i>
                                    </a>
                                    <a  href="index.php?page=view_tracer&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
                                    <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-flat delete_survey" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                    </button>
                            </div>
                            </td>
                        </tr>	
                    <?php endwhile; ?>
                    <?php endif; ?>

                    <?php if($_SESSION['login_type'] == 2): ?>
                        <?php
                        $i = 1;
                        $survey = $conn->query("SELECT d.*, s.* from dept_bio d inner join survey_set s on d.course_id = s.department_id where d.id = '" .$_SESSION['login_dept_id']."' order by date(start_date) asc,date(end_date) asc ");
                        while($row=$survey->fetch_assoc()):
                        ?>
                        <tr>
                            <th class="text-center"><?php echo $i++ ?></th>
                            <td><b><?php echo ucwords($row['title']) ?></b></td>
                            <td><b class="truncate"><?php echo $row['description'] ?></b></td>
                            <td><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
                            <td><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
                            <td class="text-center">
                                <!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                                </button>
                                <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_survey" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                                </div> -->
                                <div class="btn-group">
                                    <a href="index.php?page=edit_tracer&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
                                    <i class="fas fa-edit"></i>
                                    </a>
                                    <a  href="index.php?page=view_tracer&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
                                    <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-flat delete_survey" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                    </button>
                            </div>
                            </td>
                        </tr>	
                    <?php endwhile; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.delete_survey').click(function(){
	_conf("Are you sure to delete this survey?","delete_survey",[$(this).attr('data-id')])
	})
	})
	function delete_survey($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_survey',
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
</script>