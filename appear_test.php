<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <!-- <?php echo $_SESSION["classroom_name"] ?> -->
    </title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/appear_test.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="screen">
        <div class="test-box">
            <div class="test-header text-light">
                <span>Question No. 1</span>
                <div class="timer">15</div>
            </div>
            <div class="test-item">
                <div class="question">
                    <span>Q. </span><p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</p>
                </div>
                <hr>
                <div class="options">
                    <div class="option-item">
                        <input type="radio" name="o" id="option1" value="A">
                        <label for="option1"><span> A: </span></label>
                        <label for="option1">Lorem ipsum dolor sit amet consectetur</label>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="o" id="option2" value="B">
                        <label for="option2"><span> B: </span></label>
                        <label for="option2">Lorem ipsum dolor sit amet consectetur Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio, vero! Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, et distinctio ea veniam exercitationem, voluptatem quod sit beatae quo eius dicta rerum atque animi ratione, amet quaerat labore odio eum!</label>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="o" id="option3" value="C">
                        <label for="option3"><span> C: </span> Lorem ipsum dolor sit amet consectetur</label>
                    </div>
                    <div class="option-item">
                        <input type="radio" name="o" id="option4" value="D">
                        <label for="option4"><span> D: </span> Lorem ipsum dolor sit amet consectetur</label>
                    </div>
                </div>
            </div>
            <div class="test-footer text-light">
                <button class="btn btn-primary">Next</button>
            </div>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>
    <script>
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }
    </script>
</body>

</html>