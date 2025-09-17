
 <?php require('web_header.php'); ?>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>webnew/assets/css/css.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>webnew/assets/css/style.css">

   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


 <style>
    a:hover,a:focus{
    outline: none;
    text-decoration: none;
}
.tab .nav-tabs{
    position: relative;
    border-bottom: none;
}
.tab .nav-tabs li{
    text-align: center;
    margin-right: 3px;
}
.tab .nav-tabs li a{
    display: block;
    font-size: 15px;
    font-weight: 600;
    color: #231123;
    padding: 15px;
    background: #fff;
    margin-right: 0;
    border-radius: 0;
    border: none;
    position: relative;
    transition: all 0.5s ease 0s;
}
.tab .nav-tabs li a:before{
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: transparent;
    position: absolute;
    margin-left: -20px;
    bottom: 0;
    left: 50%;
    transition: all 0.2s ease 0s;
}
.tab .nav-tabs li a:hover:before,
.tab .nav-tabs li.active a:before{
    background: #00cad5;
}
.tab .nav-tabs li a:after{
    content: "";
    width: 0;
    height: 1px;
    background: #00cad5;
    margin-left: -15px;
    position: absolute;
    bottom: 6%;
    left: 50%;
    transition: all 0.2s ease 0s;
}
.tab .nav-tabs li a:hover:after,
.tab .nav-tabs li.active a:after{
    width: 35px;
}
.nav-tabs li.active a,
.nav-tabs li.active a:focus,
.nav-tabs li.active a:hover,
.nav-tabs li a:hover{
    border: none;
    color: #00cad5;
}
.tab .tab-content{
    font-size: 14px;
    color: #6f6c6c;
    line-height: 26px;
    padding: 20px 20px 20px 15px;
}
.tab .tab-content h3{
    font-size: 24px;
    margin-top: 0;
}
@media only screen and (max-width: 479px){
    .tab .nav-tabs li{
        width: 100%;
        margin-bottom: 5px;
    }
}
.tab-pane ul li{
    margin-bottom: 10px;
    list-style-type: none;
    font-size:16px;
}

.my-custom-scrollbar {
position: relative;
height: 350px;
overflow: auto;
-ms-overflow-style: none;
}

.my-custom-scrollbar::-webkit-scrollbar {
  display: none;
}


</style>

  
    <section id="services" class="services mt-1"  >
      <div class="container " style="margin-top:50px;">
          <h1 id="newhead" style="font-size: 22px!important;line-height: normal;background-color:#357EC7; color: #fff!important;padding:40px 0 40px 0;margin:0 0 20px 0!important;position:relative;text-align:center;"> <strong> PRICING LIST </strong><span style="position:absolute;bottom:0;width:50px;height:2px;background-color:#fff;margin-left:-100px;margin-bottom:30px;"></span></h1>
                      <div class="row">
                          <div class="col-md-12">
                            <center>
                              <div class="tab" role="tabpanel">
                                   <ul class="nav nav-tabs" role="tablist">
                                  <?php 
                                  $active='active'; 
                                  $this->db->order_by('priority', 'asc');   
                                  $this->db->where('show_hide', 'show');
                                  $servicelist=$this->db->get('services');

                                      foreach($servicelist->result() as $servicerow)
                                      {   
                                         $ser=$servicerow->id;
                                         //$chk=$this->db->get_where('price_list', array('service_id' => $ser))->result();

                                         //echo count($chk);

                                          if(count($this->db->get_where('price_list', array('service_id' => $ser))->result())>0)
                                          {    
                                          $serviceid[]=$servicerow->id;

                                  ?>        
                                                                                 
                                      <!-- Nav tabs -->
                                    
                                      <li role="presentation" class="<?php echo $active; ?>"><a href="pricing#Section<?php echo $servicerow->id; ?>" aria-controls="home" role="tab" data-toggle="tab">  <?php echo $servicerow->service_name; ?> </a></li>
                                      
                                  <?php
                                           $active='';
                                          }
                                  }    
                                  ?>
                                  </ul>


                                   <div class="tab-content tabs">
                                  <!-- Tab panes -->

                                  <?php
                                  $active='in active';
                                  foreach($serviceid as $serrow)
                                  {   
                                      //echo $serrow;
                                  ?>

                                 
                                    <div role="tabpanel" class="tab-pane fade <?php echo $active; ?>" id="Section<?php echo $serrow; ?>">

                     
                                    <?php
                                     $this->db->order_by('cat_id', 'asc');
                                      $category_list=$this->db->get_where('category');
                                      foreach($category_list->result() as $catRow)
                                      {   $cat_id=$catRow->cat_id;
                                          $price_list=$this->db->get_where('price_list', array('service_id' => $serrow,'category_id'=>$cat_id));
                                         if(count($price_list->result())>0)
                                         {   
                                      ?>
                                      <div class=" plan" style="border:2px solid lightblue; border-radius:10px;">
                                        <div class="plan-inner" >
                                          <div class="entry-title" style="border-radius:5px;">
                                            <h3 style="font-size:17px;color:whitesmoke;"><?=$catRow->category_name?></h3>
                                            <div class="price"><img src="<?=base_url()?>assets/stock/cat_<?=$cat_id?>.png">
                                        </div>
                                          </div>
                                 
                                            <ul style="list-style: none;padding:10px;" class="my-custom-scrollbar">
                                                <?php
                                                  $this->db->order_by('id', 'asc');
                                                  $price_list=$this->db->get_where('price_list', array('service_id' => $serrow,'category_id'=>$cat_id));
                                                  foreach($price_list->result() as $pricerow)
                                                  {
                                                      $filename="assets/stock/".$pricerow->id.".png";
                                                      if (!file_exists($filename)) {   
                                                        $filefound = 0;                         
                                                      } else 
                                                      {   $filefound=$pricerow->id; } 

                                                      $serviceUnit=($pricerow->service_unit=="kg")? " kg" : "-";
                                                      $cloth_id=$pricerow->cloth_id;
                                                      echo ' <li> <table> 
                                                       <tr> <td> <img src="'.base_url().'assets/stock/'.$filefound.'.png" style="height:40px;width:40px;vertical-align:middle;padding:0px;border-radius:50px;"> '. $this->db->get_where('cloths' , array('id' =>$cloth_id))->row()->cloth_type.'</td> <td style="text-align:right;"> </span>₹ '.$pricerow->price.' / '.$serviceUnit.' </td></tr></table></li>';
                                                  }
                                                  
                                                ?>

                                             </ul> 
                                          </div>
                                        </div>
                                        <?php
                                          } // if condtion if blank
                                        }
                                        ?>

                                          
                                      </div>
                                       <?php
                                       $active='';
                                    }
                                    ?>
                                      
                                </div>      <!-- end tab-contents -->

                                 
                              </div>
                         
                  </div>
              </section>

              
             
          
            </div>
          </div>

           
  
  <?php require('web_footer.php'); ?>

<!-- <script type="text/javascript" src="<?php echo base_url();?>webnew/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>webnew/assets/js/plugins.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>webnew/assets/js/layouts.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>webnew/assets/js/main.min.js"></script> -->
