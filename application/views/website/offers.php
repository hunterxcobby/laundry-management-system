

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>web/cssoff/style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>web/cssoff/fdw-demo.css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>

        <!-- stylesheets -->
        <link rel="stylesheet" href="style.css">
        <!-- js files -->
        <script src="<?php echo base_url();?>web/jsoff/jquery-v1.8.2.js"></script> <!-- jQuery 1.8.2 -->
        <script src="<?php echo base_url();?>web/jsoff/jquery-tweetscroll.js"></script> <!-- jQuery tweetscroll plugin -->
        <script src="<?php echo base_url();?>web/jsoff/caroufredsel-carousel.js"></script><!-- CarouFredSel carousel plugin -->
		
<?php require("header.php"); $WebCustId=$this->session->userdata('cust_id'); ?>	 

<!-- /breadcrumb  -->
	<div class="page-content">
		
		<div class="two-columns">
			<div class="container"> 
				<div class="row"> 
					<div class="col-md-4 col-lg-3"> <br/> <br/>
					<?php include("myacc_leftmenu.php"); ?>
					<div class="divider-lg visible-xs"></div>
					<div class="col-md-8 col-lg-9">
						<div class="table-title"> <i class="glyphicon glyphicon-tags"></i> &nbsp; OFFER SECTION  </div>		

<body>

  <div class="freshdesignweb">
                <article class="grid_3  carousel-article">
                    <h4> Offers </h4>

                    <div style="display: block; text-align: start; position: relative; top: auto; right: auto; bottom: auto; left: auto; width: 220px; height: 90px; margin: 0px; overflow: hidden;" class="caroufredsel_wrapper">
                    <ul style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 1540px; height: 90px;" id="foo3" class="carousel-li">
					

                    <?php
					$promo = $this->db->get_where('tax_charges' , array('coupon' =>'yes'));
					
					foreach($promo->result() as $prow) :
					{	echo '<li>  <p> ';
						if($prow->charge_name!='') echo $prow->charge_name;
						echo '</p> </li>';
						echo '<div class="clearfix"></div>';
					}
					endforeach;	
					?>
						
					</ul>
					</div>

                    <div class="clearfix"></div>

                    <div style="display: block;" class="carousel-pagination" id="foo3_pag"><a class="selected" href="#"><span>1</span></a><a class="" href="#"><span>2</span></a><a class="" href="#"><span>3</span></a></div>

                </article><!-- slider text article end -->

        <script>
            $("#foo3").carouFredSel({
                items: 1,
                auto: true,
                scroll: 1,
                pagination  : "#foo3_pag"
            });
        </script>
</div>  </div>  

            
<script type="text/javascript">
var get_height = window.innerHeight; 
var get_height1 =  get_height - 25;
var get_container = document.getElementById('container');
get_container.style.height =  get_height1 + 'px';
</script>
</body>
</html>
