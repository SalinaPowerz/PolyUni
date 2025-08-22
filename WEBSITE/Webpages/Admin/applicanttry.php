<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="applicantCSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Applicants - Polycium University</title>
</head>
<body> 
    <div class="container">
        <div class="sidebar_filter">
            <div class="sidebar_logo">
                <img src="img/new.png" alt="University Logo" class="logo-img">
                <div class="univ-name">
                    <h2>Polycium University</h2>
                    <h3>Administrator</h3>
                </div>
            </div>
            <ul>
                <li><a href="dashboardtry.php"><i class='fas fa-poll'></i><div class="title">Dashboard</div></a></li>
                <li><a href="coursetry.php"><i class='fas fa-graduation-cap'></i><div class="title">Courses</div></a></li>
                <li><a href="applicanttry.php"><i class='fas fa-users'></i><div class="title">Applicants</div></a></li>
                <li><a href="announcetry.php"><i class='fas fa-bullhorn'></i><div class="title">Announcements</div></a></li>
                <li><a href="logout.php"><i class='fa fa-share-square'></i><div class="title">Logout</div></a></li>
            </ul>
        </div>
        <div class="applicant_main">
            <h1 class="applicant-title">Applicants</h1>
            <div class="filter-btns">
                <a href="?course=BSIT"><button class="filter-btn<?php echo (!isset($_GET['course']) || $_GET['course'] == 'BSIT') ? ' active' : ''; ?>" data-course="BSIT">BSIT</button></a>
                <a href="?course=BSCS"><button class="filter-btn<?php echo (isset($_GET['course']) && $_GET['course'] == 'BSCS') ? ' active' : ''; ?>" data-course="BSCS">BSCS</button></a>
                <a href="?course=BSHM"><button class="filter-btn<?php echo (isset($_GET['course']) && $_GET['course'] == 'BSHM') ? ' active' : ''; ?>" data-course="BSHM">BSHM</button></a>
                <a href="?course=BSEd"><button class="filter-btn<?php echo (isset($_GET['course']) && $_GET['course'] == 'BSEd') ? ' active' : ''; ?>" data-course="BSEd">BSEd</button></a>
                <a href="?course=BMMA"><button class="filter-btn<?php echo (isset($_GET['course']) && $_GET['course'] == 'BMMA') ? ' active' : ''; ?>" data-course="BMMA">BMMA</button></a>
            </div>
            <div class="applicant-table-container">
                <table class="applicant-table">
                    <thead>
                        <tr>
                            <th class="applicant-name-col">Applicant Name</th>
                            <th class="exam-col">Exam</th>
                            <th class="info-col">Information</th>
                            <th class="next-col">Next</th>
                        </tr>
                    </thead>
                    <tbody id="applicants-table-body">
                        <?php
                        require_once 'connect.php';
                        // Map course short name to Course_ID or course string in DB
                        $course_map = [
                            'BSIT' => 'BSIT',
                            'BSCS' => 'BSCS',
                            'BSHM' => 'BSHM',
                            'BSEd' => 'BSEd',
                            'BMMA' => 'BMMA',
                        ];
                        $selected_course = isset($_GET['course']) ? $_GET['course'] : 'BSIT';
                        $course_id = isset($course_map[$selected_course]) ? $course_map[$selected_course] : 'BSIT';
                        $stmt = $conn->prepare("SELECT LastName, FirstName, MiddleName FROM admission_form WHERE Course_ID = ? ORDER BY LastName, FirstName, MiddleName");
                        $stmt->bind_param("s", $course_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $lname = htmlspecialchars($row['LastName']);
                                $fname = htmlspecialchars($row['FirstName']);
                                $mname = htmlspecialchars($row['MiddleName']);
                                $full = strtoupper($lname) . ', ' . strtoupper($fname) . ' ' . strtoupper($mname);
                                echo '<tr>';
                                echo '<td>' . $full . '</td>';
                                echo '<td>-</td>';
                                echo '<td><button class="view-btn">View</button></td>';
                                echo '<td><button class="next-btn">Next</button></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="4" style="text-align:center;color:#aaa;">No applicants found.</td></tr>';
                        }
                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="modal" class="modal"><div class="modal-content"><span class="close-modal">&times;</span><div id="modal-body"></div></div></div>
    </div>
    <script>
    // Modal logic (demo)
    const modal = document.getElementById('modal');
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-btn')) {
            document.getElementById('modal-body').innerHTML = '<h3>Student Information</h3><p>All info here (dynamic)</p>';
            modal.style.display = 'flex';
        }
        if (e.target.classList.contains('close-modal')) {
            modal.style.display = 'none';
        }
        // Add similar logic for requirements and next buttons as needed
    });
    window.onclick = function(event) {
        if (event.target == modal) modal.style.display = 'none';
    }
    </script>
</body>
</html>