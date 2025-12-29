<?php
if(isset($_POST['submit'])){

    if(!is_dir("uploads")) mkdir("uploads",0777,true);

    $file = "uploads/".time()."_".$_FILES['firCopy']['name'];
    move_uploaded_file($_FILES['firCopy']['tmp_name'], $file);

    $data = [
        "cnic" => $_POST['cnic'],
        "fir_copy" => $file
    ];

    $ch = curl_init("http://localhost:3000/request");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo "<h2 style='text-align:center; color:green; margin-top:50px;'>Request submitted successfully!</h2>";
}
?>
