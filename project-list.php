<?php include'db_connect.php'; 
// if(isset($_SESSION['login_id'])){
// 	$userqry = $conn->query("SELECT * FROM users where id = ".$_SESSION['login_id'])->fetch_array();
// 	foreach($userqry as $k => $v){
// 		$u_[$k] = $v;
// 	}
// }
$where_user = "";
if($_SESSION['login_type'] == 1){
	$where_user = "WHERE manager_id = {$_SESSION['login_id']}";
}
elseif($_SESSION['login_id'] == 3){
	$where_user = "WHERE chair_id = {$_SESSION['login_id']}";
}else{
	$where_user = "WHERE concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%'";
}

?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-body">
			<div class="table-responsive xpand xpand-table x-scroll">
				<table class="table table-hover table-condensed " id="project-list-table">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Project Name</th>
							<th>Members</th>
							<th>Start Date</th>
							<th>Due Date</th>
							<th>Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;

						$prodlistqry = $conn->query("SELECT * FROM project_list $where_user");
						while($row= $prodlistqry->fetch_assoc()){

							$user_ids = $row['user_ids'];

							// html description

							// fetch members in array
							$qrymembers = $conn->query("SELECT avatar,concat(firstname,' ',lastname) as uname FROM users where id in ($user_ids) order by concat(firstname,' ',lastname) asc");

							// Calc Statis / Progress
							// if date_created is over to the start_date of table `project_list` the status should be 'Started'
							$started_qry = $conn->query("SELECT * FROM project_list where id = {$row['id']} AND start_date > now()")->num_rows;
							// if a task in a specific project is started, project status will be 'In-Progress'
							$inprogress_qry = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} AND status = 2")->num_rows;
							// if all task in a specific project is completed, project status will be 'In-Review'
							$inreview_qry = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} AND status = 4")->num_rows;
							// if all task in and task files for a specific project is accomplished, project status will be 'Completed'
							$completed_qry = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']} AND cast(date_uploaded AS DATE) != {$row['end_date']}")->num_rows;

							$tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
							$cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 1")->num_rows;
							$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
							$prog = $prog > 0 ?  number_format($prog,5) : $prog;
							$prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;

							// status calc display on project-list
							if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
								if($started_qry  > 0 && $prod  > 0)
								$row['status'] = 1;
								// elseif($inprogress_qry  > 0)
								// $row['status'] = 2;
								// elseif($inreview_qry  > 0)
								// $row['status'] = 3;
								// elseif($completed_qry  > 0)
								// $row['status'] = 4;
								else
								$row['status'] = 0;
								elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
								$row['status'] = 4;
							endif;
							
							// encrypt id params
							$data = $row['id'];
							// convert to string and make it longer
							$encode_data = (strval($data)*'9234123120');
							// // encrypt data with base64 
							$encoded_id = base64_encode($encode_data);
						?>
						<tr>
							<td class="text-center"><?= $i++ ?></td>
							<td class="text-left">
								<?= ucwords($row['name']) ?>
							</td>
							<td class="text-left">
								<ul class="users-list text-left ms-auto align-left d-flex clearfix p-0">
									<?php while($members = $qrymembers->fetch_assoc()): ?>											
									<li>
										<img src="assets/uploads/<?php echo $members['avatar'] ?>" title="<?= $members['uname'] ?>" alt="User Image" class="img-circle elevation-2 img-responsive p-0 m-0" style="width:40px;height:40px;cursor:pointer">
										<span class="users-list-date"></span>
									</li>
									<?php endwhile ?>
								</ul>
							</td>
							<td class="text-left"><?= date("M d, Y",strtotime($row['start_date'])) ?></td>
							<td class="text-left"><?= date("M d, Y",strtotime($row['end_date'])) ?></td>
							<td class="text-left">
								<?php
								if($row['status'] == 0){
									echo "<span class='badge badge-secondary'>Not Started</span>";
								}elseif($row['status'] == 1){
								echo "<span class='badge badge-primary'>Started</span>";
								}elseif($row['status'] == 2){
								echo "<span class='badge badge-info'>In Progress</span>";
								}elseif($row['status'] == 3){
								echo "<span class='badge badge-warning'>In Review</span>";
								}elseif($row['status'] == 4){
								echo "<span class='badge badge-success'>Completed</span>";
								}
								// elseif($row['status'] == 6){
								// 	echo "<span class='badge badge-success'>Completed</span>";
								// }
								?>
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-round border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								Action
								</button>
								<div class="dropdown-menu" style="">
								<?php if($_SESSION['login_type'] == 3): ?>
									<a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?=$encoded_id;?>" data-id="<?=$encoded_id;?>">
									<i class="fas fa-eye mr-2"></i> View Task</a>
								<?php endif; ?>									
								<?php if($_SESSION['login_type'] != 3): ?>
									<a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?=$encoded_id;?>" data-id="<?=$encoded_id;?>">
									<i class="fas fa-plus mr-2"></i> Add Task</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_project&id=<?=$encoded_id;?>">
									<i class="fas fa-pencil-alt mr-2"></i> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?=$row['id'];?>">
									<i class="fas fa-trash mr-2"></i> Delete</a>
								<?php endif; ?>
								</div>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	.table-responsive .x-scroll table{
		width: 375px !important;
		max-width: 375px !important;
		overflow-x: auto !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#project-list-table').dataTable();	
        $('.delete_project').click(function(){
        _conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
        })

	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
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