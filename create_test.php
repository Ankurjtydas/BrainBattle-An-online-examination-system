<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/test_create.css">
    <title>Document</title>
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="container">
        <!-- <form action="" method="post"> -->
            <div class="test-details">
                <div class="body">
                    <div class="detail-item">
                        <label for="examTitle" class="form-label">Exam title</label>
                        <input type="text" class="form-control" id="examTitle" name="examTitle"
                            placeholder="e.g. Mathematics Class-test 1">
                    </div>
                    <div class="detail-item">
                        <label for="examDescription" class="form-label">Description description</label>
                        <textarea class="form-control desc" id="examDescription" name="examDescription"
                            placeholder="e.g. Total marks - 100; Pass marks - 35"></textarea>
                    </div>
                    <div class="detail-item">
                        <label for="noOfQuestions" class="form-label">No. of questions</label>
                        <input type="number" min="1" value="1" class="form-control" id="noOfQuestions"
                            name="noOfQuestions">
                    </div>
                </div>
                <div class="body">
                    <div class="detail-item">
                        <label for="examDate" class="form-label">Set Exam Date</label>
                        <input type="date" class="form-control" id="examDate" name="examDate">
                    </div>
                    <div class="detail-item">
                        <label for="examTime" class="form-label">Set Exam Time</label>
                        <input type="time" class="form-control" id="examTime" name="examTime">
                    </div>
                    <div class="detail-item">
                        <label for="timePerQuestion" class="form-label">Time per question</label>
                        <input type="number" min="10" value="10" class="form-control" id="timePerQuestion"
                            name="timePerQuestion">
                    </div>
                    <button type="submit" onclick="showalert()" class="btn btn-primary">Apply</button>
                </div>
            </div>
        <!-- </form> -->
        <hr>
        <div class="test-questions">
            <h5 class="text-center mt-1">Set Questions</h5>
            <div class="test-item">
                <div class="question">
                    <span>Question no. 1 : </span>
                    <textarea oninput="auto_grow(this)" class="question-field" name="qno1" id="qno1"></textarea>
                </div>
                <div class="options">
                    <div class="option-item">
                        <span>Option A : </span><textarea oninput="auto_grow(this)" class="option-field" type="text"
                            name="option1" id="option1"></textarea>
                    </div>
                    <div class="option-item">
                        <span>Option B : </span><textarea oninput="auto_grow(this)" class="option-field" type="text"
                            name="option2" id="option2"></textarea>
                    </div>
                    <div class="option-item">
                        <span>Option C : </span><textarea oninput="auto_grow(this)" class="option-field" type="text"
                            name="option3" id="option3"></textarea>
                    </div>
                    <div class="option-item">
                        <span>Option D : </span><textarea oninput="auto_grow(this)" class="option-field" type="text"
                            name="option4" id="option4"></textarea>
                    </div>
                    <div class="option-item">
                        <label for="answer">Correct answer :</label>
                        <select id="answer">
                            <option value="A">Option A</option><hr>
                            <option value="B">Option B</option><hr>
                            <option value="C">Option C</option><hr>
                            <option value="D">Option D</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Finish</button>
        </div>
    </div>
    <script>
        let number = document.getElementById("noOfQuestions");
        number.addEventListener("focusout", ()=>{
            console.log(number.value);
            if(number.value < 1 && number.value != ""){
                    number.value = 1;
            }
        })

        let time = document.getElementById("timePerQuestion");
        time.addEventListener("focusout", ()=>{
            console.log(new Date().getTime());
            if(time.value < 10 ){
                    time.value = 10;
            }
        })

        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }
    </script>
    <?php require "partials/_footer.php"; ?>
</body>

</html>