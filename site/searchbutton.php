<html>
	<body>
	<FORM> 
			<p> Please insert the name of the form you'd like to fill:</p>
				<INPUT id="Form_To_Search" TYPE = "TEXT" placeholder ="Nume Formular" NAME ="Nume Search" >
				<INPUT id="Form_Button" TYPE ="Button" NAME= "Search" VALUE=" Search">
	</FORM>
	
	
	
	<p > Formulare noastre: </p>
	<td> 
		<input type="button" value="Refresh Page" onClick="window.location.reload()"> Refresh the page:
	</td>
	<div id="target">
		
	</div>
	
	
	<script>
		var button=document.getElementById('Form_Button');
		var nameToSearch=document.getElementById('Form_To_Search');
		button.onclick = function() 
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
 					document.getElementById('target').innerHTML += xmlhttp.responseText;
 				}
 			};
			xmlhttp.open("GET","search.php?numeForm="+nameToSearch.value,true);
         	xmlhttp.send();
 		};
		

	</script>
	</body>
</html>