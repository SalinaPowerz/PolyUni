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
                        $stmt = $conn->prepare("SELECT Ad_ID, LastName, FirstName, MiddleName, Email, BirthDate, Sex, Religion, City, Province, ReportCard, Form137, HealthRecords FROM admission_form WHERE Course_ID = ? AND Ad_ID NOT IN (SELECT Ad_ID FROM accepted_applicants) ORDER BY LastName, FirstName, MiddleName");
                        $stmt->bind_param("s", $course_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $adid = (int)$row['Ad_ID'];
                                $lname = htmlspecialchars($row['LastName']);
                                $fname = htmlspecialchars($row['FirstName']);
                                $mname = htmlspecialchars($row['MiddleName']);
                                $full = strtoupper($lname) . ', ' . strtoupper($fname) . ' ' . strtoupper($mname);
                                $email = htmlspecialchars($row['Email']);
                                $bdate = htmlspecialchars($row['BirthDate']);
                                $sex = htmlspecialchars($row['Sex']);
                                $religion = htmlspecialchars($row['Religion']);
                                $city = htmlspecialchars($row['City']);
                                $province = htmlspecialchars($row['Province']);
                                $report = htmlspecialchars($row['ReportCard']);
                                $form137 = htmlspecialchars($row['Form137']);
                                $health = htmlspecialchars($row['HealthRecords']);
                                // Exam status logic
                                $exam_status = '';
                                $exam_icon = '';
                                $is_passed = false;
                                if ($fname === 'GREF') {
                                    $exam_status = 'PASSED';
                                    $exam_icon = '<i class="fa fa-check-circle req-complete"></i>';
                                    $is_passed = true;
                                } elseif ($fname === 'AYESA') {
                                    $exam_status = 'PASSED';
                                    $exam_icon = '<i class="fa fa-check-circle req-complete"></i>';
                                    $is_passed = true;
                                } elseif ($fname === 'GEERO') {
                                    $exam_status = 'PASSED';
                                    $exam_icon = '<i class="fa fa-check-circle req-complete"></i>';
                                    $is_passed = true;
                                } else {
                                    $exam_status = '-';
                                    $exam_icon = '';
                                }
                                echo '<tr id="row-' . $adid . '">';
                                echo '<td>' . $full . '</td>';
                                echo '<td>' . $exam_icon . ' ' . $exam_status . '</td>';
                                echo '<td><button class="view-btn" data-id="' . $adid . '">View</button>';
                                // Hidden info for modal, page 1 (info) and page 2 (images)
                                echo '<div id="appinfo-' . $adid . '" class="applicant-info" style="display:none;">';
                                echo '<div class="modal-page modal-info-page">';
                                echo '<div class="modal-info-title">Applicant Information</div>';
                                echo '<div class="modal-info-content">';
                                echo '<div><strong>Name:</strong> ' . $full . '</div>';
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
                                // Next button logic
                                $next_btn_class = $is_passed ? 'next-btn active-next-btn' : 'next-btn inactive';
                                $next_btn_disabled = $is_passed ? '' : 'disabled';
                                echo '<td><button class="' . $next_btn_class . '" data-id="' . $adid . '" data-fullname="' . $full . '" ' . $next_btn_disabled . '><i class="fa fa-arrow-circle-right"></i></button></td>';
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
    // Modal logic with two pages and image zoom
    const modal = document.getElementById('modal');
    let currentPage = 1;
    let totalPages = 2;
    let navBtns = null;
    // Accept modal logic
    let acceptModal = null;
    let acceptAdId = null;
    let acceptFullName = '';
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-btn')) {  
            var adid = e.target.getAttribute('data-id');
            var infoDiv = document.getElementById('appinfo-' + adid);
            if (infoDiv) {
                document.getElementById('modal-body').innerHTML = infoDiv.innerHTML +
                  '<div class="modal-nav"><button class="modal-next-btn">Next &raquo;</button></div>';
                currentPage = 1;
                showModalPage(currentPage);
            } else {
                document.getElementById('modal-body').innerHTML = '<h3>Applicant Information</h3><p>No info found.</p>';
            }
            modal.style.display = 'flex';
        }
        if (e.target.classList.contains('close-modal')) {
            modal.style.display = 'none';
        }
        if (e.target.classList.contains('modal-next-btn')) {
            currentPage = 2;
            showModalPage(currentPage);
        }
        if (e.target.classList.contains('modal-prev-btn')) {
            currentPage = 1;
            showModalPage(currentPage);
        }
        // Image zoom
        if (e.target.classList.contains('modal-img-zoom')) {
            showImageZoom(e.target.src, e.target.alt);
        }
        if (e.target.id === 'zoom-overlay') {
            document.getElementById('zoom-overlay').remove();
        }
        if (e.target.classList.contains('next-btn') && !e.target.classList.contains('inactive')) {
            acceptAdId = e.target.getAttribute('data-id');
            acceptFullName = e.target.getAttribute('data-fullname');
            showAcceptModal(acceptAdId, acceptFullName);
        }
    });
    window.onclick = function(event) {
        if (event.target == modal) modal.style.display = 'none';
    }
    function showModalPage(page) {
        var modalBody = document.getElementById('modal-body');
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
    function showAcceptModal(adid, fullname) {
        // Remove previous modal if exists
        if (document.getElementById('accept-modal')) {
            document.getElementById('accept-modal').remove();
        }
        acceptModal = document.createElement('div');
        acceptModal.id = 'accept-modal';
        acceptModal.style.position = 'fixed';
        acceptModal.style.left = 0;
        acceptModal.style.top = 0;
        acceptModal.style.width = '100vw';
        acceptModal.style.height = '100vh';
        acceptModal.style.background = 'rgba(35,41,70,0.18)';
        acceptModal.style.display = 'flex';
        acceptModal.style.alignItems = 'center';
        acceptModal.style.justifyContent = 'center';
        acceptModal.style.zIndex = 10001;
        acceptModal.innerHTML = `
            <div style="background:#fff;padding:32px 28px;border-radius:16px;box-shadow:0 8px 32px rgba(74,115,248,0.18);max-width:400px;width:90vw;min-width:340px;">
                <div style="font-size:1.3em;font-weight:700;margin-bottom:18px;">Accept applicant (${fullname})?</div>
                <div style="display:flex;gap:18px;justify-content:center;">
                    <button id="accept-btn" style="background:#4a73f8;color:#fff;border:none;border-radius:8px;padding:8px 22px;font-size:1em;font-weight:600;cursor:pointer;">Accept</button>
                    <button id="cancel-btn" style="background:#bdbdbd;color:#fff;border:none;border-radius:8px;padding:8px 22px;font-size:1em;font-weight:600;cursor:pointer;">Cancel</button>
                </div>
            </div>
        `;
        document.body.appendChild(acceptModal);
        document.getElementById('cancel-btn').onclick = function() {
            acceptModal.remove();
        };
        document.getElementById('accept-btn').onclick = function() {
            acceptApplicant(acceptAdId, acceptFullName);
        };
    }
    function acceptApplicant(adid, fullname) {
        // AJAX request to PHP to add to accepted_applicants
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'accept_applicant.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText === 'success') {
                // Remove row from table
                var row = document.getElementById('row-' + adid);
                if (row) row.remove();
                acceptModal.remove();
                alert('Applicant accepted and moved to courses!');
            } else {
                alert('Failed to accept applicant: ' + xhr.responseText);
            }
        };
        xhr.send('adid=' + encodeURIComponent(adid) + '&fullname=' + encodeURIComponent(fullname));
    }
    </script>
</body>
</html>