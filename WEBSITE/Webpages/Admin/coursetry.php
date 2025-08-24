<!DOCTYPE html>
<head> 
    <link rel="stylesheet" href="courseCSS.css">
    <link rel="stylesheet" href="applicantCSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title>Admin - Polycium University</title>
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
        <div class="course_main">
            <h1 class="course-title">Courses</h1>
            <div class="course-filter-btns">
                <button class="course-btn" data-course="BSIT">BSIT</button>
                <button class="course-btn" data-course="BSCS">BSCS</button>
                <button class="course-btn" data-course="BSHM">BSHM</button>
                <button class="course-btn" data-course="BSEd">BSEd</button>
                <button class="course-btn" data-course="BMMA">BMMA</button>
            </div>
            <div class="course-table-container">
                <table class="course-table">
                    <thead>
                        <tr>
                            <th>Accepted Applicants</th>
                            <th>Date & Time Accepted</th>
                            <th>Information</th>
                        </tr>
                    </thead>
                    <tbody id="applicants-table-body">
                        <?php
                        require_once 'connect.php';
                        $course_map = [
                            'BSIT' => 'BSIT',
                            'BSCS' => 'BSCS',
                            'BSHM' => 'BSHM',
                            'BSEd' => 'BSEd',
                            'BMMA' => 'BMMA',
                        ];
                        $selected_course = isset($_GET['course']) ? $_GET['course'] : 'BSIT';
                        $course_id = $selected_course; 
                            $stmt = $conn->prepare("SELECT aa.Accept_ID, aa.FullName, aa.Accept_Date, aa.Ad_ID, af.Email, af.BirthDate, af.Sex, af.Religion, af.City, af.Province, af.ReportCard, af.Form137, af.HealthRecords FROM accepted_applicants aa LEFT JOIN admission_form af ON aa.Ad_ID = af.Ad_ID WHERE aa.Course_ID = ? ORDER BY aa.Accept_Date DESC");
                            $stmt->bind_param("s", $course_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $accepted_id = (int)$row['Accept_ID'];
                                    $fullname = htmlspecialchars($row['FullName']);
                                    $date_accepted = htmlspecialchars($row['Accept_Date']);
                                    $adid = (int)$row['Ad_ID'];
                                    $email = htmlspecialchars($row['Email']);
                                    $bdate = htmlspecialchars($row['BirthDate']);
                                    $sex = htmlspecialchars($row['Sex']);
                                    $religion = htmlspecialchars($row['Religion']);
                                    $city = htmlspecialchars($row['City']);
                                    $province = htmlspecialchars($row['Province']);
                                    $report = htmlspecialchars($row['ReportCard']);
                                    $form137 = htmlspecialchars($row['Form137']);
                                    $health = htmlspecialchars($row['HealthRecords']);
                                    echo '<tr>';
                                    echo '<td>' . $fullname . '</td>';
                                    echo '<td>' . $date_accepted . '</td>';
                                    echo '<td><button class="view-btn" data-id="' . $adid . '" data-fullname="' . $fullname . '">View</button>';
                                    // Hidden info for modal, page 1 (info) and page 2 (images)
                                    echo '<div id="appinfo-' . $adid . '" class="applicant-info" style="display:none;">';
                                    echo '<div class="modal-page modal-info-page">';
                                    echo '<div class="modal-info-title">Applicant Information</div>';
                                    echo '<div class="modal-info-content">';
                                    echo '<div><strong>Name:</strong> ' . $fullname . '</div>';
                                    echo '<div><strong>Email:</strong> ' . $email . '</div>';
                                    echo '<div><strong>Birthdate:</strong> ' . $bdate . '</div>';
                                    echo '<div><strong>Sex:</strong> ' . $sex . '</div>';
                                    echo '<div><strong>Religion:</strong> ' . $religion . '</div>';
                                    echo '<div><strong>City:</strong> ' . $city . '</div>';
                                    echo '<div><strong>Province:</strong> ' . $province . '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    // Page 2: images
                                    echo '<div class="modal-page modal-image-page" style="display:none;">';
                                    echo '<div class="modal-info-title">Applicant Documents</div>';
                                    echo '<div class="modal-image-list">';
                                    if ($report) echo '<div class="modal-image-item"><span>Report Card</span><img src="../ADMISSION/' . $report . '" class="modal-img-zoom" alt="Report Card" onerror="this.onerror=null;this.src=\'../ADMISSION/uploads/placeholder.png\';"></div>';
                                    if ($form137) echo '<div class="modal-image-item"><span>Form 137</span><img src="../ADMISSION/' . $form137 . '" class="modal-img-zoom" alt="Form 137" onerror="this.onerror=null;this.src=\'../ADMISSION/uploads/placeholder.png\';"></div>';
                                    if ($health) echo '<div class="modal-image-item"><span>Health Records</span><img src="../ADMISSION/' . $health . '" class="modal-img-zoom" alt="Health Records" onerror="this.onerror=null;this.src=\'../ADMISSION/uploads/placeholder.png\';"></div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3" style="text-align:center;color:#aaa;">No applicants found.</td></tr>';
                            }
                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal for student info (uses applicantCSS.css styles) -->
        <div id="student-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <div id="student-info-content">
                    <!-- Student info will be shown here -->
                </div>
            </div>
        </div>
        <script>
// Course filter button logic: reload page with ?course=...
const courseBtns = document.querySelectorAll('.course-btn');
const urlParams = new URLSearchParams(window.location.search);
const selectedCourse = urlParams.get('course') || 'BSIT';
courseBtns.forEach(btn => {
    if (btn.getAttribute('data-course') === selectedCourse) {
        btn.classList.add('active');
    } else {
        btn.classList.remove('active');
    }
    btn.addEventListener('click', function() {
        window.location.href = window.location.pathname + '?course=' + btn.getAttribute('data-course');
    });
});
// Modal logic for Information button (same look/function as applicanttry.php)
const modal = document.getElementById('student-modal');
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('view-btn')) {
        var adid = e.target.getAttribute('data-id');
        var infoDiv = document.getElementById('appinfo-' + adid);
        if (infoDiv) {
            document.getElementById('student-info-content').innerHTML = infoDiv.innerHTML +
              '<div class="modal-nav"><button class="modal-next-btn">Next &raquo;</button></div>';
            window.currentPage = 1;
            showModalPage(window.currentPage);
        } else {
            document.getElementById('student-info-content').innerHTML = '<h3>Applicant Information</h3><p>No info found.</p>';
        }
        modal.style.display = 'flex';
    }
    if (e.target.classList.contains('close-modal')) {
        modal.style.display = 'none';
    }
    if (e.target.classList.contains('modal-next-btn')) {
        window.currentPage = 2;
        showModalPage(window.currentPage);
    }
    if (e.target.classList.contains('modal-prev-btn')) {
        window.currentPage = 1;
        showModalPage(window.currentPage);
    }
    // Image zoom
    if (e.target.classList.contains('modal-img-zoom')) {
        showImageZoom(e.target.src, e.target.alt);
    }
    if (e.target.id === 'zoom-overlay') {
        document.getElementById('zoom-overlay').remove();
    }
});
window.onclick = function(event) {
    if (event.target == modal) modal.style.display = 'none';
}
function showModalPage(page) {
    var modalBody = document.getElementById('student-info-content');
    var infoPage = modalBody.querySelector('.modal-info-page');
    var imgPage = modalBody.querySelector('.modal-image-page');
    var navDiv = modalBody.querySelector('.modal-nav');
    if (page === 1) {
        infoPage.style.display = '';
        imgPage.style.display = 'none';
        navDiv.innerHTML = '<button class="modal-next-btn">Next &raquo;</button>';
    } else {
        infoPage.style.display = 'none';
        imgPage.style.display = '';
        navDiv.innerHTML = '<button class="modal-prev-btn">&laquo; Back</button>';
    }
}
function showImageZoom(src, alt) {
    var overlay = document.createElement('div');
    overlay.id = 'zoom-overlay';
    overlay.style.position = 'fixed';
    overlay.style.left = 0;
    overlay.style.top = 0;
    overlay.style.width = '100vw';
    overlay.style.height = '100vh';
    overlay.style.background = 'rgba(0,0,0,0.8)';
    overlay.style.display = 'flex';
    overlay.style.alignItems = 'center';
    overlay.style.justifyContent = 'center';
    overlay.style.zIndex = 10000;
    overlay.innerHTML = '<img src="' + src + '" alt="' + alt + '" style="max-width:90vw;max-height:90vh;border-radius:12px;box-shadow:0 4px 32px #000;">';
    document.body.appendChild(overlay);
}
        </script>
    </div>
</body>
</html>