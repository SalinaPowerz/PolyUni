<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Events Management</title>
    <style>
        /* Navigation styles from nav.html and style.css */
        .navigation:hover{
            color: blue;
            font-weight: bold;
        }
        
        #Navigation_bar {
            position: fixed; 
            width: 100%; 
            height: 60px; 
            background-color: #32508F; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            padding: 0 17px; 
            box-sizing: border-box;
            z-index: 1000;
            top: 0;
            left: 0;
        }
        
        /* Original calendar styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            padding: 20px;
            padding-top: 80px; /* Added space for fixed navigation */
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #32508F;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        h2 {
            color: #32508F;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        textarea {
            height: 100px;
            resize: vertical;
        }
        
        button {
            background-color: #32508F;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        
        button:hover {
            background-color: #2a4379;
        }
        
        button.delete {
            background-color: #d9534f;
        }
        
        button.delete:hover {
            background-color: #c9302c;
        }
        
        button.select-all {
            background-color: #5bc0de;
        }
        
        button.select-all:hover {
            background-color: #46b8da;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .actions {
            display: flex;
            gap: 5px;
        }
        
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .date-range {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .date-range > div {
            flex: 1;
            min-width: 200px;
        }
        
        .bulk-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .checkbox-cell {
            width: 40px;
            text-align: center;
        }
        
        .multi-date-options {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        
        .date-list {
            margin-top: 10px;
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            background-color: white;
        }
        
        .date-item {
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .date-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Navigation bar from nav.html -->
    <div id="Navigation_bar">
        <div style="display: flex; align-items: center;">
            <img src="../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
            
        </div>

    </div>
    
    <div class="container">
        <!-- Removed the "Calendar Events Management" h1 heading -->
        
        <?php
        // Include database connection
        include '../Exams/db.php';
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Handle form submissions
        $message = "";
        $messageType = "";
        
        // Add new event(s)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
            $event_title = $_POST['event_title'];
            $event_description = $_POST['event_description'];
            
            // Check if we're adding to multiple dates
            $multi_date = isset($_POST['multi_date']) && $_POST['multi_date'] === 'yes';
            
            if ($multi_date && isset($_POST['date_list'])) {
                // Add to multiple dates
                $dates = explode(',', $_POST['date_list']);
                $successCount = 0;
                
                foreach ($dates as $date) {
                    if (!empty($date) && !empty($event_title)) {
                        $stmt = $conn->prepare("INSERT INTO calendar_events (Event_Date, Event_Title, Event_Description) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $date, $event_title, $event_description);
                        
                        if ($stmt->execute()) {
                            $successCount++;
                        }
                        
                        $stmt->close();
                    }
                }
                
                if ($successCount > 0) {
                    $message = "Event added to $successCount dates successfully!";
                    $messageType = "success";
                } else {
                    $message = "Error adding events to multiple dates";
                    $messageType = "error";
                }
            } else {
                // Add to single date
                $event_date = $_POST['event_date'];
                if (!empty($event_date) && !empty($event_title)) {
                    $stmt = $conn->prepare("INSERT INTO calendar_events (Event_Date, Event_Title, Event_Description) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $event_date, $event_title, $event_description);
                    
                    if ($stmt->execute()) {
                        $message = "Event added successfully!";
                        $messageType = "success";
                    } else {
                        $message = "Error adding event: " . $conn->error;
                        $messageType = "error";
                    }
                    
                    $stmt->close();
                } else {
                    $message = "Please fill in all required fields (Date and Title)!";
                    $messageType = "error";
                }
            }
        }
        
        // Delete single event
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            
            $stmt = $conn->prepare("DELETE FROM calendar_events WHERE Event_ID = ?");
            $stmt->bind_param("i", $delete_id);
            
            if ($stmt->execute()) {
                $message = "Event deleted successfully!";
                $messageType = "success";
            } else {
                $message = "Error deleting event: " . $conn->error;
                $messageType = "error";
            }
            
            $stmt->close();
            
            // Redirect to avoid resubmission on refresh
            header("Location: " . str_replace("&delete_id=" . $delete_id, "", $_SERVER['REQUEST_URI']));
            exit();
        }
        
        // Bulk delete events
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_delete'])) {
            if (isset($_POST['selected_events']) && is_array($_POST['selected_events']) && count($_POST['selected_events']) > 0) {
                $placeholders = implode(',', array_fill(0, count($_POST['selected_events']), '?'));
                $stmt = $conn->prepare("DELETE FROM calendar_events WHERE Event_ID IN ($placeholders)");
                
                // Bind parameters
                $types = str_repeat('i', count($_POST['selected_events']));
                $stmt->bind_param($types, ...$_POST['selected_events']);
                
                if ($stmt->execute()) {
                    $deletedCount = $stmt->affected_rows;
                    $message = "$deletedCount events deleted successfully!";
                    $messageType = "success";
                } else {
                    $message = "Error deleting events: " . $conn->error;
                    $messageType = "error";
                }
                
                $stmt->close();
            } else {
                $message = "Please select at least one event to delete.";
                $messageType = "error";
            }
        }
        
        // Display message if exists
        if (!empty($message)) {
            echo "<div class='message $messageType'>$message</div>";
        }
        ?>
        
        <div class="section">
            <h2>Add New Event</h2>
            <form method="POST" action="" id="eventForm">
                <div class="form-group">
                    <label for="event_title">Event Title *</label>
                    <input type="text" id="event_title" name="event_title" required>
                </div>
                
                <div class="form-group">
                    <label for="event_description">Event Description</label>
                    <textarea id="event_description" name="event_description"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Add to multiple dates?</label>
                    <div>
                        <input type="radio" id="single_date" name="multi_date" value="no" checked onchange="toggleDateSelection()">
                        <label for="single_date" style="display: inline; font-weight: normal;">Single Date</label>
                        
                        <input type="radio" id="multi_date" name="multi_date" value="yes" onchange="toggleDateSelection()">
                        <label for="multi_date" style="display: inline; font-weight: normal;">Multiple Dates</label>
                    </div>
                </div>
                
                <div id="single_date_container">
                    <div class="form-group">
                        <label for="event_date">Event Date *</label>
                        <input type="date" id="event_date" name="event_date">
                    </div>
                </div>
                
                <div id="multi_date_container" style="display: none;">
                    <div class="multi-date-options">
                        <div class="form-group">
                            <label for="start_date">Start Date *</label>
                            <input type="date" id="start_date" name="start_date">
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date">End Date *</label>
                            <input type="date" id="end_date" name="end_date">
                        </div>
                        
                        <div class="form-group">
                            <label>Days of Week</label>
                            <div>
                                <?php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                foreach ($days as $index => $day) {
                                    $checked = $index < 5 ? 'checked' : ''; // Mon-Fri checked by default
                                    echo "<input type='checkbox' id='day_$index' name='days[]' value='$index' $checked>";
                                    echo "<label for='day_$index' style='display: inline; font-weight: normal; margin-right: 10px;'>$day</label>";
                                }
                                ?>
                            </div>
                        </div>
                        
                        <button type="button" onclick="generateDateList()">Generate Dates</button>
                        
                        <div class="form-group">
                            <label>Selected Dates</label>
                            <div class="date-list" id="date_list_display">No dates selected</div>
                            <input type="hidden" name="date_list" id="date_list">
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="add_event">Add Event</button>
            </form>
        </div>
        
        <div class="section">
            <h2>Existing Events</h2>
            <form method="POST" action="">
                <?php
                // Fetch all events
                $result = $conn->query("SELECT * FROM calendar_events ORDER BY Event_Date DESC, Event_ID DESC");
                
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th class='checkbox-cell'><input type='checkbox' id='select_all'></th>";
                    echo "<th>Date</th>";
                    echo "<th>Title</th>";
                    echo "<th>Description</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='checkbox-cell'><input type='checkbox' name='selected_events[]' value='" . $row['Event_ID'] . "' class='event-checkbox'></td>";
                        echo "<td>" . htmlspecialchars($row['Event_Date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Event_Title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Event_Description']) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='?delete_id=" . $row['Event_ID'] . "' onclick=\"return confirm('Are you sure you want to delete this event?')\">";
                        echo "<button class='delete'>Delete</button>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
                    
                    echo "<div class='bulk-actions'>";
                    echo "<button type='button' class='select-all' id='select_all_btn'>Select All</button>";
                    echo "<button type='submit' name='bulk_delete' class='delete'>Delete Selected</button>";
                    echo "</div>";
                } else {
                    echo "<p>No events found.</p>";
                }
                
                $conn->close();
                ?>
            </form>
        </div>
    </div>

    <script>
        // Toggle between single and multiple date selection
        function toggleDateSelection() {
            const singleDate = document.getElementById('single_date').checked;
            document.getElementById('single_date_container').style.display = singleDate ? 'block' : 'none';
            document.getElementById('multi_date_container').style.display = singleDate ? 'none' : 'block';
            
            if (!singleDate) {
                // Set default date range (next 7 days)
                const today = new Date();
                const nextWeek = new Date();
                nextWeek.setDate(today.getDate() + 7);
                
                document.getElementById('start_date').value = formatDate(today);
                document.getElementById('end_date').value = formatDate(nextWeek);
                
                generateDateList();
            }
        }
        
        // Format date as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        // Parse date from YYYY-MM-DD format
        function parseDate(dateStr) {
            const parts = dateStr.split('-');
            return new Date(parts[0], parts[1] - 1, parts[2]);
        }
        
        // Generate list of dates based on selection
        function generateDateList() {
            const startDate = parseDate(document.getElementById('start_date').value);
            const endDate = parseDate(document.getElementById('end_date').value);
            
            if (isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                alert('Please select a valid date range.');
                return;
            }
            
            // Get selected days of week
            const selectedDays = [];
            document.querySelectorAll('input[name="days[]"]:checked').forEach(checkbox => {
                selectedDays.push(parseInt(checkbox.value));
            });
            
            if (selectedDays.length === 0) {
                alert('Please select at least one day of the week.');
                return;
            }
            
            // Generate dates
            const dates = [];
            const currentDate = new Date(startDate);
            
            while (currentDate <= endDate) {
                const dayOfWeek = currentDate.getDay();
                // Convert Sunday (0) to 6, others to 0-5
                const adjustedDay = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
                
                if (selectedDays.includes(adjustedDay)) {
                    dates.push(formatDate(new Date(currentDate)));
                }
                
                currentDate.setDate(currentDate.getDate() + 1);
            }
            
            // Display dates
            const dateListDisplay = document.getElementById('date_list_display');
            const dateListInput = document.getElementById('date_list');
            
            if (dates.length > 0) {
                dateListDisplay.innerHTML = '';
                dates.forEach(date => {
                    const dateItem = document.createElement('div');
                    dateItem.className = 'date-item';
                    dateItem.textContent = date;
                    dateListDisplay.appendChild(dateItem);
                });
                
                dateListInput.value = dates.join(',');
            } else {
                dateListDisplay.innerHTML = 'No dates match your criteria';
                dateListInput.value = '';
            }
        }
        
        // Select all checkboxes
        document.getElementById('select_all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.event-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        document.getElementById('select_all_btn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.event-checkbox');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            
            document.getElementById('select_all').checked = !allChecked;
        });
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            toggleDateSelection();
        });
    </script>
</body>
</html>