<?php

global $conn;
global $student_id;
function connect_db() {
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "codeandpunch");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
}

function disconnect_db() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}

function email_validation($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL); //true: valid email , false: invalid email
}

function no_symbol_validation($text){
    return preg_match('/[\'"^£$%&*()}{@#~?><>,|=+¬-]/', $text); //true: invalid text, false: valid text
}

function number_validation($number){
    if (preg_match('/[a-zA-Z\'"^£$%&*()}{@#~?><>,|=_+¬-]/',$number) 
        || strlen($number) > 10){
            return false;
        }
    return true; // true: valid number, false: invalid number
}


function check_parameter(...$agrs){  // check if all the para not null
    $empty_var  = false;            // return false if all the var not null
                                    // return true if 1 of them null
    foreach($agrs as $arg){
        if ($arg){
            continue;
        }
        $empty_var = true;
        
    }
    return $empty_var;
}

function update_record($password,$email,$phone,$id){
    global $conn;
    $query = "UPDATE information 
    SET password = ?, email = ?, phone_num = ?   
    WHERE user_id = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('sssi',$password,$email,$phone,$id);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
}
function add_record($username,$password,$role,$fullname,$email,$phone){
    global $conn;
    if ($role == 'teacher'){
        $role = 1 ;
    }
    else {
        $role = 0;
    }
    $password = hash('sha256', $password);
    $query = "INSERT INTO information (username, role, password, full_name, email, phone_num) VALUES (?,?,?,?,?,?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('sisssi',$username,$role,$password,$fullname,$email,$phone);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
    
}

function check_login($username,$password){
    global $conn;
    $_SESSION['password'] = $password;
    $password = hash('sha256', $password);
    $query = "SELECT * FROM information WHERE username = ? AND password = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('ss',$username,$password);
    $preparedStatement->execute();
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "Incorrect username or password!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return false;
    } else {
        // get the username
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        
        return true; 
        
    } 
}
function get_information($id){
    global $conn;
    $query = "SELECT * FROM information WHERE user_id = ?";
    try{
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
    }
    catch(Exception $e ){
        echo "<script>alert('Error connecting to database')</script>";
        exit();
    }
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "No result found !";
        echo "<script type='text/javascript'>alert('$message');</script>";
        
    } else {
        
        $row = $result->fetch_assoc();
        return $row;
}
}

function delete_record($id){
    global $conn;
    $query = "DELETE FROM `information` WHERE user_id = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('i',$id);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
}


function get_all_users(){
    global $conn;
    $query = "SELECT * FROM information";
    $result = mysqli_query($conn, $query);
    return $result;
}

function check_dupl_username($str){  // return true if username duplicated, false if no duplicate found
    $result = get_all_users();
    while ($row = mysqli_fetch_assoc($result)){
        if ($row['username'] == $str){
            return true;
        }
    }
    return false;

}

// homework
function get_all_homework(){
    global $conn;
    $query = "SELECT * FROM homework";
    $result = mysqli_query($conn, $query);
    return $result;
}

function get_homework_information($id){
    global $conn;
    $query = "SELECT * FROM homework WHERE homework_id = ?";
    try{
        $preparedStatement = $conn->prepare($query);
        $preparedStatement->bind_param('i',$id);
        $preparedStatement->execute();
    }
    catch(Exception $e ){
        echo "<script>alert('Error connecting to database')</script>";
        exit();
    }
    $result = $preparedStatement->get_result();
    if (mysqli_num_rows($result) <= 0) {
        $message = "No result found !";
        echo "<script type='text/javascript'>alert('$message');</script>";
        
    } else {
        
        $row = $result->fetch_assoc();
        return $row;
}
}
function add_homework($tittle, $description, $file_name, $date){
    global $conn;
    $current_submission = 0;
    $query = "INSERT INTO homework (tittle, description, file_name, date, current_submission) VALUES (?,?,?,?,?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('ssssi',$tittle, $description, $file_name, $date,$current_submission);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
    
}

function update_homework($homework_id ,$tittle, $description, $file_name, $date){
    global $conn;
    $query = "UPDATE homework 
    SET tittle = ?, description = ?, file_name = ? , date = ?  
    WHERE homework_id = ?;";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('ssssii',$tittle, $description, $file_name, $date,$homework_id);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
}
function delete_homework($homework_id){
    global $conn;
    $query = "DELETE FROM `homework` WHERE homework_id = ?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('i',$homework_id);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
}
// FILE

function validateFile()
{
    $allowedMimeTypes = ['text/plain','application/msword','application/pdf'];
    $allowedExtensions = ['txt','doc','pdf'];
    $maxFileSize = 170000;

    $file = $_FILES['file_name'];
    $tempFile = $file['tmp_name'];

    // Check if file was uploaded successfully
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        return false;
    }

    // Check file MIME type
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $tempFile);
    echo $mimeType;
    finfo_close($fileInfo);
    if (!in_array($mimeType, $allowedMimeTypes)) {
        echo "Invalid file type. Only text,word,pdf files are allowed.";
        return false;
    }

    // Check file extension
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Invalid file extension. Only TXT files are allowed.";
        return false;
    }

    // Check file size
    if ($file['size'] > $maxFileSize) {
        echo "File size exceeds the limit.";
        return false;
    }

    return true;
}

function uploadFile($targetDir)
{
    if ($_FILES['file_name']['name'] != "") {
        // Where the file is going to be stored
        $fileName = $_FILES['file_name']['name'];
        $tempFile = $_FILES['file_name']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Sanitized file name
        $temp = basename($fileName);
        $pattern = '/[^A-Za-z0-9_.-]/';
        $sanitizedFileName = preg_replace($pattern, '', $temp);

        // Generate a unique file name
	  
        $uniqueName = uniqid() . '_' . $sanitizedFileName;
        $targetFile = $targetDir . $uniqueName;

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "<script>alert('Sorry, a file with the same name already exists.')</script>";
            return null;
        } elseif (!validateFile()) {
            echo "<script>alert('Invalid file.')</script>";
            return null; 
        } else {
            // Move uploaded file to the desired directory
            if (move_uploaded_file($tempFile, $targetFile)) {
                echo "<script>alert('File uploaded successfully !')</script>";
                return $targetFile;
            } else {
                echo "<script>alert('Error uploading file.')</script>";
                return null;
            }
        }
    } else {
        echo "<script>alert('No file selected.')</script>";
        return null;
    }
}


?>