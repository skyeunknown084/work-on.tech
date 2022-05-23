<div class="col-lg-12">
	<ul class="nav nav-pills ml-auto p-2">
		<li class="nav-item"><a class="nav-link active" href="#list" data-toggle="tab">List</a></li>
		<li class="nav-item"><a class="nav-link" href="#files" data-toggle="tab">Files</a></li>
	</ul>
	<hr class="border-primary mt-0 mb-3">
	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane" id="list" role="tabpanel" aria-labelledby="pills-board-tab">
			<?php include 'list.php' ?>
			<div class="d-flex justify-content-center align-tems-center m-1 hide"><h1>Board Card (Drag & Drop) - Coming Soon!</h1></div>
		</div>
		<div class="tab-pane" id="files" role="tabpanel" aria-labelledby="pills-files-tab">
			<?php include 'files.php' ?>

			<div id="display-files"></div>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
	.users-list>li img {
	    border-radius: 50%;
	    height: 35px;
	    width: 35px;
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
	// $(document).ready(function(){
	// 	$('#data-list').dataTable();	
    //     $('.delete_project').click(function(){
    //     _conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
    //     })

	// })
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