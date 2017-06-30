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
$bool = false;

$var_id = '';
if ($_GET['id']) {
    $bool = true;
    $var_id = $_GET['id'];

} else {
    $bool = false;
}
$alert = "";

$result = @mysql_query("SELECT * FROM criminal_records where id='$var_id'");


while ($row = mysql_fetch_array($result)) {

    $suggestionsArray[] = $row;
}


$id1 = "";

if (isset($_POST['delete'])) {
    echo "came";
    $id1 = $_POST['id'];

    $result2 = @mysql_query("delete from criminal_records where id='$id1'");
    if ($result2) {
        $alert = "Record Deleted Successfully";

//Remove image from gallery
        $app_id = '57e1475f';
        $api_key = 'b9b4294c74eed87784ba272885fbcd49';
        $Kairos = new Kairos($app_id, $api_key);
        $subject_id = $id1;
        $gallery_name = 'criminals';
        $argumentArray = array(
            "subject_id" => $subject_id,
            "gallery_name" => $gallery_name
        );
        $response = $Kairos->removeSubjectFromGallery($argumentArray);

        header("Location: http://localhost/FaceRec/viewremove.php");
        die();


    } else {
        $alert = "Please enter valid ID";
    }

}

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

if (isset($_POST['update'])) {
    if (!$t1 && !$t2 && !$t3 && !$t4 && !$t5 && !$t6 && !$t9) {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $crime = $_POST['crime'];
        $term = $_POST['term'];
        $date = $_POST['date'];
        $gallery = 'criminals';
        // $image=$_POST['image'];
        $result = @mysql_query("UPDATE criminal_records SET first_name='$first_name',last_name='$last_name',age='$age',gender='$gender',crime='$crime',term='$term',date='$date',gallery='$gallery' WHERE id=$id");

        if ($result) {
            $message = "Record Successfully Registered!!";
            header("Location: http://localhost/FaceRec/viewremove.php");
            die();


        } else {
            $message = "Record Registration Unsuccessful";
            echo '<script>
             alert("Sorry");
          </script>';
        }
    } else {
        $message = "Please fill all the details before registering record";
    }
}
?>

<html>
<head>

    <title>View/Delete Records</title>
    <style type="text/css">
        .form-style-7 {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            border-radius: 2px;
            padding: 20px;
            font-family: Georgia, "Times New Roman", Times, serif;
            position: absolute;
            /*transition: .5s ease;*/
            top: 22%;
            left: 33%
        }

        .form-style-7 h1 {
            display: block;
            text-align: center;
            padding: 0;
            margin: 0px 0px 20px 0px;
            color: #5C5C5C;
            font-size: x-large;
        }

        .form-style-7 ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .form-style-7 li {
            display: block;
            padding: 9px;
            border: 1px solid #DDDDDD;
            margin-bottom: 30px;
            border-radius: 3px;
        }

        .form-style-7 li:last-child {
            border: none;
            margin-bottom: 0px;
            text-align: center;
        }

        .form-style-7 li > label {
            display: block;
            float: left;
            margin-top: -19px;
            background: #FFFFFF;
            height: 14px;
            padding: 2px 5px 2px 5px;
            color: #B9B9B9;
            font-size: 14px;
            overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
        }

        .form-style-7 input[type="text"],
        .form-style-7 input[type="date"],
        .form-style-7 input[type="datetime"],
        .form-style-7 input[type="email"],
        .form-style-7 input[type="number"],
        .form-style-7 input[type="search"],
        .form-style-7 input[type="time"],
        .form-style-7 input[type="url"],
        .form-style-7 input[type="password"],
        .form-style-7 textarea,
        .form-style-7 select {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            width: 100%;
            display: block;
            outline: none;
            border: none;
            height: 25px;
            line-height: 25px;
            font-size: 16px;
            padding: 0;
            font-family: Georgia, "Times New Roman", Times, serif;
        }

        .form-style-7 input[type="text"]:focus,
        .form-style-7 input[type="date"]:focus,
        .form-style-7 input[type="datetime"]:focus,
        .form-style-7 input[type="email"]:focus,
        .form-style-7 input[type="number"]:focus,
        .form-style-7 input[type="search"]:focus,
        .form-style-7 input[type="time"]:focus,
        .form-style-7 input[type="url"]:focus,
        .form-style-7 input[type="password"]:focus,
        .form-style-7 textarea:focus,
        .form-style-7 select:focus {
        }

        .form-style-7 li > span {
            background: #F3F3F3;
            display: block;
            padding: 3px;
            margin: 0 -9px -9px -9px;
            text-align: center;
            color: #C0C0C0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        .form-style-7 textarea {
            resize: none;
        }

        .form-style-7 input[type="submit"],
        .form-style-7 input[type="button"] {
            background: #2471FF;
            border: none;
            padding: 10px 20px 10px 20px;
            border-bottom: 3px solid #5994FF;
            border-radius: 3px;
            color: #D2E2FF;
        }

        .form-style-7 input[type="submit"]:hover,
        .form-style-7 input[type="button"]:hover {
            background: #6B9FFF;
            color: #fff;
        }
    </style>
    <style>
        body {
            background-image: url('images/blue.jpg');
            background-size: cover;
            background-repeat: repeat;
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

        #top {
            position: absolute;
            top: 30%;
            width: 40%;
            left: 40%;
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
            top: 12%;
            left: 86%;
        }

        }
        .button2:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);

        }

        .button1 {
            position: absolute;
            transition: .5s ease;
            top: 12%;
            left: 80%;
        }

        }
        .button1:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);

        }

        .img {
            position: absolute;
            transition: .5s ease;
            top: 0%;
            left: 38%;

        }
    </style>


</head>
<body>

<img class="img" src="images/2.png" alt="HTML5 Icon" style="width:350px;height:125px;">
<div id="1">
    <a href="viewremove.php">
        <button class="button button1">Back</button>
    </a>
</div>
<div id="2">
    <a href="homepage.php">
        <button class="button button2">Home</button>
    </a>
</div>
<?php if ($bool) {
    foreach ($suggestionsArray as $row): ?>
        <form class="form-style-7" method="post" action="edit.php" enctype="multipart/form-data">


            <ul>
                <li>
                    <label for="name">Image</label>
                    <?php echo '<img name="image" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" height="200" width="350"/></a>'; ?>
                    <span>Criminal's Face</span>
                </li>
                <li>
                    <label for="name">First Name</label>
                    <input type="text" name="first_name" maxlength="100" value="<?php echo $row['first_name']; ?>"/>

                </li>
                <li>
                    <label for="email">Last Name</label>
                    <input type="text" name="last_name" maxlength="100" value="<?php echo $row['last_name']; ?>"/>

                </li>
                <li>
                    <label for="url">Age</label>
                    <input type="text" name="age" maxlength="100" value="<?php echo $row['age']; ?>"/>
                </li>
                <li>
                    <label for="url">Gender</label>
                    <input type="text" name="gender" maxlength="100" value="<?php echo $row['gender']; ?>"/>

                </li>
                <li>
                    <label for="url">Crime</label>
                    <input type="text" name="crime" maxlength="100" value="<?php echo $row['crime']; ?>"/>

                </li>
                <li>
                    <label for="url">Term</label>
                    <input type="text" name="term" maxlength="100" value="<?php echo $row['term']; ?>"/>

                </li>
                <li>
                    <label for="url">Date</label>
                    <input type="text" name="date" maxlength="100" value="<?php echo $row['date']; ?>"/>

                </li>


                <li>

                    <input type="submit" name="update" value="Update"/>
                    <input type="submit" name="delete" value="Delete"/>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                </li>


            </ul>


        </form>

    <?php endforeach;
} ?>

</body>
</html>