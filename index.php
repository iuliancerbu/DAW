<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
    echo "<script type='text/javascript'> document.location ='issued-books.php'; </script>";
}
if(isset($_POST['login']))
{

$email=$_POST['emailid'];
$password=md5($_POST['password']);
$sql ="SELECT EmailId,Password,StudentId,FullName,Status,Role FROM users WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            $_SESSION['fname'] = $result->FullName;

            if ($result->Role == "admin") {
                $_SESSION['alogin'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
            } else {
                if ($result->Status == 1) {
                    $_SESSION['login'] = $_POST['emailid'];
                    
                    echo "<script type='text/javascript'> document.location ='issued-books.php'; </script>";
                } else {
                    echo "<script>alert('Contul dumneavoastra este blocat. Va rugam contactati administratorul.');</script>";

                }
            }
        }
} 

else{
echo "<script>alert('Date invalide');</script>";
}
}

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manager Online Biblioteca</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">LOGIN FORM</h4>
</div>
</div>
             
<!--LOGIN-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 LOGIN FORM
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Enter Email id</label>
<input class="form-control" type="text" name="emailid" required autocomplete="off" />
</div>
<div class="form-group">
<label>Password</label>
<input class="form-control" type="password" name="password" required autocomplete="off"  />
<p class="help-block"><a href="user-forgot-password.php">Forgot Password</a></p>
</div>

 <button type="submit" name="login" class="btn btn-info">LOGIN </button> | <a href="signup.php">Not Register Yet</a>
</form>
 </div>
</div>
</div>
</div>  
          
             
 
    </div>
    </div>

 <?php include('includes/footer.php');?>
 
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
