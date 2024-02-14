<?php
include '../Includes/dbcon.php';

// Retrieve the imported Excel data from the POST request
$excelData = json_decode($_POST['excelData'], true);

// Assuming the structure of $excelData is an array of arrays,
// where each inner array represents a row of data from the Excel file
foreach ($excelData as $row) {
    // Extract data from the row
    $firstName = $row[0];
    $lastName = $row[1];
    $otherName = $row[2];
    $admissionNumber = $row[3];
    $classId = $row[4];
    $classArmId = $row[5];
    $dateCreated = date("Y-m-d");

    // Perform insertion into tblstudents table
    $query = "INSERT INTO tblstudents (firstName, lastName, otherName, admissionNumber, classId, classArmId, dateCreated) 
              VALUES ('$firstName', '$lastName', '$otherName', '$admissionNumber', '$classId', '$classArmId', '$dateCreated')";
    $result = mysqli_query($conn, $query);

    // Handle insertion success/failure
    if (!$result) {
        // Handle insertion failure
        $errorMessage = mysqli_error($conn);
        echo json_encode(['success' => false, 'message' => 'Error inserting data: ' . $errorMessage]);
        exit;
    }
}

// If all insertions were successful
echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);

// Now we need to display the imported data in the website's table.
// We can redirect to the page where the table is displayed after importing the data.
header("Location: createStudents.php");
exit();
?>
