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

        if ($_GET['id']) {

            $id = mysqli_real_escape_string($conn, $_GET['id']);

            $query = "SELECT * FROM `Formulare` WHERE id_formular='$id' LIMIT 1";
            $r = mysqli_query($conn, $query);

            $result = mysqli_fetch_assoc($r);

            if (!$result) {
                die('Nu am gasit formularul solicitat');
            }

            $formular = $result;

            $name = $formular['nume'];
            $id_formular = $formular['id_formular'];
            $description = $formular['description'];
            $domain = $formular['domeniu'];
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
                            <INPUT TYPE = "TEXT" VALUE placeholder ="Cheie" NAME ="id_formular">
                        </td>
                    <tr>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Description:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">

                            <INPUT TYPE = "TEXT" VALUE placeholder ="Descriptie" NAME ="descriere">

                        </td>
                    <tr>
                    <tr>
                        <td width="75" height="35" align="left" valign="center">
                            <p>Form Domain:</p>
                        </td>	
                        <td width="355" height="35" align="left" valign="center">

                            <INPUT TYPE = "TEXT" VALUE placeholder ="Domeniu" NAME ="domeniu">

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
            <?php
            if ($formular['html']) {
                echo $formular['html'];
            } else {
                ?>
                <!--Nu scrieti nimic aici-->
                <form action="" method="POST">
                    <!--Nu scrieti nimic aici-->
                </form>
                <!--Nu scrieti nimic aici-->
            <?php } ?>
        </div>
        <br>
        <input type="submit" name='Adauga' onclick='submitForm()' />
        <br>

        <?php include 'footer.php'; ?>

        <script>

            function inputTypeListener() {
                var option = document.getElementById('input_type').value;
                if (option == 1 || option == 2) {
                    document.getElementById('choice_option').style.display = 'block';
                } else {
                    document.getElementById('choice_option').style.display = 'none';
                }
            }

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
                        addTextInput(inputLabel);
                        break;
                    case '1':
                        var optionLabel = document.getElementById('choice_option').value;
                        addSingleChoice(inputLabel, optionLabel);
                        break;
                    case '2':
                        var optionLabel = document.getElementById('choice_option').value;
                        addMultipleChoice(inputLabel, optionLabel);
                        break;
                    default:
                        alert('Invalid option for input type. You provided ' + option);
                }
            });

            function addBreak(container) {
                container.appendChild(document.createElement("br"));
            }

            function addSpace(container) {
                container.appendChild(document.createTextNode(" "));
            }

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
                        document.getElementById("1").innerHTML += xmlhttp.responseText;
                    }
                };

                var formGeneralData = document.getElementById('adaugare_formular_utilizator');

                var url = formGeneralData.action;

                xmlhttp.open("POST", url, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                var data = insinfo(formGeneralData);

                data = data + '&userForm=' + encodeURIComponent(document.getElementById('form_create_container').innerHTML);

                xmlhttp.send(data);

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

        <script>

            //    var textfield = document.getElementById("Text_Field");
            //    var nameTextField = document.getElementById("Form_Name");
            //    var submit = document.getElementById("submit_form6");
            //    submit.onclick = function ()
            //    {
            //        if (window.XMLHttpRequest)
            //        {
            //            // code for IE7+, Firefox, Chrome, Opera, Safari
            //            xmlhttp = new XMLHttpRequest();
            //        }
            //        else
            //        {
            //            // code for IE6, IE5
            //            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            //        }
            //        xmlhttp.onreadystatechange = function ()
            //        {
            //            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            //            {
            //                document.getElementById("0").innerHTML += xmlhttp.responseText;
            //            }
            //        };
            //        xmlhttp.open("GET", "AddText.php?q=" + textfield.value + "~" + nameTextField.value + ".", true);
            //        xmlhttp.send();
            //    };
            //    var textfieldsingle = document.getElementById("Single_Choice");
            //    var nameTextField = document.getElementById("Form_Name");
            //    var submitSingle = document.getElementById("submit_form7");
            //    submitSingle.onclick = function ()
            //    {
            //        if (window.XMLHttpRequest)
            //        {
            //            // code for IE7+, Firefox, Chrome, Opera, Safari
            //            xmlhttp = new XMLHttpRequest();
            //        }
            //        else
            //        {
            //            // code for IE6, IE5
            //            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            //        }
            //        xmlhttp.onreadystatechange = function ()
            //        {
            //            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            //            {
            //                document.getElementById("1").innerHTML += xmlhttp.responseText;
            //            }
            //        };
            //        xmlhttp.open("GET", "AddSingle.php?q=" + textfieldsingle.value + "~" + nameTextField.value + ".", true);
            //        xmlhttp.send();
            //    };
            //
            //    function AddSingle()
            //    {
            //        var f = document.createElement("Single");
            //        var i = document.createElement("input");
            //        var sub = document.createElement("input")
            //        i.type = "text";
            //        i.name = "user_name";
            //        i.id = "user_name1";
            //        sub.type = "Submit";
            //        sub.name = "SubmitSingleOption";
            //        sub.id = "SubmitSingleOption";
            //
            //        f.appendChild(i);
            //        f.appendChild(sub);
            //        document.getElementsByTagName('table')[3].appendChild(f);
            //
            //    }
        </script>

    </body>
</html>