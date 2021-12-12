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

    <title>NSUT discussion forum</title>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>
   


    <!-- search results start here  -->
    <div class="container my-3">
        <h3>Search result for <?php echo $_GET['search']?></h3>
        <?php
        $noResult = true;
        $query = $_GET['search'];
        $sql = "SELECT * FROM threads WHERE match (thread_title , thread_desc) against ('$query')";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
           $title = $row['thread_title'];
           $desc = $row['thread_desc'];
           $thread_id = $row['thread_id'];
           $url = "thread.php?threadid=". $thread_id;
           $noResult = false;

           echo ' <div class="result"> 
           <h5><a href="'. $url .'" class="text-dark">' . $title. '</a></h5>
           <p>' . $desc . '</p>
       </div>';
        }
        if ($noResult){
            echo' <div class="jumbotron jumbotron-fluid bg-light p-3 ms-5 me-5">
            <div class="container">
              <p class="display-6">No results found</p>
              <p class="lead">search for a suitable thread</p>
            </div>
          </div>';
        }
        ?>
    
    </div>
<!-- <div class="result"> 
        <a href="/categories" class="text-dark">' . $title. '</a>
        <p>' . $desc . '</p>
    </div> -->
       


       
        


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