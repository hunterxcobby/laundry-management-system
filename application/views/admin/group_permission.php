
<?php require_once("header.php");

if (!empty($modelpermission)) 
	{ if (!in_array("groupanduser", $modelpermission))  
		{ echo "<script> alert('Not Permission to Access'); </script>";
		  redirect('login/logout','refresh');	
		}
		
		
	}	
?>
						
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#"><?php echo lang('Settings'); ?>  </a>
				</li>
				<li class="active"><?php echo lang('Group'); ?> </li>
			</ul><!-- /.breadcrumb -->

			<a href="<?php echo $helppath;?>" style="float:right;" title="<?php echo lang('Help'); ?>" target="_blank"> <i class="ace-icon fa fa-question-circle bigger-160"></i> </a>
		</div>

		<div class="page-content">
			
			<div class="page-header ">
				<h1 class="hidden-480" >
					<?php echo lang('Settings'); ?> 
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo lang('Groups Management'); ?>  
					</small>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs" id="myTab">
									<li >
										<a href="<?php echo base_url();?>index.php/admin/groups">
											<i class="purple ace-icon fa fa-list bigger-120"></i>
											<?php echo lang('Group List'); ?>  
										</a>
									</li>

									<li class="active">
										<a data-toggle="tab" href="#newentry">
											<i class="orange ace-icon fa fa-edit bigger-120"></i>
											<?php echo lang('Permission'); ?> 
											
										</a>
									</li>
									
									<li style="float:right;">
										<a data-toggle="tab" href="#" onclick="GroupModal('<?php echo base_url();?>index.php/admin/group_add');" >
											<i class="green ace-icon fa fa-plus bigger-120"></i>
											<?php echo lang('Add Group'); ?> 
											
										</a>
									</li>
								</ul>

								<!-- Tab Contents Starts --> 
								
								<div class="tab-content">
									
									
		<div id="newentry" class="tab-pane fade in active">
		
		<div class="">
			<?php $attributes = array('class' => 'form-horizontal', 'id' => 'cloth_form','enctype' => 'multipart/form-data');
			echo form_open('admin/group_permission_crud/view',$attributes); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="month"> <?php echo lang('Group Name'); ?>  : </label>
				<div class="col-sm-6">
				<select class="chosen-select form-control" name="grp_id" id="grp_id" data-placeholder="Choose a Member Group...">
					<option value=""> -- <?php echo lang('Select'); ?> <?php echo lang('Group'); ?> -- </option> 
					<?php $groups = $this->db->get('mem_group');
					foreach ($groups->result() as $grouprow): ?>
					<option value="<?php echo $grouprow->id;?>"
					<?php if($grouprow->id==$this->session->userdata('GroupId')) echo "selected"; ?>
					> <?php echo $groupname=$grouprow->group_name; ?>
					</option>
					
					<?php endforeach; ?>
				</select>
								
				</div>
				<!--			
				<div class="col-sm-2">
					<div class="input-group">
					<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; Submit &nbsp;&nbsp;">
					</div>
					
				</div> -->
			</div>
			</form> 
			
			
		</div>
		
	<?php 
	$group_id=$this->session->userdata('GroupId');
	if($this->session->userdata('GroupPerm')=="view" && $group_id!="")
	{	$group_id=$this->session->userdata('GroupId');
		$group_permission_model = $this->db->get_where('mem_group' , array('id' =>$group_id))->row()->group_permission;
		$group_name = $this->db->get_where('mem_group' , array('id' =>$group_id))->row()->group_name;
		$grpmodel=unserialize($group_permission_model);
	?>
		<div> <hr style='color: 1px solid blue;'> </div>
		<?php $attributes = array('class' => 'form-horizontal', 'id' => 'form_permission','enctype' => 'multipart/form-data');
			echo form_open('admin/group_permission_crud/update/'.$group_id.'',$attributes); ?>
		<table id="dynamic-table" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				
				
				<th style="width:200px;"> <?php echo lang('Model Name'); ?>  </th>
				<th> <?php echo lang('Group'); ?> <?php echo lang('Permission'); ?>  ( <span style='color:green;'> <?php echo $group_name; ?> </span> ) </th> 

				
			</tr>
		</thead>
		<tbody>
		<tr>
		<td style='color:red;'> <i class="menu-icon fa fa-user-times"></i> <?php echo lang('Null (No Permission )'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="null" style="height:16px; width:16px;" 
		<?php if (!empty($grpmodel)) { if (in_array("null", $grpmodel)) echo "checked"; } ?> />
		</td> 
		
		</tr>
		
		
		<tr>
		<td> <i class="menu-icon fa fa-tachometer"></i> <?php echo lang('Dashboard'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="desktop"  style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("desktop", $grpmodel)) echo "checked"; } ?> >  </td> </td>   
		
		</tr> 
		
		<tr>
		<td> <i class="menu-icon fa fa-desktop"></i> <?php echo lang('Master'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="master" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("master", $grpmodel)) echo "checked"; }  ?>>  </td>  </td>   
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon glyphicon glyphicon-tint"></i> <?php echo lang('Garments'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="garment" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("garment", $grpmodel)) echo "checked"; }  ?>>  </td>  </td>   
		 
		</tr>
		
		
		<tr>
		<td> <i class="menu-icon fa fa-truck"></i> <?php echo lang('Services'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="services" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("services", $grpmodel)) echo "checked"; }  ?>>  </td>  </td>   
		 
		</tr>
		
		
		<tr>
		<td> <i class="menu-icon fa fa-list"></i> <?php echo lang('Job Order'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="joborder" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("joborder", $grpmodel)) echo "checked"; }  ?>>  </td>   </td> 
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-pencil-square-o"></i> <?php echo lang('Reports'); ?> </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="reports" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("reports", $grpmodel)) echo "checked"; } ?>>  </td>  </td>  
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-cog"></i> <?php echo lang('Settings'); ?> </td> 
		<td> <input type="checkbox" name="grp_perm[]" value="settings" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("settings", $grpmodel)) echo "checked"; } ?>>  </td>  </td>  
		 
		</tr>
		
		<tr>
		<td> <i class="menu-icon fa fa-users"></i> <?php echo lang('Groups_Role'); ?>  </td> 
		<td> <input type="checkbox" name="grp_perm[]"  value="groupanduser" style="height:16px; width:16px;" <?php if (!empty($grpmodel)) { if (in_array("groupanduser", $grpmodel)) echo "checked"; } ?> >  </td>   </td> 
		</tr>
		
		</tbody>
		</table>	
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
		<input class="btn btn-success" type="submit" value=" &nbsp;&nbsp; <?php echo lang('Update'); ?> &nbsp;&nbsp;">
			
			&nbsp; &nbsp; &nbsp;														
			&nbsp; &nbsp; &nbsp;
		<input class="btn" type="reset" value="&nbsp;&nbsp; <?php echo lang('Reset'); ?> &nbsp;&nbsp; ">
			
		
		</div>

	</div>	

  <?php
	}
  ?>
	</div>
								
							
								<!-- Tab Contents Ends --> 
								
							
						</div><!-- /.col -->

						
			</div>
			</form>
						
						<div class="vspace-12-sm"></div>
						
					</div><!-- /.row -->

					

				</div><!-- /.row -->

				
					
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
			

	
		
						

<?php require_once("modal.php"); ?>
<?php require_once("footer.php"); ?>

<script>
function GroupModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_order .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_order').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_order .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_order">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo "Add Group "; ?></h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                
                    
                    
                </div>
               <!-- 
                <div class="modal-footer" style="background:#fbeed5;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
				-->
            </div>
        </div>
    </div>
	
		<!------------------>
		

<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/buttons.pdf_font.min.js"></script>
		
		

		<!-- ace scripts -->
		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				
				$("#grp_id").change(function() 
				{	
					var groupid = $("#grp_id").val();
					//alert(groupid);
					$.post("<?php echo base_url(); ?>index.php/admin/group_permission_crud/view", {"grp_id": groupid });
					setTimeout(location.reload.bind(location), 500);
					
				});
				
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null,
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"title" : "ClothType", 
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: ''
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>
		
	</body>
</html>