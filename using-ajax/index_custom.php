<?php
// Start the session.
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Test</title>
  <script src="jquery-1.11.1.js"></script>
  
</head>
<body>
 
  <script>
   
    
	
	$( document ).ready(function() {
		
		 $("#abort").click(function(){
			 startAjaxProcess(1);
			return false;
		  });
		  
		  $("#go").click(function(){
		   
			startAjaxProcess(0);
			
			return false;
		  });  
		
		
		
		
	});

	 
	  
  
	
	
	
	
	
	

	var xhr;
    function startAjaxProcess(status){
        if(status ==1){
            xhr.abort();
        }else{
			xhr = $.ajax({
				url: 'test.php',
				success: function(data) {
					alert(data);
				}
			});
		}
    };

	
  </script>
  
  
  <a id = "abort" href="#">abort</a>
  <a id = "go" href="#">go</a>
</body>
</html>
