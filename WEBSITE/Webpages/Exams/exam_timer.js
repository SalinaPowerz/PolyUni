window.addEventListener("DOMContentLoaded", () => { 
  
  document.querySelectorAll("input[type='radio']").forEach((radio) => {
    const saved = localStorage.getItem(radio.name);
    if (saved && radio.value === saved) {
      radio.checked = true;
    }
  });

  var TIMER_KEY = "countdown_timer_start";
  var TIMER_DURATION = 1 * 20 * 1000;

  function startOrResumeTimer() {
    var startTime = localStorage.getItem(TIMER_KEY);

    if (!startTime) {
      startTime = Date.now();
      localStorage.setItem(TIMER_KEY, startTime);
    }

    setInterval(function() {
      var elapsed = Date.now() - parseInt(localStorage.getItem(TIMER_KEY));
      var remaining = TIMER_DURATION - elapsed;

      if (remaining <= 0) {
        document.getElementById("timer").textContent = "Time's up!";
        alert("Time's Up! Goodluck!");
        localStorage.removeItem(TIMER_KEY);

        var isPage1 = document.querySelector("input[name='q1']") !== null;
        var isPage2 = document.querySelector("input[name='p1']") !== null;

        if (isPage1) {
          showMyAnswers1();
        } else if (isPage2) {
          showMyAnswers2();
        }

        window.location.href = "/Submit.php";
      } else {
        var minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remaining % (1000 * 60)) / 1000);
        var hours = Math.floor(remaining / (1000 * 60 * 60));

        if (minutes < 10) minutes = "0" + minutes;
        if (seconds < 10) seconds = "0" + seconds;

        document.getElementById("timer").textContent = hours + ":" + minutes + ":" + seconds;
      }
    }, 1000);
  }

  startOrResumeTimer();

  document.querySelectorAll("input[type='radio']").forEach((radio) => {
    radio.addEventListener("change", () => {
      localStorage.setItem(radio.name, radio.value);
    });
  });

});

let firstExamScore = 0;
let secondExamScore = 0;
let finalScore;
let answers = [];
let answers2 = [];

const macroskillsAnswers = [
  "B", "A", "A", "C", "B", "B", "A", "A", "B", "B",
  "B", "D", "B", "B", "B", "B", "D", "B", "B", "A",
  "B", "B", "A", "B", "B", "B", "B", "B", "B", "C",
  "B", "B", "C", "B", "A", "B", "B", "B", "C", "B"
];

const mathAnswers = [
  "A", "C", "B", "B", "C", "C", "D", "C", "A", "A",
  "A", "A", "D", "B", "B", "C", "A", "A", "B", "A",
  "A", "B", "B", "A", "A", "A", "A", "B", "A", "B",
  "A", "B", "A", "B", "A", "B", "A", "B", "B", "A"
];

function showMyAnswers1(){
  firstExamScore = 0;
  answers = [];
  const firstExamCount = 40;
  for (let i = 1; i <= firstExamCount; i++) {
    let questions = document.querySelector("input[type = 'radio'][name = 'q" + i + "']:checked");
    answers.push(questions ? questions.value : null);
  }
  for (let i = 0; i < macroskillsAnswers.length; i++) {
    if (macroskillsAnswers[i] === answers[i]) {
      firstExamScore++;
    }
  }
  localStorage.setItem("firstExamScore", firstExamScore);
}

function showMyAnswers2(){
  secondExamScore = 0;
  answers2 = [];
  const secondExamCount = 40;
  for (let i = 1; i <= secondExamCount; i++) {
    let questions = document.querySelector("input[type = 'radio'][name = 'p" + i + "']:checked");
    answers2.push(questions ? questions.value : null);
  }
  for (let i = 0; i < mathAnswers.length; i++) {
    if (mathAnswers[i] === answers2[i]) {
      secondExamScore++;
    }
  }

  firstExamScore = parseInt(localStorage.getItem("firstExamScore") || "0");
  finalScore = firstExamScore + secondExamScore;
  document.getElementById('exam-score').value = finalScore;

  let examResult;
  if(finalScore < 60){
    examResult = "failed";
    document.getElementById('exam-grades').value = examResult;
  } else {
    examResult = "passed";
    document.getElementById('exam-grades').value = examResult;
  }

  alert("Your exam result has been recorded!" + finalScore + "/80\nfirst " + firstExamScore + " second " + secondExamScore);
}