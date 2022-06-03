<?php
include 'db_connect.php';
error_reporting(0);
// Decrypt ID Param
$decrypt_1 = base64_decode($_GET['id']);
// Get ID on url
$p_id = ($decrypt_1 / 9234123120);

$qry = $conn->query("SELECT * FROM project_list where id = ".$p_id)->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}

$count_dean = $conn->query("SELECT * FROM users u INNER JOIN project_list p ON p.manager_id = u.id where p.id = ".$id)->num_rows;
$count_chair = $conn->query("SELECT * FROM users u INNER JOIN project_list p ON p.chair_id = u.id where p.id = ".$id)->num_rows;
$count_member = $conn->query("SELECT * FROM users u INNER JOIN project_list p ON concat('[',REPLACE(p.user_ids,',','],['),']') = u.id where p.id = ".$id)->num_rows;
// $projmanager = $conn->query("SELECT concat(firstname,' ',lastname) as name,avatar FROM users WHERE id = $chair_id");
// $projmanager = $projmanager->num_rows > 0 ? $projmanager->fetch_array() : array();

// convert to string and make it longer
// $encode_data = (strval($id)*'9234123120');
// // encrypt data with base64 
// $encoded_id = base64_encode($encode_data);

// calculate progress
$tprog = $conn->query("SELECT * FROM task_list where project_id = ".$id)->num_rows;
$cprog = $conn->query("SELECT * FROM task_list where project_id = ".$id." and status = 1")->num_rows;
$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog,5) : $prog;
$prod = $conn->query("SELECT * FROM user_productivity where project_id = ".$id)->num_rows;
// calculate status
if($status == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
if($prod  > 0  || $cprog > 0)
	$status = 1;
else
	$status = 0;
elseif($status == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
$status = 4;
endif;
?>

<div class="col-lg-12">
	<div class="row">		
		<div class="col-md-12">
			<!-- Project Details -->
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-4">
							<dl>
								<dt><b class="border-bottom border-primary">Project Name</b></dt>
								<dd><?php echo ucwords($name) ?></dd>
								<dt><b class="border-bottom border-primary">Description</b></dt>
								<dd><?php echo html_entity_decode($description) ?></dd>
							</dl>
						</div>
						<div class="col-md-4">
							<dl>
								<dt><b class="border-bottom border-primary">Project Manager</b></dt>
								<dd>
								<ul class="users-list clearfix">
									<?php 
									if(!empty($chair_id)):
										$projmanager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $chair_id order by concat(firstname,' ',lastname) asc");
										while($row=$projmanager->fetch_assoc()):
									?>
									<li class="d-flex">
										<img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image" class="p-1" title="<?= ucwords($row['name']) ?>" style="width:40px;height:40px">
										<a href="#" class="users-list-name pt-2" title="<?= ucwords($row['name']) ?>" style="text-decoration:none;font-weight:700"><?php echo ucwords($row['name']) ?></a>
									</li>
									<?php 
										endwhile;
									endif;
									?>
								</ul>
								</dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd>
									<?php 
									$stat = array("0","1","2","3","4");
									if($stat[$status] == '0'){
										echo "<span class='badge badge-secondary'>Not Started</span>";
									}elseif($stat[$status] == '1'){
									echo "<span class='badge badge-primary'>Started</span>";
									}elseif($stat[$status] == '2'){
									echo "<span class='badge badge-info'>In Progress</span>";
									}elseif($stat[$status] == '3'){
									echo "<span class='badge badge-warning'>In Review</span>";
									}elseif($stat[$status] == '4'){
									echo "<span class='badge badge-success'>Completed</span>";
									}
									// elseif($stat[$status] == 6){
									// 	echo "<span class='badge badge-danger'>Over Due</span>";
									// }
									?>
								</dd>
							</dl>						
							
						</div>
						<div class="col-md-4">
							<dl>
								<dt><b class="border-bottom border-primary">Start Date</b></dt>
								<dd><?php echo date("F d, Y",strtotime($start_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">End Date</b></dt>
								<dd><?php echo date("F d, Y",strtotime($end_date)) ?></dd>
							</dl>
						</div>						
						<div class="col-sm-4 hide">
							<dl>
							</dl>
						</div>
					</div>
				</div>
			</div>
			<!-- Task List -->
			<div class="card card-outline card-primary">
				<div class="card-header">
					<div class="row d-flex">
						<div class="col-6 text-left">
							<label for="" class="">Task List</label>
						</div>
						<?php if($_SESSION['login_type'] != 3 || $_SESSION['login_id'] == $chair_id){ ?>
						<div class="col-6 text-right">
							<button class="btn btn-primary btn-sm" type="button" id="new_task"><i class="fa fa-plus"></i> New Task</button>
						</div>
						<?php } ?>
					</div>					
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<?php if($_SESSION['login_type'] == 3){ ?>
						<table class="table" id="task-list-table">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="40%">Task</th>
									<th width="30%">Assignee</th>
									<th width="15%">Status</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$owner_id = $_SESSION['login_id'];
								$tasklistqry = $conn->query("SELECT * FROM task_list where notif_status = 1 AND task_owner = ".$owner_id." AND project_id = ".$id);
								while($row = $tasklistqry->fetch_assoc()):
									$status = $row['status'];
									// $user_id = $row['task_owner'];

									// html description

									// fetch assignee in array
									

									// encrypt id params
									$data = $row['id'];
									// convert to string and make it longer
									$encode_data = (strval($data)*'9234123120');
									// // encrypt data with base64 
									$encoded_id = base64_encode($encode_data);
								?>
								<tr>
									<td class="text-left"><?= $i++ ?></td>
									<td class="text-left">
										<?php echo $row['task'] ?>
									</td>
									<td class="text-left">
										<ul class="users-list clearfix">
										<?php 
											$qryassignee = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users u INNER JOIN task_list t ON u.id = t.task_owner where t.task_owner = ".$row['task_owner']);
											if($t_owner = $qryassignee->fetch_assoc()): ?>	
											<li class="d-flex">
												<?php echo ucwords($t_owner['uname']) ?>
											</li>
											<?php endif ?>
										</ul>
									</td>
									<td class="text-left">
										<?php 
										$stat = array("0","1","2","3","4");
										if($stat[$status] == '0'){
											echo "<span class='badge badge-secondary'>Not Started</span>";
										}elseif($stat[$status] == '1'){
										echo "<span class='badge badge-primary'>Started</span>";
										}elseif($stat[$status] == '2'){
										echo "<span class='badge badge-info'>In Progress</span>";
										}elseif($stat[$status] == '3'){
										echo "<span class='badge badge-warning'>In Review</span>";
										}elseif($stat[$status] == '4'){
										echo "<span class='badge badge-success'>Completed</span>";
										}
										// elseif($stat[$status] == 6){
										// 	echo "<span class='badge badge-danger'>Over Due</span>";
										// }
										?>
									</td>
									<td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-round border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										Action
										</button>
										<div class="dropdown-menu" style="">
										<?php if($_SESSION['login_type'] == 1 || $_SESSION['login_id'] == $chair_id){ ?>
										<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>" data-task="<?php echo $row['task'] ?>"><i class="fa fa-pencil-alt mx-1"></i> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash mx-1"></i> Delete</a>
										<?php }elseif($_SESSION['login_type'] == 3){ ?>
											<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>" data-task="<?php echo $row['task'] ?>"><i class="fa fa-pencil-alt mx-1"></i> Edit</a>
										<?php } ?>
										</div>
									</td>
								</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
						<?php } else { ?>
							<table class="table" id="task-list-table">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="40%">Task</th>
									<th width="30%">Assignee</th>
									<th width="15%">Status</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$owner_id = $_SESSION['login_id'];
								$tasklistqry = $conn->query("SELECT * FROM task_list where notif_status = 1 AND project_id = ".$id);
								while($row = $tasklistqry->fetch_assoc()):

									// $user_id = $row['task_owner'];

									// html description

									// fetch assignee in array
									

									// encrypt id params
									$data = $row['id'];
									// convert to string and make it longer
									$encode_data = (strval($data)*'9234123120');
									// // encrypt data with base64 
									$encoded_id = base64_encode($encode_data);
								?>
								<tr>
									<td class="text-left"><?= $i++ ?></td>
									<td class="text-left">
										<?php echo $row['task'] ?>
									</td>
									<td class="text-left">
										<ul class="users-list clearfix">
										<?php 
											$qryassignee = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users u INNER JOIN task_list t ON u.id = t.task_owner where t.task_owner = ".$row['task_owner']);
											if($t_owner = $qryassignee->fetch_assoc()): ?>	
											<li class="d-flex">
												<?php echo ucwords($t_owner['uname']) ?>
											</li>
											<?php endif ?>
										</ul>
									</td>
									<td class="text-left">
										<?php 
										$stat = array("0","1","2","3","4");
										if($stat[$status] == '0'){
											echo "<span class='badge badge-secondary'>Not Started</span>";
										}elseif($stat[$status] == '1'){
										echo "<span class='badge badge-primary'>Started</span>";
										}elseif($stat[$status] == '2'){
										echo "<span class='badge badge-info'>In Progress</span>";
										}elseif($stat[$status] == '3'){
										echo "<span class='badge badge-warning'>In Review</span>";
										}elseif($stat[$status] == '4'){
										echo "<span class='badge badge-success'>Completed</span>";
										}
										// elseif($stat[$status] == 6){
										// 	echo "<span class='badge badge-danger'>Over Due</span>";
										// }
										?>
									</td>
									<td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-round border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										Action
										</button>
										<div class="dropdown-menu" style="">
										<?php if($_SESSION['login_type'] != 3 || $_SESSION['login_id'] == $chair_id){ ?>
										<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>" data-task="<?php echo $row['task'] ?>"><i class="fa fa-pencil-alt mx-1"></i> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash mx-1"></i> Delete</a>
										<?php } ?>
										</div>
									</td>
								</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
						<?php } ?>
					</div>
				</div>				
			</div>
			<!-- Task Files -->
			<div class="card card-outline card-success">
				<div class="card-header">
					<div class="row d-flex">
						<div class="col-6 text-left">
							<label for="" class="">Task Files</label>
						</div>
						<div class="col-6 text-right">
							<button class="btn btn-primary bg-primary btn-sm" type="button" id="new_productivity"><i class="fa fa-plus"></i> Add Attachment File</button>
						</div>
					</div>					
				</div>
				<div class="card-body">
					<div class="table-responsive xpand xpand-table x-scroll">
						<table class="table table-hover table-striped table-condensed " id="task-files-table">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="85%">Task</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;

								// $tasklistqry = $conn->query("SELECT * FROM user_productivity up INNER JOIN task_list t ON up.task_id = t.id WHERE up.project_id = $id order by unix_timestamp(up.date_created) desc");
								$tasklistqry = $conn->query("SELECT * FROM user_productivity  WHERE project_id = $id order by date_created desc");
								while($row= $tasklistqry->fetch_assoc()){
									// html description

									// get taskname
									$tasknameqry = $conn->query("SELECT * FROM task_list WHERE id = ".$row['task_id']);
									// encrypt id params
									$data = $row['id'];
									// convert to string and make it longer
									$encode_data = (strval($data)*'9234123120');
									// // encrypt data with base64 
									$encoded_id = base64_encode($encode_data);
								?>
								<tr>
									<td class="text-left"><?= $i++ ?></td>
									<td class="text-left">
										<?php while($taskname = $tasknameqry->fetch_assoc()){ ?>
										<?= ucwords($taskname['task']) ?>
										<?php } ?>
									</td>
									<td class="text-center">
										<span class="btn-group dropleft float-right">
											<button class="btn btn-default btn-sm btn-round border-info wave-effect text-info py-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
												Action <i class="fa fa-ellipsis-v"></i>
											</button>
											<div class="dropdown-menu">
												<?php if($_SESSION['login_type'] != 3 ){ ?>
												<a class="dropdown-item view_progress" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>"  data-task="<?php echo $row['task'] ?>"><i class="fa fa-comments mx-1"></i> Comments</a>
												<div class="dropdown-divider"></div>												
												<a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash mx-1"></i> Delete</a>												
												<?php }else{ ?>
												<a class="dropdown-item view_progress" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>"  data-task="<?php echo $row['task'] ?>"><i class="fa fa-comments mx-1"></i> Comments</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item manage_progress" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>"  data-task="<?php echo $row['task'] ?>"><i class="fa fa-pencil-alt mx-1"></i> Edit</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash mx-1"></i> Delete</a>
												<?php } ?>
											</div>
										</span>
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
	.btn_url {
		text-decoration: none !important;
		color: #fff !important;
	}
	.users-list>li img {
	    border-radius: 50%;
	    height: 57px;
	    width: 57px;
	    object-fit: cover;
	}
	.users-list>li {
		width: 33.33% !important;
	}
	.truncate {
		-webkit-line-clamp:1 !important;
	}
</style>
<script>
	// dataTables Search and Sort
	$(document).ready(function(){
		$('#task-list-table').dataTable();		
		$('#task-files-table').dataTable();		
	})
	// Links For Pages & Modal which connect to ajax.php and api.php
	$('#new_task').click(function(){
		uni_modal("New Task For <?php echo ucwords($name) ?>","new_task.php?pid=<?php echo $id ?>","mid-large")
	})
	// Modal goes to manage_task php to edit
	$('.edit_task').click(function(){
		uni_modal("Edit Task: "+$(this).attr('data-task'),"manage_task.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),"mid-large")
	})
	// Add Link to Modal for Add Task Productivity
	$('#new_productivity').click(function(){		
		uni_modal("<i class='fa fa-plus'></i> Task Progress","manage_progress.php?pid=<?php echo $id ?>",'large')
	})
	// View Link to Modal for Add Task Productivity
	$('.view_progress').click(function(){
		uni_modal("<i class='fa fa-comments'></i> Task Comments","view_progress.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),'large')
	})
	// Edit Link to Modal for Add Task Productivity
	$('.manage_progress').click(function(){		
		uni_modal("<i class='fa fa-edit'></i> Edit Progress","manage_progress.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),'large')
	})
	// Delete Task
	$('.delete_task').click(function(){
	_conf("Are you sure to delete this task?","delete_task",[$(this).attr('data-id')])
	});
	function delete_task($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_task',
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

	// Delete Link to Modal for Add Task Productivity
	$('.delete_progress').click(function(){
	_conf("Are you sure to delete this progress?","delete_progress",[$(this).attr('data-id')])
	});
	function delete_progress($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_progress',
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