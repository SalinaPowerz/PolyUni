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