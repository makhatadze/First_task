(function () {


    var quesCounter = 0;
    var selectOptions = [];
    var quizSpace = $('#quiz');

    nextQuestion();
    console.log(data);

    $('#next').click(function () {
        console.log(quesCounter);

        chooseOption();
        if (isNaN(selectOptions[quesCounter])) {
            alert('Please select answer !');
        } else {
            $.ajax({
                type: "POST",
                url: 'save',
                data: {
                    selected: selectOptions[quesCounter],
                    quesCounter: quesCounter,
                    quizId: data[0].quiz_id,
                    questionId: data[quesCounter].id,
                },
                error: function (result) {
                    console.log(result)
                }
            });
            quesCounter++;
            nextQuestion();
        }
    });

    $('#prev').click(function () {

        chooseOption();
        quesCounter--;
        nextQuestion();
        console.log(quesCounter);
    });

    function createElement(index) {
        var element = $('<div>', {id: 'question'});
        var question = $('<h1>').append(data[index].name);
        element.append(question);

        var radio = radioButtons(index);
        element.append(radio);

        return element;
    }

    function radioButtons(index) {
        var radioItems = $('<ul id="ulia">');
        var item;
        var input = '';
        for (var i = 0; i < data[index].answers.length; i++) {
            if (data[index].logAnswers[0]) {
                if (parseInt(data[index].logAnswers[0].answer_id) === parseInt(data[index].answers[i].id)) {
                    item = $('<label id="lia">');
                    input = '<input type="radio" id="answer" name="answer" checked="checked" value=' + data[index].answers[i].id + ' />';
                    input += data[index].answers[i].name;
                    item.append(input);
                    radioItems.append(item);
                }else {
                    item = $('<label id="lia">');
                    input = '<input type="radio" id="answer" name="answer" value=' + data[index].answers[i].id + ' />';
                    input += data[index].answers[i].name;
                    item.append(input);
                    radioItems.append(item);
                }
            }else {
                item = $('<label id="lia">');
                input = '<input type="radio" id="answer" name="answer" value=' + data[index].answers[i].id + ' />';
                input += data[index].answers[i].name;
                item.append(input);
                radioItems.append(item);
            }

        }
        return radioItems;
    }

    function chooseOption() {
        selectOptions[quesCounter] = +$('input[name="answer"]:checked').val();
    }

    function nextQuestion() {
        quizSpace.fadeOut(function () {
            $('#question').remove();
            if (quesCounter < data.length) {
                var nextQuestion = createElement(quesCounter);
                quizSpace.append(nextQuestion).fadeIn();
                if (!(isNaN(selectOptions[quesCounter]))) {
                    $('input[value=' + selectOptions[quesCounter] + ']').prop('checked', true);
                }
                if (quesCounter === 1) {
                    $('#prev').show();
                } else if (quesCounter === data.length-1) {
                    var buttonText = "Finish Test";
                    document.getElementById("next").innerHTML = buttonText;
                } else if (quesCounter === 0) {
                    $('#prev').hide();
                    $('#next').show();
                }
            } else {

                var scoreRslt = displayResult();
                $.ajax({
                    type: "POST",
                    url: 'result',
                    data: {
                        correctAnswer: scoreResult(),
                        questionCount: data.length,
                        quizID: data[0].quiz_id
                    },
                    success: function (result) {
                        console.log(result)
                    }
                });
                setTimeout(function(){
                    window.location.replace("../result/index");
                }, 2500);

                quizSpace.append(scoreRslt).fadeIn();
                $('#next').hide();
                $('#prev').hide();
            }
        });
    }
    function displayResult() {
        var score = $('<h1>', {id: 'question'});
        var correct = 0;
        for (var i = 0; i < data.length; i++) {
            for (var j = 0; j < data[i].answers.length; j++) {
                if (parseInt(data[i].answers[j].id) === selectOptions[i]) {
                    correct += parseInt(data[i].answers[j].is_correct);
                }
            }
        }
        score.append('You scored ' + correct + ' out of ' + data.length);
        return score;
    }
    function scoreResult() {
        var correct = 0;
        for (var i = 0; i < data.length; i++) {
            for (var j = 0; j < data[i].answers.length; j++) {
                if (parseInt(data[i].answers[j].id) === selectOptions[i]) {
                    correct += parseInt(data[i].answers[j].is_correct);
                }
            }
        }
        return correct;
    }
})();