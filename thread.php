
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

    <style>
        #ques{
            min-height: 433px;
        }
    </style>

    <title>NSUT discussion forum</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = '$id' ";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        //query the user table to find out the name of original poster
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }

    ?>

<?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //insert  into comment db
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', current_timestamp(), '$sno')";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="bg-dark text-light p-3 rounded-lg m-3 ms-5 me-5">
            <h1 class="display-6"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?>  </p>
            <p>Posted by: <em><?php echo $posted_by; ?></em></p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'
    <div class="container">
        <h2 class="mt-5 ms-5">Post a comment </h2>
        <form action="' . $_SERVER["REQUEST_URI"] .'" method="post">
            
            <div class="form-group mb-3 ms-5 me-5">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value=" '. $_SESSION["sno"] .' " >
            </div>
            <button type="submit" class="btn btn-info ms-5 mb-5">post comment</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container">
        <h2 class="mt-5 ms-5">Start a discussion</h2>
        <p class="lead ms-5">Please login to start a discussion</p>
    </div>';
    }
    ?>




    <div class="container" id="ques">
       <p class="display-6  text-center">Discussion</p>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];
        $thread_user_id = $row['comment_by'];
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
    

    echo'
        <div class="d-flex my-3 ms-5">
            <div class="flex-shrink-0">
                <img src="images/user.png" width = "54px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3 mb-3">
             <p class="my-0"><strong>comment by: '. $row2['user_email'] .' at ' . $comment_time . ' </strong></p>
                
                '. $content . '
            </div>
        </div>';
    }

    // echo var_dump($noResult);
    if($noResult){
        echo '<div class="jumbotron jumbotron-fluid bg-dark text-light p-3 ms-5 me-5">
        <div class="container">
          <p class="display-6">No results found</p>
          <p class="lead">Be the first person to ask a question.</p>
        </div>
      </div>';
    }

        ?>
    </div>
    

       
     
    <?php include 'partials/_footer.php'; ?>
    


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>