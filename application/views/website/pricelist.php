<?php require('header.php'); ?>

	<div class="page-content">
		
		
		
		<div class="container">
			<h2 class="title-underline"> Full Price list</h2>
			<div class="prices-tabs">
				<?php 
				    $this->db->order_by("priority");
					$servicelist=$this->db->get('services');
					$incre=1;
					foreach($servicelist->result() as $servicerow) : 
					$ServiceId=$servicerow->id;
				?>
				

				<!--  -->
				<div class="panel" role="tablist">
					<!-- panel heading -->
					<div class="panel-heading" role="tab">
						<h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#collapse<?php echo$incre; ?>"><?php echo $servicerow->service_name; ?> </a> </h4>
					</div>
					<div id="collapse<?php echo$incre; ?>" class="panel-collapse collapse" role="tabpanel">
						<div class="panel-body">
							<!--  -->
							<div class="table-price">
								<table>
									<tbody>
										<?php
										    
											//$this->db->where('service_id',$ServiceId);
											//$this->db->order_by('service_id');
											$this->db->order_by("price","asc");
								    		$ServicePrice=$this->db->get_where('price_list',array('service_id'=>$ServiceId))->result(); 
								            //$ServicePrice=$this->db->get('price_list')->result(); 
											foreach($ServicePrice as $pricerow) :
											$clothId=$pricerow->cloth_id;
											echo '<tr><td>'.strtoupper($this->db->get_where('cloths' , array('id' =>$clothId))->row()->cloth_type).' </td>';	
											echo '<td> <span style="color:#33d65b;">'.$sys_curr.' '. $pricerow->price.'</span> per '. $pricerow->service_unit .'</td></tr>';	
											
											endforeach;
										?>
							
									</tbody>
								</table>
							</div>
							<!-- / -->
						</div>
					</div>
				</div>
				<!-- / -->
				<?php				
					$incre++;
					endforeach;
				?> 
				
				
			</div>
		</div>
			
			<div class="container">
			<h2 class="title-underline">Affordable Prices</h2>
			<div class="row product-box-mobile arrow-on-white">
				<div class="col-md-4">
					<!-- product-box -->
					<a href="#" class="product-box animation" data-animation="fadeIn" data-animation-delay="0.5s">
						<span class="icon icon-shirt"></span>
						<h3 class="title">
							From <span class="base-color"><?php echo $sys_curr; ?> 2 </span> per cloth
						</h3>
						<h6 class="description">
							Steam Ironing
						</h6>
					</a>
					<!-- /product-box -->
				</div>
				<div class="col-md-4">
					<!-- product-box -->
					<a href="#" class="product-box animation" data-animation="fadeIn" data-animation-delay="0s">
						<span class="icon icon-bag"></span>
						<h3 class="title">
							<span class="base-color"><?php echo $sys_curr; ?> 20 </span> per blanket
						</h3>
						<h6 class="description">
							Wash and Fold
						</h6>
					</a>
					<!-- /product-box -->
				</div>
				<div class="col-md-4">
					<!-- product-box -->
					<a href="#" class="product-box animation" data-animation="fadeIn" data-animation-delay="0.5s">
						<span class="icon icon-towel"></span>
						<h3 class="title">
							From <span class="base-color"><?php echo $sys_curr; ?> 5 </span> per item
						</h3>
						<h6 class="description">
							Dry cleaning
						</h6>
					</a>
					<!-- /product-box -->
				</div>
			</div>
		</div>
		
		</div>
	</div>

<?php include('footer.php'); ?>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>web/external/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/slick/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/waypoints/jquery.waypoints.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/countto/jquery.countTo.js"></script>
	<script src="<?php echo base_url(); ?>web/external/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap-datetimepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>web/external/form/jquery.form.js"></script>
	<script src="<?php echo base_url(); ?>web/external/form/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>web/js/main.js"></script>
</body>


</html>