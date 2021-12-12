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
    #ques {
        min-height: 433px;
    }
    </style>

    <title>NSUT discussion forum</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories2` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category-description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //insert thread into db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your thread has been added.Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <!-- category container starts here -->
    <div class="container my-4">
        <div class="bg-dark text-light p-5 rounded-lg m-3 ms-5 me-5">
            <h1 class="display-5">Welcome to <?php echo $catname;?> forum!</h1>
            <p class="lead"> <?php echo $catdesc;?> </p>
            <hr class="my-4">
            <h5 class="mb-3"><em> "Far and away the best prize that life offers
                    is the chance to work hard at work worth doing." —Theodore Roosevelt</em></h5>
            <a class="btn btn-outline-light" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'
    <div class="container">
        <h2 class="mt-5 ms-5">Start a discussion</h2>
        <form action=" ' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="mb-3 ms-5 me-5">
                <label for="exampleInputEmail1" class="form-label">Problem title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short as possible</div>
            </div>
            <input type="hidden" name="sno" value=" '. $_SESSION["sno"] .' " >
            <div class="form-group mb-3 ms-5 me-5">
                <label for="exampleFormControlTextarea1">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-info ms-5 mb-5">Submit</button>
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
        <h2 class="py-2 ms-5">Browse questions</h2>
        <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['timestamp'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
    

    echo'<div class="d-flex my-3 ms-5">
            <div class="flex-shrink-0">
                <img src="images/user.png" width = "54px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3 mb-3">'.
            '<a class="text-dark text-decoration-none" href="thread.php?threadid= ' . $id . '"> ' . $title . '</a>
                <p> '. $desc . '</p></div>'.'<p class="my-0">Asked by: ' . $row2['user_email'] . ' at ' . $thread_time . ' </p>'.
        '</div>';
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