

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
        <div class="test-container">
            <?php
            for ($i = 1; $i <= 3; $i++) {
                echo '
            <div class="test-box" id="' . $i . '">
                <div class="test-header">
                    <span>Question No. ' . $i . '</span>
                    <div class="timer">
                        <span>Timer</span>
                        <div class="time" id="time' . $i . '">10</div>
                    </div>
                </div>
                <div class="test-item">
                    <div class="question">
                        <span>Q. </span>
                        <p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                            amet.
                        </p>
                    </div>
                    <hr class="appear">
                    <div class="options">
                        <div class="option-item">
                            <input type="radio" name="o" id="optionA' . $i . '" value="A">
                            <label for="option1"><span> A: </span></label>
                            <label for="option1">Lorem ipsum dolor sit amet consectetur</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="o" id="optionB' . $i . '" value="B">
                            <label for="option2"><span> B: </span></label>
                            <label for="option2">Lorem ipsum dolor sit amet consectetur</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="o" id="optionC' . $i . '" value="C">
                            <label for="option3"><span> C: </span></label>
                            <label for="option3">Lorem ipsum dolor sit amet consectetur</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="o" id="optionD' . $i . '" value="D">
                            <label for="option4"><span> D: </span></label>
                            <label for="option4">Lorem ipsum dolor sit </label>
                        </div>
                    </div>
                </div>
                <div class="test-footer">';
                if ($i != 3) {
                    echo '<button class="btn btn-primary next" value="next' . $i . '">Next</button>';
                } else {
                    echo '<button class="btn btn-primary submit">Submit</button>';
                }
                echo '
                </div>
            </div>';
            }
            ?>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>
    <script>

        let d = new Date();
        let totalTime = Math.round(d.getTime() / 1000) + 10;
        let interval;

        document.getElementById("1").style.display = "block";
        timer(1);
        
        function timer(id) {
            console.log(id);
            d = new Date();
            totalTime = Math.round(d.getTime() / 1000) + 10;
            interval = setInterval(function () {
            let n = new Date();
            let time = Math.round(n.getTime() / 1000);
            if ((totalTime - time) < 0) {
                clearInterval(interval);
                alert("Time up");
            }else
                document.getElementById("time" + id).innerText = (totalTime - time);
        }, 1000);
        }

        

        document.querySelectorAll(".next").forEach((e) => {
            e.addEventListener("click", () => {
                let nextId = parseInt(e.parentNode.parentNode.id) + 1;
                if (document.getElementById(nextId) != null) {
                    e.parentNode.parentNode.style.display = "none";
                    setTimeout(()=>{
                    document.getElementById(nextId).style.display = "block";
                    clearInterval(interval);
                    timer(nextId)},1000);
                }
            })
        })
    </script>
</body>

</html>