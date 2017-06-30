<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location:index.php");
} ?>

<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/pure/0.5.0/pure-min.css'>


    <link rel="stylesheet" href="css/button.css">
    <style>
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
            position: absolute;
            transition: .5s ease;
            top: 20%;
            left: 87%;

        }

        .button2:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);

        }

        #a {
            position: absolute;
            transition: .5s ease;
            top: 65%;
            left: 8%;
        }

        #b {
            position: absolute;
            transition: .5s ease;
            top: 65%;
            left: 32%;
        }

        #c {
            position: absolute;
            transition: .5s ease;
            top: 65%;
            left: 56%;
        }

        #d {
            position: absolute;
            transition: .5s ease;
            top: 65%;
            left: 78%;
        }

        body {
            background-image: url('images/bg2.jpg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }


    </style>
</head>
<body>
<div>
    <a href="signout.php">
        <button class="button button2">Logout</button>
    </a>
</div>
<div class="flex-grid-center">
    <div id="a" class="pure-button fuller-button blue" onclick="location.href='enroll.php';">Enroll</div>
    <div id="b" class="pure-button fuller-button blue" onclick="location.href='detect.php';">Detect</div>
    <div id="c" class="pure-button fuller-button blue" onclick="location.href='viewremove.php';">View/Delete</div>
    <div id="d" class="pure-button fuller-button blue" onclick="location.href='textsearch.php';">Name search</div>

</div>
</body>
</html>