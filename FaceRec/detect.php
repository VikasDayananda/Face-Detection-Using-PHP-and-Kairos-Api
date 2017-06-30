<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location:index.php");
}

include("Kairos.php");

$con = mysql_connect('localhost', 'root', 'admin');
mysql_select_db("criminal_db", $con);
$ses = $_SESSION['uname'];

$img = "";
$img2 = array();
$bool1 = false;
$bool3 = false;
$img = mysql_query("SELECT image FROM criminal_records;");
$i = 0;

if (isset($_POST['submit'])) {
    $bool1 = true;
    while ($rowimg = mysql_fetch_array($img)) {
        $img2[] = $rowimg;
    }

}


$result = mysql_query("SELECT * FROM admins where username='$ses'");
$row = mysql_fetch_array($result);
$name = $row['first_name'];

$firstname = "";
$lastname = "";
$age = "";
$gender = "";
$crime = "";
$term = "";
$date = "";
$image1 = "";

$message = "";
$response = "";
$result = "";
$result1 = "";

$bool2 = false;


//something wrong
$t1 = empty($_POST['submit']);

// recognize an image
if (isset($_POST['submit'])) {
    if (!$t1) {
        $bool2 = true;
        $app_id = '57e1475f';
        $api_key = 'b9b4294c74eed87784ba272885fbcd49';
        $Kairos = new Kairos($app_id, $api_key);
        $data = file_get_contents($_FILES['image']['tmp_name']);
        $image = base64_encode($data);
        $gallery_name = 'criminals';
        $argumentArray = array(
            "image" => $image,
            "gallery_name" => $gallery_name
        );

        $response = $Kairos->recognize($argumentArray);

        $decodedArray = json_decode($response, true);
        $result = $decodedArray["images"][0]["transaction"]["status"];


        if ($result == "success") {
            $result1 = $decodedArray["images"][0]["transaction"]["subject_id"];

            $result2 = @mysql_query("SELECT * FROM criminal_records where id='$result1'");


            while ($row = mysql_fetch_array($result2)) {

                $firstname = $row['first_name'];
                $lastname = $row['last_name'];
                $age = $row['age'];
                $gender = $row['gender'];
                $crime = $row['crime'];
                $term = $row['term'];
                $date = $row['date'];
                $image1 = $row['image'];


            }


        } else {

            $bool2 = false;
            $bool3 = true;

        }

    }
}

?>

<html>
<head>
    <title>Recognize</title>
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
          rel="stylesheet" type="text/css"/>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/form-7.css">
    <link rel="stylesheet" href="css/form-10.css">

    <style>
        body {
            background-image: url('images/blue.jpg');
            background-size: 100% 100%;
            background-repeat: repeat;
        }

        .initial-hide{
            display: none;
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
        }

        #bcenter {
            position: absolute;
            top: 65%;
            height: 70%;
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

        .title {
            position: absolute;
            transition: .5s ease;
            top: 0%;
            left: 38%;
            z-index: -10;

        }

        .imgshow {
            position: absolute;
            transition: .5s ease;
            top: 25%;
            left: 53%;

        }

        .gif {
            position: absolute;
            transition: .5s ease;
            top: 25%;
            left: 50%;

        }
        .mySlides {
            display: none;
        }

        .scan {

            width: 300px;
            height: 3px;
            background: #00ff00;
            z-index: 5;
            position: relative;
            animation: mymove 0.25s infinite;
        }
        .form-style-7 {
            top: 17%;
            left: 50%;
        }

        @keyframes mymove {
            from {
                top: 0px;
            }
            to {
                top: 280px;
            }
        }

    </style>
</head>
<body>
<img class="title" src="images/1-min.png" alt="HTML5 Icon" style="width:350px;height:125px;">


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
    <h3>Lets Find him!<span></span></h3>
    <form method="post" action="detect.php" enctype="multipart/form-data">
        <div class="section"></div>
        <div class="inner-wrap">
            <table>

                <tr>
                    <td>
                        <label>Upload Image:<input type="file" class="image" name="image"
                                                   onchange="readURL(this);"></label>

                    </td>
                </tr>
                <tr>
                    <td>
                        <img id="blah" src="#" alt="your image"/>
                    </td>
                </tr>
            </table>
        </div>

        <div class="button-section">
            <input type="submit" name="submit" id="scan" value="Detect" onclick="showDiv()"/>

        </div>
    </form>
</div>

<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<div id="showdiv" class="imgshow">

    <?php if ($bool1) {
        foreach ($img2 as $rowimg): ?>
            <?php echo '<img class="mySlides" src="data:image/jpeg;base64,' . base64_encode($rowimg['image']) . '"style="position: absolute;" height="300" width="300"/>'; ?>
        <?php endforeach; ?>
        <p class="scan">
        </p>
    <?php } ?>

</div>


<?php if ($bool2) { ?>
    <div class="initial-hide">
    <div id="result1" class="form-style-7">

        <ul>
            <li>
                <label for="name">Image</label>
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($image1) . '" height="180" width="300"/></a>'; ?>
                <span>Criminal's Face</span>
            </li>
            <li>
                <label for="name">First Name</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $firstname; ?>"/>

            </li>
            <li>
                <label for="email">Last Name</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $lastname; ?>"/>

            </li>
            <li>
                <label for="url">Age</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $age ?>"/>
            </li>
            <li>
                <label for="url">Gender</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $gender ?>"/>

            </li>
            <li>
                <label for="url">Crime</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $crime ?>"/>

            </li>
            <li>
                <label for="url">Term</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $term; ?>"/>

            </li>
            <li>
                <label for="url">Date</label>
                <input type="text" name="name" maxlength="100" value="<?php echo $date; ?>"/>

            </li>

        </ul>
    </div>
    </div>

<?php } ?>


<script>
    $(document).ready(function () {
        $('#result1').hide();
        $('#showdiv').delay(5000).fadeOut();
        $('#result1').delay(6000).fadeIn(100);
        $('#result2').hide();
        $('#result2').delay(6000).fadeIn(100)
        $('div').delay(6000).removeClass('initial-hide');
    });
</script>
<?php if ($bool3) { ?>
    <form method="post" action="enroll.php" enctype="multipart/form-data">
        <div id="result2" class="form-style-7" style="top: 35%; left :53%;">
            <p>Sorry! No Match Found.</p>
            <div class="button-section" style="margin-left:30%;">
                <input type="submit" name="submit" value="Enroll"/>

            </div>
    </form>

    </div>
<?php } ?>


<script>

    var myIndex = 0;
    carousel();
    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {
            myIndex = 1
        }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 250); // Change image every 2 seconds

    }
</script>
</body>
</html>