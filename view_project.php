<?php
include 'db_connect.php';

// Decrypt ID Param
$decrypt_1 = base64_decode($_GET['id']);
// Get ID on url
$p_id = ($decrypt_1 / 9234123120);

$qry = $conn->query("SELECT * FROM project_list where id = ".$p_id)->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}

?>
<div class="col-lg-12">
	<div class="row">
		<!-- Project Details -->
		<div class="col-md-12">
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
		</div>
		<!-- Task List -->
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<div class="row d-flex">
						<div class="col-6 text-left">
							<label for="" class="">Task List</label>
						</div>
						<div class="col-6 text-right">
							<?php if($_SESSION['login_type'] != 3 ): ?>
								<button class="btn btn-primary bg-primary btn-sm" type="button" id="new_task"><i class="fa fa-plus"></i> New Task</button>
							<?php endif; ?>
						</div>
					</div>					
				</div>
				<div class="card-body">
					<div class="table-responsive xpand xpand-table x-scroll">
						<table class="table table-hover table-striped table-condensed " id="task-list-table">
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

								$tasklistqry = $conn->query("SELECT * FROM task_list where project_id = {$id} order by task asc");
								while($row= $tasklistqry->fetch_assoc()){

									// $user_ids = $row['task_owner'];

									// html description

									// fetch assignee in array
									$qryassignee = $conn->query("SELECT avatar,concat(firstname,' ',lastname) as uname FROM users where id in ({$row['task_owner']}) order by concat(firstname,' ',lastname) asc");

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
										<?= ucwords($row['task']) ?>
									</td>
									<td class="text-left">
										<ul class="users-list clearfix">
											<?php while($assignee = $qryassignee->fetch_assoc()): ?>	
											<li class="d-flex">
												<img src="assets/uploads/<?php echo $assignee['avatar'] ?>" title="<?= $assignee['uname'] ?>" alt="User Image" class="img-circle elevation-2 img-responsive p-0 mr-2" style="width:35px;height:35px;cursor:pointer">
												<a class="users-list-name pt-2" href="#" style="text-decoration:none;font-weight:700;"><?php echo ucwords($assignee['uname']) ?></a>
											</li>
											<?php endwhile ?>
										</ul>
									</td>
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
										<a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>" data-task="<?php echo $row['task'] ?>"><i class="fa fa-eye mx-1"></i> View</a>
										<div class="dropdown-divider"></div>
										<?php if($_SESSION['login_type'] != 3): ?>
										<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $encoded_id ?>" data-task="<?php echo $row['task'] ?>"><i class="fa fa-pencil-alt mx-1"></i> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash mx-1"></i> Delete</a>
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
		
	})
	// Links For Pages & Modal which connect to ajax.php and api.php
	$('#new_task').click(function(){
		uni_modal("New Task For <?php echo ucwords($name) ?>","manage_task.php?pid=<?php echo $id ?>","mid-large")
	})
	// Modal goes to manage_task php to edit
	$('.edit_task').click(function(){
		uni_modal("Edit Task: "+$(this).attr('data-task'),"manage_task.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),"mid-large")
	})
</script>