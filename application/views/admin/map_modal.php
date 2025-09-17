<script type="text/javascript">
	function showAjaxMapViewModel(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax_map .modal-body').html('<div style="text-align:center;margin-top:50px;"><img src="<?php echo base_url(); ?>/assets/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax_map').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax_map .modal-body').html(response);
			}
		});
	}
</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax_map">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header" style="background:#fbeed5;" >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Driver Map View</h4>
                </div>
                
                <div class="modal-body" style="height:450px; overflow:auto;">
                
                    
                    
                </div>
               <!-- 
                <div class="modal-footer" style="background:#fbeed5;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
				-->
            </div>
        </div>
    </div>
    