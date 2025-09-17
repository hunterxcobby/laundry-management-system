<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder"> Laundry Management System </span>
				 &copy; 2017-<?=date('Y')?> by Red Planet Computers Pvt Ltd
			</span>

			&nbsp; &nbsp;
			<span class="action-buttons">
				<a href="https://plus.google.com/107727469340636521522" target="_blank">
					<i class="ace-icon fa fa-google-plus-square light-red bigger-150"></i>
				</a>

				<a href="https://www.facebook.com/redplanetcomputers2017/" target="_blank">
					<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
				</a>

				<a href="http://www.rpcits.co.in/">
					<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
				</a>
			</span>
		</div>
	</div>
</div>

<script type="text/javascript">
	function showAjaxPickupModel(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:10px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax_pickup').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax_pickup .modal-body').html(response);
			}
		});
	}
</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax_pickup" >
        <div class="modal-dialog" style="height:auto; width:900px;"  >
            <div class="modal-content" >
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"> New Pickup Order ( <?php echo date('d-m-Y'); ?> )</h4>
                </div>
                
                <div class="modal-body" style="height:auto; width:900px;">
                
                    
                    
                </div>
               
            </div>
        </div>
    </div>


<script type="text/javascript">
			jQuery(function($) {
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
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
								
				
</script>
			