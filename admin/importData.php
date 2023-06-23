<?php
  // Load the database configuration file 
  include_once '../dbConfig.php';

  // Include PhpSpreadsheet library autoloader 
  require_once 'vendor/autoload.php'; 
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 

  // Allowed mime types 
  $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

  // Validate whether selected file is a Excel file 
  if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){

    // If the file is uploaded 
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
      //Check code table if not create table
      $result = $db->query("SELECT * FROM code");
      if(!$result){
        $newTable = $db->query("CREATE TABLE `$dbName`.`code` (`id` VARCHAR(50) NOT NULL , `checked` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
      }

      //Read Excel
      $reader = new Xlsx(); 
      $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
      $worksheet = $spreadsheet->getActiveSheet();  
      $worksheet_arr = $worksheet->toArray();

      // Remove header row 
      unset($worksheet_arr[0]);

      foreach($worksheet_arr as $row){
        $id = $row[0];
        $checked = intval($row[1]);

        // Check whether code already exists in the database 
        $result = $db->query("SELECT id, checked FROM code WHERE id = '".$id."'");

        if($result->num_rows > 0){
          while($code = $result->fetch_assoc()) {
            // Check the checked from Excel is higher or not
            if($checked > $code['checked']) {
              // Insert the checked from Excel to data
              $db->query("UPDATE code SET checked = ".$checked." WHERE id = '".$id."'");
            }
          }
          continue;
        } else {
          //Insert row into table
          $db->query("INSERT INTO code (id, checked) VALUES ('".$id."','".$checked."')");
        }
        
      }
      $qstring = '?status=succ';
    } else {
      $qstring = '?status=err';
    }
  } else {
    $qstring = '?status=invalid_file';
  }

  // Redirect to the listing page 
  header("Location: index.php".$qstring);
?>