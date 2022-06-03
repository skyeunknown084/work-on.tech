<?php 
include 'db_connect.php';
// error_reporting(0);
session_start();
if(isset($_GET['id'])){
	// Decrypt ID Param
	$decrypt_1 = base64_decode($_GET['id']);
	// Get ID on url
	$up_id = ($decrypt_1 / 9234123120);

	$qryprogress = $conn->query("SELECT * FROM user_productivity where id = ".$up_id)->fetch_array();
	foreach($qryprogress as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-progress">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<input type="hidden" name="notif_id" value="<?php echo isset($notif_id) ? $notif_id : '1' ?>">
		<select class="hide" name="leader">
		<?php 
		$lead = $conn->query("SELECT * FROM task_list where task_owner =".$_SESSION['login_id']." OR leader =".$_SESSION['login_id']);
		if($row= $lead->fetch_assoc()){ ?>
		<option value="<?php echo $row['leader'] ?>" <?php echo isset($leader) && $leader == $row['leader'] ? "selected" : 'selected' ?> selected><?php echo ucwords($row['leader']) ?></option>
		<?php } ?>
		</select>
		
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
		              <label for="" class="control-label">Task Name</label>
		              <select class="form-control form-control-sm select2" name="task_id" >
		              	<option></option>
		              	<?php 
		              	$tasks = $conn->query("SELECT * FROM task_list where project_id = ".$_GET['pid']." order by task asc ");
		              	while($row= $tasks->fetch_assoc()):
		              	?>
		              	<option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
		              	<?php endwhile; ?>
		              </select>
		            </div>
					<div class="form-group">
						<label for="" class="control-label">Add Task File</label>
						<div class="custom-file">
							<input type="file" class="" id="custom_file" name="taskfile" <?php echo isset($file_name) ? $file_name : '' ?> onchange="displayFile(this,$(this))" required>
						</div>
					</div>
					<div class="form-group d-flex file-display">
						<?php
						$fileqry = $conn->query("SELECT * FROM user_productivity up INNER JOIN task_list t ON up.task_id = t.id WHERE up.project_id = ".$_GET['pid']);
						while($row= $fileqry->fetch_assoc()){
							$file_name = $row['file_name'];
							$file_type = $row['file_type'];
							$file_size = $row['file_size'];
							$file_path = $row['file_path'];
							if($file_type == 'pdf'){ ?>
							<a target="_blank" id="theFile" class="text-primary pdf-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
                            <?php 
                            }
                            elseif($file_type == 'docx'){ ?>
                            <a target="_blank" id="theFile" class="text-primary docx-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
                        	<?php 
                            }
                            elseif($file_type == 'xlsx'){ ?>
                            <a target="_blank" id="theFile" class="text-primary xlsx-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
                            <?php 
                            }
                            elseif($file_type == 'pptx'){ ?>
                            <a target="_blank" id="theFile" class="text-primary pptx-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}
							elseif($file_type == 'png'){ ?>
							<a target="_blank" id="theFile" class="text-primary png-file img-thumbnail">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}							
							elseif($file_type == 'jpg'){ ?>
							<a target="_blank" id="theFile" class="text-primary jpg-file img-thumbnail">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}
							elseif($file_type == 'gif'){ ?>
							<a target="_blank" id="theFile" class="text-primary gif-file img-thumbnail">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}
							elseif($file_type == 'zip'){ ?>
							<a target="_blank" id="theFile" class="text-primary zip-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}
							elseif($file_type == 'rar'){ ?>
							<a target="_blank" id="theFile" class="text-primary rar-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
							<?php 
							}
							elseif($file_type == ''){ ?>
							<a target="_blank" id="theFile" class="text-primary none-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'No File Attached' ?>
							</a>
                        	<?php 
                            }
                            else{ ?>
                            <a target="_blank" id="theFile" class="text-primary original-file" href="<?php echo $file_path ?>">
								<?php echo isset($file_name) ? $file_name :'' ?>
							</a>
                        <?php }
						} ?>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group pb-4 mb-4">
						<label for="description">Progress Description</label>
						<textarea name="description" id="task_progress_desc" cols="30" rows="10" class="form-control">
							<?php echo isset($description) ? $description : '' ?>
						</textarea>
					</div>					
				</div>
			</div>
		</div>
	</form>
</div>
<style>
	.custom-file .custom-file-input {
		height: 1rem !important;
		padding: 0 !important;
	}
</style>
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
	function displayFile(input,_this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#theFile').attr('href', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
    $('#manage-progress').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_progress',
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
</script>