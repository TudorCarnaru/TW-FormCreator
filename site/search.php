<html>
<head>
    <title>Search forms</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="mains.css">
    
    <script>
function popitup()
{
	var person= prompt("Please insert the key","Key");
	if(person!=null)
	{
		window.location="create.php";
	}
}
function goTo()
{
	window.location="popup.php";
}
function goToStatistics()
{
	window.location="statistics.php";
}
</script>
</head>

<body>
    <header>
      <h1 class="page-title">Anonymous Feedback Tool - Search</h1>
	<nav>
      <ul>
        <li><a href="home.php"><b>Home</b></a></li>
        <li><a href="create.php">Create new form</a></li>
        <li><a href="search.php">Search</a></li>
	</ul>
      <div class="contact-btn"><a href="contact.php">Contact</a>
      </div>
	</nav>
    </header>
	<form>
 		Search for a form:<b></b><br><input type="text" placeholder="Form name goes here" name="form name"></br>
	</form>
    <section class="container">
        Form1<li><button onclick=goTo()>Fill</button> /<button onclick="popitup()">Edit</button>/ <button onclick=goToStatistics()>Statistics</button><br></br>
        Form2<li><button onclick=goTo()>Fill</button> /<button onclick="popitup()">Edit</button>/ <button onclick=goToStatistics()>Statistics</button> <br></br>
        Form3<li><button onclick=goTo()>Fill</button> /<button onclick="popitup()">Edit</button>/ <button onclick=goToStatistics()>Statistics</button><br></br>
      </section>


</li>
</nav>

 <?php include 'footer.php'; ?>

  </body>
</html>