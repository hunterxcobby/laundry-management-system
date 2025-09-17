$(document).ready(function() {
	
	//product1		
			$( "#prod_name1" ).autocomplete({
			source: 'search_product.php'
			});
	
		
			$('#prod_name1').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price1').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty1').focus();
					CalOrder1();
                }
				
            });
			 $('#prod_unit_price1').val(0); 	
			 $('#prod_first_qty1').val(0); 	
			 $('#prod_total_qty1').val(0); 	
			 $('#prod_total_amt1').val(0); 	
			 CalOrder1();
			 return false;
			});	
			
			
	
			//product2			
	
			$( "#prod_name2" ).autocomplete({
			source: 'search_product.php'
			});
	
			$('#prod_name2').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price2').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty2').focus();
					CalOrder2();
                }
				
            });
			$('#prod_unit_price2').val(0); 	
			 $('#prod_first_qty2').val(0); 	
			 $('#prod_last_qty2').val(0); 	
			 $('#prod_total_qty2').val(0); 	
			 $('#prod_total_amt2').val(0); 	
			 CalOrder2();
			 return false;
			});	
			
		 	//product3			
	
			$( "#prod_name3" ).autocomplete({
			source: 'search_product.php'
			});
	
			$('#prod_name3').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price3').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty3').focus();
					CalOrder3();
                }
				
            });
			 $('#prod_unit_price3').val(0); 	
			 $('#prod_first_qty3').val(0); 	
			 $('#prod_last_qty3').val(0); 	
			 $('#prod_total_qty3').val(0); 	
			 $('#prod_total_amt3').val(0); 
				CalOrder3();			 
			 return false;
			});	
			
		 	
			//product4			
	
			$( "#prod_name4" ).autocomplete({
			source: 'search_product.php'
			});
	
			$('#prod_name4').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price4').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty4').focus();
					CalOrder4();
                }
				
            });
			 $('#prod_unit_price4').val(0); 	
			 $('#prod_first_qty4').val(0); 	
			 $('#prod_last_qty4').val(0); 	
			 $('#prod_total_qty4').val(0); 	
			 $('#prod_total_amt4').val(0); 	
			 CalOrder4();
			 return false;
			});	
			
		 	//product5			
	
			$( "#prod_name5" ).autocomplete({
			source: 'search_product.php'
			});
	
			$('#prod_name5').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price5').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty5').focus();
					CalOrder5();
                }
				
            });
			 $('#prod_unit_price5').val(0); 	
			 $('#prod_first_qty5').val(0); 	
			 $('#prod_last_qty5').val(0); 	
			 $('#prod_total_qty5').val(0); 	
			 $('#prod_total_amt5').val(0); 	
			 CalOrder5();
			 return false;
			});	
			
		 	//product6			
	
			$( "#prod_name6" ).autocomplete({
			source: 'search_product.php'
			});
	
			$('#prod_name6').focusout(function() {
			var productcode = $(this).val();
			$.ajax({
                url: 'check_product.php',
				cache:'false',
                type: 'POST',
                data: {productcode: productcode},
				dataType: 'json',
                success: function(result) {
                    $('#prod_unit_price6').val(result.toFixed(2));
					//$('#pordunitprice1').prop("disabled",true);
                    $('#prod_first_qty6').focus();
					CalOrder6();
                }
				
            });
			 $('#prod_unit_price6').val(0); 	
			 $('#prod_first_qty6').val(0); 	
			 $('#prod_last_qty6').val(0); 	
			 $('#prod_total_qty6').val(0); 	
			 $('#prod_total_amt6').val(0); 	
			 CalOrder6();
			 return false;
			});	
			
		 	
    });


	function CalOrder1()  		//product 1
      { 
        var prod1_first_qty = parseFloat(document.getElementById("prod_first_qty1").value);
        var prod1_last_qty = parseFloat(document.getElementById("prod_last_qty1").value);
        var prod1_unit_price = parseFloat(document.getElementById("prod_unit_price1").value);
        var actio1= document.getElementById("prod_arith1").value;
		
			
		if(actio1==="plus")
        { 
		  if(prod1_last_qty!=0.5 &&  prod1_last_qty!=1 && prod1_last_qty!=2 && prod1_last_qty!=3 && prod1_last_qty!=5)
		  {  document.getElementById("prod_total_qty1").value=0;
			 document.getElementById("prod_total_amt1").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty1").value=prod1_last_qty.toFixed(1); 
	      } 
		  
		  document.getElementById("prod_total_qty1").value =(prod1_first_qty + prod1_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt1").value =((prod1_first_qty + prod1_last_qty)*prod1_unit_price).toFixed(2);
		  
		}
		
		if(actio1==="mult")
        { document.getElementById("prod_total_qty1").value = (prod1_first_qty * prod1_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt1").value =((prod1_first_qty * prod1_last_qty)*prod1_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
	
      }  
	  
	
	function CalOrder2()  	// rpdocut 2
      { 
        var prod2_first_qty = parseFloat(document.getElementById("prod_first_qty2").value);
		var prod2_last_qty = parseFloat(document.getElementById("prod_last_qty2").value);
        var prod2_unit_price = parseFloat(document.getElementById("prod_unit_price2").value);
        var actio2 = document.getElementById("prod_arith2").value;
		
		if(actio2==="plus")
        { if(prod2_last_qty!=0.5 &&  prod2_last_qty!=1 && prod2_last_qty!=2 && prod2_last_qty!=3 && prod2_last_qty!=5)
		  {	 document.getElementById("prod_total_qty2").value=0;
		    document.getElementById("prod_total_amt2").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty2").value=prod2_last_qty.toFixed(1); 
	      } 
	
	
		  document.getElementById("prod_total_qty2").value = (prod2_first_qty + prod2_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt2").value =((prod2_first_qty + prod2_last_qty)*prod2_unit_price).toFixed(2); 
		}
		
		if(actio2==="mult")
        { document.getElementById("prod_total_qty2").value = (prod2_first_qty * prod2_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt2").value =((prod2_first_qty * prod2_last_qty)*prod2_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
      } 
	  
	  function CalOrder3()  	// rpdocut 3
      { 
        var prod3_first_qty = parseFloat(document.getElementById("prod_first_qty3").value);
					
        var prod3_last_qty = parseFloat(document.getElementById("prod_last_qty3").value);
        var prod3_unit_price = parseFloat(document.getElementById("prod_unit_price3").value);
        var actio3 = document.getElementById("prod_arith3").value;
		if(actio3==="plus")
        { if(prod3_last_qty!=0.5 &&  prod3_last_qty!=1 && prod3_last_qty!=2 && prod3_last_qty!=3 && prod3_last_qty!=5)
		  {  document.getElementById("prod_total_qty3").value=0;
			 document.getElementById("prod_total_amt3").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty3").value=prod3_last_qty.toFixed(1); 
	      } 
	
		  document.getElementById("prod_total_qty3").value = (prod3_first_qty + prod3_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt3").value =((prod3_first_qty + prod3_last_qty)*prod3_unit_price).toFixed(2); 
		}
		
		if(actio3==="mult")
        { document.getElementById("prod_total_qty3").value = (prod3_first_qty * prod3_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt3").value =((prod3_first_qty * prod3_last_qty)*prod3_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
      } 
	  
	  
	  function CalOrder4()  	// rpdocut 4
      { 
        var prod4_first_qty = parseFloat(document.getElementById("prod_first_qty4").value);
					
        var prod4_last_qty = parseFloat(document.getElementById("prod_last_qty4").value);
        var prod4_unit_price = parseFloat(document.getElementById("prod_unit_price4").value);
        var actio4 = document.getElementById("prod_arith4").value;
		if(actio4==="plus")
        { if(prod4_last_qty!=0.5 &&  prod4_last_qty!=1 && prod4_last_qty!=2 && prod4_last_qty!=3 && prod4_last_qty!=5)
		  {  document.getElementById("prod_total_qty4").value=0;
			 document.getElementById("prod_total_amt4").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty4").value=prod4_last_qty.toFixed(1); 
	      } 
	
		  document.getElementById("prod_total_qty4").value = (prod4_first_qty + prod4_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt4").value =((prod4_first_qty + prod4_last_qty)*prod4_unit_price).toFixed(2); 
		}
		
		if(actio4==="mult")
        { document.getElementById("prod_total_qty4").value = (prod4_first_qty * prod4_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt4").value =((prod4_first_qty * prod4_last_qty)*prod4_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
      }

	  function CalOrder5()  	// rpdocut 5
      { 
        var prod5_first_qty = parseFloat(document.getElementById("prod_first_qty5").value);
					
        var prod5_last_qty = parseFloat(document.getElementById("prod_last_qty5").value);
        var prod5_unit_price = parseFloat(document.getElementById("prod_unit_price5").value);
        var actio5 = document.getElementById("prod_arith5").value;
		if(actio5==="plus")
        { if(prod5_last_qty!=0.5 &&  prod5_last_qty!=1 && prod5_last_qty!=2 && prod5_last_qty!=3 && prod5_last_qty!=5)
		  {  document.getElementById("prod_total_qty5").value=0;
			 document.getElementById("prod_total_amt5").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty5").value=prod5_last_qty.toFixed(1); 
	      }
	
		  document.getElementById("prod_total_qty5").value = (prod5_first_qty + prod5_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt5").value =((prod5_first_qty + prod5_last_qty)*prod5_unit_price).toFixed(2); 
		}
		
		if(actio5==="mult")
        { document.getElementById("prod_total_qty5").value = (prod5_first_qty * prod5_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt5").value =((prod5_first_qty * prod5_last_qty)*prod5_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
      } 	
	  
	  function CalOrder6()  	// rpdocut 6
      { 
        var prod6_first_qty = parseFloat(document.getElementById("prod_first_qty6").value);
					
        var prod6_last_qty = parseFloat(document.getElementById("prod_last_qty6").value);
        var prod6_unit_price = parseFloat(document.getElementById("prod_unit_price6").value);
        var actio6 = document.getElementById("prod_arith6").value;
		if(actio6==="plus")
        { if(prod6_last_qty!=0.5 &&  prod6_last_qty!=1 && prod6_last_qty!=2 && prod6_last_qty!=3 && prod6_last_qty!=5)
		  {  document.getElementById("prod_total_qty6").value=0;
			 document.getElementById("prod_total_amt6").value=0;
			 return false;
		  }
		  else
		  {  document.getElementById("prod_last_qty6").value=prod6_last_qty.toFixed(1); 
	      }
			
		  document.getElementById("prod_total_qty6").value = (prod6_first_qty + prod6_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt6").value =((prod6_first_qty + prod6_last_qty)*prod6_unit_price).toFixed(2); 
		}
		
		if(actio6==="mult")
        { document.getElementById("prod_total_qty6").value = (prod6_first_qty * prod6_last_qty).toFixed(1); 
          document.getElementById("prod_total_amt6").value =((prod6_first_qty * prod6_last_qty)*prod6_unit_price).toFixed(2); 
		}
		
		TotalPayAmount();
      } 
	  
	  
	

	function TotalPayAmount()
	  {
		  
		  var prod_vat=parseFloat(document.getElementById("vat").value);
		  
		  var prod_total_one=parseFloat(document.getElementById("prod_total_amt1").value);
		  var prod_total_two=parseFloat(document.getElementById("prod_total_amt2").value);
		  var prod_total_three=parseFloat(document.getElementById("prod_total_amt3").value);
		  var prod_total_four=parseFloat(document.getElementById("prod_total_amt4").value);
		  var prod_total_five=parseFloat(document.getElementById("prod_total_amt5").value);
		  var prod_total_six=parseFloat(document.getElementById("prod_total_amt6").value);
		  
		  
		 	  
		 		  
		  var prod_amt=(prod_total_one+prod_total_two+prod_total_three+prod_total_four+prod_total_five+prod_total_six);
		  
		  document.getElementById("tot_amt").value=prod_amt.toFixed(2);
		  
		  var prod_vat_amt=(prod_amt*prod_vat/100);
		  document.getElementById("vat_amt").value=prod_vat_amt.toFixed(2);
		  
		  var prod_payable_amt=prod_amt+prod_vat_amt;
		  document.getElementById("tot_pay_amt").value=prod_payable_amt.toFixed(2);
		  
	  }