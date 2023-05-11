
<?php
// Original code copied from w3schools.
// Adapted for CST8805 project by Yvan Perron November 27, 2021
//Do not change any of the code below this line and up to the "End of do not modify comment below"
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_fileSig = $target_dir . basename($_FILES["fileToUploadSig"]["name"]);
$target_fileX509 = $target_dir . basename($_FILES["fileToUploadX509"]["name"]);

$uploadOk = 1;

// Check if file already exists
//if (file_exists($target_file) || file_exists($target_fileSig) || file_exists($target_fileX509)) {
//  echo " <p>Files already exists - they will be overwritten. </p> ";
//  //$uploadOk = 0;
//}

echo " <p style='color:blue; font-size:1.5em;'> File Upload Results</p> ";

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "&nbsp &nbsp &nbsp Sorry, your file is too large.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "&nbsp &nbsp &nbsp Sorry, your file was not uploaded. ";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["fileToUploadSig"]["tmp_name"], $target_fileSig) && move_uploaded_file($_FILES["fileToUploadX509"]["tmp_name"], $target_fileX509)) {
//    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " and its digital signature have been uploaded. <br>";
      echo "&nbsp &nbsp &nbsp Files successfully uploaded to Bank Payroll Application <br>";
  } else {
    echo "&nbsp &nbsp &nbsp  Sorry, there was an error uploading your file. ";
    $uploadOk = 0;
  }
}
//End of do NOT modify any of the code above this line

//The code below this line is student customizable
//Important variables
//  $target_fileSig    path to payroll signature file
//  $target_file       path to payroll file
//  $target_fileX509   path to signer x509 certificate
//  $target_filePub  path to signer public key

$target_filePubKey = $target_fileX509 . "_Pub.pem";

//Sample code - Signature Validation via OpenSSL command shell
if ($uploadOk !== 0) {

    $openssl_verify_command = "openssl verify -verbose -trusted certs/PKIcert.cer $target_fileX509";

    //$openssl_crl_check_command = "openssl verify -verbose -crl_check -CRLfile CAProject.crl.pem -trusted certs/PKIcert.cer $target_fileX509 2>&1";
    
    $openssl_expired_check_command = "openssl verify -verbose -attime 1681950572 -trusted certs/PKIcert.cer $target_fileX509 2>&1";
    
    $openssl_signature_check_command = "openssl x509 -inform pem -in $target_fileX509 -pubkey -out $target_filePubKey && openssl dgst -sha256 -verify $target_filePubKey -signature $target_fileSig $target_file";
    
    //$crl_check_result = shell_exec($openssl_crl_check_command);
    $expired_check_result = shell_exec($openssl_expired_check_command);
    $signature_check_result = exec($openssl_signature_check_command);
    $trusted_check_result = shell_exec($openssl_verify_command);

   
    if(strpos($expired_check_result, "expired") !== false){
        // Certificate Expired
        echo "<h2 style='color:red;'>Certificate Expired!</h2>";
    }
    elseif (strpos($trusted_check_result, "OK") === false) {
        // Certificate not from trusted source
        echo "<h2 style='color:red;'>Certificate not from trusted source!</h2>";
    } 
    elseif (strpos($signature_check_result, "OK") === false) {
        // File signature does not match
        echo "<h2 style='color:red;'>File is Tampered!</h2>";
    } 
//elseif (strpos($crl_check_result, "certificate revoked") !== false) {
         //Certificate revoked
     //   echo "<h2 style='color:red;'>Certificate revoked!</h2>";
   // } 
    else {
        // Document is valid
        echo "<h2 style='color:green;'>Document is signed with valid certificate!</h2>";
    }
 
}
else {
    // Upload failed, do nothing
}
?>
