<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileHolder</title>
    <link rel="icon" href="../../media/favicon-32x32.png"></link>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

        .columnCenterLog {
            font-family: 'Open Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .mainLog {
            border: 1px solid black;
            box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.2);
            background-color: snow;
            width: 300px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .buttonLog {
            margin-right: 10px;
            width: 90px;
            height: 25px;
            border: 1px solid black;
            box-shadow: 0px 0px 10px 2px rgba(0,0,0,0.15);
            background-color: whitesmoke;
        }
        .buttonLog:hover {
            cursor: pointer;
            background-color: ghostwhite;
        }
        .alignLog {
            display: flex;
            flex-direction: row;
        }
    </style>
</head>
<body>
    <div style="margin-top: 15%;">
        <div class="columnCenterLog">
            <main class="mainLog">
                <p>Are you sure you want to log out?</p>
                <div class="alignLog">
                    <a href="logout.php"><button class="buttonLog">Yes</button></a>
                    <a href="../index.php"><button class="buttonLog">No</button></a>
                </div>
            </main>
        </div>
    </div>
</body>
</html>