<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <script type="text/javascript" src="http://www.clubdesign.at/floatlabels.js"></script>
<script> $(function() {
  $('input').floatlabel({labelEndTop:0});
});  </script>

</head>
  
<body>
  
  <nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Welcome To The Social Page</a>
    </div>

 
      
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">Already have an account?</p></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								

								 <form action="login.php" method="POST">
										<div class="form-group">
											 <label class="sr-only" for="emailAddress">Email address</label>
											 <input type="email" class="form-control" name="emailAddress" placeholder="Email address" required>
										</div>
										<div class="form-group">
											 <label class="sr-only" for="password">Password</label>
											 <input type="password" class="form-control" name="password" placeholder="Password" required>
                                       
										</div>
										<div class="form-group">
											 <input type="submit" value="Login"><br>
										</div>
										
								 </form>
							</div>
					 </div>
				</li>
			</ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<div class="container">
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Social Media Registration</h3>
			 			</div>
			 			<div class="panel-body">
						<form action="createAccount.php" method="POST">	
						<div class="form-group">
			    				<input type="text" name="emailAddress"  class="form-control input-sm" placeholder="Email Address">
			    			</div>
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" name="firstName" class="form-control input-sm floatlabel" placeholder="First Name">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="lastName"  class="form-control input-sm" placeholder="Last Name">
			    					</div>
			    				</div>
			    			</div>

			    			<div class="form-group">
			    				<input type="text" name="country"  class="form-control input-sm" placeholder="Location">
			    			</div>
							<div class="form-group">
			    				<input type="number" name="age"  class="form-control input-sm" placeholder="Age">
			    			</div>
							
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password"  class="form-control input-sm" placeholder="Password">
			    					</div>
			    				</div>
								
								<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password_conf" class="form-control input-sm" placeholder="Confirm Password">
			    					</div>
			    				</div>
			    				
			    			</div>
			    			
			    			<input type="submit" value="Register" class="btn btn-info btn-block">
			    		
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>
	

<a href="indexAdmin.php">Page for Admin</a>





</body>
<!--<h1> Login Form Structure </h1>
<form action="login.php" method="POST">
	<label>Email Address: </label><input name="emailAddress" type="text"><br>
	<label>Password: </label><input name="password" type="password" ><br>
	<input type="submit" value="Login"><br>
</form> -->

<!--<h1> Create Account Form Structure </h1>
<form action="createAccount.php" method="POST">
	<label>Email Address: </label><input name="emailAddress" type="text"><br>
	<label>First Name: </label><input name="firstName" type="text"><br>
	<label>Last Name: </label><input name="lastName" type="text"><br>
	<label>Country: </label><input name="country" type="text"><br>
	<label>Age: </label><input name="age" type="number"><br>
	<label>Password: </label><input name="password" type="password" ><br>
	<label>Confirm Password: </label><input name="password_conf" type="password" ><br>
	<input type="submit"><br>
</form> -->
</html>

<style>

	body{
  /* Safari 4-5, Chrome 1-9 */
    background: -webkit-gradient(radial, center center, 0, center center, 460, from(#1a82f7), to(#2F2727));

  /* Safari 5.1+, Chrome 10+ */
    background: -webkit-radial-gradient(circle, #1a82f7, #2F2727);

  /* Firefox 3.6+ */
    background: -moz-radial-gradient(circle, #1a82f7, #2F2727);

  /* IE 10 */
    background: -ms-radial-gradient(circle, #1a82f7, #2F2727);
    height:600px;
	
	
    background:url('https://s-media-cache-ak0.pinimg.com/originals/69/37/b3/6937b3806d8f3a03e00f23abede8f592.jpg');
    padding:50px;
}

.centered-form{
	margin-top: 60px;
}

.centered-form .panel{
	background: rgba(255, 255, 255, 0.8);
	box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
}

label.label-floatlabel {
    font-weight: bold;
    color: #46b8da;
    font-size: 11px;
}




#login-dp{
    min-width: 250px;
    padding: 14px 14px 0;
    overflow:hidden;
    background-color:rgba(255,255,255,.8);
}
#login-dp .help-block{
    font-size:12px    
}
#login-dp .bottom{
    background-color:rgba(255,255,255,.8);
    border-top:1px solid #ddd;
    clear:both;
    padding:14px;
}
#login-dp .social-buttons{
    margin:12px 0    
}
#login-dp .social-buttons a{
    width: 49%;
}
#login-dp .form-group {
    margin-bottom: 10px;
}
.btn-fb{
    color: #fff;
    background-color:#3b5998;
}
.btn-fb:hover{
    color: #fff;
    background-color:#496ebc;
}
.btn-tw{
    color: #fff;
    background-color:#55acee;
}
.btn-tw:hover{
    color: #fff;
    background-color:#59b5fa;
}
@media(max-width:768px){
    #login-dp{
        background-color: inherit;
        color: #fff;
    }
    #login-dp .bottom{
        background-color: inherit;
        border-top:0 none;
    }
}









</style>


