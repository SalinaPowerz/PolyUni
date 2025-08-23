<!DOCTYPE html>
<head> 
    <link rel="stylesheet" href="admintryCSS.css">
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
        <div class="dashboard_main">
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <?php
            require_once 'connect.php';
            // Get total applicants
            $result = $conn->query("SELECT COUNT(*) AS total FROM admission_form");
            $total_applicants = ($result && $row = $result->fetch_assoc()) ? (int)$row['total'] : 0;
            // Get accepted applicants
            $result2 = $conn->query("SELECT COUNT(*) AS accepted FROM accepted_applicants");
            $accepted_applicants = ($result2 && $row2 = $result2->fetch_assoc()) ? (int)$row2['accepted'] : 0;
            // Pending = total - accepted
            $pending_applicants = $total_applicants - $accepted_applicants;
            ?>
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <span class="card-icon"><i class="fas fa-users"></i></span>
                    <span class="card-title">Total Applicants</span>
                    <span class="card-value"><?php echo $total_applicants; ?></span>
                </div>
                <div class="dashboard-card">
                    <span class="card-icon"><i class="fas fa-user-check"></i></span>
                    <span class="card-title">Accepted Applicants</span>
                    <span class="card-value"><?php echo $accepted_applicants; ?></span>
                </div>
                <div class="dashboard-card">
                    <span class="card-icon"><i class="fas fa-user-clock"></i></span>
                    <span class="card-title">Pending Applicants</span>
                    <span class="card-value"><?php echo $pending_applicants; ?></span>
                </div>
            </div>
            <!-- Total Applicants by Course Table -->
            <div class="dashboard-section">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <h2 style="margin:0;">Total Applicants by Course</h2>
                    <a href="MODULES/dataexport.php" target="_blank" class="export-btn" title="Export All Applicants Data" style="background:#4a73f8;color:#fff;border:none;border-radius:8px;padding:8px 18px;font-size:1em;font-family:'Trebuchet MS', Arial, sans-serif;font-weight:600;cursor:pointer;box-shadow:0 2px 8px rgba(74,115,248,0.08);transition:background 0.2s,transform 0.2s;display:flex;align-items:center;gap:8px;text-decoration:none;position:relative;">
                        <i class="fas fa-file-export" style="font-size:1.2em;"></i>
                        <span>Export</span>
                    </a>
                </div>
                <table class="dashboard-table" style="font-family:'Trebuchet MS', Arial, sans-serif;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Course</th>
                            <th style="text-align:center;">Number of Applicants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $course_info = [
                            'BSIT' => [
                                'name' => 'BS Information Technology',
                                'icon' => '<i class="fas fa-laptop-code" style="color:#4a73f8;font-size:1.5em;margin-right:12px;"></i>'
                            ],
                            'BSCS' => [
                                'name' => 'BS Computer Science',
                                'icon' => '<i class="fas fa-desktop" style="color:#4a73f8;font-size:1.5em;margin-right:12px;"></i>'
                            ],
                            'BSHM' => [
                                'name' => 'BS Hospitality Management',
                                'icon' => '<i class="fas fa-hotel" style="color:#4a73f8;font-size:1.5em;margin-right:12px;"></i>'
                            ],
                            'BSEd' => [
                                'name' => 'BS Education',
                                'icon' => '<i class="fas fa-chalkboard-teacher" style="color:#4a73f8;font-size:1.5em;margin-right:12px;"></i>'
                            ],
                            'BMMA' => [
                                'name' => 'BS Multimedia Arts',
                                'icon' => '<i class="fas fa-palette" style="color:#4a73f8;font-size:1.5em;margin-right:12px;"></i>'
                            ],
                        ];
                        foreach ($course_info as $course_id => $info) {
                            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM admission_form WHERE Course_ID = ?");
                            $stmt->bind_param("s", $course_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $count = ($result && $row = $result->fetch_assoc()) ? (int)$row['count'] : 0;
                            echo '<tr style="font-family:Trebuchet MS, Arial, sans-serif;">';
                            echo '<td style="text-align:left;font-weight:600;display:flex;align-items:center;gap:10px;">' . $info['icon'] . htmlspecialchars($info['name']) . '</td>';
                            echo '<td style="text-align:center;font-weight:700;">' . $count . '</td>';
                            echo '</tr>';
                            $stmt->close();
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>