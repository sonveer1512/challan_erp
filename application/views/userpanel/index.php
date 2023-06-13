<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalabel=0'>
	<meta content="<?php echo $this->auth->gettitle(); ?>" name="description">
	<title><?php echo $this->auth->gettitle(); ?></title>
	<link rel="icon" href="<?php echo $this->auth->getlogo(); ?>" type="image/x-icon"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/style.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/login.css">
</head>

<body style="background-color: #39f;">
	<div id="app" class="page">
      	<section class="section">
        	<div class="container sectioncontainer">
        		<div class="card-body">
          			<div class="row">
      					<div class="col-md-6 float-left">
			    			<img src="<?=base_url()?>assets/login_back.jpg" class="imgleft">
			    		</div>
      					<div class="col-md-6 float-right" style="margin-top:auto ">
			                <div class="single-page">
			                  	<div class="wrapper wrapper2">
		                      		<?php if(!empty($this->auth->getlogo())) { ?>
		                      			<img src="<?php echo $this->auth->getlogo(); ?>" style="width: 40%;">
		                      		<?php } ?>
		                      		<h4>User Login</h4>

	                    			<form class="login" method="post" autocomplete="off">
                  						<div class="row" style="place-content: center;">
                    						<div class="col-sm-12 col-md-10">
                      							<div class="mail">
                      								<label>Email Address <span class="error-alert">*</span></label>
													<input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
												</div>
                      							<div class="passwd" style="margin-top: 20px;">
                      								<label>Password <span class="error-alert">*</span></label>
													<input type="password" name="password" class="form-control" id="password" placeholder="Password">
												</div>

                      							<div class="submit" style="margin: 15px 0px;">
													<button type="submit" class="btn btn-block" name="submit" style="background-color: #39f;color: #fff;">Login</button>
												</div>
                							</div>
          								</div>
           							</form> 
					            </div>
          					</div>
      					</div>
          			</div>
          		</div>
    		</div>
		</section>
	</div>

	<div id="snackbar"></div>
	<div id="snackbar2"></div>

	<script src="<?=base_url()?>assets/loginjs/jquery-3.5.1.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
		  $(".login").on('submit', (function (e) {
		    e.preventDefault();
		    err = 0;
		    var formData = new FormData(this);
		    formData.append('action', "enqdet");

		    var email = $("#email").val();
		    var password = $("#password").val();

		    if(email == '' || password == '') { 
		    	err = 1;
				myFunction("Please Enter Required Fields");
		    }

		    if (err == 0) {
		      $.ajax({
		          url: "<?=base_url()?>userpanel/index/login",
		          type: "POST",
		          data: new FormData(this),
		          dataType: 'json',
		          contentType: false,
		          cache: false,
		          processData: false,
		          beforeSend: function () {
		            $("#submit").attr('disabled', true);
		          },
		          success: function (response) {
		            if(response.status == true) {
		                location.href = '<?=base_url()?>userpanel/dashboard';		              	
		            }else{
		            	myFunction(response.msg);	
		            }
		            $("#submit").removeAttr('disabled', false);
		          }
		      });
		    }
		  }));
		});

		function myFunction(msg) {
			document.getElementById("snackbar").innerHTML = msg;
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		}
	</script>
	</body>

</html>