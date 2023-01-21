<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 


if(isset($_GET['reqbook']))
{
$id=$_GET['reqbook'];
$astatus=0;
$sql="update tbcarti set Avaible=:astatus where id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query->bindParam(':astatus',$astatus,PDO::PARAM_STR);
$query -> execute();

$bookid=$_GET['reqbook'];
$stdid = $_SESSION['stdid'];
$rstatus = 0;
$sql="INSERT INTO  tbimprumut (BookId,StudentID) VALUES(:bookid,:stdid)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->execute();

$_SESSION['msg']="!!!!! ";
header('location:avaible-books.php');



}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manager Online Biblioteca</title>
    
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>

<?php include('includes/header.php');?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Carti</h4>
    </div>
     <div class="row">
    <?php if($_SESSION['error']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']);?>
<?php echo htmlentities($_SESSION['error']="");?>
</div>
</div>
<?php } ?>

<?php if($_SESSION['msg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']);?>
<?php echo htmlentities($_SESSION['msg']="");?>
</div>
</div>
<?php } ?>



</div>


        </div>
            <div class="row">
                <div class="col-md-12">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de carti
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nume carte</th>
                                            <th>Categoria</th>
                                            <th>Autor</th>
                                            <th>Editia</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT tbcarti.BookName,tbcategorie.CategoryName,tbautori.AuthorName,tbcarti.Pubyear,tbcarti.id as bookid from  tbcarti join tbcategorie on tbcategorie.id=tbcarti.CatId join tbautori on tbautori.id=tbcarti.AuthorId WHERE tbcarti.Avaible='1' ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>
                                            <td class="center"><?php echo htmlentities($result->Pubyear);?></td>
                                            <td class="center">

                                            <a href="avaible-books.php?reqbook=<?php echo htmlentities($result->bookid);?>"onclick="return confirm('Sigur vreti sa imprumutati aceasta carte?');""><button class="btn btn-primary"><i class="fa fa-check "></i> Imprumuta</button> 
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>


            
    </div>
    </div>


  <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
