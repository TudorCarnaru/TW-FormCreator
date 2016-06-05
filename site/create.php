<html>
<head>
    <title>Create a form</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="mains.css">
 
 
 
 </head>
 <body>

	<?php
	
		
			
			$conn = oci_connect("system","wowmaster252","localhost/orcl");
			
			$name=array_key_exists('nume',$_POST)? $_POST['nume']:"random1";
			$id_formular=array_key_exists('id_formular',$_POST)? $_POST['id_formular']:"0";
			$description=array_key_exists('descriere',$_POST)? $_POST['descriere']:"random1";
			$domain=array_key_exists('domeniu',$_POST)? $_POST['domeniu']:"random1";
			$query = "select count(nume) from Formulare where nume='$name'";
			$q = oci_parse($conn, $query);
			$r=oci_execute($q);
			$re=oci_fetch_array($q);
			$valoare=$re[0];
			if($valoare>0) echo " Introduceti alt nume";
			//else $query="update table Formulare set nume='$name' where nume='$name'";
			$query = "select count(id_formular) from Formulare where id_formular='$id_formular'";
			$q = oci_parse($conn, $query);
			$r=oci_execute($q);
			$re=oci_fetch_array($q);
			$valoare=$re[0];
			if($valoare>0) echo " Introduceti alt id";
			//else $query="update table Formulare set nume='$name' where nume='$name'";
			
			
			
			
			
	?>
    <header>
      <h1 class="page-title">Anonymous Feedback Tool - Add</h1>
	<nav>
      <ul>
       <li><a href="home.php"><b>Home</b></a></li>
        <li><a href="create.php">Create new form</a></li>
        <li><a href="search.php">Search</a></li>
	</ul>
      <div class="contact-btn"><a href="contact.php">Contact</a>
      </div>
	</nav>
	<h3 class="title"> Create your own form </h3>
    </header>
	<table width="800" rows="10" cols="3" cellspacing="0" border="0">
	<tbody>
	<tr>
		<td width="75" height="35" align="left" valign="center">
	<p>Form Name:</p>
		</td>	
		<td width="355" height="35" align="left" valign="center">
		<FORM NAME ="form1" METHOD ="POST" ACTION = "create.php">

			<INPUT id="Form_Name" TYPE = "TEXT" placeholder ="Nume" NAME ="nume" VALUE="<?php echo htmlentities($name); ?>">
			<INPUT TYPE = "Submit" Name = "Edit" VALUE = "Edit">

		</FORM>
		</td>
	<tr>
	<tr>
		<td width="75" height="35" align="left" valign="center">
	<p>Form Key:</p>
		</td>	
		<td width="355" height="35" align="left" valign="center">
		<FORM NAME ="form2" METHOD ="POST" ACTION = "create.php">

			<INPUT TYPE = "TEXT" VALUE placeholder ="Cheie" NAME ="id_formular">
			<INPUT id="submit" TYPE = "Submit" Name = "Edit" VALUE = "Edit">

		</FORM>
		</td>
	<tr>
	<tr>
		<td width="75" height="35" align="left" valign="center">
	<p>Form Description:</p>
		</td>	
		<td width="355" height="35" align="left" valign="center">
		<FORM NAME ="form3" METHOD ="POST" ACTION = "create.php">

			<INPUT TYPE = "TEXT" VALUE placeholder ="Descriptie" NAME ="descriere">
			<INPUT TYPE = "Submit" Name = "Edit" VALUE = "Edit">

		</FORM>
		</td>
	<tr>
	<tr>
		<td width="75" height="35" align="left" valign="center">
	<p>Form Domain:</p>
		</td>	
		<td width="355" height="35" align="left" valign="center">
		<FORM NAME ="form4" METHOD ="POST" ACTION = "create.php">

			<INPUT TYPE = "TEXT" VALUE placeholder ="Domeniu" NAME ="domeniu">
			<INPUT TYPE = "Submit" Name = "Edit" VALUE = "Edit">

		</FORM>
		</td>
	<tr>

</table>

</li>
</nav>
<table width="800" rows="10" cols="3" cellspacing="0" border="0">
	<tbody>
		<table id="dataTableTextInput" class="form" border="1">
		<tbody>
		<tr>
			<td>
		<FORM NAME ="form6" onsubmit="return false;">
			<label>Text Input:</label>
			<INPUT id="Text_Field" TYPE = "TEXT" placeholder ="Nume Field" NAME ="Text_Field" />
			<INPUT id="submit_form6" TYPE = "Submit" Name = "Edit" VALUE = "Add"  />

		</FORM>
		<p id="0"> </p>
			</td>
		</tr>
		</tbody>
		</table>
		<table id="dataTableSingleChoice" name=" TableSingleChoice" class="form" border="1">
		<tbody>
		<tr>
		<td>
			<FORM NAME ="form7" onsubmit="return false;">
			<label>Single Choice Input:</label>
			<INPUT id="Single_Choice" TYPE = "TEXT" placeholder ="Nume Field" NAME ="Single_Choice" />
			<INPUT id="submit_form7" TYPE = "Submit" Name = "Edit" VALUE = "Add"  />

		</FORM>
		<p id="1"> </p>
		</td>
		</tr>
		</tbody>
		</table>
		<table id="dataTableMultipleChoice" class="form" border="1">
		<tbody>
		<tr>
		<td>
			<input type="radio" name="Input" value="2"> Multiple options
			<input type="button" value="Add option" onclick="addRow('dataTableMultipleChoice')">
		<td>
		<tr>
		<tbody>
		</table>
		
		<p id="2"> </p>


	
</table>
<br>
<button onclick=goTo()> Submit </button>
<br>

 <?php include 'footer.php'; ?>

  <script>
function goTo()
{
	window.location="home.php";
}
		var textfield = document.getElementById("Text_Field");
		var nameTextField=document.getElementById("Form_Name");
		var submit = document.getElementById("submit_form6");
		submit.onclick = function() 
		{
			if (window.XMLHttpRequest) 
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} 
			else 
			{
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{	
					document.getElementById("0").innerHTML += xmlhttp.responseText;
				}
			};
        xmlhttp.open("GET","AddText.php?q="+textfield.value+"~"+nameTextField.value+".",true);
        xmlhttp.send();
		};
		var textfieldsingle = document.getElementById("Single_Choice");
		var nameTextField=document.getElementById("Form_Name");
		var submitSingle = document.getElementById("submit_form7");
		submitSingle.onclick = function() 
		{
			if (window.XMLHttpRequest) 
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} 
			else 
			{
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{	
					document.getElementById("1").innerHTML += xmlhttp.responseText;
				}
			};
        xmlhttp.open("GET","AddSingle.php?q="+textfieldsingle.value+"~"+nameTextField.value+".",true);
        xmlhttp.send();
		};
		
function AddSingle()
{
	var f = document.createElement("Single");
	var i = document.createElement("input");
	var sub = document.createElement("input")  
	i.type = "text";
	i.name = "user_name";
	i.id = "user_name1";
	sub.type= "Submit";
	sub.name= "SubmitSingleOption";
	sub.id="SubmitSingleOption";
	
	f.appendChild(i);
	f.appendChild(sub);
	document.getElementsByTagName('table')[3].appendChild(f); 

}
</script>

  </body>
</html>