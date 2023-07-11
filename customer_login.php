<?php 
 include("logininit.php");
$response= "";
$response_status = "none";

 if(isset($_POST["login"]))
 {
    $email = $_POST["email"];
    $password= $_POST["password"];
    $response= "This credentials does not Match";
    $response_status = "error";

    $find= find("all","customer","*","where email='$email' and password='$password' and approval_status='Y'",array());
    if($find)
    {
        //$finduser=  find("first","admin as a inner join admin_roles as ar on a.admin_id = ar.admin_id inner join designations as d on ar.desig_id=d.desig_id","*"," where a.admin_email='$email' and a.password='$password'",array());
        $findcust=  find("first","customer as c inner join customer_roles as cr on c.role=cr.cust_role_id","*","where email='$email' and password='$password'",array());

        $_SESSION["user_id"]=$findcust["customer_id"];
        $_SESSION["email"]=$findcust["email"];
        $_SESSION["role"]= $findcust["role_name"];
        $_SESSION["roll"]= $findcust["cust_role_id"];
        $_SESSION["name"]= $findcust["name"];
        $_SESSION["type"]= "customer";
        $user_id= $findcust["customer_id"];
        $findpendingorder = find("all","placeorder","*"," where user_id= '$user_id' and status='P' and is_placed_order='N'",array());
        if($findpendingorder)
        {
            $findpendingorder = find("first","placeorder","*"," where user_id= '$user_id' and status='P' and is_placed_order='N'",array());
        
            $_SESSION["order_id"]= $findpendingorder["stockiest_order_id"];
        }
        else{
            unset($_SESSION["order_id"]);
        }
        redirectfn("dashboard.php");
        
        $response= "login Successfull";
        $response_status = "success";
    }
    else{
        $response= " This credential is not found";
        $response_status = "error";
    }
 }
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SCM | LOGIN</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="./css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body
        {
            background-image : url("images/login_bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3 bg-white p-2" style="border-radius: 20px;">
										<a href="customer_login.php"><img src="images/logo-text.png" style="width:50%" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4 text-white">Customer Login</h4>
                                    <form action="" method="POST">
                                    <?php if(isset($response_status)){ 
                                            
                                        if($response_status!="none") { 
                                            if($response_status=="error") {
                                            ?>
                                            <div class="form-group bg-danger text-white p-1">  
                                                <?= $response?>
                                            </div>
                                        <?php 
                                            }
                                            if($response_status=="success") {
                                                ?>
                                                <div class="form-group bg-success text-white p-1">  
                                                <?= $response?>
                                                </div>
                                            <?php 
                                                }
                                    
                                        } } ?>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control"  placeholder="example@gmail.com" value="">
                                        </div>
                                        <label class="mb-1 text-white"><strong>Password</strong></label>
                                        <div class="form-group input-group input-info">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="showHidepass()"><i class="fa fa-eye" ></i></span>
                                            </div>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1 text-white">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a class="text-white" href="recover_account.php?type=customer">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <input  type="submit" name="login" class="btn bg-white text-primary btn-block" value="Sign Me In" />
                                        </div>
                                    </form>
                                        <div class="form-row d-flex justify-content-center mt-4">
                                            <div class="form-group">
                                                <a href="customer_registration.php" class="text-white">New Customer ?</a>
                                            </div>
                                            <!-- <div class="form-group">
                                                <a href="vetzone_login.php" class="text-white">Switch to VetZone Login</a> <br>
                                            </div> -->
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/deznav-init.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showHidepass(){
                var passwordInput = $('#password');
                var passwordFieldType = passwordInput.attr('type');
                
                // Toggle between password and text types
                if (passwordFieldType === 'password') {
                passwordInput.attr('type', 'text');
                } else {
                passwordInput.attr('type', 'password');
                }
            }
    </script>
</body>

</html>