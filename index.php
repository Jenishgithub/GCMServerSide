<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
       <title>Android Push Notification With Image Example</title>
        <link href='style.css' rel='stylesheet' type='text/css'>
          <script type="text/javascript">
            function validate()
            {
                if (document.myForm.title.value == "")
                {
                    alert("Please provide title!");
                    document.myForm.title.focus();
                    return false;
                }
                if (document.myForm.message.value == "")
                {
                    alert("Please provide message!");
                    document.myForm.message.focus();
                    return false;
                }

                if (document.myForm.image.value == "")
                {
                    alert("Please provide image url path!");
                    document.myForm.image.focus();
                    return false;
                }
                return(true);
            }

        </script>
    </head>
    <body>

        <?php
        $server = "localhost";
        $database = "push_demo";
        $username = "root";
        $password = "";
        error_reporting('E_ALL ^ E_NOTICE');
        if (isset($_POST['submit'])) {
            $mysqlConnection = mysql_connect($server, $username, $password);
            if (!$mysqlConnection) {
                echo "Please try later.";
            } else {
                mysql_select_db($database, $mysqlConnection);
            }
            $title = $_POST['title'];
            $message = $_POST['message'];
            $image = $_POST['image'];
            $q = mysql_query("SELECT * FROM user");
            $registrationIds = array();
            while ($row = mysql_fetch_array($q)) { //Creates a loop to loop through results 
                $registrationIds[] = $row['registration_id'];
            }
            $outputvalue = "Push Notification Sent";
            define('API_ACCESS_KEY', 'AIzaSyDJFCKY3jUlwa6RZD3MMFOM6hvShhd9Qy4');
            $msg = array('message' => $message,
                'title' => $title,
                'image_url' => $image
            );

            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $msg
            );

            $headers = array(
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        ?>
        <div class="login-page" >
            <h1 text-color:"#ffffff">
                <center>Android Push Notification with Image</center>
            </h1>

            <div class="form">
                <form class="login-form" action="#" method="post" name="myForm" onsubmit="return(validate());" >
                    <input type="text" placeholder="Title" name="title" id="title"/>
                    <input type="text" placeholder="Message" name="message" id="message"/>
                    <input type="text" placeholder="Image URL Path" name="image" id="image"/>
                    <input type="submit" name="submit" id="submit" value="Submit">
                    <div id="outputvalue"> <?php print_r($outputvalue); ?> </div>
                </form>
            </div>
        </div>
        <?php
        // put your code here
        ?>


    </body>
</html>
