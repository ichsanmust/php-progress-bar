<?php
// Start the session.
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Progress Bar</title>
  <script src="jquery-1.11.1.js"></script>
  <style>
    #progress {
      width: 500px;
      border: 1px solid #aaa;
      height: 20px;
    }
    #progress .bar {
      background-color: #ccc;
      height: 20px;
    }
  </style>
</head>
<body>
  <div id="progress"></div>
  <div id="message"></div>
  <?php $pid = getmypid() ?>
  <script>
    var timer;

    // The function to refresh the progress bar.
    function refreshProgress() {
      // We use Ajax again to check the progress by calling the checker script.
      // Also pass the session id to read the file because the file which storing the progress is placed in a file per session.
      // If the call was success, display the progress bar.
      $.ajax({
        url: "checker.php?file=<?php echo session_id() ?>",
        success:function(data){
          $("#progress").html('<div class="bar" style="width:' + data.percent + '%"></div>');
          $("#message").html(data.message);
          // If the process is completed, we should stop the checking process.
          if (data.percent == 100) {
            window.clearInterval(timer);
            timer = window.setInterval(completed, 1000);
          }
        }
      });
    }

    function completed() {
      $("#message").html("Completed");
      window.clearInterval(timer);
    }

     // When the document is ready
     $(document).ready(function(){
	 // asli
      // Trigger the process in web server.
      var request = $.ajax({
						url: "process.php",
						success:function(data){
							//alert('ok');
						}
					});
      // Refresh the progress bar every 1 second.
      timer = window.setInterval(refreshProgress, 1000);
	  
	  
	  
	  
	  $("#abort").click(function(){
        //alert("The link was clicked.");
		request.abort();
		//window.clearInterval(timer);
		
		$.ajax({
			url: "kill_process.php?pid=<?php echo $pid?>",
			success:function(data){
				alert('killed');
			}
		});
					
		return false;
	  });
	  
	  /* $("#go").click(function(){
        $.ajax({
						url: "process.php",
						success:function(data){
							//alert('ok');
						}
					});
		// Refresh the progress bar every 1 second.
		timer = window.setInterval(refreshProgress, 1000);
		return false;
	  });  */
	  
    }); 
	
	
	
	
	
	
	/* $(window).on('beforeunload', function(e) {
		//if(hasUnsaved()) {
			return 'You have unsaved stuff. Are you sure to leave?';
		//}
	}); */

	/* $(window).on('unload', function(e) {
		alert('Bye.');
	}); */
	
  </script>
  
  
  <a id = "abort" href="#">abort</a>
  <?php /*<a id = "go" href="#">go</a>*/ ?>
</body>
</html>
