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
                <button class="filter-btn active" data-course="BSIT">BSIT</button>
                <button class="filter-btn" data-course="BSCS">BSCS</button>
                <button class="filter-btn" data-course="BSHM">BSHM</button>
                <button class="filter-btn" data-course="BSEd">BSEd</button>
                <button class="filter-btn" data-course="BMMA">BMMA</button>
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
                        <!-- Dynamic rows here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="modal" class="modal"><div class="modal-content"><span class="close-modal">&times;</span><div id="modal-body"></div></div></div>
    </div>
    <script>
    // Sample data for demonstration
    const applicants = [
    { name: 'Alice Cruz', course: 'BSIT', exam: 'Passed', info: 'All info here', id: 1 },
    { name: 'Brian Lee', course: 'BSCS', exam: 'Pending', info: 'All info here', id: 2 },
    { name: 'Carla Dela Cruz', course: 'BSHM', exam: 'Failed', info: 'All info here', id: 3 }
    ];
    function renderTable(course) {
        const tbody = document.getElementById('applicants-table-body');
        tbody.innerHTML = '';
        applicants.filter(a => a.course === course).forEach(applicant => {
            tbody.innerHTML += `
                <tr>
                    <td>${applicant.name}</td>
                    <td>${applicant.exam}</td>
                    <td>
                        <button class='view-btn' data-id='${applicant.id}'>View</button>
                    </td>
                    <td>
                        <button class='next-btn' data-id='${applicant.id}'>Next</button>
                    </td>
                </tr>
            `;
        });
    }
    // Filter logic
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            renderTable(this.getAttribute('data-course'));
        });
    });
    renderTable('BSIT');
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