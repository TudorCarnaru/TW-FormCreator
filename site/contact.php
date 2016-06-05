<html>
<head>
    <title>Contact us</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
	<header>
		<h1 class="page-title">Contact Us</h1>
		<nav>
      <ul>
        <li><a href="home.php"><b>Home</b></a></li>
        <li><a href="create.php">Create new form</a></li>
        <li><a href="search.php">Search</a></li>
      </ul>
	</nav><br>

		<img src="http://www.toxicalgaenews.com/wp-content/uploads/2014/04/form_icon_25603.png" style="width:80px;height120px;">
    	</header>
  	<form action="myform.php" method="post">
		<p>Your Name: <input type="text" name="yourname" /><br />
		Your E-mail: <input type="text" name="email" /></p>

		<p>Do you like this website?
		<input type="radio" name="likeit" value="Yes" checked="checked" /> Yes
		<input type="radio" name="likeit" value="No" /> No
		<input type="radio" name="likeit" value="Not sure" /> Not sure</p>

		<p>Your comments:<br />
		<textarea name="comments" rows="10" cols="40"></textarea></p>

		<p><input type="submit" value="Send it!"></p>
	</form>



  <?php include 'footer.php'; ?>

  </body>
</html>