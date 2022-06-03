<?php include'db_connect.php'; 
$where_user = "";
if($_SESSION['login_type'] == 1){
	$where_user = "WHERE manager_id = {$_SESSION['login_id']}";
}
if($_SESSION['login_type'] == 3){
	$where_user = "WHERE chair_id = {$_SESSION['login_id']} OR concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%'";
}
// elseif($_SESSION['login_id'] == 2){
// 	$where_user = "WHERE chair_id = {$_SESSION['login_id']}";
// }

?>
<div class="col-lg-12">

	<ul class="nav nav-pills ml-auto p-2">
		<li class="nav-item"><a class="nav-link active" href="#list" data-toggle="tab">List</a></li>
		<li class="nav-item"><a class="nav-link" href="#files" data-toggle="tab">Files</a></li>
	</ul>
	<hr class="border-primary mt-0 mb-3">
	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane active" id="list" role="tabpanel" aria-labelledby="pills-list-tab">
			<div class="card card-outline card-success">
				<div class="card-body">
					<div class="table-responsive xpand xpand-table x-scroll">
						<table class="table table-hover table-condensed " id="project-list-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Project Name</th>
									<th>Chair</th>
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
										$chair_id = $row['chair_id'];

										// html description

										// fetch chairs in array
										$qrychair = $conn->query("SELECT avatar,concat(firstname,' ',lastname) as uname FROM users where id = $chair_id order by concat(firstname,' ',lastname) asc");
										
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
										$completed_qry = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']} AND cast(date_created AS DATE) != {$row['end_date']}")->num_rows;

										$tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
										$cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 1")->num_rows;
										$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
										$prog = $prog > 0 ?  number_format($prog,4) : $prog;
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
											<?php if($ch = $qrychair->fetch_assoc()): ?>											
											<li>
												<img src="assets/uploads/<?php echo $ch['avatar'] ?>" title="<?= $ch['uname'] ?>" alt="User Image" class="img-circle elevation-2 img-responsive p-0 m-0" style="width:40px;height:40px;cursor:pointer">
												<span class="users-list-date"></span>
											</li>
											<?php endif ?>
										</ul>
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
										$stat = array("0","1","2","3","4");
										if($stat[$row['status']] == 0){
											echo "<span class='badge badge-secondary'>Not Started</span>";
										}elseif($stat[$row['status']] == 1){
										echo "<span class='badge badge-primary'>Started</span>";
										}elseif($stat[$row['status']] == 2){
										echo "<span class='badge badge-info'>In Progress</span>";
										}elseif($stat[$row['status']] == 3){
										echo "<span class='badge badge-warning'>In Review</span>";
										}elseif($stat[$row['status']] == 4){
										echo "<span class='badge badge-success'>Completed</span>";
										}
										// elseif($row['status'] == 6){
										// 	echo "<span class='badge badge-danger'>Over Due</span>";
										// }
										?>
									</td>
									<td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-round border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										Action
										</button>
										<div class="dropdown-menu" style="">
																		
										<?php if($_SESSION['login_type'] == 1){ ?>
											<a class="dropdown-item view_project" href="./index.php?page=view-project&id=<?=$encoded_id;?>" data-id="<?=$encoded_id;?>">
											<i class="fas fa-plus mr-2"></i> Add Task</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="./index.php?page=edit_project&id=<?=$encoded_id;?>">
											<i class="fas fa-pencil-alt mr-2"></i> Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?=$row['id'];?>">
											<i class="fas fa-trash mr-2"></i> Delete</a>
										<?php }elseif($_SESSION['chair']['chair_id'] == $_SESSION['login_id']){ ?>
											<a class="dropdown-item view_project" href="./index.php?page=view-project&id=<?=$encoded_id;?>" data-id="<?=$encoded_id;?>">
											<i class="fas fa-plus mr-2"></i> Add Task</a>
										<?php }elseif($_SESSION['login_id'] != 1){ ?>
											<a class="dropdown-item view_project" href="./index.php?page=view-project&id=<?=$encoded_id;?>" data-id="<?=$encoded_id;?>">
											<i class="fas fa-plus mr-2"></i> View Task</a>
										<?php } ?>
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
		<div class="tab-pane" id="files" role="tabpanel" aria-labelledby="pills-files-tab">
			<div class="card card-outline card-success">
				<div class="card-body">
					<div class="table-responsive xpand xpand-table x-scroll">
						<table class="table table-hover table-condensed " id="project-files-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Task Name</th>
									<th>File Name</th>
									<th>Size</th>
                        			<th>Type</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								function formatBytes($bytes) {
									if ($bytes > 0) {
										$i = floor(log($bytes) / log(1024));
										$sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
										return sprintf('%.02F', round($bytes / pow(1024, $i),1)) * 1 . ' ' . @$sizes[$i];
									} else {
										return 0;
									}
								}
								
								$prodlistqry = $conn->query("SELECT * FROM user_productivity up INNER JOIN task_list t ON t.id = up.task_id");
								while($row= $prodlistqry->fetch_assoc()){
									$imageURL = 'assets/uploads/files/'.$row["file_name"];
									$exFormat = $row['file_type'];
									$file_name = $row['file_name'];
									$file_path = $row['file_path'];
									$file_size = $row['file_size'];
									$taskname = $row['task'];									
								?>
								<tr>
									<td class="text-center" ><?= $i++ ?></td>
									<td class="text-left">
										<?= $taskname ?>
									</td>
									<td class="text-left">
										<a></a><?= $file_name ?>
									</td>
									<td class="text-left"><?= formatBytes($file_size) ?></td>
									<td class="text-left"><?= $exFormat ?></td>
									<td class="text-center">
										<a target="_blank" href="<?php echo $file_path; ?>" title="View File: <?php echo $file_name ?>" class="text-success view_file mr-2"><i class="fa fa-eye text-info"></i></a>
										<a download="<?php echo $file_path; ?>" href="<?php echo $file_path; ?>" title="Download" class="text-success download_file mr-2"><i class="fa fa-download text-info"></i></a>								
										<a class="delete_file" href="javascript:void(0)"  id="file_<?php echo $row['id'] ?>" title="Delete" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash text-danger"></i></a>
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
		$('#project-files-table').dataTable();
		$('.delete_file').click(function(){
			_conf("Are you sure to delete this file?","delete_file",[$(this).attr('data-id')])
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

	function delete_file($id){
		start_load()
        var id = $(this).attr('data-id');
        var path = $( '#file_'+id ).attr("href");
        
		$.ajax({
			url:'ajax.php?action=delete_file',
			method:'POST',      
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
                    end_load()
				}
			}
		})
	}
</script>