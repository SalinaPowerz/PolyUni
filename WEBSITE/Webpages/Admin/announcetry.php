<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="announceCSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Announcements - Polycium University</title>
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
        <div class="main-content">
            <h1 class="announce-title">Announcements</h1>
            <div class="event-table-card">
                <h2>Upcoming Events</h2>
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once 'connect.php';
                        // Delete all events that are already past the current date
                        $today = date('Y-m-d');
                        $deleteStmt = $conn->prepare("DELETE FROM calendar_events WHERE Event_Date < ?");
                        $deleteStmt->bind_param("s", $today);
                        $deleteStmt->execute();
                        $deleteStmt->close();

                        $result = $conn->query("SELECT Event_ID, Event_Date, Event_Title, Event_Description FROM calendar_events ORDER BY Event_Date ASC");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $date = date('F j, Y', strtotime($row['Event_Date']));
                                $title = htmlspecialchars($row['Event_Title']);
                                $desc = htmlspecialchars($row['Event_Description']);
                                $id = $row['Event_ID'];
                                echo "<tr class='event-row' data-id='$id' data-date='" . htmlspecialchars($date, ENT_QUOTES) . "' data-title='" . htmlspecialchars($row['Event_Title'], ENT_QUOTES) . "' data-desc='" . htmlspecialchars($row['Event_Description'], ENT_QUOTES) . "'>";
                                echo "<td>$date</td>";
                                echo "<td>$title</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' style='text-align:center;color:#aaa;'>No events found.</td></tr>";
                        }
                        // $conn->close(); // Removed to keep connection open for form submission
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="event-form-card">
                <h2>Add New Event</h2>
                <?php
                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    require_once 'connect.php';
                    $date = $_POST['event_date'];
                    $title = $_POST['event_title'];
                    $desc = $_POST['event_desc'];
                    $stmt = $conn->prepare("INSERT INTO calendar_events (Event_Date, Event_Title, Event_Description) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $date, $title, $desc);
                    if ($stmt->execute()) {
                        echo '<div class="success-msg">Event added successfully!</div>';
                    } else {
                        echo '<div class="error-msg">Failed to add event. Please try again.</div>';
                    }
                    $stmt->close();
                    $conn->close();
                }
                ?>
                <form id="eventForm" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" id="event_date" name="event_date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="event_title">Event Title</label>
                        <input type="text" id="event_title" name="event_title" required maxlength="255" placeholder="Enter event title">
                    </div>
                    <div class="form-group">
                        <label for="event_desc">Description</label>
                        <textarea id="event_desc" name="event_desc" required maxlength="500" placeholder="Enter event description"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submitBtn" disabled>Submit</button>
                        <button type="button" id="clearBtn" class="clear-btn">Clear</button>
                    </div>
                </form>
            </div>
            <!-- Modal -->
            <div id="eventModal" class="event-modal" style="display:none;">
                <div class="event-modal-content">
                    <span class="event-modal-close">&times;</span>
                    <h3 id="modalTitle"></h3>
                    <div class="event-modal-date" id="modalDate"></div>
                    <div class="event-modal-desc" id="modalDesc"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Set min date to tomorrow
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('event_date');
            const today = new Date();
            today.setDate(today.getDate() + 1);
            const minDate = today.toISOString().split('T')[0];
            dateInput.setAttribute('min', minDate);

            // Form validation
            const form = document.getElementById('eventForm');
            const submitBtn = document.getElementById('submitBtn');
            const clearBtn = document.getElementById('clearBtn');
            const title = document.getElementById('event_title');
            const desc = document.getElementById('event_desc');

            function checkForm() {
                if (dateInput.value && title.value.trim() && desc.value.trim()) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }
            dateInput.addEventListener('input', checkForm);
            title.addEventListener('input', checkForm);
            desc.addEventListener('input', checkForm);

            clearBtn.addEventListener('click', function() {
                form.reset();
                submitBtn.disabled = true;
            });

            // Modal logic
            const modal = document.getElementById('eventModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalDate = document.getElementById('modalDate');
            const modalDesc = document.getElementById('modalDesc');
            const closeModal = document.querySelector('.event-modal-close');
            document.querySelectorAll('.event-row').forEach(row => {
                row.addEventListener('click', function() {
                    modalTitle.textContent = this.getAttribute('data-title');
                    modalDate.textContent = this.getAttribute('data-date');
                    modalDesc.textContent = this.getAttribute('data-desc');
                    modal.style.display = 'flex';
                });
            });
            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>