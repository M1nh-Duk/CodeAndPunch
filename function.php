<?php

global $conn;
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



?>