<html>
<head>
    <title>Anonymous Feedback</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="mainh.css">
</head>

<body>
   <?php include 'header.php';
		echo  "    Here are the latest forms. Are you interested in anything?";
		$conn=oci_connect("system","wowmaster252","localhost/orcl");
		If (!$conn)
			echo 'Failed to connect to Oracle';
		else
			echo 'Succesfully connected with Oracle DB';
 
	oci_close($conn);
?>

    <div class="gallery">
      <figure class="gallery-item">
        <img class="thumbnail" src="https://angular.io/resources/images/devguide/forms/hero-form-1.png">
      </figure>
      <figure class="gallery-item">
        <img class="thumbnail" src="https://s3.amazonaws.com/codecademy-content/projects/make-a-website/lesson-3/moss2.jpg">
      </figure>
      <figure class="gallery-item">
        <img class="thumbnail" src="https://s3.amazonaws.com/codecademy-content/projects/make-a-website/lesson-3/moss3.jpg">
      </figure>
      <figure class="gallery-item">
        <img class="thumbnail" src="https://s3.amazonaws.com/codecademy-content/projects/make-a-website/lesson-3/moss4.jpg">
      </figure>
      <figure class="gallery-item">
        <img class="thumbnail" src="https://s3.amazonaws.com/codecademy-content/projects/make-a-website/lesson-3/moss5.jpg">
      </figure>
      <figure class="gallery-item">
        <img class="thumbnail" src="https://s3.amazonaws.com/codecademy-content/projects/make-a-website/lesson-3/moss6.jpg">
      </figure>
    </div>

	<nav>
      <ul>
       <li><a href="home.php"><b>Home</b></a></li>
        <li><a href="create.php">Create new form</a></li>
        <li><a href="search.php">Search</a></li>
      </ul>
      <div class="contact-btn"><a href="contact.php">Contact</a>
      </div>
    </nav>
<br></br>
  
  <?php include 'footer.php'; ?>

  </body>
</html>