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
  <div id="page2"></div>
  <div class="navbar" style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box; z-index: 999;">
    <div style="display: flex; align-items: center;">
      <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
      <span style="font-size: 30px; color: #FFFFFF;">POLYCIUM UNIVERSITY</span>
    </div>
  </div>

<div class="container">
  <header>
    <h1>I. Mathematical Assessment </h1>
    <p class="instructions">Instructions: Choose the button of the correct answer.</p>
    <div class="timer" id="timer">Loading...</div>
  </header>

<section class="question">
  <p class="question-text">1. What is the value of 8 + (−5) + 8 + (−5)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p1" value="A" /> A. 3</label></li>
    <li><label><input type="radio" name="p1" value="B" /> B. -3</label></li>
    <li><label><input type="radio" name="p1" value="C" /> C. 13</label></li>
    <li><label><input type="radio" name="p1" value="D" /> D. -13</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">2. Simplify: 12 − 5 + 3 × 2</p>
  <ul class="options">
    <li><label><input type="radio" name="p2" value="A" /> A. 22</label></li>
    <li><label><input type="radio" name="p2" value="B" /> B. 18</label></li>
    <li><label><input type="radio" name="p2" value="C" /> C. 17</label></li>
    <li><label><input type="radio" name="p2" value="D" /> D. 21</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">3. If a person buys 3 items for ₱150, how much would one item cost?</p>
  <ul class="options">
    <li><label><input type="radio" name="p3" value="A" /> A. ₱100</label></li>
    <li><label><input type="radio" name="p3" value="B" /> B. ₱50</label></li>
    <li><label><input type="radio" name="p3" value="C" /> C. ₱75</label></li>
    <li><label><input type="radio" name="p3" value="D" /> D. ₱90</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">4. The sum of two numbers is 45. If one number is 17, what is the other?</p>
  <ul class="options">
    <li><label><input type="radio" name="p4" value="A" /> A. 29</label></li>
    <li><label><input type="radio" name="p4" value="B" /> B. 27</label></li>
    <li><label><input type="radio" name="p4" value="C" /> C. 28</label></li>
    <li><label><input type="radio" name="p4" value="D" /> D. 26</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">5. Solve for x: 3x − 7 = 11</p>
  <ul class="options">
    <li><label><input type="radio" name="p5" value="A" /> A. 5</label></li>
    <li><label><input type="radio" name="p5" value="B" /> B. 6</label></li>
    <li><label><input type="radio" name="p5" value="C" /> C. 7</label></li>
    <li><label><input type="radio" name="p5" value="D" /> D. 8</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">6. Simplify: 2x + 3x − 4x</p>
  <ul class="options">
    <li><label><input type="radio" name="p6" value="A" /> A. x</label></li>
    <li><label><input type="radio" name="p6" value="B" /> B. 5x</label></li>
    <li><label><input type="radio" name="p6" value="C" /> C. −x</label></li>
    <li><label><input type="radio" name="p6" value="D" /> D. 0</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">7. Use the FOIL method to expand: (x + 2)(x − 3)</p>
  <ul class="options">
    <li><label><input type="radio" name="p7" value="A" /> A. x² − 6x + 6</label></li>
    <li><label><input type="radio" name="p7" value="B" /> B. x² − x − 6</label></li>
    <li><label><input type="radio" name="p7" value="C" /> C. x² + 5x − 6</label></li>
    <li><label><input type="radio" name="p7" value="D" /> D. x² − x − 6</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">8. Solve for x: 4x + 3 = 19</p>
  <ul class="options">
    <li><label><input type="radio" name="p8" value="A" /> A. 3</label></li>
    <li><label><input type="radio" name="p8" value="B" /> B. 4</label></li>
    <li><label><input type="radio" name="p8" value="C" /> C. 5</label></li>
    <li><label><input type="radio" name="p8" value="D" /> D. 7</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">9. Simplify the rational expression: (2x² + 4x) / 2x</p>
  <ul class="options">
    <li><label><input type="radio" name="p9" value="A"/> A. x + 2</label></li>
    <li><label><input type="radio" name="p9" value="B" /> B. x² + 2</label></li>
    <li><label><input type="radio" name="p9" value="C" /> C. 2x + 4</label></li>
    <li><label><input type="radio" name="p9" value="D" /> D. x + 4</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">10. Which of the following is a solution to the equation 3x + 4 = 16?</p>
  <ul class="options">
    <li><label><input type="radio" name="p10" value="A" /> A. x = 5</label></li>
    <li><label><input type="radio" name="p10" value="B" /> B. x = 4</label></li>
    <li><label><input type="radio" name="p10" value="C" /> C. x = 6</label></li>
    <li><label><input type="radio" name="p10" value="D" /> D. x = 7</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">11. Solve the inequality: 5x − 7 &lt; 13</p>
  <ul class="options">
    <li><label><input type="radio" name="p11" value="A" /> A. x &lt; 4</label></li>
    <li><label><input type="radio" name="p11" value="B" /> B. x &gt; 4</label></li>
    <li><label><input type="radio" name="p11" value="C" /> C. x &lt; 5</label></li>
    <li><label><input type="radio" name="p11" value="D" /> D. x &gt; 5</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">12. Which of the following is the graph of the equation y = 2x + 3?</p>
  <ul class="options">
    <li><label><input type="radio" name="p12" value="A" /> A. A line with a slope of 2 and y-intercept of 3</label></li>
    <li><label><input type="radio" name="p12" value="B" /> B. A line with a slope of 3 and y-intercept of 2</label></li>
    <li><label><input type="radio" name="p12" value="C" /> C. A parabola</label></li>
    <li><label><input type="radio" name="p12" value="D" /> D. A line with slope -2 and y-intercept of 3</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">13. The point (3, −4) is located in which quadrant?</p>
  <ul class="options">
    <li><label><input type="radio" name="p13" value="A" /> A. Quadrant I</label></li>
    <li><label><input type="radio" name="p13" value="B" /> B. Quadrant II</label></li>
    <li><label><input type="radio" name="p13" value="C" /> C. Quadrant III</label></li>
    <li><label><input type="radio" name="p13" value="D" /> D. Quadrant IV</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">14. What is the slope of the line passing through the points (2, 3) and (4, 7)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p14" value="A" /> A. 1</label></li>
    <li><label><input type="radio" name="p14" value="B" /> B. 2</label></li>
    <li><label><input type="radio" name="p14" value="C" /> C. 4</label></li>
    <li><label><input type="radio" name="p14" value="D" /> D. 3</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">15. What is the result of (−4) + 9?</p>
  <ul class="options">
    <li><label><input type="radio" name="p15" value="A" /> A. -5</label></li>
    <li><label><input type="radio" name="p15" value="B" /> B. 5</label></li>
    <li><label><input type="radio" name="p15" value="C" /> C. -13</label></li>
    <li><label><input type="radio" name="p15" value="D" /> D. 13</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">16. Simplify: (−7) − (−3)</p>
  <ul class="options">
    <li><label><input type="radio" name="p16" value="A" /> A. -4</label></li>
    <li><label><input type="radio" name="p16" value="B" /> B. -10</label></li>
    <li><label><input type="radio" name="p16" value="C" /> C. 4</label></li>
    <li><label><input type="radio" name="p16" value="D" /> D. 10</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">17. What is the product of (−6) × 4?</p>
  <ul class="options">
    <li><label><input type="radio" name="p17" value="A" /> A. -24</label></li>
    <li><label><input type="radio" name="p17" value="B" /> B. 24</label></li>
    <li><label><input type="radio" name="p17" value="C" /> C. 10</label></li>
    <li><label><input type="radio" name="p17" value="D" /> D. 2</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">18. Solve for x: x² − 5x + 6 = 0</p>
  <ul class="options">
    <li><label><input type="radio" name="p18" value="A" /> A. x = 2, 3</label></li>
    <li><label><input type="radio" name="p18" value="B" /> B. x = 1, -6</label></li>
    <li><label><input type="radio" name="p18" value="C" /> C. x = -2, 3</label></li>
    <li><label><input type="radio" name="p18" value="D" /> D. x = -3, -2</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">19. The solution to the equation x² = 25 is:</p>
  <ul class="options">
    <li><label><input type="radio" name="p19" value="A" /> A. x = 5</label></li>
    <li><label><input type="radio" name="p19" value="B" /> B. x = 5, -5</label></li>
    <li><label><input type="radio" name="p19" value="C" /> C. x = 10</label></li>
    <li><label><input type="radio" name="p19" value="D" /> D. x = -10</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">20. Which of the following is the factored form of x² + 7x + 10?</p>
  <ul class="options">
    <li><label><input type="radio" name="p20" value="A" /> A. (x + 2)(x + 5)</label></li>
    <li><label><input type="radio" name="p20" value="B" /> B. (x + 5)(x − 2)</label></li>
    <li><label><input type="radio" name="p20" value="C" /> C. (x − 2)(x + 5)</label></li>
    <li><label><input type="radio" name="p20" value="D" /> D. (x − 5)(x + 2)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">21. Solve x² − 6x = 0</p>
  <ul class="options">
    <li><label><input type="radio" name="p21" value="A" /> A. x = 0, 6</label></li>
    <li><label><input type="radio" name="p21" value="B" /> B. x = 0, -6</label></li>
    <li><label><input type="radio" name="p21" value="C" /> C. x = 6</label></li>
    <li><label><input type="radio" name="p21" value="D" /> D. x = -6</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">22. Simplify: (x² + 3x) + (2x² − x)</p>
  <ul class="options">
    <li><label><input type="radio" name="p22" value="A" /> A. 3x² + 2x</label></li>
    <li><label><input type="radio" name="p22" value="B" /> B. 3x² + 4x</label></li>
    <li><label><input type="radio" name="p22" value="C" /> C. x² + 3x</label></li>
    <li><label><input type="radio" name="p22" value="D" /> D. 2x² + 2x</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">23. Which of the following is a polynomial expression?</p>
  <ul class="options">
    <li><label><input type="radio" name="p23" value="A" /> A. 3/x</label></li>
    <li><label><input type="radio" name="p23" value="B" /> B. x + 2</label></li>
    <li><label><input type="radio" name="p23" value="C" /> C. x⁻² + 3x + 1</label></li>
    <li><label><input type="radio" name="p23" value="D" /> D. 3x² + 2x⁻¹</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">24. What is the degree of the polynomial 4x³ − 5x² + 2x − 7?</p>
  <ul class="options">
    <li><label><input type="radio" name="p24" value="A" /> A. 3</label></li>
    <li><label><input type="radio" name="p24" value="B" /> B. 2</label></li>
    <li><label><input type="radio" name="p24" value="C" /> C. 1</label></li>
    <li><label><input type="radio" name="p24" value="D" /> D. 4</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">25. Simplify: 3/5 + 4/5</p>
  <ul class="options">
    <li><label><input type="radio" name="p25" value="A" /> A. 7/5</label></li>
    <li><label><input type="radio" name="p25" value="B" /> B. 7/10</label></li>
    <li><label><input type="radio" name="p25" value="C" /> C. 5/7</label></li>
    <li><label><input type="radio" name="p25" value="D" /> D. 9/5</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">26. Simplify the rational expression: \(\frac{2x}{4x^2}\)</p>
  <ul class="options">
    <li><label><input type="radio" name="p26" value="A" /> A. \(\frac{1}{2x}\)</label></li>
    <li><label><input type="radio" name="p26" value="B" /> B. \(\frac{1}{2x^2}\)</label></li>
    <li><label><input type="radio" name="p26" value="C" /> C. \(\frac{2}{4x^2}\)</label></li>
    <li><label><input type="radio" name="p26" value="D" /> D. \(\frac{1}{4x}\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">27. Find the value of \(\frac{5}{x}\) when \(x=2\).</p>
  <ul class="options">
    <li><label><input type="radio" name="p27" value="A" /> A. \(\frac{5}{2}\)</label></li>
    <li><label><input type="radio" name="p27" value="B" /> B. 10</label></li>
    <li><label><input type="radio" name="p27" value="C" /> C. \(\frac{10}{2}\)</label></li>
    <li><label><input type="radio" name="p27" value="D" /> D. \(\frac{1}{2}\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">28. The domain of the function \(f(x) = \frac{1}{x - 2}\) is:</p>
  <ul class="options">
    <li><label><input type="radio" name="p28" value="A" /> A. \(x \neq 0\)</label></li>
    <li><label><input type="radio" name="p28" value="B" /> B. \(x \neq 2\)</label></li>
    <li><label><input type="radio" name="p28" value="C" /> C. \(x \neq 1\)</label></li>
    <li><label><input type="radio" name="p28" value="D" /> D. \(x \neq -2\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">29. What is the inverse of the function \(f(x) = 2x + 3\)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p29" value="A" /> A. \(f^{-1}(x) = \frac{x - 3}{2}\)</label></li>
    <li><label><input type="radio" name="p29" value="B" /> B. \(f^{-1}(x) = \frac{3 - x}{2}\)</label></li>
    <li><label><input type="radio" name="p29" value="C" /> C. \(f^{-1}(x) = 2x - 3\)</label></li>
    <li><label><input type="radio" name="p29" value="D" /> D. \(f^{-1}(x) = \frac{x + 3}{2}\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">30. Which of the following is a function?</p>
  <ul class="options">
    <li><label><input type="radio" name="p30" value="A" /> A. \(y = \pm \sqrt{x}\)</label></li>
    <li><label><input type="radio" name="p30" value="B" /> B. \(y = 2x + 1\)</label></li>
    <li><label><input type="radio" name="p30" value="C" /> C. \(x^2 + y^2 = 1\)</label></li>
    <li><label><input type="radio" name="p30" value="D" /> D. \(x + y = 2\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">31. What is the area of a triangle with a base of 10 cm and a height of 6 cm?</p>
  <ul class="options">
    <li><label><input type="radio" name="p31" value="A" /> A. 30 cm²</label></li>
    <li><label><input type="radio" name="p31" value="B" /> B. 15 cm²</label></li>
    <li><label><input type="radio" name="p31" value="C" /> C. 60 cm²</label></li>
    <li><label><input type="radio" name="p31" value="D" /> D. 12 cm²</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">32. The sum of the interior angles of a quadrilateral is:</p>
  <ul class="options">
    <li><label><input type="radio" name="p32" value="A" /> A. 180°</label></li>
    <li><label><input type="radio" name="p32" value="B" /> B. 360°</label></li>
    <li><label><input type="radio" name="p32" value="C" /> C. 270°</label></li>
    <li><label><input type="radio" name="p32" value="D" /> D. 720°</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">33. If two lines are parallel, what is the relationship between their slopes?</p>
  <ul class="options">
    <li><label><input type="radio" name="p33" value="A" /> A. Their slopes are equal</label></li>
    <li><label><input type="radio" name="p33" value="B" /> B. Their slopes are perpendicular</label></li>
    <li><label><input type="radio" name="p33" value="C" /> C. Their slopes add to 90°</label></li>
    <li><label><input type="radio" name="p33" value="D" /> D. Their slopes multiply to 1</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">34. Find the circumference of a circle with a radius of 7 cm. Use \(\pi = 3.14\).</p>
  <ul class="options">
    <li><label><input type="radio" name="p34" value="A" /> A. 22 cm</label></li>
    <li><label><input type="radio" name="p34" value="B" /> B. 44 cm</label></li>
    <li><label><input type="radio" name="p34" value="C" /> C. 14 cm</label></li>
    <li><label><input type="radio" name="p34" value="D" /> D. 21.98 cm</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">35. The area of a rectangle is 48 square meters and the length is 8 meters. What is the width?</p>
  <ul class="options">
    <li><label><input type="radio" name="p35" value="A" /> A. 6 meters</label></li>
    <li><label><input type="radio" name="p35" value="B" /> B. 5 meters</label></li>
    <li><label><input type="radio" name="p35" value="C" /> C. 4 meters</label></li>
    <li><label><input type="radio" name="p35" value="D" /> D. 3 meters</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">36. What is the volume of a cube with a side length of 5 cm?</p>
  <ul class="options">
    <li><label><input type="radio" name="p36" value="A" /> A. 25 cm³</label></li>
    <li><label><input type="radio" name="p36" value="B" /> B. 125 cm³</label></li>
    <li><label><input type="radio" name="p36" value="C" /> C. 100 cm³</label></li>
    <li><label><input type="radio" name="p36" value="D" /> D. 20 cm³</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">37. Using SOHCAHTOA, what is the value of \(\sin(30^\circ)\)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p37" value="A" /> A. \(\frac{1}{2}\)</label></li>
    <li><label><input type="radio" name="p37" value="B" /> B. \(\frac{\sqrt{3}}{2}\)</label></li>
    <li><label><input type="radio" name="p37" value="C" /> C. 1</label></li>
    <li><label><input type="radio" name="p37" value="D" /> D. \(\frac{\sqrt{2}}{2}\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">38. What is the cosine of \(90^\circ\)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p38" value="A" /> A. 1</label></li>
    <li><label><input type="radio" name="p38" value="B" /> B. 0</label></li>
    <li><label><input type="radio" name="p38" value="C" /> C. \(\frac{1}{2}\)</label></li>
    <li><label><input type="radio" name="p38" value="D" /> D. \(2\sqrt{2}\)</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">39. Using SOHCAHTOA, \(\cos(\theta) = \frac{\text{adjacent}}{\text{hypotenuse}}\). What is the cosine of \(45^\circ\)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p39" value="A" /> A. \(\frac{1}{\sqrt{2}}\)</label></li>
    <li><label><input type="radio" name="p39" value="B" /> B. \(\frac{\sqrt{2}}{2}\)</label></li>
    <li><label><input type="radio" name="p39" value="C" /> C. 0</label></li>
    <li><label><input type="radio" name="p39" value="D" /> D. 1</label></li>
  </ul>
</section>

<section class="question">
  <p class="question-text">40. What is the value of \(\tan(45^\circ)\)?</p>
  <ul class="options">
    <li><label><input type="radio" name="p40" value="A" /> A. 1</label></li>
    <li><label><input type="radio" name="p40" value="B" /> B. 0</label></li>
    <li><label><input type="radio" name="p40" value="C" /> C. \(2\sqrt{2}\)</label></li>
    <li><label><input type="radio" name="p40" value="D" /> D. \(\frac{1}{\sqrt{2}}\)</label></li>
  </ul>
</section>
  <form style="text-align: center; margin-top: 50px; margin-left: 500px;" action="submitScore.php" method="POST">
    <a href="../Exam1/Exam1.html">
  <input type="hidden" name="exam_score" id="exam-score">
  <input type="hidden" name="exam_grades" id="exam-grades">
	<button class="back-button">Back</button></a>
	
    <button type="submit" class="next-button" id="submit-btn" onclick="showMyAnswers2()">Submit</button>
  </form>
  
</div>
<script src="../exam_timer.js"></script>

</body>
</html>