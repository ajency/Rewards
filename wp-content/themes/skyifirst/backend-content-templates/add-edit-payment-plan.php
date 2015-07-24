<?php
//form heading
require_once (get_template_directory().'/functions/building.php');
if(!current_user_can('manage_settings') && !current_user_can('manage_options')){

    wp_redirect(site_url('no-access'));

    exit;
    
} 
$heading = "Add"; 
$tower_arr = array();
$payment_milestones = array();
$archive_val = 0;
 $checked_apply = "";
$checked = "";
$apply_val =0;
$checkedtower = "";
if(isset($_REQUEST["id"])){
$tower_arr = array();
$heading = "Edit";

    $payment_plan_id = $_REQUEST["id"];

    $payment_plan = (get_payment_by_id($payment_plan_id));
 
    $payment_plan_name = $payment_plan["option_name"];
 
    $payment_milestones =  unserialize($payment_plan["option_value"]) ;
  
    $towers =  $payment_milestones["towers"];
   if(count($towers) > 0){
    $checkedtower = "checked";
    foreach($towers as $key=>$val){
      if(intval($val)!=0 && $val != "")
      array_push($tower_arr, intval($val));
    }
}
$tower_arr = array_unique($tower_arr);

     $archive =  $payment_milestones["archive"];
    
    if(intval($archive) == 1){
      $checked = "checked";
      $archive_val = 1;
    }
    
    $buildingsid =  $payment_milestones["building"];
    
    
    if($buildingsid != ""){
      $apply_val = 1;
      $checked_apply = 'checked';}


      $payment_milestones =  $payment_milestones["milestones"];


    
    
   

 
}
?>
<div class="page-title">
 
    <h3>
        <?php echo $heading;?> Payment Plan
    </h3>

</div>

<div class="row">
<div class="col-md-6">
<div class="grid simple">
<div class="grid-title no-border">
    <h4>
        Enter Payment Plan Details
    </h4>
</div>
<div class="grid-body no-border">
<form id="form_add_edit_payment_plan"  name = "form_add_edit_payment_plan" action="" novalidate="novalidate">
 
<?php echo wp_nonce_field( plugin_basename( __FILE__ ), 'custom_save_payment_plan',true,false);?>
<input type="hidden" name="payment_plan_id" id="payment_plan_id" value="<?php echo @$payment_plan_id;?>" />
                    <br/>
<div class="form-group">
    <label class="form-label">
        Payment Plan Name
    </label> 
    <div class="input-with-icon  right">

        <i class="">
        </i>
        <input type="text" name="payment_plan_name" id="payment_plan_name" value="<?php echo $payment_plan_name;?>"class="form-control">

    </div>
</div><!--
<div class="form-group">
    <label class="form-label">
        Milestones
    </label> 
    <div class="input-with-icon  right">

        <i class="">
        </i>
       <ul id="milestone-list">

       <?php
       $items = 1;
       if(count($payment_milestones)){
        $items = count($payment_milestones);
            foreach($payment_milestones as $key=>$payment_milestone){
                ?>

                <li class="sortable-items" id="sortable-items-<?php echo $key+1;?>">
              
                    <select  name="milestone" id="milestone_<?php echo $key+1;?>"   class="milestone form-control form-control-medium">
                        <option value="">Select Milestone</option>
                        <option value="+" class="select-add-item ">Add New Milestone</option>
                          <?php
                          $milestones = get_milestones();

                          foreach($milestones as $milestone)
                          {

                            ?>
                            <option value="<?php echo $milestone["id"];?>" <?php if($payment_milestone["milestone"]==$milestone["id"]){ echo "selected";}?>  ><?php echo $milestone["name"];?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <input type="text" name="payment_percentage" id="payment_percentage_<?php echo $key;?>" value="<?php echo $payment_milestone["payment_percentage"];?>" class="form-control  form-control-small"> %
                    <a href="javascript:void(0)" item="<?php echo $key+1;?>" class="milestone-remove">x</a>
                </li>
                <?php
            } 
        ?>

        <?php
       }else{

        ?>

            <li class="sortable-items" id="sortable-items-1">
              
              <select  name="milestone" id="milestone_1"   class="milestone form-control form-control-medium">
              <option value="">Select Milestone</option>
              <option value="+" class="select-add-item ">Add New Milestone</option>
              <?php
              $milestones = get_milestones();

              foreach($milestones as $milestone)
              {

                ?>
                <option value="<?php echo $milestone["id"];?>"  ><?php echo $milestone["name"];?></option>
                <?php
              }
              ?>
              </select>
              <input type="text" name="payment_percentage" id="payment_percentage_1" value="" class="form-control  form-control-small"> %
              <a href="javascript:void(0)" item="1" class="milestone-remove">x</a>
          </li>
        <?php
       }
       ?>
          
          
        </ul>
            <a href="javascript:void(0)" id="add-more-milstones" count="<?php echo $items;?>">Add More</a>
            <div editing-element="" class="modal fade" id="milestone-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create New Milestone</h4>
                  </div>
                  <div class="modal-body">
                    Milestone : <input type='text' id="milestone_name">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-milestone">Create</button>
                  </div>
                </div>
              </div>
            </div>
    </div>
</div>-->

<!--test1-->
<div class="form-group">
    <label class="form-label">
        Milestones
    </label> 
    <div class="input-with-icon  right">

        <i class="">
        </i>
       <ul id="milestone-list">

       <?php
       $items = 1;
       if(count($payment_milestones)){
        $items = count($payment_milestones);
            foreach($payment_milestones as $key=>$payment_milestone){
                ?>

                <li class="sortable-items" id="sortable-items-<?php echo $key+1;?>">
              <div class="row">
			  <div class="col-md-4">
                    <select  name="milestone" id="milestone_<?php echo $key+1;?>"   class="milestone form-control">
                        <option value="">Select Milestone</option>
                        <option value="+" class="select-add-item ">Add New Milestone</option>
                          <?php
                          $milestones = get_milestones();

                          foreach($milestones as $milestone)
                          {

                            ?>
                            <option value="<?php echo $milestone["id"];?>" <?php if($payment_milestone["milestone"]==$milestone["id"]){ echo "selected";}?>  ><?php echo $milestone["name"];?></option>
                            <?php
                            }
                            ?>
                    </select>
					</div>
					<div class="col-md-4">
                    <input type="text" name="payment_percentage" id="payment_percentage_<?php echo $key+1;?>" value="<?php echo $payment_milestone["payment_percentage"];?>" class="form-control  form-control-small"> %
					</div>
					<div class="col-md-4">
                    <a href="javascript:void(0)" item="<?php echo $key+1;?>" class="milestone-remove"><i class="fa fa-trash-o thrash" item="<?php echo $key+1;?>" class="milestone-remove" ></i></a></div>
					</div>
                </li>
                <?php
            } 
        ?>

        <?php
       }else{

        ?>

            <li class="sortable-items" id="sortable-items-1">
              <div class="row">
			  <div class="col-md-6">
              <select  name="milestone" id="milestone_1"   class="milestone form-control ">
              <option value="">Select Milestone</option>
              <option value="+" class="select-add-item ">Add New Milestone</option>
              <?php
              $milestones = get_milestones();

              foreach($milestones as $milestone)
              {

                ?>
                <option value="<?php echo $milestone["id"];?>"  ><?php echo $milestone["name"];?></option>
                <?php
              }
              ?>
              </select></div>
			  <div class="col-md-4">
              <input type="text" name="payment_percentage" id="payment_percentage_1" value="" class="form-control  form-control-small"><label class="form-label">%</label></div>
			  <div class="col-md-2">
              <a href="javascript:void(0)" item="1" class="milestone-remove"><i class="fa fa-trash-o thrash" item="<?php echo $key+1;?>" class="milestone-remove"></i></a></div></div>
          </li>
        <?php
       }
       ?>
          
          
        </ul>
		<div class="m-t-20">
            <a class="btn btn-default" href="javascript:void(0)" id="add-more-milstones" count="<?php echo $items;?>">Add More</a></div><br/><input type="radio" id="showtowers" <?php echo $checkedtower;?> name="showtowers" value="0"><label class="form-label">Towers</label><br/><div id="display_towers" class="hidden">
            <?php 
            $building_arr = array();
            $buildings = get_buildings();
            
            foreach($buildings as $value){
              $checked_tower =""; 
              array_push($building_arr, $value['id']);
              if(in_array(intval($value['id']), $tower_arr))
                
                  $checked_tower = "checked";

              ?>

              <input type="checkbox" class="towervalue" <?php echo $checked_tower;?> id="towervalue<?php echo $value['id'];?>" name="towervalue<?php echo $value['id'];?>" value="<?php echo $value['id'];?>" /><?php echo $value['name'];?>&nbsp;&nbsp;

           <?php }

            ?>
            </div><br/><input type="hidden" id="apply_arr" name="apply_arr"  value="<?php echo implode(',', $building_arr);?>"><input type="radio" id="apply"  <?php echo $checked_apply;?> name="showtowers" value="<?php echo $apply_val;?>" /><label for="apply" class="form-label">Apply to All Towers</label>
            <br/><br/><input type="hidden" id="towerstring" name="towerstring" value="<?php echo implode(',', $tower_arr);?>" /><input type="checkbox" id="archive" <?php echo $checked;?> name="archive" value="<?php echo $archive_val;?>" /><label for="archive" class="form-label">Archive</label>
            <div editing-element="" class="modal fade" id="milestone-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create New Milestone</h4>
                  </div>
                  <div class="modal-body">
				  <div class="row">
				  <div class="col-md-2">
                    <label class="form-label form-label-inline">Milestone :</label> 
					</div>
					
					<div class="col-md-6">
					<input type='text' id="milestone_name" class="form-control">
					</div>
					</div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-milestone">Create</button>
                  </div>
                </div>
              </div>
            </div>
    </div>
</div>
<!--test1-->  




<div class="form-actions">

    <button type="button" class="btn btn-success btn-cons" id="save_payment_plan">
        <i class="icon-ok">
        </i>
        Submit
    </button>
</div>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function select_tower(){


}


</script>