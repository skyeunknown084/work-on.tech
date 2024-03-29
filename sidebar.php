<?php
error_reporting(0);
  // $chair_qry = $conn->query("SELECT * FROM project_list where chair_id = ".$_SESSION['login_id'])->fetch_array();
	// foreach($qryprogress as $k => $v){
	// 	$chair[$k] = $v;
	// }
?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown brand-logo mb-5">
      <a href="./" class="nav-item brand-link">
        <?php if($_SESSION['login_type'] == 1): ?>
          <img src="assets/img/work-on-logo.png" height="40px" >
        <h3 class="text-center p-0 m-0 hide"><b>ADMIN</b></h3>
        <?php else: ?>
          <img src="assets/img/work-on-logo.png" height="40px"> 
        <h3 class="text-center p-0 m-0 hide"><b>USER</b></h3>
        <?php endif; ?>
      </a>
    </div>
    <div class="sidebar pb-4 mb-5">
      <nav class="mt-4">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="hide">
            <a href="./" class="nav-item">
              <?php if($_SESSION['login_type'] == 1): ?>
                <img src="assets/img/work-on-logo.png" height="40px" >
              <h3 class="text-center p-0 m-0 hide"><b>ADMIN</b></h3>
              <?php else: ?>
                <img src="assets/img/work-on-logo.png" height="40px"> 
              <h3 class="text-center p-0 m-0 hide"><b>USER</b></h3>
              <?php endif; ?>
            </a> 
          </li>
          <li class="nav-item dropdown mt-2">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>  
          
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link nav-edit_group">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if($_SESSION['login_type'] == 1 || $_SESSION['chair']['chair_id'] == $_SESSION['login_id']): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Create New Project</p>
                </a>
              </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=project-list" class="nav-link nav-project-list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Project List</p>
                </a>
              </li>
            </ul>
          </li>
          
          <?php if($_SESSION['login_type'] == 1 || $_SESSION['chair']['chair_id'] == $_SESSION['login_id']) : ?>
          <li class="nav-item">
            <a href="./index.php?page=reports" class="nav-link nav-reports">
              <i class="fas fa-th-list nav-icon"></i>
              <p>Reports</p>
            </a>
          </li>
          <?php endif; ?>
          <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>