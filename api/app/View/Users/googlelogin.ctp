

<div class="container">

<div class="col-sm-12">
                <div class="fancy">
                  <h2>Google Profile</h2>
                </div>
          	</div>
        <div class="privacy_policy">
          <?php
		   if (isset($authUrl)){ 
	//show login url
	echo '<div align="center">';
	echo '<h3>Login with Google -- Demo</h3>';
	echo '<div>Please click login button to connect to Google.</div>';
	echo '<a class="login" href="' . $authUrl . '"><button class="btn btn-info">Google Login</button></a>';
	echo '</div>';
	
		} 

?>
        
        </div>
</div>
 