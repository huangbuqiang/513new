<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style4.css" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <title></title>

	<style type="text/css">
		h20{
		   font: 35px "微软雅黑";
		   margin:30px auto; 
		   font-weight: 500; 
		   text-align: center; 
		   color: #f35626; 
		   -webkit-animation:swing 2s infinite;
		}
  
        @-webkit-keyframes swing{
		   20%{
		      -webkit-transform:rotate(15deg);
		   }40%{
		      -webkit-transform:rotate(-15deg);
		   }60%{
		      -webkit-transform:rotate(5deg);
		   }80%{
		      -webkit-transform:rotate(-5deg);
		   }100%{
		      -webkit-transform:rotate(0deg);
		   }
		}
	</style>
  </head>
  <body>
    <nav class="nav">
      <div class="container">
        <img src="logo.jpg" width="100",height="100";>
        <h20 class="logo"><a href="/index.html">LUCAS bakery</a></h20>
        <ul>
          <li ><a href="index4.html" accesskey="1" title="">Home</a></li>
          <li><a href="about us2.html" accesskey="2" title="">About US</a></li>
          <li><a href="careers2.html" accesskey="3" title="">Careers </a></li>
          <li><a href="orderonline2.php" accesskey="4" title="">Order online </a></li>
		  <li><a href="contactus2.html" accesskey="5" title="">Contact Us</a></li>
          <li><a href="#" class="current"register4.php" accesskey="6" title="">Register</a></li>
        </ul>
      </div>
    </nav>

  


<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary612 = $username = $password ="";
$name_err = $address_err = $salary612_err = $username_err =$password_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary612
    $input_salary612 = trim($_POST["salary612"]);
    if(empty($input_salary612)){
        $salary612_err = "Please enter the salary612 amount.";     
    } elseif(!ctype_digit($input_salary612)){
        $salary612_err = "Please enter a positive integer value.";
    } else{
        $salary612 = $input_salary612;
    }

    // Validate username
if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
} elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
    $username_err = "Username can only contain letters, numbers, and underscores.";
} else{
    // Prepare a select statement
    $sql = "SELECT id FROM employees WHERE username = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        
        // Set parameters
        $param_username = trim($_POST["username"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                $username_err = "This username is already taken.";
            } else{
                $username = trim($_POST["username"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Validate confirm password
if(empty(trim($_POST["password"]))){
    $password_err = "Please confirm password.";     
} else{
    $password = trim($_POST["password"]);
    if(empty($password_err) && ($password != $password)){
        $password_err = "Password did not match.";
    }
}
 
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary612_err)&& empty($username_err)&& empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary612, username, password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiss", $param_name, $param_address, $param_salary612, $param_username, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary612 = $salary612;
            $param_username = $username;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: register2.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    </head>
    <br>
        <br>
        <br>
        <br> <br>
        <br>
       
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"id="form"syley="align=“center”">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" style="width:500px;height:50px"name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address"style="width:500px;height:50px" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>salary</label>
                            <input type="text" style="width:500px;height:50px"name="salary612" class="form-control <?php echo (!empty($salary612_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary612; ?>">
                            <span class="invalid-feedback"><?php echo $salary612_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" style="width:500px;height:50px"name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" style="width:500px;height:50px"name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit"style="width:100px;height:60px">
                        
                        <a href="index2.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    
    
    
    
    
    
    
    
                
                            <footer class='footer2'>
                                <h4>Address:36 Garden Ave, Mullumbimby NSW 2482</h4>
                                <h4>Telephone number:61 8 6377 8270</h4>
                                    <h4>Email address:support@signalhire.com</h4> 
                              </footer>
    </body>
    <style>
        	html, body
	{
		height: 100%;
	}
	
	body
	{
		margin: 0px;
		padding: 0px;
		background: #99ff66;
		font-family: 'Questrial', sans-serif;
		font-size: 12pt;
		color: rgba(0,0,0,.6);
	}
	
	
	h1, h2, h3
	{
		margin: 0;
		padding: 0;
		color: #404040;
	}
	
	p, ol, ul
	{
		margin-top: 0;
	}
	
	ol, ul
	{
		padding: 0;
		list-style: none;
	}
	
	p
	{
		line-height: 180%;
	}
	
	
	strong
	{
	}
	
	a
	{
		color: #CC3399;
	}
	
	a:hover
	{
		text-decoration: none;
	}
	

	.container
	{
		margin: 0px auto;
		width: 1200px;
		overflow: hidden;
		padding: 0em 0em 5em 0em;
		
	}
	



/*********************************************************************************/
/* List Styles                                                                   */
/*********************************************************************************/

	ul.style1
	{
	}




	ul.contact
	{
		margin: 0;
		padding: 2em 0em 0em 0em;
		list-style: none;
	}
	
	ul.contact li
	{
		display: inline-block;
		padding: 0em 0.10em;
		font-size: 1em;
	}
	
	ul.contact li span
	{
		display: none;
		margin: 0;
		padding: 0;
	}
	
	ul.contact li a
	{
		color: #FFF;
	}
	
	ul.contact li a:before
	{
		display: inline-block;
		background: #4C93B9;
		width: 40px;
		height: 40px;
		line-height: 40px;
		text-align: center;
		color: rgba(255,255,255,1);
	}
	

/*********************************************************************************/
/* Button Style                                                                  */
/*********************************************************************************/

	.button
	{
		display: inline-block;
		margin-top: 2em;
		padding: 0.8em 2em;
		background: #64ABD1;
		line-height: 1.8em;
		letter-spacing: 1px;
		text-decoration: none;
		font-size: 1em;
		color: #FFF;
	}
	
	.button:before
	{
		display: inline-block;
		background: #8DCB89;
		margin-right: 1em;
		width: 40px;
		height: 40px;
		line-height: 40px;
		border-radius: 20px;
		text-align: center;
		color: #272925;
	}
	
	.button-small
	{
	}
		
/*********************************************************************************/
/* Heading Titles                                                                */
/*********************************************************************************/

	.title
	{
		margin-bottom: 3em;
		background-image: url();
	}
	
	.title h2
	{
		font-size: 2.8em;
	}
	
	.title .byline
	{
		font-size: 1.1em;
		color: #6F6F6F#;
	}

/*********************************************************************************/
/* Header                                                                        */
/*********************************************************************************/

	#header-wrapper
	{
		overflow: hidden;
		background-image: url("product-images/logo.png");
	    background-repeat:no-repeat;
		/*background: #C73399 url(images/overlay.png) repeat;*/
	}

	#header
	{
		text-align: center;
	}

/*********************************************************************************/
/* Logo                                                                          */
/*********************************************************************************/

	#logo
	{
		padding: 8em 0em 4em 0em;
	}
	
	#logo h1
	{
		display: inline-block;
		margin-bottom: 0.20em;
		padding: 0.20em 0.9em;
		font-size: 3.5em;
	}
	
	#logo a
	{
		text-decoration: none;
		color: #FFF;
	}
	
	#logo span
	{
		padding-right: 0.5em;
		text-transform: uppercase;
		font-size: 0.90em;
		color: rgba(255,255,255,1);
	}

	#logo span a
	{
		color: rgba(255,255,255,0.8);
	}
	
	



	#menu
	{
		height: 60px;
	}
	
	#menu ul
	{
		display: inline-block;
		padding: 0em 2em;
		text-align: center;
	}
	
	#menu li
	{
		display: inline-block;
	}
	
	#menu li a, #menu li span
	{
		display: inline-block;
		padding: 0em 1.5em;
		text-decoration: none;
		font-size: 0.90em;
		font-weight: 600;
		text-transform: uppercase;
		line-height: 60px;
		outline: 0;
		color: #FFF;
	}
	
	#menu li:hover a, #menu li.active a, #menu li.active span
	{
		background: #FFF;
		color: #CC3399;
	}
	
	#menu .current_page_item a
	{
	}
	

/*********************************************************************************/
/* Banner                                                                        */
/*********************************************************************************/

	#banner
	{
	}

/*********************************************************************************/
/* Wrapper                                                                       */
/*********************************************************************************/


	.wrapper
	{
		overflow: hidden;
		padding: 0em 0em 5em 0em;
		background: rgb(255, 255, 255);
	}

	#wrapper1
	{
		background: #FFF;
	}

	#wrapper2
	{
		overflow: hidden;
		background: #F3F3F3;
		padding: 5em 0em;
		text-align: center;
	}

	#wrapper3
	{
	}
	
	#wrapper4
	{
	}

/*********************************************************************************/
/* Welcome                                                                       */
/*********************************************************************************/

	#welcome
	{
		overflow: hidden;
		width: 1000px;
		padding: 6em 100px 0em 100px;
		text-align: center;
	}
	
	#welcome .content
	{
		padding: 0em 8em;
	}
	
	#welcome .title h2
	{
	}
	
	#welcome a,
	#welcome strong
	{
	}


	#page-wrapper
	{
		overflow: hidden;
		background: #2F1E28;
		padding: 3em 0em 6em 0em;
		text-align: center;
	}

	#page
	{
	}


	#content
	{
		float: left;
		width: 700px;
		padding-right: 100px;
		border-right: 1px solid rgba(0,0,0,.1);
	}



	#footer
	{
		overflow: hidden;
		padding: 5em 0em;
		background: #E3F0F7;
		text-align: center;
	}


		
	#footer .fbox1,
	#footer .fbox2,
	#footer .fbox3
	{
		float: left;
		width: 320px;
		padding: 0px 40px 0px 40px;
	}
	
	#footer .icon
	{
		display: block;
		margin-bottom: 1em;
		font-size: 3em;
	}

	
	#footer .title span
	{
		color: rgba(255,255,255,0.4);
	}


	#newsletter
	{
		overflow: hidden;
		padding: 8em 0em;
		background: #EDEDED;
		text-align: center;
	}
	
	#newsletter .title h2
	{
		color: rgba(0,0,0,0.8);
	}
	
	#newsletter .content
	{
		width: 600px;
		margin: 0px auto;
	}
	


	.column1,
	.column2,
	.column3,
	.column4
	{
		width: 282px;
	}
	
	.column1,
	.column2,
	.column3
	{
		float: left;
		margin-right: 24px;
	}
	
	.column4
	{
		float: right;
	}

/

	#three-column
	{
		overflow: hidden;
		margin-top: 5em;
		padding-top: 1em;
		border-top: 1px solid rgba(0,0,0,0.2);
		text-align: left;
	}
	
	#three-column h2
	{
		margin: 1em 0em;
		font-size: 1.5em;
		font-weight: 700;
	}
	
	#three-column .icon
	{
		position: relative;
		display: block;
		margin: 0px auto 0.80em auto;
		background: none;
		line-height: 150px;
		font-size: 4em;
		width: 150px;
		height: 150px;
		border-radius: 100px;
		border: 6px solid #67128F;
		text-align: left;
		color: #FFF;
		
	}
		
	#three-column #tbox1,
	#three-column #tbox2,
	#three-column #tbox3
	{
		float: left;
		width: 320px;
		padding: 80px 40px 80px 40px;
	}
	
	#three-column .title
	{
		text-align: left;
	}
	
	#three-column .title h2
	{
		font-size: 1.60em;
	}
	
	#three-column .title .byline
	{
		padding-top: 0.50em;
		font-size: 0.90em;
		color: #858585;
	}

	#three-column .arrow-down
	{
		border-top-color: #292929;
	}
	

	
	
	ul.tools
	{
		margin: 0;
		padding: 0em 0em 0em 0em;
		list-style: none;
	}
	
	ul.tools li
	{
		display: inline-block;
		padding: 0em .2em;
		font-size: 4em;
	}
	
	ul.tools li span
	{
		display: none;
		margin: 0;
		padding: 0;
	}
	
	ul.tools li a
	{
		color: #FFF;
	}
	
	ul.tools li a:before
	{
		display: inline-block;
		background: #1ABC9C;
		width: 120px;
		height: 120px;
		border-radius: 50%;
		line-height: 120px;
		text-align: center;
		color: #FFFFFF;
	}
	.footer {
	  position: fixed;
	  left: 10px;
	  bottom: 5px;
	  right: 10px; 
	  width: 95%;
	  background-color: gray;
	  color: white;
	  text-align: center;
	  }

    </style>

<style>
.footer {

  left: 10px;
  bottom: 5px;
  right: 10px; 
  width: 95%;
  background-color: rgb(248, 183, 42);
  color: rgb(52, 18, 247);
  text-align: center;
  }
  </style>
<div class="footer">
  LUCAS Zed
  </div>
  </Body>
  </Html>