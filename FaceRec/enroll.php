<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location:index.php");
}

include("Kairos.php");
$con = mysql_connect('localhost', 'root', 'admin');
mysql_select_db("criminal_db", $con);
$ses = $_SESSION['uname'];
$result = mysql_query("SELECT * FROM admins where username='$ses'");
$row = mysql_fetch_array($result);
$name = $row['first_name'];

$response = "";
$id = "";
$first_name = "";
$last_name = "";
$age = "";
$gender = "";
$crime = "";
$term = "";
$date = "";
$gallery = "";
$image = "";
$message = "";
$t1 = empty($_POST['first_name']);
$t2 = empty($_POST['age']);
$t3 = empty($_POST['gender']);
$t4 = empty($_POST['crime']);
$t5 = empty($_POST['term']);
$t6 = empty($_POST['date']);

/*$t8=empty(file_get_contents($_FILES['image']['tmp_name']));*/
$t9 = empty($_POST['last_name']);
if (isset($_POST['submit'])) {
    if (!$t1 && !$t2 && !$t3 && !$t4 && !$t5 && !$t6 && !$t9) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $crime = $_POST['crime'];
        $term = $_POST['term'];
        $date = $_POST['date'];
        $gallery = 'criminals';
        /*$image=$_POST['image'];*/
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $result = @mysql_query("INSERT INTO criminal_records(first_name,last_name,age,gender,crime,term,date,gallery,image) VALUES ('$first_name','$last_name','$age','$gender','$crime','$term','$date','$gallery','$image')");
        if ($result) {
            $message = "Record Successfully Registered!!";


            $result1 = @mysql_query("select * from criminal_records where id = (select max(id) from criminal_records)");
            if ($result1 == false) {
                echo "There is an error";
            }
            while ($row = mysql_fetch_array($result1)) {
                $id = $row['id'];
            }
            $app_id = '57e1475f';
            $api_key = 'b9b4294c74eed87784ba272885fbcd49';
            $Kairos = new Kairos($app_id, $api_key);
// Enroll an image
            $data = file_get_contents($_FILES['image']['tmp_name']);
            $image1 = base64_encode($data);
            $subject_id = $id;
            $gallery_id = 'criminals';
            $argumentArray = array(
                "image" => $image1,
                "subject_id" => $subject_id,
                "gallery_name" => $gallery_id
            );
            $response = $Kairos->enroll($argumentArray);
        } else {

            $message = "Record Registration Successful";


        }
    } else {
        $message = "Please fill all the details before registering record";
    }
}

if (isset($_POST['submit2'])) {
    $app_id = '57e1475f';
    $api_key = 'b9b4294c74eed87784ba272885fbcd49';
    $Kairos = new Kairos($app_id, $api_key);
    $response = $Kairos->viewGalleries();
    echo "$response";
}

if (isset($_POST['submit3'])) {
    $app_id = '57e1475f';
    $api_key = 'b9b4294c74eed87784ba272885fbcd49';
    $Kairos = new Kairos($app_id, $api_key);
    $gallery_name = 'criminals';
    $argumentArray = array(
        "gallery_name" => $gallery_name
    );
    $response = $Kairos->viewSubjectsInGallery($argumentArray);
    echo "$response";
}

if (isset($_POST['submit4'])) {
    $app_id = '57e1475f';
    $api_key = 'b9b4294c74eed87784ba272885fbcd49';
    $Kairos = new Kairos($app_id, $api_key);
    $gallery_name = 'criminals';
    $argumentArray = array(
        "gallery_name" => $gallery_name
    );
    $response = $Kairos->removeGallery($argumentArray);
}

?>

<html>
<head>
    <title>Enroll</title>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>


    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
    <style type="text/css">
        .form-style-10 {
            width: 450px;
            padding: 20px 0px 20px 0px;
            position: absolute;
            /*transition: .5s ease;*/
            top: 25%;
            background: #FFF;
            width: 990px;
            height: 390px;
            left: 160px;
            border-radius: 10px;

        }

        .form-style-10 .inner-wrap {
            padding: 30px;
            background: #F8F8F8;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .form-style-10 h1 {
            background: #2A88AD;
            padding: 20px 30px 15px 30px;
            margin: -30px -30px 30px -30px;
            border-radius: 10px 10px 0 0;
            -webkit-border-radius: 10px 10px 0 0;
            -moz-border-radius: 10px 10px 0 0;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
            font: normal 30px 'Bitter', serif;
            -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            border: 1px solid #257C9E;
        }

        .form-style-10 h1 > span {
            display: block;
            margin-top: 2px;
            font: 13px Arial, Helvetica, sans-serif;
        }

        .form-style-10 label {
            display: block;
            font: 13px Arial, Helvetica, sans-serif;
            color: #888;
            margin-bottom: 15px;
        }

        .form-style-10 input[type="text"],
        .form-style-10 input[type="date"],
        .form-style-10 input[type="datetime"],
        .form-style-10 input[type="email"],
        .form-style-10 input[type="number"],
        .form-style-10 input[type="search"],
        .form-style-10 input[type="time"],
        .form-style-10 input[type="url"],
        .form-style-10 input[type="password"],
        .form-style-10 textarea,
        .form-style-10 select {
            display: block;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border: 2px solid #fff;
            box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
            -moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
            -webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
        }

        .form-style-10 .section {
            font: normal 20px 'Bitter', serif;
            color: #2A88AD;
            margin-bottom: 5px;
        }

        .form-style-10 .section span {
            background: #2A88AD;
            padding: 5px 10px 5px 10px;
            position: absolute;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border: 4px solid #fff;
            font-size: 14px;
            margin-left: -45px;
            color: #fff;
            margin-top: -3px;
        }

        .form-style-10 input[type="button"],
        .form-style-10 input[type="submit"] {
            background: #2A88AD;
            padding: 8px 20px 8px 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
            font: normal 30px 'Bitter', serif;
            -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
            border: 1px solid #257C9E;
            font-size: 15px;
        }

        .form-style-10 input[type="button"]:hover,
        .form-style-10 input[type="submit"]:hover {
            background: #2A6881;
            -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
            -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
            box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
        }
    </style>

    <style>
        #a {
            position: absolute;
            transition: .5s ease;
            top: 50%;
            left: 78%;
        }

        body {
            background-image: url('images/enrollbg.jpg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .button {
            background-color: #ba3a3a; /* Green */
            border: none;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;

        }

        .button2 {
            position: absolute;
            transition: .5s ease;
            top: 15%;
            left: 86%;
        }

        }
        .button2:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);

        }

        .button1 {
            position: absolute;
            transition: .5s ease;
            top: 15%;
            left: 80%;
        }

        }
        .button1:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);

        }

        #right {
            position: absolute;
            top: 3%;
            height: 50%;
            width: 10%;
            left: 70%;
        }

        #bright {
            position: absolute;
            top: 18%;
            height: 50%;
            width: 10%;
            left: 80%;
        }

        #center {
            position: absolute;
            top: 25%;
            height: 50%;
            width: 40%;
            left: 30%;

    </style>
</head>
<body>
<h2><?php echo $message; ?></h2>
<div id="1">
    <a href="homepage.php">
        <button class="button button1">Back</button>
    </a>
</div>
<div id="2">
    <a href="signout.php">
        <button class="button button2">Logout</button>
    </a>
</div>

<div class="form-style-10">


    <form method="post" action="enroll.php" enctype="multipart/form-data">

        <div id="1" class="section" style="position: absolute;left: 100px;"><span>1</span>Inmate Information
            <div class="inner-wrap">
                <label>First Name <input type="text" name="first_name" required/></label>
                <label>Last Name <input type="text" name="last_name" required/></label>
                <label>Age <input type="text" name="age" required/></label>

                <label>Gender <select name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select></label>
            </div>
        </div>

        <div id="2" class="section" style="position: absolute;left: 400px;"><span>2</span>Crime
            <div class="inner-wrap">
                <label>Crime <input type="text" name="crime" required/></label>
                <label>Term/Punishment <input type="text" name="term" required/></label>
                <label>Term Start Date<input type="date" name="date" required/></label>
            </div>
        </div>
        <div id="3" class="section" style="position: absolute;left: 700px;"><span>3</span>Image
            <div class="inner-wrap" style="width: 200px;height: 272px;">
                <label>Upload Image:<input type="file" class="image" name="image" required onchange="readURL(this);"></label>
                <img id="blah" src="#" alt="your image"/>
            </div>
        </div>
        <div class="button-section" style="position: absolute; left: 1000px;">
            <input type="submit" name="submit" value="Upload" style="
    position: absolute;
    top: 310px;
    right: 440px;
"/><br>

        </div>

    </form>

</div>


</body>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</html>