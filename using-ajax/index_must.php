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
  
  <?php 
	$pid = getmypid() ;
	$sessionID = session_id();
	echo 'PID : '.$pid .' - '.' Session :'.$sessionID;
  ?>
  
  
  <script>
    var timer;
	
    // The function to refresh the progress bar.
    function refreshProgress() {
      // We use Ajax again to check the progress by calling the checker script.
      // Also pass the session id to read the file because the file which storing the progress is placed in a file per session.
      // If the call was success, display the progress bar.
      $.ajax({
        url: "checker.php?file=<?php echo $sessionID ?>",
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
	
	
	var xhr;
    function startAjaxProcess(status){
        if(status ==1){
            xhr.abort();
        }else{
			xhr = $.ajax({
						url: "process.php",
						success:function(data){
							alert('done');
						}
				});
		}
    };
	
	

     // When the document is ready
     $(document).ready(function(){	  
	  
		  $("#go").click(function(){
				startAjaxProcess(0);
				timer = window.setInterval(refreshProgress, 1000);
				return false;
		  });  
		  
		  
		  $("#abort").click(function(){
			
				$.ajax({
					url: "kill_process.php?pid=<?php echo $pid?>&file=<?php echo $sessionID ?>",
					success:function(data){
						alert('killed');
					}
				});
				
				startAjaxProcess(1);
				window.clearInterval(timer); // unhide ini apabila ingin melihat cjecker interval nya jalan, dan memastikan process nya ter killed apa belum
				
						
				return false;
		  });
	  
	  
	  
    }); 
	
  </script>
  
  
  <a id = "abort" href="#">abort</a>
  <a id = "go" href="#">go</a>
  
  
  
</body>
</html>
