<?php include('../config/config.php');?>

  <!-- right col -->

  <div class="col w-md bg-white-only b-l bg-auto no-border-xs">

    <div class="nav-tabs-alt" >

      <ul class="nav nav-tabs" role="tablist">

        <li class="active">

          <a data-target="#tab-1" role="tab" data-toggle="tab">

            <i class="glyphicon glyphicon-user text-md text-muted wrapper-sm"></i>

          </a>

        </li>

        <li>

          <a data-target="#tab-2" role="tab" data-toggle="tab">

            <i class="glyphicon glyphicon-comment text-md text-muted wrapper-sm"></i>

          </a>

        </li>

        <li>

          <a data-target="#tab-3" role="tab" data-toggle="tab">

            <i class="glyphicon glyphicon-transfer text-md text-muted wrapper-sm"></i>

          </a>

        </li>

      </ul>

    </div>

    <div class="tab-content">

      <div role="tabpanel" class="tab-pane active" id="tab-1">

        <div class="wrapper-md">

          <div class="m-b-sm text-md">Who to follow</div> 

          <ul class="list-group no-bg no-borders pull-in">

            <li class="list-group-item">

              <a herf class="pull-left thumb-sm avatar m-r">

                <img src="./theme/html/img/a4.jpg" alt="..." class="img-circle">

                <i class="on b-white bottom"></i>

              </a>

              <div class="clear">

                <div><a href>Chris Fox</a></div>

                <small class="text-muted">Designer, Blogger</small>

              </div>

            </li>

            <li class="list-group-item">

              <a herf class="pull-left thumb-sm avatar m-r">

                <img src="./theme/html/img/a5.jpg" alt="..." class="img-circle">

                <i class="on b-white bottom"></i>

              </a>

              <div class="clear">

                <div><a href>Mogen Polish</a></div>

                <small class="text-muted">Writter, Mag Editor</small>

              </div>

            </li>

            <li class="list-group-item">

              <a herf class="pull-left thumb-sm avatar m-r">

                <img src="./theme/html/img/a6.jpg" alt="..." class="img-circle">

                <i class="busy b-white bottom"></i>

              </a>

              <div class="clear">

                <div><a href>Joge Lucky</a></div>

                <small class="text-muted">Art director, Movie Cut</small>

              </div>

            </li>

            <li class="list-group-item">

              <a herf class="pull-left thumb-sm avatar m-r">

                <img src="./theme/html/img/a7.jpg" alt="..." class="img-circle">

                <i class="away b-white bottom"></i>

              </a>

              <div class="clear">

                <div><a href>Folisise Chosielie</a></div>

                <small class="text-muted">Musician, Player</small>

              </div>

            </li>

            <li class="list-group-item">

              <a herf class="pull-left thumb-sm avatar m-r">

                <img src="./theme/html/img/a8.jpg" alt="..." class="img-circle">

                <i class="away b-white bottom"></i>

              </a>

              <div class="clear">

                <div><a href>Aron Gonzalez</a></div>

                <small class="text-muted">Designer</small>

              </div>

            </li>

          </ul>

          <div class="text-center">

            <a href class="btn btn-sm btn-primary padder-md m-b">More Connections</a>

          </div>

        </div>

      </div>

      <div role="tabpanel" class="tab-pane tab-2" id="tab-2">

        <div class="wrapper-md">

          <div class="m-b-sm text-md">Chat</div>

          <ul class="list-group no-borders pull-in auto">
          
          <?php 
            $comments = "select * from support_comment order by support_comment_id DESC limit 20";
            $comments_query = mysql_query($comments);
            while($comments_row = mysql_fetch_array($comments_query))    
            {
                        
                            if($comments_row['user_type']=='user')
                            {                        
                                $user_query = "select * from users where user_id = '".$comments_row['user_id']."'";
                                $user_sql = mysql_query($user_query);
                                $user_data = mysql_fetch_array($user_sql);
                                //echo $user_data['f_name'];
                                $user_name = $user_data['f_name']." ". $user_data['l_name'];
                                
                                if(file_exists("app/ajax/profile/profile_pic_".$user_data['user_id'].".png"))
                                {
                                    $src = "app/ajax/profile/profile_pic_".$user_data['user_id'].".png";
                                }                       
                                else
                                {
                                    $src = "app/ajax/profile/avatar5.png";
                                }
                            }
                            
                            if($comments_row['user_type']=='admin')
                            {
                                $admin_query = "select * from admin where emp_id = '".$comments_row['user_id']."'";
                                $admin_sql = mysql_query($admin_query);
                                $admin_data = mysql_fetch_array($admin_sql);
                                
                                $user_name = $admin_data['name'];
                                
                                if(file_exists("admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png"))
                                {
                                    $src = "admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png";
                                }                       
                                else
                                {
                                    $src = "admin/app/ajax/profile/admin/avatar5.png";
                                }
                            }
                            
            ?>

            <li class="list-group-item">
              <span class="pull-left thumb-sm m-r"><img src="<?php echo $src; ?>" alt="..." class="img-circle"></span>
              <!--<a href="#" class="text-muted" ui-toggle-class="show" target=".app-aside-right"><i class="fa fa-comment-o pull-right m-t-sm text-sm"></i></a>-->
              <div class="clear">
                <div><a href=""><?php echo $user_name;?></a></div>
                <small class="text-muted"><?php echo $comments_row['comment'];?></small>
              </div>
            </li>
            <?php } ?>

            <li class="list-group-item">

              <span class="pull-left thumb-sm m-r"><img src="./theme/html/img/a2.jpg" alt="..." class="img-circle"></span>

              <a href="#" class="text-muted" ui-toggle-class="show" target=".app-aside-right"><i class="fa fa-comment-o pull-right m-t-sm text-sm"></i></a>

              <div class="clear">

                <div><a href="">Amanda Conlan</a></div>

                <small class="text-muted">about 2 hours ago</small>

              </div>

            </li>

            <li class="list-group-item">

              <span class="pull-left thumb-sm m-r"><img src="./theme/html/img/a3.jpg" alt="..." class="img-circle"></span>

              <a href class="text-muted" ui-toggle-class="show" target=".app-aside-right"><i class="fa fa-comment-o pull-right m-t-sm text-sm"></i></a>

              <div class="clear">

                <div><a href="">Dan Doorack</a></div>

                <small class="text-muted">3 days ago</small>

              </div>

            </li>

            <li class="list-group-item">

              <span class="pull-left thumb-sm m-r"><img src="./theme/html/img/a4.jpg" alt="..." class="img-circle"></span>

              <a href class="text-muted" ui-toggle-class="show" target=".app-aside-right"><i class="fa fa-comment-o pull-right m-t-sm text-sm"></i></a>

              <div class="clear">

                <div><a href="">Lauren Taylor</a></div>

                <small class="text-muted">about 2 minutes ago</small>

              </div>

            </li>

          </ul>

        </div>

      </div>

      <div role="tabpanel" class="tab-pane tab-3" id="tab-3">

        <div class="wrapper-md">

          <div class="m-b-sm text-md">Transaction</div>

          <ul class="list-group list-group-sm list-group-sp list-group-alt auto m-t">

            <li class="list-group-item">

              <span class="text-muted">Transfer to Jacob at 3:00 pm</span>

              <span class="block text-md text-info">B 15,000.00</span>

            </li>

            <li class="list-group-item">

              <span class="text-muted">Got from Mike at 1:00 pm</span>

              <span class="block text-md text-primary">B 23,000.00</span>

            </li>

            <li class="list-group-item">

              <span class="text-muted">Sponsored ORG at 9:00 am</span>

              <span class="block text-md text-warning">B 3,000.00</span>

            </li>

            <li class="list-group-item">

              <span class="text-muted">Send to Jacob at 8:00 am</span>

              <span class="block text-md">B 11,000.00</span>

            </li>

          </ul>

        </div>

      </div>

    </div>

    <div class="col-sm-12">
    <div class="col-sm-2">
  </div>
    <div class="wrapper">
      <ul class="timeline">
      <li class="tl-header">
          <div class="btn btn-info">Now</div>
        </li>
     <?php 
    $comments = "select comment.*, admin.name as admin_name from comment JOIN admin ON comment.user_id = admin.emp_id where comment.cheque_id = $cheque_id ORDER BY comment.comment_id DESC";
    $comments_query = mysql_query($comments);
    while($comments_row = mysql_fetch_array($comments_query))
    //$time = mysql_query("select time from ");
    {
    ?> 
        <li class="tl-item tl-left">
          <div class="tl-wrap b-primary">
            <span class="tl-date"><?php echo $comments_row['timestamp'];?></span>
            <div class="tl-content panel padder b-a block">
              <span class="arrow left pull-up hidden-left"></span>
              <span class="arrow right pull-up visible-left"></span>
              <div class="text-lt m-b-sm">
              
              <a href class="avatar thumb-xs m-r-xs" style="width: 45px;">
                    <img src='                    
                    <?php
                        if(file_exists("app/ajax/profile/admin/profile_pic_".$comments_row['user_id'].".png"))
                        {
                            echo"app/ajax/profile/admin/profile_pic_".$comments_row['user_id'].".png";
                        }                       
                        else
                        {
                            echo"app/ajax/profile/admin/avatar5.png";
                        }
                    ?>
                    '  class="img-circle" alt="User Image" style="height: 45px;"/>
                    <i class="on b-white left"></i>
                  </a>
              
              <?php echo $comments_row['admin_name'];?></div>
              <div class="panel-body pull-in b-t b-light">
                <p style="color: #23b7e5;"><?php echo $comments_row['comment'];?></p>
                
              </div>             
            </div>
          </div>
        </li> 

  <?php } ?>
          </ul>
    </div>
  </div>

    <div data-ng-include=" 'tpl/blocks/aside.right.html' ">

      

  <!-- aside right -->

  <div class="app-aside-right pos-fix no-padder w-md w-auto-xs bg-white b-l animated fadeInRight hide">

    <div class="vbox">

      <div class="wrapper b-b b-t b-light m-b">

        <a href class="pull-right text-muted text-md" ui-toggle-class="show" target=".app-aside-right"><i class="icon-close"></i></a>

        Chat

      </div>

      <div class="row-row">

        <div class="cell">

          <div class="cell-inner padder">

            <!-- chat list -->

            <div class="m-b">

              <a href class="pull-left thumb-xs avatar"><img src="./theme/html/img/a2.jpg" alt="..."></a>

              <div class="clear">

                <div class="pos-rlt wrapper-sm b b-light r m-l-sm">

                  <span class="arrow left pull-up"></span>

                  <p class="m-b-none">Hi John, What's up...</p>

                </div>

                <small class="text-muted m-l-sm"><i class="fa fa-ok text-success"></i> 2 minutes ago</small>

              </div>

            </div>

            <div class="m-b">

              <a href class="pull-right thumb-xs avatar"><img src="./theme/html/img/a3.jpg" class="img-circle" alt="..."></a>

              <div class="clear">

                <div class="pos-rlt wrapper-sm bg-light r m-r-sm">

                  <span class="arrow right pull-up arrow-light"></span>

                  <p class="m-b-none">Lorem ipsum dolor :)</p>

                </div>

                <small class="text-muted">1 minutes ago</small>

              </div>

            </div>

            <div class="m-b">

              <a href class="pull-left thumb-xs avatar"><img src="./theme/html/img/a2.jpg" alt="..."></a>

              <div class="clear">

                <div class="pos-rlt wrapper-sm b b-light r m-l-sm">

                  <span class="arrow left pull-up"></span>

                  <p class="m-b-none">Great!</p>

                </div>

                <small class="text-muted m-l-sm"><i class="fa fa-ok text-success"></i>Just Now</small>

              </div>

            </div>

            <!-- / chat list -->

          </div>

        </div>

      </div>

      <div class="wrapper m-t b-t b-light">

        <form class="m-b-none">

          <div class="input-group">

            <input type="text" class="form-control" placeholder="Say something">

            <span class="input-group-btn">

              <button class="btn btn-default" type="button">SEND</button>

            </span>

          </div>

        </form>

      </div>

    </div>

  </div>

  <!-- / aside right -->



    </div>

  </div>

  <!-- / right col -->