<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li class="hide">
        <a class="nav-link text-white"  href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item hide">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown mx-0 px-0">
        <a class="nav-link mx-0 px-0 notif-toggle" data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
          <span>
            <div class="badge-pill mt-0">
              <span class="fa fa-bell mr-0 mb-1 mt-0 pt-0" style="font-size:25px;padding:0;"></span>              
              <!-- admin bell -->
              <?php $bell_count_admin_accept = $conn->query("SELECT * FROM task_list where active = 0 and notif_status = 1 and admin_id = ".$_SESSION['login_id'])->num_rows; ?>              
              <?php $bell_count_admin_submit = $conn->query("SELECT * FROM user_productivity where active = 0 and notif_id = 1 and admin_id = ".$_SESSION['login_id'])->num_rows; ?>              
              <?php $bell_count_admin = $bell_count_admin_accept + $bell_count_admin_submit ?>
              <!-- project chair bell -->
              <?php $bell_count_chair_accept = $conn->query("SELECT * FROM task_list where active = 0 and notif_status = 1 and leader = ".$_SESSION['login_id'])->num_rows; ?>              
              <?php $bell_count_chair_submit = $conn->query("SELECT * FROM user_productivity where active = 0 and notif_id = 1 and leader = ".$_SESSION['login_id'])->num_rows; ?>              
              <!-- member bell -->
              <?php $bell_count_member = $conn->query("SELECT * FROM task_list where active = 0 and notif_status = 0 and task_owner = ".$_SESSION['login_id'])->num_rows; ?>              
              <!-- count bell for members task, chair accept and chair submit feedback per login user -->
              <?php $bell_count_chair_member = $bell_count_chair_accept + $bell_count_chair_submit + $bell_count_member ?>

              <?php if($bell_count_admin>0 && $_SESSION['login_id'] == 1){ ?> 
                <span class="badge badge-danger notif-admin m-0"><?= $bell_count_admin ?></span>
              <?php } ?>
              <?php if($bell_count_chair_member>0 &&  $_SESSION['login_id'] != 1){ ?> 
                <span class="badge badge-danger notif-chair"><?= $bell_count_chair_member ?> </span>
              <?php }elseif($bell_count_chair_member>0 && $_SESSION['login_id'] != 1){ ?> 
                <span class="badge badge-danger notif-member"><?= $bell_count_chair_member ?></span>
              <?php } ?>
            </div>
          </span>
        </a>        
        <div class="dropdown-menu notif-menu y-scroll" style="">
          <?php
          // notif counts admin accept + submit
          $notif_admin_accept = $conn->query("SELECT * FROM task_list where active = 0 and notif_status = 1 and admin_id = ".$_SESSION['login_id'])->num_rows;
          $notif_admin_submit = $conn->query("SELECT * FROM user_productivity where active = 0 and notif_id = 1 and admin_id = ".$_SESSION['login_id'])->num_rows;
          $notif_admin = $notif_admin_accept + $notif_admin_submit;
          // notif counts chair accept + submit
          $notif_chair_accept = $conn->query("SELECT * FROM task_list where active = 0 and notif_status = 1 and leader = ".$_SESSION['login_id'])->num_rows;
          $notif_chair_submit = $conn->query("SELECT * FROM user_productivity where active = 0 and notif_id = 1 and leader = ".$_SESSION['login_id'])->num_rows;
          // notif counts member tasks to accept or decline
          $notif_member = $conn->query("SELECT * FROM task_list where active = 0 and task_owner = ".$_SESSION['login_id'])->num_rows;
          $notif_chair = $notif_chair_accept + $notif_chair_submit + $notif_member;
                
          // admin notif list with accept + submit
          if($notif_admin > 0 && $_SESSION['login_id'] == 1){
            $admin_accept_qry = $conn->query("SELECT * FROM task_list WHERE active = 0 and notif_status = 1 and admin_id = ".$_SESSION['login_id']." ORDER BY id DESC");
            $admin_submit_qry = $conn->query("SELECT * FROM user_productivity WHERE active = 0 and notif_id = 1 and admin_id = ".$_SESSION['login_id']." ORDER BY id DESC");
          ?>
          <div id="admin-accept-submit-notif-list" style="height:400px;y-overflow:auto">
            <?php  while($row = $admin_accept_qry->fetch_assoc()){ ?> 
            <a class="dropdown-item admin-accept y-scroll" href="javascript:void(0)" id="notified_list" style="y-overflow:auto">
              <i class="fa fa-tasks"></i> <strong><?= $row["task"]?></strong><br/>
              <i class="fa fa-dialog"></i> 
                <em>Accepted by 
                <?php $qryassigneetask = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users WHERE id = ".$row['task_owner']);
                  if($t_owner = $qryassigneetask->fetch_assoc()): ?>	
                    <?php echo ucwords($t_owner['uname']) ?>
                  <?php endif ?>
                </em><br/>
              <a class="btn btn-success btn-xs px-3 ml-3 mb-2 notifAdminOK" data-id="<?=$row["id"]?>" id="notif_okay">OK</a>
            </a>
            <div class="dropdown-divider"></div>
            <?php } ?>            
            <?php while($row = $admin_submit_qry->fetch_assoc()){ ?>
              <a class="dropdown-item admin-submit y-scroll" href="javascript:void(0)" id="notified_list" style="y-overflow:auto">
                <i class="fa fa-tasks"></i> 
                <strong> 
                  <?php $qrytasknamesubmitted = $conn->query("SELECT * FROM task_list WHERE id = ".$row['task_id']);
                  if($taskname_submitted= $qrytasknamesubmitted->fetch_assoc()): ?>
                    <?php echo ucwords($taskname_submitted['task']) ?>
                  <?php endif ?> with attached file: <a class="pl-3" title="see attached file <?php echo $row['file_name'] ?>" href="<?php echo $row['file_path'] ?>" target="_blank"><i class="fa fa-file"></i> <?php echo $row['file_name'] ?></a>
                </strong><br/>                
                <i class="fa fa-dialog"></i>
                <em class="pl-3">Submitted by 
                <?php $qryassigneetasksubmit = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users WHERE id = ".$row['user_id']);
                  if($ts_owner = $qryassigneetasksubmit->fetch_assoc()): ?>	
                    <?php echo ucwords($ts_owner['uname']) ?>
                  <?php endif ?>
                </em><br/>
                <a class="btn btn-success btn-xs px-3 ml-3 mb-2 notifAdminSubmitOK" data-id="<?=$row["id"]?>" id="notif_submit_okay">OK</a>
              </a>
              <div class="dropdown-divider"></div>
            <?php } ?>  
          </div>
          <?php }elseif($notif_admin == 0 && $_SESSION['login_id'] == 1){ ?>
            <div id="admin-accept-submit-no-notif-list" style="y-overflow:auto">
              <a class="dropdown-item" href="javascript:void(0)" id="">No New Notifications</a>
            </div>
          <?php } ?>

          <?php
          // chair notif list with accept + submit + member accept/decline tasks
          if($notif_chair > 0 && $_SESSION['login_id'] != 1) { 
            $chair_accept_qry = $conn->query("SELECT * FROM task_list WHERE active = 0 and notif_status = 1 and leader = ".$_SESSION['login_id']." ORDER BY id DESC");
            $chair_submit_qry = $conn->query("SELECT * FROM user_productivity WHERE active = 0 and notif_id = 1 and leader = ".$_SESSION['login_id']." ORDER BY id DESC");
            $member_tasks_qry = $conn->query("SELECT * FROM task_list WHERE active = 0 and notif_status = 0 and task_owner = ".$_SESSION['login_id']." ORDER BY id DESC");
          ?>
          <div id="chair-accept-submit-notif-list" style="height:400px;y-overflow:auto">
            <?php  while($row = $chair_accept_qry->fetch_assoc()){ ?> 
            <a class="dropdown-item admin-accept y-scroll" href="javascript:void(0)" id="notified_list" style="y-overflow:auto">
              <i class="fa fa-tasks"></i> <strong><?= $row["task"]?></strong><br/>
              <i class="fa fa-dialog"></i> 
                <em>Accepted by 
                <?php $qryassigneetask = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users WHERE id = ".$row['task_owner']);
                  if($t_owner = $qryassigneetask->fetch_assoc()): ?>	
                    <?php echo ucwords($t_owner['uname']) ?>
                  <?php endif ?>
                </em><br/>
              <a class="btn btn-success btn-xs px-3 ml-3 mb-2 notifChairOK" data-id="<?=$row["id"]?>" id="notif_okay">OK</a>
            </a>
            <div class="dropdown-divider"></div>
            <?php } ?>            
            <?php while($row = $chair_submit_qry->fetch_assoc()){ ?>
              <a class="dropdown-item admin-submit y-scroll" href="javascript:void(0)" id="notified_list" style="y-overflow:auto">
                <i class="fa fa-tasks"></i> 
                <strong> 
                  <?php $qrytasknamesubmitted = $conn->query("SELECT * FROM task_list WHERE id = ".$row['task_id']);
                  if($taskname_submitted= $qrytasknamesubmitted->fetch_assoc()): ?>
                    <?php echo ucwords($taskname_submitted['task']) ?>
                  <?php endif ?> with attached file: <a class="pl-3" title="see attached file <?php echo $row['file_name'] ?>" href="<?php echo $row['file_path'] ?>" target="_blank"><i class="fa fa-file"></i> <?php echo $row['file_name'] ?></a>
                </strong><br/>                
                <i class="fa fa-dialog"></i>
                <em class="pl-3">Submitted by 
                <?php $qryassigneetasksubmit = $conn->query("SELECT concat(firstname,' ',lastname) as uname FROM users WHERE id = ".$row['user_id']);
                  if($ts_owner = $qryassigneetasksubmit->fetch_assoc()): ?>	
                    <?php echo ucwords($ts_owner['uname']) ?>
                  <?php endif ?>
                </em><br/>
                <a class="btn btn-success btn-xs px-3 ml-3 mb-2 notifChairSubmitOK" data-id="<?=$row["id"]?>" id="notif_submit_okay">OK</a>
              </a>
              <div class="dropdown-divider"></div>
            <?php } ?>
            <?php while($row = $member_tasks_qry->fetch_assoc()){ ?>
              <a class="dropdown-item y-scroll" href="javascript:void(0)" style="y-overflow:auto">
                <i class="fa fa-tasks"></i> <strong><?= $row["task"]?></strong><br/>
                <i class="fa fa-dialog"></i> <em><?=$row["description"] ?></em><br/>
                <a class="btn btn-success btn-xs ml-3 mb-2 notifMeAccept" data-id="<?=$row["id"]?>" id="notif_accept">Accept</a>
                <a class="btn btn-default btn-xs mb-2 notifMeDecline" data-id="<?=$row["id"]?>" id="notif_decline">Decline</a>
              </a>
            <div class="dropdown-divider"></div>
            <?php } ?>
          </div>
          <?php }elseif($notif_chair == 0 && $_SESSION['login_id'] != 1){ ?>
          <div id="chair-accept-submit-no-notif-list" style="y-overflow:auto">
            <a class="dropdown-item" href="javascript:void(0)" id="">No New Notifications</a>
          </div>
        <?php } ?>

        </div>
        
        
      </li>
      <li class="nav-item dropdown mx-0 px-0">
        <a class="nav-link mx-0 px-0"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
          <span>
            <div class="d-felx badge-pill">
              <span class="fa fa-bell mr-2 hide"></span>
              <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
              <span class="fa fa-angle-down ml-2"></span>
            </div>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
          <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
          <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script>
    // Accept Task Notify
    $('.notifMeAccept').click(function(){
      _conf("Are you sure to 'Accept' this task?","notifMeAccept",[$(this).attr('data-id')])
    })
    function notifMeAccept($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_notif_accept',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Task successfully accepted",'success')
            setTimeout(function(){
              location.reload()
            },1500)

          }
        }
      })
    }

    // Decline Task Notify
    $('.notifMeDecline').click(function(){
      _conf("Are you sure to 'Decline' this task?","notifMeDecline",[$(this).attr('data-id')])
    })
    function notifMeDecline($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_notif_reject',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Task successfully declined",'success')
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })
    }

    // Admin Feedback Task Notify if Accepted
    $('.notifAdminOK').click(function(){
      _conf("Task is 'Accepted'. If continue, task status will be Started","notifAdminOK",[$(this).attr('data-id')])
    })
    function notifAdminOK($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_notif_admin_ok',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Status changed to Started",'success');
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })
    }

    // Notify Admin or feedback on every task file submitted
    $('.notifAdminSubmitOK').click(function(){
      _conf("Task is 'Submitted'. Approved?","notifAdminSubmitOK",[$(this).attr('data-id')])
    })
    function notifAdminSubmitOK($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_submitted_notif_admin_ok',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Successfully Approved",'success');
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })
    }

    // Chair Feedback Task Notify if Accepted
    $('.notifChairOK').click(function(){
      _conf("Task is 'Accepted'. If continue, task status will be Started","notifChairOK",[$(this).attr('data-id')])
    })
    function notifChairOK($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_notif_chair_ok',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Status changed to Started",'success');
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })
    }

    // Notify Admin or feedback on every task file submitted
    $('.notifChairSubmitOK').click(function(){
      _conf("Task is 'Submitted'. Approved?","notifChairSubmitOK",[$(this).attr('data-id')])
    })
    function notifChairSubmitOK($id){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_task_submitted_notif_chair_ok',
        method:'POST',
        data:{id:$id},
        success:function(resp){
          if(resp==1){
            alert_toast("Successfully Approved",'success');
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })
    }
  </script>
