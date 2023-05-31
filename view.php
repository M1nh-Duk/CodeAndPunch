<?php
  session_start();
  include("function.php");
  if (! isset($_SESSION['user_id'])) {
    // Redirect to the login page or deny access if not authorized
    header('Location: login.php');
    exit;
  }
  connect_db();
  $row = get_information($_SESSION['user_id']);
  $username = $row['username'];
  if ($row['role'] == 1){
      $role = "Teacher";
  }
  else {
      $role = "Student";
  }
  $fullname = $row['full_name'];
  $email = $row['email'];
  $phone = $row['phone_num'];

  disconnect_db();
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CodeAndPunch</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
.round-button {background-color: green;color: white;border: none;border-radius: 50%;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;cursor: pointer;}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Username: <?php echo $username; ?><br>Role: <?php echo $role; ?></b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> 
    <a href="edit.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Edit information</a>
    <a href="view.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">View user</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Homework</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Game</a>
    <br><br><br><br><br><br><br><br>
    <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Sign Out</a> 

  </div>
</nav>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:20px" id="showcase">
    <h1 class="w3-jumbo"><b>View users</b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
 
  <div>
    <h3><b>User Table</b></h3>
    <br><br>
    <table>
        <tr>
            <th>Full name</th> 
            <th>Role</th> 
            <th>Action</th>     
        </tr>
        <?php
            connect_db();
            $result = get_all_users();
            disconnect_db();
        ?>
            <?php while ($row = mysqli_fetch_assoc($result))://print all users and use javascript to send the clicked student to next page ?>   
            <?php
                $row['role'] = ($row['role'] == 1) ? 'Teacher' : 'Student';
            ?>
        <tr>
            <td> <?php echo $row['full_name'] ?></td>
            <td> <?php echo $row['role'] ?></td>
            <td>
                    <form action="view_user.php" method="POST">
                        <input type="hidden" name="view_id" value="<?php echo $row['user_id']; ?>">
                    <button  type="submit"> View </button> 
                    </form>
                <?php  if ($role == 'Teacher' && $row['role'] == 'Student'):// only teacher can edit student but not other teacher?>
                    <form action="edit_student.php" method="POST">
                        <input type="hidden" name="edit_id" value="<?php $_SESSION['edit_id'] = $row['user_id']; ?>">
                    <button  type="submit"> Edit </button> 
                    </form>
                
                <?php endif; ?>

            </td>
        </tr>
        <?php endwhile; ?>

        
    </table>

  </div>
  
<!-- End page content -->
</div>


<!-- Footer -->
<footer>
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:10px;padding-right:58px"><p class="w3-right"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="GIFT" target="_blank" class="w3-hover-opacity">Small gift for you</a></p></div>
</footer>


<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

function redirectToEdit() {
        // Redirect to the desired page
        window.location.href = "edit_student.php";
    }

// Edit student
function editStudent(username) {
        // Perform desired actions with the student ID
        // You can send the student ID to the server via AJAX for further processing
        console.log("Edit student with username: " + username);
        // Additional logic can be added here, such as redirecting to an edit page
    }
</script>

</body>
</html>
