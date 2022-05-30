<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<div id="form_builder_wp" class="form_builder" style="margin-top: 25px">
<form>
  <div class="row">
    <div class="col-sm-2">
      <nav class="nav-sidebar">
        <ul class="nav">
          <li class="form_bal_textfield"> <a href="javascript:;">Text Field <i class="fa fa-plus-circle pull-right"></i></a> </li>
          <li class="form_bal_select"> <a href="javascript:;">Select <i class="fa fa-plus-circle pull-right"></i></a> </li>
          <li class="form_bal_radio"> <a href="javascript:;">Radio Button <i class="fa fa-plus-circle pull-right"></i></a> </li>
          <li class="form_bal_checkbox"> <a href="javascript:;">Checkbox <i class="fa fa-plus-circle pull-right"></i></a> </li>
        </ul>
      </nav>
    </div>
    <div class="col-md-5 bal_builder">
      <div class="form_builder_area">
       
      <?php
        global $wpdb;
        $data = $wpdb->get_results("SELECT * FROM wp_filter_table");
        if(count($data) > 0 ){
          foreach($data as $datas){ 
           // print_r($datas)
          /////////// For Text
          if( $datas->form_sec_type == 'text') {?>
            <div class="li_<?php echo $datas->form_sec_id ?> form_builder_field ui-sortable-handle" style="width: 708.328px; height: 260px;">
          <div class="all_div">
              <div class="row li_row">
                  <div class="col-md-12">
                      <button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="<?php echo $datas->form_sec_id ?>"><i class="fa fa-times"></i></button>
                  </div>
              </div>
          </div>
          <hr />
          <div class="row li_row form_output" data-type="text" data-field="<?php echo $datas->form_sec_id ?>">
              <div class="col-md-12">
                  <div class="form-group"><input type="text" name="label_<?php echo $datas->form_sec_id ?>" class="form-control form_input_label" value="<?php echo $datas->form_sec_label ?>" data-field="<?php echo $datas->form_sec_id ?>" /></div>
              </div>
              <div class="col-md-12">
                  <div class="form-group"><input type="text"placeholder="Placeholder"  name="placeholder_<?php echo $datas->form_sec_id ?>" data-field="<?php echo $datas->form_sec_id ?>" class="form-control form_input_placeholder" value="<?php echo $datas->form_sec_placeholder ?>" /></div>
              </div>
              <div class="col-md-12">
                  <div class="form-group"><input type="text" value="<?php echo $datas->form_sec_name ?>" name="text_<?php echo $datas->form_sec_id ?>" class="form-control form_input_name" placeholder="Name" /></div>
              </div>
              <div class="col-md-12">
                  <div class="form-check">
                      <label class="form-check-label"><input data-field="<?php echo $datas->form_sec_id ?>" type="checkbox" class="form-check-input form_input_req" <?php echo ($datas->form_sec_require == 1) ?  'checked' :  ''  ?>/>Required</label>
                  </div>
              </div>
          </div>
      </div>
          <?php } 

          /////////// For Text
          if( $datas->form_sec_type == 'select') {?>

           
             <div class="li_<?php echo $datas->form_sec_id ?> form_builder_field" style="width: 817.222px; height: 308.837px;">
              <div class="all_div">
                  <div class="row li_row">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-primary btn-sm remove_bal_field pull-right" data-field="<?php echo $datas->form_sec_id ?>"><i class="fa fa-times"></i></button>
                      </div>
                  </div>
                  <hr />
                  <div class="row li_row form_output" data-type="select" data-field="<?php echo $datas->form_sec_id ?>">
                      <div class="col-md-12">
                          <div class="form-group"><input type="text" name="label_<?php echo $datas->form_sec_id ?>" class="form-control form_input_label" value="<?php echo $datas->form_sec_label ?>" data-field="<?php echo $datas->form_sec_id ?>" /></div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group"><input type="text" name="text_<?php echo $datas->form_sec_id ?>" class="form-control form_input_name" value="<?php echo $datas->form_sec_name ?>" placeholder="Name" /></div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <select name="select_<?php echo $datas->form_sec_id ?>" class="form-control">
                              <?php 
                               $filter_opn = Unserialize($datas->filter_option);
                               foreach($filter_opn as $filter_opns){ 
                                echo "<option data-opt='7395' value='$filter_opns'>$filter_opns</option>";
                               }
                              ?>
                                  
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="row li_row">
                      <div class="col-md-12">
                          <div class="field_extra_info_<?php echo $datas->form_sec_id ?>">

                          <?php 
                          $filter_opn = Unserialize($datas->filter_option);
                          $filter_val = Unserialize($datas->filter_value);
                          foreach($filter_opn as $i => $filter_opns){ ?>
                              <div data-field="<?php echo $datas->form_sec_id ?>" class="row select_row_<?php echo $datas->form_sec_id ?>" data-opt="7395">
                                  <div class="col-md-4">
                                      <div class="form-group"><input type="text" value="<?php echo $filter_opns ?>" class="s_opt form-control" /></div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group"><input type="text" value="<?php echo $filter_val[$i] ?>" class="s_val form-control" /></div>
                                  </div>                                
                              </div>
                          <?php } ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <?php } 


          }
        }
        else{
         //echo '<h3>No Data Found</h3>';
        }
        
        ?>
      
      </div>
    </div>
    <div class="col-md-5">
      <div class="col-md-12">
        <div class="form-horizontal">
          <div class="preview"></div>
          <div style="display: none" class="form-group plain_html">
            <textarea id="export_filter_form" rows="15" class="form-control"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="form_submit">
  <input type="submit" value="Submit" class="filter_form_submit btn btn-primary">
  <input type="button" class="btn btn-success export_html" value="Export">
</div>
</form>
<script>
jQuery('.filter_form_submit').on('click', function(e){
    e.preventDefault();
    jQuery('.form_input_name').val();
    if(!jQuery('.form_input_name').val() == ''){
    var formData = jQuery( "#form_builder_wp form" ).serialize();
    var form_output = [];
    var form_checked = [];
    var form_type = [];
    var option_label = [];
    var option_value = [];
    jQuery(".form_builder_field").each(function(){
      form_output.push(jQuery(this).find('.form_output').attr('data-field'));
      form_checked.push(jQuery(this).find('.form_input_req:checked').length);
      form_type.push(jQuery(this).find('.form_output').attr('data-type'));      
      var option_value_pair = jQuery(this).find('.li_row:last-child .row');
      option_value_pair.map(function(e){
        option_label.push(jQuery(option_value_pair[e]).find('.col-md-4 .s_opt').val());
        option_value.push(jQuery(option_value_pair[e]).find('.col-md-4 .s_val').val());
      })
      //option_value.push();
        });
    jQuery.ajax({
         type : "POST",
         url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
         data : formData  +`&action=form_data_function&form_output=${form_output}&form_checked=${form_checked}&form_type=${form_type}&option_label=${option_label}&option_value=${option_value}`,
         success: function(res) {
             console.log(res);
      }
    })
  }
  else{
    alert('Name is require');
  }
})


jQuery('.remove_bal_field').on('click', function(){
    var did = jQuery(this).attr('data-field');
    jQuery.ajax({
         type : "POST",
         url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
         data : {action: 'form_delete_function', did: did},
         success: function(res) {
             console.log(res);
      }
    })
})

</script>

</div>









<!--  
<div class="form_builder" style="margin-top: 25px">
  <div class="row form_builder_inner">
    <div class="col-sm-3 form_builder_inner_first">
        <ul class="form_builder_inner_first_nav ui-widget-content">
            <li>Text</li>
            <li>Radio</li>
            <li>Checkbox</li>
        </ul>
    </div>
    <div class="col-md-9 bal_builder form_builder_inner_second">
      <div class="form_builder_area"></div>
    </div>
  </div>
</div>
 <script>
jQuery( ".form_builder_inner_first_nav li" ).draggable();
jQuery('.form_builder_area').sortable();
jQuery( ".form_builder_inner_second" ).droppable({
      drop: function( event, ui ) {
          console.log(ui.draggable);
          $(this).find('.form_builder_area').append(ui.draggable);
      }
    });

     </script> -->

 
