    <!-- aside -->
  <aside id="aside" class="app-aside hidden-xs bg-dark">
      <div class="aside-wrap">
        <div class="navi-wrap">
          <!-- user -->
          <div class="clearfix hidden-xs text-center hide" id="aside-user">
            <div class="dropdown wrapper">
              <a href="app.page.profile">
                <span class="thumb-lg w-auto-folded avatar m-t-sm">
                  <img src='
                    <?php
                        if(file_exists("app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png"))
                        {
                            echo"app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png";
                        }                       
                        else
                        {
                            echo"app/ajax/profile/avatar5.png";
                        }
                    ?>
                    '  class="img-circle" alt="User Image"/>
                </span>
              </a>
              <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
                <span class="clear">
                  <span class="block m-t-sm">
                    <strong class="font-bold text-lt"><?php echo $_SESSION['logname']." ".$_SESSION['logname1'];?></strong> 
                    <b class="caret"></b>
                  </span>
                  <span class="text-muted text-xs block"></span>
                </span>
              </a>
              <!-- dropdown -->
              <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                <li class="wrapper b-b m-b-sm bg-info m-t-n-xs">
                  <span class="arrow top hidden-folded arrow-info"></span>
                  
                  
                </li>
                <li>
                  <a href="./profile.php">Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="./app/action/logout.php">Logout</a>
                </li>
              </ul>
              <!-- / dropdown -->
            </div>
            <div class="line dk hidden-folded"></div>
          </div>
          <!-- / user -->

          <!-- nav -->
          <nav ui-nav class="navi clearfix">
            <ul class="nav">
              <!--<li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>Navigation</span>
              </li>-->
              <li>
                <a href="./dashboard.php">
                  <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                  <!--<b class="badge bg-success pull-right">30%</b>-->
                  <span class="font-bold">Dashboard</span>
                </a>
              </li>
         
              <li class="line dk hidden-folded"></li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">          
                <span>Your Stuff</span>
              </li> 
           
              <li>
                <a href="transactions.php">
                  <i class="icon-user icon text-success-lter"></i>
                  <!--<b class="badge bg-success pull-right">30%</b>-->
                  <span>Transactions</span>
                </a>
              </li>
              <li class="line dk hidden-folded"></li>
              <li>
                <a href="disburshments.php">
                  <i class="icon-user icon text-success-lter"></i>
                  <!--<b class="badge bg-success pull-right">30%</b>-->
                  <span>Disburshments</span>
                </a>
              </li>
              <li class="line dk hidden-folded"></li>
              <li>
                <a href="profile.php">
                  <i class="icon-user icon text-success-lter"></i>
                  <!--<b class="badge bg-success pull-right">30%</b>-->
                  <span>My Account</span>
                </a>
              </li>
              <li class="line dk hidden-folded"></li>
              
              <li>
                <a href="billing.php">
                  <i class="glyphicon glyphicon-edit"></i>
                  <!--<b class="badge bg-success pull-right">30%</b>-->
                  <span>Billing</span>
                </a>
              </li>
              
              <li class="line dk hidden-folded"></li>

              
              <li>
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-th"></i>
                  <span>Support</span>
                </a>
                <ul class="nav nav-sub dk">
                  <li class="nav-sub-header">
                    <a href>
                      <span>Support</span>
                    </a>
                  </li>
                  <li>
                    <a href="open-ticket.php">
                    <i class="icon-user icon text-success-lter"></i>
                      <span>Open Ticket</span>
                    </a>
                  </li>
                  <li>
                    <a href="closed-ticket.php">
                    <i class="icon-user icon text-success-lter"></i>
                      <span>Closed Ticket</span>
                    </a>
                  </li>
                  <li>
                    <a href="support-form.php">
                      <i class="icon-user icon text-success-lter"></i>
                      <!--<b class="badge bg-success pull-right">30%</b>-->
                      <span>Create Ticket</span>
                    </a>
                  </li>
                        
                </ul>
              </li>
             
            </ul>
          </nav>
          <!-- nav -->
        </div>
      </div>
  </aside>
  <!-- / aside -->