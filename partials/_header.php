<?php
session_start();


echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">NSUT Forum</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">Action</a></li>
          <li><a class="dropdown-item" href="#">Another action</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tabindex="-1">Contact</a>
      </li>
    </ul>
    <div class="mx-2">
     <form class="d-flex method="get" action="search.php">
    <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-info" type="submit">Search</button>
    </form>
    </div>';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo'
    <p class="text-light my-0"> Welcome ' . $_SESSION['useremail'] . '</p>
    <a href="partials/_logout.php" class="btn btn-outline-info ml-2">Logout</a>';
  }

  else{
    echo '
    <div class="mx-2">
    <button class="btn btn-outline-info ml-2"  data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
    <button class="btn btn-outline-info mx-2"  data-bs-toggle="modal" data-bs-target="#signupmodal">Signup</button> ';
  }
   echo '
    </div>

  </div>
</div>
</nav>';

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){ 
  echo "you have registered! you can now log in";
}
?>