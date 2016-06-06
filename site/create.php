<html>
    <head>
        <title>Create a form</title>
        <meta charset="utf-8"/>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="mains.css">



    </head>
    <body>

        <?php
        include 'db.php';
        if (isset($_GET['id_formular'])) 
		{
            $id_formular = $_GET['id_formular'];
            $query = "select * from Formulare where id_formular='$id_formular'";
			$q = oci_parse($conn, $query);
			$r=oci_execute($q);
			$formular=oci_fetch_array($q);
            $name = $formular['1'];
            $id_formular = $formular['0'];
            $description = $formular['2'];
            $domain = $formular['3'];
        }
		else
		{
			$name='';
			$id_formular='0';
			$description='';
			$domain='';
		}
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
        <FORM id='adaugare_formular_utilizator' NAME ="adaugare_formular_utilizator" METHOD ="POST" ACTION = "saveForm.php">
            <table width="800" rows="10" cols="3" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Name:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">
                            <INPUT id="Form_Name" TYPE = "TEXT" placeholder ="Nume" NAME ="nume" VALUE="<?php echo htmlentities($name); ?>">
                        </td>
                    <tr>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Key:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">
                            <INPUT id="id_formular" TYPE = "TEXT" placeholder ="Cheie" NAME ="id_formular" VALUE="<?php echo htmlentities($id_formular); ?>">
                        </td>
                    <tr>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Description:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">
                            <INPUT id="form_desc" TYPE = "TEXT"  placeholder ="Descriptie" NAME ="description" VALUE="<?php echo htmlentities($description); ?>">
                        </td>
                    <tr>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Domain:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">
                            <INPUT id="form_dom" TYPE = "TEXT"  placeholder ="Domeniu" NAME ="domain" VALUE="<?php echo htmlentities($domain); ?>">
                        </td>
                    <tr>

            </table>
        </form>
        <table width="800" rows="10" cols="3" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>Adaugati campuri:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select id="input_type" name='input_type' onchange="inputTypeListener()">
                            <option value="0">Input text</option>
                            <option value="1">Single choice</option>
                            <option value="2">Multiple choice</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" id='input_name' name='input_name' value='' placeholder='Eticheta campului'/>
                    </td>
                    <td>
                        <input style='display:none' type="text" id='choice_option' value='' placeholder='Optiune'/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" id='add_input_btn' name="submit" value="Adauga"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <h5>Aici va fi formularul dumneavoastra:</h5>
        <div id="form_create_container">
                <!--Nu scrieti nimic aici-->
                <form action="" method="POST">
                    <!--Nu scrieti nimic aici--> 
                </form>
                <!--Nu scrieti nimic aici-->
        </div>
		<p id="Test"> </p>
        <br>
        <input type="submit" name='Adauga' onclick='submitForm()' />
        <br>

        <?php include 'footer.php'; ?>

        <script>
		
			//Most variables used
			var TextArray=[];
			var SingleArray=[];
			var MultipleArray=[];
			var i=0;
			var j=0;
			var r=0;
			var textinputcount=0;
			var nameTextField=document.getElementById('id_formular');
			
			
			
			
			//Input type pentru generarea casueti de optiuni
            function inputTypeListener() {
                var option = document.getElementById('input_type').value;
                if (option == 1 || option == 2) {
                    document.getElementById('choice_option').style.display = 'block';
                } else {
                    document.getElementById('choice_option').style.display = 'none';
                }
            }
			
			
			
			//Caseurile pentru generarea + adaugarea campurilor formularului
            document.getElementById("add_input_btn").addEventListener("click", function (e)
            {
                e.preventDefault();
                var option = document.getElementById('input_type').value;
                var inputLabel = document.getElementById('input_name').value;

                if (inputLabel.length == 0) {
                    alert('Trebuie sa introduceti o eticheta!');
                    return false;
                }

                switch (option) {
                    case '0':
                        //text input
						if(textinputcount<5)
						{
							textinputcount++;
							addTextInput(inputLabel);
							AddText(inputLabel);
						}
						else alert('Too many Text fields!');
                        break;
                    case '1':
							var optionLabel = document.getElementById('choice_option').value;
							AddSingle(inputLabel,optionLabel);
							addSingleChoice(inputLabel, optionLabel);
                        break;
                    case '2':
							var optionLabel = document.getElementById('choice_option').value;
							AddMultiple(inputLabel,optionLabel);
							addMultipleChoice(inputLabel, optionLabel);
                        break;
                    default:
                        alert('Invalid option for input type. You provided ' + option);
                }
            });
			
			
			//self explanatory
            function addBreak(container) {
                container.appendChild(document.createElement("br"));
            }
			//self explanatory
            function addSpace(container) {
                container.appendChild(document.createTextNode(" "));
            }
			
			
			
			
			//adaugarea unei casute de text la container
            function addTextInput(inputLabel) {
                var container = document.getElementById('form_create_container').getElementsByTagName('form')[0];

                addBreak(container);
                // Append a node with a random text
                container.appendChild(document.createTextNode(inputLabel));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                input.type = "text";
                input.name = inputLabel + '_' + container.children.length;
                container.appendChild(input);
                // Append a line break 

            }
			
			
			
			//adaugarea unei optiuni la un anumit camp
            function addSingleChoice(inputLabel, optionLabel) {
                var container = document.getElementById('form_create_container').getElementsByTagName('form')[0];

                var inputExists = document.getElementsByClassName(inputLabel)[0];


                var count = 0;
                if (typeof inputExists === 'undefined') {
                    addBreak(container);
                    var span = document.createElement('span');
                    span.setAttribute('class', inputLabel);
                    container.appendChild(span);
                    container = span;
                    container.appendChild(document.createTextNode(inputLabel));
                    addSpace(container);
                } else {
                    container = inputExists;
                    count = inputExists.length;
                }

                container.appendChild(document.createTextNode(optionLabel));

                radioInput = document.createElement('input');
                radioInput.setAttribute('type', 'radio');
                radioInput.setAttribute('name', inputLabel + '_' + count);

                container.appendChild(radioInput);
                addSpace(container);
            }
			
			
			
			//adaugarea unei optiuni pentru un anumit camp ( varianta cat adaugam la un camp de checbox)
            function addMultipleChoice(inputLabel, optionLabel) {
                var container = document.getElementById('form_create_container').getElementsByTagName('form')[0];

                var inputExists = document.getElementsByClassName(inputLabel)[0];

                var count = 0;
                if (typeof inputExists === 'undefined') {
                    addBreak(container);
                    var span = document.createElement('span');
                    span.setAttribute('class', inputLabel);
                    container.appendChild(span);
                    container = span;
                    container.appendChild(document.createTextNode(inputLabel));
                    addSpace(container);
                } else {
                    container = inputExists;
                    count = inputExists.length;
                }

                container.appendChild(document.createTextNode(optionLabel));

                checkboxInput = document.createElement('input');
                checkboxInput.setAttribute('type', 'checkbox');
                checkboxInput.setAttribute('name', inputLabel + '_' + count);

                container.appendChild(checkboxInput);
                addSpace(container);
            }
			
			
			
			//functia de submit ce face requesturi ajax
            function submitForm() {

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
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("form_create_container").innerHTML += xmlhttp.responseText;
                    }
                };

                var formGeneralData = document.getElementById('adaugare_formular_utilizator');

                var url = formGeneralData.action;

                xmlhttp.open("POST", url, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                var data = insinfo(formGeneralData);
				console.log(TextArray);
                data = data + '&TextFields=' + TextArray + '&SingleFields=' + SingleArray + '&MultipleFields=' + MultipleArray;
			
                xmlhttp.send(data);

            }
			function AddText(str)
			{
				TextArray[i]=str;
				i++;
			}
			
			function AddSingle(str1,str2)
			{
				SingleArray[j]=str1;
				j++;
				SingleArray[j]=str2;
				j++;
			}
			
			function AddMultiple(str1,str2)
			{
				MultipleArray[r]=str1;
				r++;
				MultipleArray[r]=str2;
				r++;
			}

            function insinfo(sendForm) {
                var dataArray = [];
                //Getting the data from all elements in the form
                for (var i = 0; i < sendForm.elements.length; i++) {
                    var encodedData = encodeURIComponent(sendForm.elements[i].name);
                    encodedData += "=";
                    encodedData += encodeURIComponent(sendForm.elements[i].value);
                    dataArray.push(encodedData);
                }
                return dataArray.join("&");
            }

        </script>

    </body>
</html>