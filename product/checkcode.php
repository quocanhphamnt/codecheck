<?php 
  // Load the database configuration file 
  include_once '../dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="./assets/css/reset.css" />
    
    <link rel="stylesheet" href="./assets/css/style.css" />
</head>
<body>
    <main>
        <div class="boxContent">
            <img src="./assets/images/logo-NH23.png" alt="" class="logo">
            <?php
                // Check GET method exists code
                if(!empty($_GET['id'])){
                    // Check code exists  
                    $result = $db->query("SELECT id, checked FROM code WHERE id = '".$_GET['id']."'");
                    if($result->num_rows > 0) {
                        while($code = $result->fetch_assoc()) {
                            // Insert (checked+1) to data
                            $db->query("UPDATE code SET checked = ".(intval($code['checked'])+1)." WHERE id = '".$code['id']."'");
                        }
                        ?>
                        <img src="./assets/images/green-double-circle-check-mark/green_double_circle_check_mark.jpg" alt="" class="greentick">
                        <p id="code"></p>
                        <p class="noti">Congratulation! Your product code is valid and the packed</p>
            <?php   } else { ?>
                        <img src="./assets/images/red-cross-check-mark/red-cross-check-mark.png" alt="" class="greentick">
                        <p class="noti">Sorry! Your product code is not valid</p>
            <?php   }
                }
            ?>
            
        </div>
    </main>
    <footer>
        <div class="content">
            © MARC WEISS PARIS GmbH & Co. KG I CONTACT US I IMPRINT I PRIVACY POLICY
        </div>
    </footer>
    <script src="./app.js"></script>
</body>
</html>
