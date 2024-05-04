<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result - Exam Title</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        position: relative;
        overflow: hidden;
    }

    body::before {
        content: "";
        background: url(images/result_background.jpeg);
        position: absolute;
        height: 100vh;
        width: 100%;
        top: 0;
        left: 0;
        z-index: -1;
        opacity: 1;
        background-repeat: no-repeat;
        background-position: center 0vh;
        filter: brightness(50%);
    }

    .container {
        border: 2px solid lightblue;
        width: 100%;

    }

    .profile {
        //border: 2px solid brown;
        width: 500px;
        padding: 30px;
        margin-left: auto;
        margin-right: auto;
        height: fit-content;
        margin-top: 110px;
        background-color: white;
        border-radius: 45px;
    }

    .profile-image {
        border: 2px solid lightblue;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        background: url(images/profile.png);
        background-size: cover;
    }

    h2 {
        width: fit-content;
        margin: 15px auto;
        margin-bottom: 50px;
        font-size: 25px;
    }

    span {
        display: block;
        margin: 10px 0;

    }

    .details {
        margin: 20px 0;
        font-size: 20px;
    }
    .score{
        display: inline;
        font-weight: bold;
        font-size: larger;
    }
</style>

<body>
    <div class="container">
        <div class="profile">
            <div class="profile-image">
            </div>
            <h2>hunmely hansepi</h2>
            <div class="details">
                <span>Name: Hunmely Hansepi</span>
                <span>Exam title: CNS</span>
                <span>Score: <span class="score">10</span> out of <span class="score">15</span></span>

            </div>
            <p>Note: Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam quasi temporibus possimus, rerum
                laudantium eveniet!</p>

        </div>
    </div>
</body>

</html>