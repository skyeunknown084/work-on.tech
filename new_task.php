<?php 
include 'db_connect.php';
session_start();
if(isset($_GET['id'])){
	// Decrypt ID Param
	$decrypt_1 = base64_decode($_GET['id']);
	// Get ID on url
	$t_id = ($decrypt_1 / 9234123120);

	$managetaskqry = $conn->query("SELECT * FROM task_list where id = ".$t_id)->fetch_array();
	foreach($managetaskqry as $k => $v){
		$$k = $v;
	}

	$leader = $_SESSION['login_id'];
	// convert to string and make it longer
	// $encode_data = ($id*'9234123120');
	// // encrypt data with base64 
	// $encoded_id = base64_encode($encode_data);
}
?>
<div class="container-fluid">
	<form action="" id="add-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="active" value="<?php echo isset($active) ? $active : '0' ?>">
		<input type="hidden" name="notif_status" value="<?php echo isset($notif_status) ? $notif_status : '0' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<input type="hidden" name="leader" value="<?php echo isset($_SESSION['login_id']) ? $_SESSION['login_id'] : '' ?>">
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" value="<?php echo isset($task) ? $task : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="">Assignee</label>
			<select name="task_owner" id="task_owner" class="custom-select custom-select-sm" required>
				<option>Select Assignee</option>
				<?php 
				$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as uname FROM users where type = 3 AND id != ".$_SESSION['login_id']);
				while($row= $employees->fetch_assoc()):
				?>				
				<option value="<?php echo $row['id'] ?>" <?php echo isset($task_owner) && in_array($row['id'],explode(',',$task_owner)) ? "selected" : '' ?>><?php echo ucwords($row['uname']) ?></option>
				<?php
				endwhile; ?>
			</select>
			
		</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Not Started</option>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Started</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>In Progress</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>In Review</option>
				<option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>Completed</option>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){
		$('.select2').select2({
			// dropdownParent: $('#uni_modal'),
			placeholder:"Please select here",
			width: "100%"
		});
		// for text area
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				[ 'style', [ 'style' ] ],
				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				[ 'fontname', [ 'fontname' ] ],
				[ 'fontsize', [ 'fontsize' ] ],
				[ 'color', [ 'color' ] ],
				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				[ 'table', [ 'table' ] ],
				[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
			]
		})
	})
    
	 $('#add-task').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_task',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");					
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })

	// $('#manage-task').submit(function(e){
    // 	e.preventDefault()
    // 	start_load()
    // 	$.ajax({
    // 		url:'ajax.php?action=save_task_notif',
	// 		data: new FormData($(this)[0]),
	// 	    cache: false,
	// 	    contentType: false,
	// 	    processData: false,
	// 	    method: 'POST',
	// 	    type: 'POST',
	// 		success:function(resp){
	// 			if(resp == 1){
	// 				// alert_toast('Data successfully saved',"success");
	// 				setTimeout(function(){
	// 					location.reload()
	// 				},1500)
	// 			}
	// 		}
    // 	})
    // })
</script>