<?php
  session_start();
  include("function.php");

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
ul {list-style: none;padding: 0;margin: 0;}
li {display: flex;align-items: center;margin-bottom: 50px;}
li span{font-weight: bold;margin-right: 10px;width: 300px;}
</style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Username: <br>Role: </b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Edit information</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Assign homework</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Get homework</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Search user</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Game</a>
    <br><br><br><br><br><br><br><br>
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Sign Out</a> 

  </div>
</nav>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:20px" id="showcase">
    <h1 class="w3-jumbo"><b>Welcome aboard, </b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Showcase.</b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
  <div>
    <h3><b>Your information:</b></h3>
    <br><br>
    <ul>
        <li>
            <span>Username:</span>
            <span>[Username]</span>
        </li>
        <li>
            <span>Password:</span>
            <span>[Password]</span>
        </li>
        <li>
            <span>Full name:</span>
            <span>[Full name]</span>
        </li>
        <li>
            <span>Role:</span>
            <span>[Role]</span>
        </li>
        <li>
            <span>Email:</span>
            <span>[Email]</span>
        </li>
        <li>
            <span>Phone Number:</span>
            <span>[Phone Number]</span>
        </li>
    </ul>

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

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
