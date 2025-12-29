<?php
if(isset($_POST['submit'])){

    // Safely fetch POST data
    $full_name = isset($_POST['name']) ? $_POST['name'] : '';
    $cnic = isset($_POST['cnic']) ? $_POST['cnic'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $issue_type = isset($_POST['crime_type']) ? $_POST['crime_type'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // File upload
    $evidence = "";
    if(isset($_FILES['evidence']) && $_FILES['evidence']['error'] == 0){
        $upload_dir = "uploads/";
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES["evidence"]["name"]);
        $target_file = $upload_dir . $file_name;

        if(move_uploaded_file($_FILES["evidence"]["tmp_name"], $target_file)){
            $evidence = $target_file;
        }
    }

    // Prepare data to send to Node.js
    $data = [
        "full_name" => $full_name,
        "cnic" => $cnic,
        "phone" => $phone,
        "city" => $city,
        "issue_type" => $issue_type,
        "description" => $description,
        "evidence" => $evidence
    ];

    // Send data via cURL to Node.js backend
    $ch = curl_init("http://localhost:3000/women");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "<h2 style='text-align:center; color:green; margin-top:50px;'>Women help request submitted successfully!</h2>";
}
?>
