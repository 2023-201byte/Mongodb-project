<?php
if(isset($_POST['submit'])){

    $evidence = "";
    if(isset($_FILES['evidence']) && $_FILES['evidence']['error']==0){
        if(!is_dir("uploads")) mkdir("uploads",0777,true);
        $evidence = "uploads/".time()."_".$_FILES['evidence']['name'];
        move_uploaded_file($_FILES['evidence']['tmp_name'], $evidence);
    }

    $data = [
        "full_name" => $_POST['name'],
        "cnic" => $_POST['cnic'],
        "phone" => $_POST['phone'],
        "city" => $_POST['city'],
        "place" => $_POST['place'],
        "crime_type" => $_POST['crime_type'],
        "description" => $_POST['description'],
        "evidence" => $evidence
    ];

    $ch = curl_init("http://localhost:3000/fir");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo "<h2 style='text-align:center; color:green; margin-top:50px;'>FIR submitted successfully!</h2>";
}
?>
