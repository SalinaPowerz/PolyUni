 window.addEventListener("DOMContentLoaded", () => { 
  document.querySelectorAll("input[type='radio']").forEach((radio) => {
  const saved = localStorage.getItem(radio.name);
  if (saved && radio.value === saved) {
    radio.checked = true;
  }
  });
  var TIMER_KEY = "countdown_timer_start";
  var TIMER_DURATION = 120 * 60 * 1000;

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
        window.location.href = "../ExamStart/ExamStart.html";
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
  window.onload = startOrResumeTimer;

  document.querySelectorAll("input[type='radio']").forEach((radio) => {
    radio.addEventListener("change", () => {
      localStorage.setItem(radio.name, radio.value);
    });
  });
  function showMyAnswers1(){
    const firstExamCount = 40;
    let answers = [];
    
    for (let i = 1; i <= firstExamCount; i++) {
    let questions = document.querySelector("input[type = 'radio'][name = 'q" + i + "']:checked");
    answers.push(questions ? questions.value : null);
  }
  //  for (let i = 0; i < firstExamCount; i++) {
  //    alert(answers[i]);
    //}
  }
  
  const nextBtn = document.getElementById('next-btn');
  nextBtn.addEventListener('click', showMyAnswers1);
  
  function showMyAnswers2(){
    const secondExamCount = 40;
    let answers2 = [];
    
    for (let i = 1; i <= secondExamCount; i++) {
    let questions = document.querySelector("input[type = 'radio'][name = 'p" + i + "']:checked");
    answers2.push(questions ? questions.value : null);
    }
    for (let i = 0; i < secondExamCount; i++) {
    alert(answers2[i]);
    }
  }
  
  const submitBtn = document.getElementById('submit-btn');
  submitBtn.addEventListener('click', showMyAnswers2);
});