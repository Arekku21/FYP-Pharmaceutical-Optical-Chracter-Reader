<?php

include('db.php');

include('sendEmail.php');

 

if (isset($_POST['submit'])) {

$email = $_POST['email'];

$password = $_POST['password'];

$code = rand();

$sql = "INSERT INTO user (`id`, `password`, `email`, `code`) VALUES (NULL, '$password', '$email', '$code')";

$result = mysqli_query($conn,$sql);

if ($result) {

    echo "Registration successfull. Please verify your email.";

    $sendMl->send($code);

  }

}

 

?>

 

<!DOCTYPE html>

<html lang="en">

<head>

  <title>Bootstrap Example</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  

</head>

<body>

 

<div class="container">

  <h2>Reg form</h2>

  <form action="" method="post">

    <div class="form-group">

      <label for="email">Email:</label>

      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">

    </div>

    <div class="form-group">

      <label for="pwd">Password:</label>

      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">

    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

  </form>

</div>

 

</body>

</html>

