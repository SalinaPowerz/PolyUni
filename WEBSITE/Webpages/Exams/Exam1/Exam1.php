<?php
  include '../db.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Exam</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div id="page1"></div>
  <div class="navbar" style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box; z-index: 999;">
    <div style="display: flex; align-items: center;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
      <span style="font-size: 30px; color: #FFFFFF;">POLYCIUM UNIVERSITY</span>
    </div>
  </div>
<div class="container">
  <header>
    <h1>I. Macroskills Assessment</h1>
    <p class="instructions">Instructions: Choose the button of the correct answer.</p>
    <div class="timer" id="timer">Loading...</div>
  </header>


  <section class="question">
    <p class="question-text">1. She _____ the novel before the movie adaptation was released.</p>
    <ul class="options">
      <li><label><input type="radio" name="q1" value="A" /> finishes</label></li>
      <li><label><input type="radio" name="q1" value="B" /> finished</label></li>
      <li><label><input type="radio" name="q1" value="C" /> finishing</label></li>
      <li><label><input type="radio" name="q1" value="D" /> has finish</label></li>
    </ul>
  </section>

  <section class="question">
    <p class="question-text">2. The committee _____ to announce the winner tomorrow.</p>
    <ul class="options">
      <li><label><input type="radio" name="q2" value="A" /> plans</label></li>
      <li><label><input type="radio" name="q2" value="B" /> plan</label></li>
      <li><label><input type="radio" name="q2" value="C" /> planning</label></li>
      <li><label><input type="radio" name="q2" value="D" /> planned</label></li>
    </ul>
  </section>

  <section class="question">
    <p class="question-text">3. If he _____ harder, he would have passed the exam.</p>
    <ul class="options">
      <li><label><input type="radio" name="q3" value="A" /> had studied</label></li>
      <li><label><input type="radio" name="q3" value="B" /> studies</label></li>
      <li><label><input type="radio" name="q3" value="C" /> study</label></li>
      <li><label><input type="radio" name="q3" value="D" /> studied</label></li>
    </ul>
  </section>
  
<section class="question">
  <p class="question-text">4. Choose the sentence that is grammatically correct:</p>
  <ul class="options">
    <li><label><input type="radio" name="q4" value="A" /> She don't like eating vegetables.</label></li>
    <li><label><input type="radio" name="q4" value="B" /> She doesn't likes eating vegetables.</label></li>
    <li><label><input type="radio" name="q4" value="C" /> She doesn't like eating vegetables.</label></li>
    <li><label><input type="radio" name="q4" value="D" /> She don't likes eating vegetables.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">5. Choose the better sentence structure:</p>
  <ul class="options">
    <li><label><input type="radio" name="q5" value="A" /> Running quickly, the finish line was crossed by her.</label></li>
    <li><label><input type="radio" name="q5" value="B" /> She crossed the finish line running quickly.</label></li>
    <li><label><input type="radio" name="q5" value="C" /> Quickly running she crossed the finish line.</label></li>
    <li><label><input type="radio" name="q5" value="D" /> She running quickly crossed the finish line.</label></li>
  </ul>
</section>
<section class="question">
  <p class="question-text">6. Arrange: [a] the museum / [b] we visited / [c] yesterday / [d] interesting exhibits.</p>
  <ul class="options">
    <li><label><input type="radio" name="q6" value="A" /> b, a, d, c</label></li>
    <li><label><input type="radio" name="q6" value="B" /> b, a, c, d</label></li>
    <li><label><input type="radio" name="q6" value="C" /> d, b, a, c</label></li>
    <li><label><input type="radio" name="q6" value="D" /> a, c, b, d</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">7. Arrange: [a] after school / [b] played soccer / [c] the boys / [d] enthusiastically.</p>
  <ul class="options">
    <li><label><input type="radio" name="q7" value="A" /> c, b, d, a</label></li>
    <li><label><input type="radio" name="q7" value="B" /> a, b, c, d</label></li>
    <li><label><input type="radio" name="q7" value="C" /> c, a, b, d</label></li>
    <li><label><input type="radio" name="q7" value="D" /> b, c, d, a</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">8. Book : Read :: Pen : _____.</p>
  <ul class="options">
    <li><label><input type="radio" name="q8" value="A" /> Write</label></li>
    <li><label><input type="radio" name="q8" value="B" /> Paper</label></li>
    <li><label><input type="radio" name="q8" value="C" /> Draw</label></li>
    <li><label><input type="radio" name="q8" value="D" /> Open</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">9. Water : Thirst :: Food : _____.</p>
  <ul class="options">
    <li><label><input type="radio" name="q9" value="A" /> Drink</label></li>
    <li><label><input type="radio" name="q9" value="B" /> Hunger</label></li>
    <li><label><input type="radio" name="q9" value="C" /> Eat</label></li>
    <li><label><input type="radio" name="q9" value="D" /> Spoon</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">10. The prefix "un-" in "unhappy" means:</p>
  <ul class="options">
    <li><label><input type="radio" name="q10" value="A" /> Very</label></li>
    <li><label><input type="radio" name="q10" value="B" /> Opposite of</label></li>
    <li><label><input type="radio" name="q10" value="C" /> Same as</label></li>
    <li><label><input type="radio" name="q10" value="D" /> Related to</label></li>
  </ul>
</section>
<section class="question">
  <p class="question-text">11. The root word "bio" means:</p>
  <ul class="options">
    <li><label><input type="radio" name="q11" value="A" /> Earth</label></li>
    <li><label><input type="radio" name="q11" value="B" /> Life</label></li>
    <li><label><input type="radio" name="q11" value="C" /> Air</label></li>
    <li><label><input type="radio" name="q11" value="D" /> Water</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">12. Choosing the Best Sentence</p>
  <ul class="options">
    <li><label><input type="radio" name="q12" value="A" /> They goes to the market every weekend.</label></li>
    <li><label><input type="radio" name="q12" value="B" /> They going to the market every weekend.</label></li>
    <li><label><input type="radio" name="q12" value="C" /> They went go to the market every weekend.</label></li>
    <li><label><input type="radio" name="q12" value="D" /> They go to the market every weekend.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">13. Choose the best sentence:</p>
  <ul class="options">
    <li><label><input type="radio" name="q13" value="A" /> Me and my friend enjoys singing.</label></li>
    <li><label><input type="radio" name="q13" value="B" /> My friend and I enjoy singing.</label></li>
    <li><label><input type="radio" name="q13" value="C" /> I and my friend enjoying singing.</label></li>
    <li><label><input type="radio" name="q13" value="D" /> My friend and me enjoy singing.</label></li>
  </ul>
</section>
<section class="question">
  <p class="question-text">14. Identify the noun: "The cat chased the mouse under the table."</p>
  <ul class="options">
    <li><label><input type="radio" name="q14" value="A" /> chased</label></li>
    <li><label><input type="radio" name="q14" value="B" /> cat</label></li>
    <li><label><input type="radio" name="q14" value="C" /> under</label></li>
    <li><label><input type="radio" name="q14" value="D" /> the</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">15. Choose the correctly used word:</p>
  <ul class="options">
    <li><label><input type="radio" name="q15" value="A" /> Your going to love this movie.</label></li>
    <li><label><input type="radio" name="q15" value="B" /> You’re going to love this movie.</label></li>
    <li><label><input type="radio" name="q15" value="C" /> Your going love this movie.</label></li>
    <li><label><input type="radio" name="q15" value="D" /> You’re going love this movie.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">16. Where should the comma go? "After dinner we went to the movies."</p>
  <ul class="options">
    <li><label><input type="radio" name="q16" value="A" /> After, dinner we went to the movies.</label></li>
    <li><label><input type="radio" name="q16" value="B" /> After dinner, we went to the movies.</label></li>
    <li><label><input type="radio" name="q16" value="C" /> After dinner we, went to the movies.</label></li>
    <li><label><input type="radio" name="q16" value="D" /> After dinner we went, to the movies.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">17. Choose the sentence with correct capitalization:</p>
  <ul class="options">
    <li><label><input type="radio" name="q17" value="A" /> My uncle will visit paris next summer.</label></li>
    <li><label><input type="radio" name="q17" value="B" /> My Uncle will visit Paris next summer.</label></li>
    <li><label><input type="radio" name="q17" value="C" /> My uncle will Visit Paris next summer.</label></li>
    <li><label><input type="radio" name="q17" value="D" /> My uncle will visit Paris next summer.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">18. Subject-Verb Agreement</p>
  <ul class="options">
    <li><label><input type="radio" name="q18" value="A" /> The team are winning the game.</label></li>
    <li><label><input type="radio" name="q18" value="B" /> The team is winning the game.</label></li>
    <li><label><input type="radio" name="q18" value="C" /> The team win the game.</label></li>
    <li><label><input type="radio" name="q18" value="D" /> The team winning the game.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">19. Choose the properly constructed sentence:</p>
  <ul class="options">
    <li><label><input type="radio" name="q19" value="A" /> Walking through the park, the trees were beautiful.</label></li>
    <li><label><input type="radio" name="q19" value="B" /> Walking through the park, I saw beautiful trees.</label></li>
    <li><label><input type="radio" name="q19" value="C" /> The trees walking through the park were beautiful.</label></li>
    <li><label><input type="radio" name="q19" value="D" /> Beautiful trees walking through the park.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">20. Identify the misplaced modifier: "She almost drove her kids to school every day."</p>
  <ul class="options">
    <li><label><input type="radio" name="q20" value="A" /> almost</label></li>
    <li><label><input type="radio" name="q20" value="B" /> drove</label></li>
    <li><label><input type="radio" name="q20" value="C" /> kids</label></li>
    <li><label><input type="radio" name="q20" value="D" /> every</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">21. Find the error: "He walk to school every day."</p>
  <ul class="options">
    <li><label><input type="radio" name="q21" value="A" /> He</label></li>
    <li><label><input type="radio" name="q21" value="B" /> walk</label></li>
    <li><label><input type="radio" name="q21" value="C" /> school</label></li>
    <li><label><input type="radio" name="q21" value="D" /> every</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">22. Choose the sentence in passive voice:</p>
  <ul class="options">
    <li><label><input type="radio" name="q22" value="A" /> The chef cooked the meal.</label></li>
    <li><label><input type="radio" name="q22" value="B" /> The meal was cooked by the chef.</label></li>
    <li><label><input type="radio" name="q22" value="C" /> The chef was cooking the meal.</label></li>
    <li><label><input type="radio" name="q22" value="D" /> The chef cooks the meal.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">23. Which sentence uses the correct past perfect tense?</p>
  <ul class="options">
    <li><label><input type="radio" name="q23" value="A" /> I had finished my homework before dinner.</label></li>
    <li><label><input type="radio" name="q23" value="B" /> I have finished my homework before dinner.</label></li>
    <li><label><input type="radio" name="q23" value="C" /> I finished my homework before dinner.</label></li>
    <li><label><input type="radio" name="q23" value="D" /> I finish my homework before dinner.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">24. Parallelism</p>
  <ul class="options">
    <li><label><input type="radio" name="q24" value="A" /> She likes to dance, singing, and to swim.</label></li>
    <li><label><input type="radio" name="q24" value="B" /> She likes dancing, singing, and swimming.</label></li>
    <li><label><input type="radio" name="q24" value="C" /> She likes dancing, sing, and to swim.</label></li>
    <li><label><input type="radio" name="q24" value="D" /> She like dancing, singing, and swim.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">25. Fill in the blank: The book is _____ the table.</p>
  <ul class="options">
    <li><label><input type="radio" name="q25" value="A" /> in</label></li>
    <li><label><input type="radio" name="q25" value="B" /> on</label></li>
    <li><label><input type="radio" name="q25" value="C" /> under</label></li>
    <li><label><input type="radio" name="q25" value="D" /> above</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">26. What does "hit the sack" mean?</p>
  <ul class="options">
    <li><label><input type="radio" name="q26" value="A" /> Start a fight</label></li>
    <li><label><input type="radio" name="q26" value="B" /> Go to sleep</label></li>
    <li><label><input type="radio" name="q26" value="C" /> Go to work</label></li>
    <li><label><input type="radio" name="q26" value="D" /> Cook dinner</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">27. Identify the figure of speech: "The world is a stage."</p>
  <ul class="options">
    <li><label><input type="radio" name="q27" value="A" /> Simile</label></li>
    <li><label><input type="radio" name="q27" value="B" /> Metaphor</label></li>
    <li><label><input type="radio" name="q27" value="C" /> Personification</label></li>
    <li><label><input type="radio" name="q27" value="D" /> Hyperbole</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">28. What does "benevolent" most nearly mean?</p>
  <ul class="options">
    <li><label><input type="radio" name="q28" value="A" /> Greedy</label></li>
    <li><label><input type="radio" name="q28" value="B" /> Kind</label></li>
    <li><label><input type="radio" name="q28" value="C" /> Cruel</label></li>
    <li><label><input type="radio" name="q28" value="D" /> Silly</label></li>
  </ul>
</section>


<section class="question">
  <p class="question-text">29. Which is the correct spelling?</p>
  <ul class="options">
    <li><label><input type="radio" name="q29" value="A" /> Accomodate</label></li>
    <li><label><input type="radio" name="q29" value="B" /> Accommodate</label></li>
    <li><label><input type="radio" name="q29" value="C" /> Acommodate</label></li>
    <li><label><input type="radio" name="q29" value="D" /> Acommodatte</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">30. Choose the synonym for "happy":</p>
  <ul class="options">
    <li><label><input type="radio" name="q30" value="A" /> Sad</label></li>
    <li><label><input type="radio" name="q30" value="B" /> Angry</label></li>
    <li><label><input type="radio" name="q30" value="C" /> Joyful</label></li>
    <li><label><input type="radio" name="q30" value="D" /> Quiet</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">31. Choose the antonym for "generous":</p>
  <ul class="options">
    <li><label><input type="radio" name="q31" value="A" /> Kind</label></li>
    <li><label><input type="radio" name="q31" value="B" /> Mean</label></li>
    <li><label><input type="radio" name="q31" value="C" /> Giving</label></li>
    <li><label><input type="radio" name="q31" value="D" /> Wealthy</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">32. Choose the correct word: The dog buried its bone in _____ backyard.</p>
  <ul class="options">
    <li><label><input type="radio" name="q32" value="A" /> it’s</label></li>
    <li><label><input type="radio" name="q32" value="B" /> its</label></li>
    <li><label><input type="radio" name="q32" value="C" /> it is</label></li>
    <li><label><input type="radio" name="q32" value="D" /> it</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">33. Choose the complete sentence:</p>
  <ul class="options">
    <li><label><input type="radio" name="q33" value="A" /> Because he was tired.</label></li>
    <li><label><input type="radio" name="q33" value="B" /> Running down the road.</label></li>
    <li><label><input type="radio" name="q33" value="C" /> She finished the race despite being tired.</label></li>
    <li><label><input type="radio" name="q33" value="D" /> Since he left early.</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">34. Find the error: "Everyone have submitted their papers."</p>
  <ul class="options">
    <li><label><input type="radio" name="q34" value="A" /> Everyone</label></li>
    <li><label><input type="radio" name="q34" value="B" /> have</label></li>
    <li><label><input type="radio" name="q34" value="C" /> submitted</label></li>
    <li><label><input type="radio" name="q34" value="D" /> their</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">35. Sentence Improvement</p>
  <ul class="options">
    <li><label><input type="radio" name="q35" value="A" /> He plays the guitar well, doesn’t he?</label></li>
    <li><label><input type="radio" name="q35" value="B" /> He plays the guitar well, don’t he?</label></li>
    <li><label><input type="radio" name="q35" value="C" /> He playing the guitar well, doesn’t he?</label></li>
    <li><label><input type="radio" name="q35" value="D" /> He play the guitar well, doesn’t he?</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">36. Teacher : School :: Doctor : _____</p>
  <ul class="options">
    <li><label><input type="radio" name="q36" value="A" /> Medicine</label></li>
    <li><label><input type="radio" name="q36" value="B" /> Hospital</label></li>
    <li><label><input type="radio" name="q36" value="C" /> Classroom</label></li>
    <li><label><input type="radio" name="q36" value="D" /> Nurse</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">37. From the sentence: "The arid land had very little vegetation," the word "arid" means:</p>
  <ul class="options">
    <li><label><input type="radio" name="q37" value="A" /> Wet</label></li>
    <li><label><input type="radio" name="q37" value="B" /> Dry</label></li>
    <li><label><input type="radio" name="q37" value="C" /> Cold</label></li>
    <li><label><input type="radio" name="q37" value="D" /> Fertile</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">38. The prefix "pre-" in "preview" means:</p>
  <ul class="options">
    <li><label><input type="radio" name="q38" value="A" /> After</label></li>
    <li><label><input type="radio" name="q38" value="B" /> Before</label></li>
    <li><label><input type="radio" name="q38" value="C" /> During</label></li>
    <li><label><input type="radio" name="q38" value="D" /> Around</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">39. Choosing the Best Sentence</p>
  <ul class="options">
    <li><label><input type="radio" name="q39" value="A"/> The package was deliver yesterday.</label></li>
    <li><label><input type="radio" name="q39" value="B" /> The package is deliver yesterday.</label></li>
    <li><label><input type="radio" name="q39" value="C" /> The package was delivered yesterday.</label></li>
    <li><label><input type="radio" name="q39" value="D" /> The package deliver yesterday.</label></li>
  </ul>
</section>	

<section class="question">
  <p class="question-text">40. "The flowers danced in the breeze" is an example of:</p>
  <ul class="options">
    <li><label><input type="radio" name="q40" value="A" /> Metaphor</label></li>
    <li><label><input type="radio" name="q40" value="B" /> Personification</label></li>
    <li><label><input type="radio" name="q40" value="C" /> Hyperbole</label></li>
    <li><label><input type="radio" name="q40" value="D" /> Simile</label></li>
  </ul>
</section>
  
  <a href="../exam2/exam2.php">
  <div style="text-align: center; margin-top: 50px; margin-left: 600px;">
    <button class="next-button" id="next-btn" onclick="showMyAnswers1()">Next</button>
  </div>
  </a>
</div>
<script src="../exam_timer.js"></script>
</body>
</html>