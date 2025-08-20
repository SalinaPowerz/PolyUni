<?php
  include '../Exams/db.php';
  session_start();

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Get current month and year (or specified month if viewing different month)
  $currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
  $currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
  
  // Validate month and year
  if ($currentMonth < 1 || $currentMonth > 12) {
    $currentMonth = date('m');
  }
  if ($currentYear < 2000 || $currentYear > 2100) {
    $currentYear = date('Y');
  }
?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="globals.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Main content area styling */
      body {
        margin: 0;
        overflow-x: hidden;
        font-family: Arial, sans-serif;
      }
      
      .main-content {
        position: relative;
        margin-left: 331px;
        width: 1180px;
        min-height: 800px;
        background-color: #ffffff;
        padding: 20px 30px;
        overflow-y: auto;
        height: calc(100vh - 60px);
      }
      
      /* Announcement styling */
      .announcement-header {
        font-family: "Konkhmer Sleokchher-Regular", Helvetica;
        font-weight: bold;
        color: #000000;
        font-size: 24px;
        text-align: left;
        margin-bottom: 20px;
        padding-top: 10px;
      }
      
      /* Calendar container */
      .calendar-container {
        margin: 20px 0;
        width: 100%;
        max-width: 900px;
      }
      
      /* Calendar header with month and navigation */
      .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
      }
      
      .calendar-title {
        font-size: 22px;
        font-weight: bold;
        color: #32508F;
      }
      
      .month-navigation {
        display: flex;
        gap: 10px;
      }
      
      .month-navigation a {
        color: #32508F;
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #32508F;
        border-radius: 4px;
        font-family: Arial, sans-serif;
      }
      
      .month-navigation a:hover {
        background-color: #32508F;
        color: white;
      }
      
      /* Calendar table styling */
      .calendar {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        table-layout: fixed;
        font-size: 14px;
        font-family: Arial, sans-serif;
      }
      
      .calendar th {
        padding: 10px;
        background-color: #32508F;
        color: white;
        font-weight: normal;
        text-align: center;
      }
      
      .calendar td {
        padding: 8px;
        height: 80px;
        vertical-align: top;
        border: 1px solid #eee;
        text-align: right;
        position: relative;
      }
      
      /* Today's cell highlight */
      .calendar .today {
        background-color: #e6f2ff;
        font-weight: bold;
      }
      
      /* Event styling */
      .calendar .event {
        display: block;
        font-size: 11px;
        margin-top: 3px;
        text-align: left;
        padding: 3px 5px;
        border-radius: 3px;
        word-break: break-word;
        background: #e3f2fd;
        color: #1565c0;
        border-left: 3px solid #1565c0;
      }
      
      /* Empty cell styling */
      .calendar .empty {
        background-color: #fafafa;
      }
      
      /* Day number styling */
      .day-number {
        font-weight: bold;
        margin-bottom: 3px;
      }
      
      /* Sidebar and main structure styles */
      .ADMISSIONGOOD .div {
        background-color: #ffffff;
        width: 1440px;
        height: auto;
        position: relative;
        min-height: 1024px;
      }
      
      .ADMISSIONGOOD .rectangle-3 {
        position: absolute;
        width: 260px;
        height: 100%;
        top: 0;
        left: 1px;
        background-color: #32508fa3;
        z-index: 5;
      }
      
      .highlight::before {
        content: "";
        position: absolute;
        top: -10px;
        left: -20px;
        width: 263px;
        height: 65px;
        background-color: rgba(173, 216, 230, 0.3);
        z-index: -1;
        transition: opacity 0.3s ease;
        opacity: 0;
      }
      
      .highlight:hover::before {
        opacity: 1;
      }
    </style>
  </head>
  <body>
    <div style="width: 100%; height: 60px; background-color: #32508F; display: flex; align-items: center; justify-content: space-between; padding: 0 17px; box-sizing: border-box;" id="Navigation_bar">
      <div style="display: flex; align-items: center;">
        <img src="../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
        <span style="font-size: 30px; color: #FFFFFF;">POLYCIUM UNIVERSITY</span>
      </div>
    </div>

    <div class="ADMISSIONGOOD">
      <div class="div">
        <div class="overlap">
          <img class="element" src="../../Images/Bg2.png" />
          <div class="rectangle"></div>
          <div class="rectangle-3"></div>
          
          <!-- Navigation Links -->
          <a href="../Admission/form.php"><div class="nav"><div class="about highlight">Profile</div></div></a>
          <a href="../Exams/ExamStart/ExamStart.php"><div class="about-wrapper"><div class="about highlight">Exams</div></div></a>
          <a href="Dash.php"><div class="div-wrapper"><div class="about highlight">Dashboard</div></div></a>
          <a href="../LogSign/log in/index.php"><div class="logout-wrapper"><div class="about highlight logout">Logout</div></div></a>
          
          <!-- Main Content Area -->
          <div class="main-content">
            <div class="announcement-header">Announcements</div>
            
            <!-- Calendar Section -->
            <div class="calendar-container">
              <div class="calendar-header">
                <div class="calendar-title">
                  <?php echo date('F Y', strtotime("$currentYear-$currentMonth-01")); ?>
                </div>
                <div class="month-navigation">
                  <?php
                    // Previous month link
                    $prevMonth = $currentMonth - 1;
                    $prevYear = $currentYear;
                    if ($prevMonth < 1) {
                      $prevMonth = 12;
                      $prevYear--;
                    }
                    echo "<a href='?month=$prevMonth&year=$prevYear'>&lt; Prev</a>";
                    
                    // Current month link
                    echo "<a href='?month=".date('m')."&year=".date('Y')."'>Current</a>";
                    
                    // Next month link
                    $nextMonth = $currentMonth + 1;
                    $nextYear = $currentYear;
                    if ($nextMonth > 12) {
                      $nextMonth = 1;
                      $nextYear++;
                    }
                    echo "<a href='?month=$nextMonth&year=$nextYear'>Next &gt;</a>";
                  ?>
                </div>
              </div>
              <div class="calendar">
                <table>
                  <thead>
                    <tr>
                      <th style="width: 14.28%">Sun</th>
                      <th style="width: 14.28%">Mon</th>
                      <th style="width: 14.28%">Tue</th>
                      <th style="width: 14.28%">Wed</th>
                      <th style="width: 14.28%">Thu</th>
                      <th style="width: 14.28%">Fri</th>
                      <th style="width: 14.28%">Sat</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $firstDayOfMonth = date('w', strtotime("$currentYear-$currentMonth-01"));
                      $daysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));
                      $day = 1;

                      // Fetch events from the database for the current month
                      $events = [];
                      $query = "SELECT Event_Date, Event_Title FROM calendar_events 
                                WHERE MONTH(Event_Date) = $currentMonth AND YEAR(Event_Date) = $currentYear";
                      $result = $conn->query($query);
                      if ($result) {
                        while ($row = $result->fetch_assoc()) {
                          $events[$row['Event_Date']] = $row['Event_Title'];
                        }
                      }

                      for ($i = 0; $i < 6; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < 7; $j++) {
                          if ($i === 0 && $j < $firstDayOfMonth) {
                            echo "<td class='empty'></td>";
                          } elseif ($day > $daysInMonth) {
                            echo "<td class='empty'></td>";
                          } else {
                            $date = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                            $isToday = ($day == date('j') && $currentMonth == date('m') && $currentYear == date('Y'));
                            $class = $isToday ? 'today' : '';
                            $event = isset($events[$date]) ? "<span class='event'>{$events[$date]}</span>" : '';
                            echo "<td class='$class'><div class='day-number'>$day</div>$event</td>";
                            $day++;
                          }
                        }
                        echo "</tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.querySelector('.logout').addEventListener('click', function () {
        alert('Logging out...');
        window.location.href = '/login';
      });
    </script>
  </body>
</html>