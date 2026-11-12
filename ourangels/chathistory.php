<?php
session_start();
include("includes_sms/connectsms.php");
error_reporting(0);
if(!isset($_SESSION['m_id']))
{
  echo "<script type=text/javascript>window.location='index.php?err';</script>";
}
else
{
  include("includes_sms/header1_sms.php"); 
?>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-fileinput.css">
<script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>

<script>
  $(function() {
    $( "#chat_date" ).datepicker({
      dateFormat:"dd-mm-yy",
      "changeMonth":true,
      "changeYear":true,
      //"yearRange":"-50:+0",
      maxDate:0
    });
  });
</script>
<div id="mst_student">
  <div class="page-content-wrapper">
    <div class="content">
      <div class="jumbotron" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="background-color:#2B303B;">
          <div class="inner">
            <ul class="breadcrumb">
              <li><p style="color:#ffffff;"><?php echo $_SESSION['strip_title'];?></p></li>
              <li><a style="color:#ffffff;" href="javascript:;" class="active"> Chat History </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="container-fluid container-fixed-lg">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default" style="height:auto;">
              <div class="panel-heading">
                <div class="panel-title"> Chat History </div>
              </div>
              <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
        <div class="radio radio-success">
<input id="male" type="radio" name="chatcat" value="homework" checked="checked">
Chat Category &nbsp;<label for="male">Homework</label>
<input id="act" type="radio" name="chatcat" value="activity">
<label for="act">Activity</label>
</div>
</div>
</div>
<div class="hwchat">
                <form  name="chatform" method="post" action="">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Select Date</label>
                        <div class="controls">
                          <input type="text" name="chat_date" id="chat_date" class="form-control" readonly required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default-select2">
                        <label>Select Standard</label>
                        <select name="stand_id" id="stand_id" class="full-width" data-init-plugin="select2" required>
                          <option value="">select</option>
                          <?php
                            $standard=mysql_query("SELECT * FROM mst_st_names")or die(mysql_error());
                            if(mysql_num_rows($standard)>0)
                            {
                              while($standard_res=mysql_fetch_array($standard))
                              {
                          ?>
                                <option value="<?php echo $standard_res['sn_id'];?>"><?php echo $standard_res['s_names'];?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default-select2">
                        <label>Select Section</label>
                        <select name="sectionid" id="sectionid" class="full-width" data-init-plugin="select2" required>
                          <option value="">select</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" name="submit" style="margin-top:14%;" id="submit" class="btn btn-block btn-primary" value="<?php echo md5("VIEWHWCHATHISTORY");?>"><span>View Chat History</span></button>
                    </div>
                  </div>
                </form>
              
                <?php
                if(isset($_REQUEST['submit'])==md5("VIEWHWCHATHISTORY"))
                {
                  $standname=mysql_query("SELECT s_names FROM mst_st_names WHERE sn_id='".$_REQUEST['stand_id']."'")or die(mysql_error());
                  $standname_res=mysql_fetch_array($standname);
                  $secname=mysql_query("SELECT sec_name FROM mst_sec WHERE sec_id='".$_REQUEST['sectionid']."'")or die(mysql_error());
                  $secname_res=mysql_fetch_array($secname);
                ?>
                <br><br><br>
                  <div class="row">
                  <div class="col-sm-6">
                    <div class="panel-body" style="border:2px solid blue; border-radius: 12px;">
                      <div class="row">
                <div class="alert alert-info bordered" role="alert">
                
                    <label>Conversation of <strong><?php echo $standname_res['s_names']."-".$secname_res['sec_name'];?></strong> on <strong><?php echo $_REQUEST['chat_date'];?></strong></label><br>
                  </div>
                  </div>
                <div class="view chat-view bg-white clearfix">
              <div class="chat-inner" id="my-conversation">
                <?php
                $hw= mysql_query("SELECT bulksms_id,msg FROM tbl_bulksms_details WHERE bulksms_date='".date('Y-m-d',strtotime($_REQUEST['chat_date']))."' AND section LIKE '%".$_REQUEST['stand_id'].", ".$_REQUEST['sectionid']." /%"."'")or die(mysql_error());
                if(mysql_num_rows($hw)>0)
                {
                while($hw_res=mysql_fetch_array($hw))
                {
                ?>
                <div class="message clearfix">
                  <div class="chat-bubble from-them">
                    <?php echo $hw_res['msg'];?>
                  </div>
                </div>
                <?php
                $chat= mysql_query("SELECT * FROM homeworkchat WHERE bulksms_id='".$hw_res['bulksms_id']."'")or die(mysql_error());
                while($chat_res=mysql_fetch_array($chat))
                {
                ?>
                <div class="message clearfix">
                  <div class="chat-bubble from-me">
                   <?php if($chat_res['senderid']=='0'){$staffname="Admin";}
                   else
                   {
                    $staff= mysql_query("SELECT CONCAT(Name,' ', Last_name) AS SNAME,standard_name,section_name FROM student_profile WHERE stu_id='".$chat_res['senderid']."'")or die(mysql_error());
                    $staff_res=mysql_fetch_array($staff);
                    $staffname=$staff_res['SNAME']."(".$staff_res['standard_name']."-".$staff_res['section_name'].")";
                   }
                   echo $chat_res['msg']."<br>"."- ".$staffname."<br>"."- ".$chat_res['date']." ".$chat_res['time'];?>
                  </div>
                </div>
                <?php
                  }
                }
              }
              else
              {
                echo "No conversation has been found";
              }
                ?>
              </div>
              </div>
            </div>
            </div>
             </div>
             <?php } ?>
           </div>


           <div class="actchat" style="display:none;">
                <form  name="actchatform" method="post" action="">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group form-group-default-select2">
                        <label>Select Category</label>
                        <select name="act_cate_id" id="act_cate_id" class="full-width" data-init-plugin="select2" required>
                          <option value="">select</option>
                          <?php
                            $category=mysql_query("SELECT * FROM activity_category WHERE academic_year='".$_SESSION["_GAGEAY"]."'")or die(mysql_error());
                            if(mysql_num_rows($category)>0)
                            {
                              while($category_res=mysql_fetch_array($category))
                              {
                          ?>
                                <option value="<?php echo $category_res['ac_id'];?>"><?php echo $category_res['ac_name'];?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default-select2">
                        <label>Select Heading</label>
                        <select name="act_head_id" id="act_head_id" class="full-width" data-init-plugin="select2" required>
                          <option value="">select</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group form-group-default-select2">
                        <label>Select Standard</label>
                        <select name="act_stand_id" id="act_stand_id" class="full-width" data-init-plugin="select2" required>
                          <option value="">select</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" name="actsubmit" style="margin-top:14%;" id="actsubmit" class="btn btn-block btn-primary" value="<?php echo md5("VIEWACTCHATHISTORY");?>"><span>View Chat History</span></button>
                    </div>
                  </div>
                </form>
              
                
           </div>

<?php
                if(isset($_REQUEST['actsubmit'])==md5("VIEWACTCHATHISTORY"))
                {
                  $category=mysql_query("SELECT ac_name FROM activity_category WHERE academic_year='".$_SESSION["_GAGEAY"]."' AND ac_id='".$_REQUEST['act_cate_id']."'")or die(mysql_error());
                  $category_res=mysql_fetch_array($category);
echo "SELECT tach_heading FROM tbl_activity_category_heading WHERE tach_category='".$_REQUEST['act_cate_id']."' AND academic_year='".$_SESSION["_GAGEAY"]."' AND tach_heading='".$_REQUEST['act_head_id']."'";exit;
                  $heading=mysql_query("SELECT tach_heading FROM tbl_activity_category_heading WHERE tach_category='".$_REQUEST['act_cate_id']."' AND academic_year='".$_SESSION["_GAGEAY"]."' AND tach_heading='".$_REQUEST['act_head_id']."'")or die(mysql_error());
                  $heading_res=mysql_fetch_array($heading);

                  $standard=mysql_query("SELECT s_names FROM mst_st_names WHERE sn_id='".$_REQUEST['act_stand_id']."'")or die(mysql_error());
                  $standard_res=mysql_fetch_array($standard);
                ?>
                <br><br><br>
                  <div class="row">
                  <div class="col-sm-6">
                    <div class="panel-body" style="border:2px solid blue; border-radius: 12px;">
                      <div class="row">
                        <div class="alert alert-info bordered" role="alert">                
                          <label>Conversation in <strong><?php echo $category_res['ac_name']."-".$heading_res['tach_heading'];?></strong> from <strong><?php echo $standard_res['s_names'];?></strong></label><br>
                        </div>
                      </div>
                <div class="view chat-view bg-white clearfix">
              <div class="chat-inner" id="my-conversation">
                <?php
                $act= mysql_query("SELECT * FROM tbl_activity_category_heading WHERE tach_category='".$_REQUEST['act_cate_id']."' AND tach_standard='".$_REQUEST['act_stand_id']."' AND tach_id='".$_REQUEST['act_head_id']."' AND academic_year='".$_SESSION["_GAGEAY"]."'")or die(mysql_error());
                if(mysql_num_rows($act)>0)
                {
                while($act_res=mysql_fetch_array($act))
                {
                ?>
                <div class="message clearfix">
                  <div class="chat-bubble from-them">
                    <?php echo $act_res['tach_heading']."<br>".$act_res['tach_desc'];?>
                  </div>
                </div>
                <?php
                $actchat= mysql_query("SELECT * FROM tbl_activity_chat WHERE ac_catid='".$_REQUEST['act_cate_id']."' AND ac_headid='".$_REQUEST['act_head_id']."'")or die(mysql_error());
                while($actchat_res=mysql_fetch_array($actchat))
                {
                ?>
                <div class="message clearfix">
                  <div class="chat-bubble from-me">
                   <?php if($actchat_res['ac_senderid']=='0'){$staffname="Admin";}
                   else
                   {
                    $staff= mysql_query("SELECT CONCAT(Name,' ', Last_name) AS SNAME,standard_name,section_name FROM student_profile WHERE stu_id='".$actchat_res['ac_senderid']."'")or die(mysql_error());
                    $staff_res=mysql_fetch_array($staff);
                    $staffname=$staff_res['SNAME']."(".$staff_res['standard_name']."-".$staff_res['section_name'].")";
                   }
                   echo $actchat_res['ac_msg']."<br>"."- ".$staffname."<br>"."- ".$actchat_res['ac_date']." ".$actchat_res['ac_time'];?>
                  </div>
                </div>
                <?php
                  }
                }
              }
              else
              {
                echo "No conversation has been found";
              }
                ?>
              </div>
              </div>
            </div>
            </div>
             </div>
             <?php } ?>

          </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes_sms/footer1_sms.php"); ?>
<script type="text/javascript" language="javascript" src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/plugins/datatable/dataTables.fixedColumns.min.js "></script>
<script src="assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
<script type="text/javascript" src="assets/plugins/datatables-responsive/js/lodash.min.js"></script>
<script src="pages/js/pages.min.js"></script>
<script src="assets/js/datatables.js" type="text/javascript"></script>
<script src="assets/js/activity.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=='homework')
        {
          $('.hwchat').show();
          $('.actchat').hide();
        }

        if($(this).attr("value")=='activity')
        {
          $('.hwchat').hide();
          $('.actchat').show();
        }
    });
});
</script>
<?php
}
?> 