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

$alert = "";

$result = @mysql_query("SELECT * FROM criminal_records");


while ($row = mysql_fetch_array($result)) {

    $suggestionsArray[] = $row;
}


?>

<html>
<head>

    <title>View/Delete Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        div.gallery {
            margin: 10px;
            border: 3px solid #ccc;
            float: left;
            width: 200px;

            position: relative;
            top: 150px;
            left: 4%;

        }

        .gallery:hover .overlay {
            opacity: 1;
        }

        div.gallery img {
            width: 100%;
            height: 40%;
        }

        div.desc {
            text-align: center;
            background: #f9f9f9;
            border-left: 10px solid #ccc;
            margin: 1.5em 10px;
            padding: 0.5em 10px;
            quotes: "\201C" "\201D" "\2018" "\2019";
        }

        .text {
            color: white;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .5s ease;
            background-color: #008CBA;
        }
    </style>
    <style type="text/css">
        .form-style-7 {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            border-radius: 2px;
            padding: 20px;
            font-family: Georgia, "Times New Roman", Times, serif;
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
    <a href="homepage.php">
        <button class="button button1">Back</button>
    </a>
</div>
<div id="2">
    <a href="signout.php">
        <button class="button button2">Logout</button>
    </a>
</div>

<?php foreach ($suggestionsArray as $row): ?>

    <div class="gallery">
        <a href="edit.php?id=<?php echo $row['id'] ?>">
            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" width="200" height="150"/>'; ?>
            <div class="overlay">
                <div class="text">Click to Edit</div>
            </div>
        </a>
        <div class="desc"><strong><?php echo $row['first_name'];
            echo '&nbsp';
            echo $row['last_name']; ?></strong>
            </br> <b><i><?php echo $row['crime']; ?> </i></b></div>


    </div>
<?php endforeach; ?>


</body>
</html>