
<?php
include('classes/DB.php');
if(!isset($_GET['name']) || !isset($_GET['result'])){
    header('Location:/quiz');
}
$name = $_GET['name'];
$result = $_GET['result'];
$result_details = DB::query('SELECT * FROM results WHERE id=:id',array(':id'=>$result));
if(!$result_details){
    header('Location:/quiz');
}
$result_details = $result_details[0];
$result_name = $result_details['name'];
$result_description = $result_details['description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta property="og:title" content="<?php echo explode(" ",$name)[0]?>'s problem is <?php echo $result_name ?>. Take The Test Now!" />
    <meta property="og:description" content="<?php echo $result_description; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://campaignersmiu.com/vision-test/result/<?php echo explode(" ",$name)[0];?>/<?php echo $_GET['result'];?>" />
    <meta property="og:image" content="https://campaignersmiu.com/vision-test/layout/png/logo.png" />
    <!--<meta property="og:image" content="https://campaignersmiu.com/vision-test/layout/png/fb_share_<?php echo 
strtolower($result_name); ?>.png" />-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/quiz/layout/css/master.css">
    <title><?php echo $name?>'s quiz result</title>
</head>
<body>
<div class="wrapper" id="main-app">
        <div id="result-body" style="display: block;">
           <div class="logo">
                <img src="/quiz/layout/png/logo.png">
            </div>
            <div class="congrats">
                <?php echo $name?> took the quiz. <br>Take yours now!
            </div>
            <a hhref="./" style="text-decoration:none;"><div style="float:inherit;margin:50px auto;" class="xbutton">Start Quiz</div></a>
        </div>
    </div>
    <div id="footer">
        Made by Campaigners' Personnel Team &copy; <?php echo date('Y');?>
    </div>
</body>
</html>

