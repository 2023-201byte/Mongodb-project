<?php
if(isset($_POST['submit'])){

    $crime_type = $_POST['crime_type'];
    $city = $_POST['city'];
    $description = $_POST['description'];

    $evidence = "";
    if(isset($_FILES['evidence']) && $_FILES['evidence']['error']==0){
        if(!is_dir("uploads")) mkdir("uploads",0777,true);
        $evidence = "uploads/".time()."_".$_FILES['evidence']['name'];
        move_uploaded_file($_FILES['evidence']['tmp_name'], $evidence);
    }

    $data = [
        "crime_type"=>$crime_type,
        "city"=>$city,
        "description"=>$description,
        "evidence"=>$evidence
    ];

    $ch = curl_init("http://localhost:3000/anonymous");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo "Anonymous tip submitted successfully!";
}
?>
