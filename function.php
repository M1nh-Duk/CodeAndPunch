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
    return preg_match('/[\'"^£$%&*()}{@#~?><>,|=_+¬-]/', $text); //true: invalid text, false: valid text
}

function number_validation($number){
    if (preg_match('/[a-zA-Z\'"^£$%&*()}{@#~?><>,|=_+¬-]/',$number) 
        && strlen($number) <= 10){
            return false;
        }
    return true; // true: invalid number, false: valid number
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


function add_to_db($username,$password,$role,$fullname,$email,$phone){
    global $conn;
    if ($role == 'teacher'){
        $role = 1 ;
    }
    else {
        $role = 0;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO information () VALUES (?,?,?,?,?,?)";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('sisssi',$username,$role,$password,$fullname,$email,$phone);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
    
}

function check_login($username,$password){
    global $conn;
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM information WHERE username=? AND password=?";
    $preparedStatement = $conn->prepare($query);
    $preparedStatement->bind_param('ss',$username,$password);
    if ($preparedStatement->execute()){
        return true;
    }
    return false;
}










?>