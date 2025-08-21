<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Data Export</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .navigation-bar {
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
        }
        .navigation-bar div {
            display: flex;
            align-items: center;
        }
        .navigation-bar span {
            font-size: 30px;
            color: #FFFFFF;
        }
        .navigation-bar nav {
            display: flex;
            gap: 12px;
            font-family: Helvetica;
            color: #FFFFFF;
            margin-right: 30px;
        }
        .navigation-bar a {
            font-size: 17px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 4px 10px;
        }
        .navigation-bar a:hover {
            color: blue;
            font-weight: bold;
        }
        .spacer {
            height: 70px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
            margin-top: 20px;
        }
        .card-header {
            background-color: #4b5e7e;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-export {
            margin: 5px;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
        }
        .btn-pdf {
            background-color: #e74c3c;
            color: white;
            border: none;
        }
        .btn-pdf:hover {
            background-color: #c0392b;
        }
        .btn-excel {
            background-color: #27ae60;
            color: white;
            border: none;
        }
        .btn-excel:hover {
            background-color: #219653;
        }
        .table-container {
            overflow-x: auto;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #4b5e7e;
            color: white;
            position: sticky;
            top: 0;
            padding: 12px 15px;
            text-align: left;
        }
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            color: #6c757d;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        .search-container {
            display: flex;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .filter-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-select {
            min-width: 150px;
        }
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .btn-pagination {
            padding: 5px 15px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navigation-bar">
        <div>
            <img src="../../../Images/new.png" width="50px" alt="Logo" style="vertical-align: middle; margin-right: 10px;" />
            <!-- Removed "POLYCIUM UNIVERSITY" text -->
        </div>
    </div>
    <div class="spacer"></div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Admission Forms Data</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap mb-4">
                    <div class="search-container">
                        <div class="d-flex">
                            <input type="text" id="searchInput" class="form-control me-2" placeholder="Search...">
                            <button class="btn btn-primary" onclick="searchTable()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="filter-container">
                            <select id="sexFilter" class="form-select filter-select" onchange="applyFilters()">
                                <option value="">All Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <select id="courseFilter" class="form-select filter-select" onchange="applyFilters()">
                                <option value="">All Courses</option>
                                <option value="BSIT">BSIT</option>
                                <!-- Add more course options as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <button class="btn btn-export btn-pdf" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </button>
                        <button class="btn btn-export btn-excel" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table id="dataTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Birth Date</th>
                                <th>Sex</th>
                                <th>Religion</th>
                                <th>City</th>
                                <th>Province</th>
                                <th>Course</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    <div>
                        <span>Showing <span id="currentCount">0</span> of <span id="totalCount">0</span> records</span>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary btn-pagination" onclick="prevPage()">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <span class="mx-2">Page <span id="currentPage">1</span></span>
                        <button class="btn btn-outline-secondary btn-pagination" onclick="nextPage()">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© 2025 Polycium University - Admission Management System</p>
    </div>

    <script>
        // Sample data based on the SQL provided
        const admissionData = [
            {
                Ad_ID: 27,
                FirstName: 'GREF',
                MiddleName: '',
                LastName: 'SDSDSD',
                Suffix: 'DSD',
                BirthDate: '1999-07-14',
                Sex: 'Male',
                Religion: 'DSDSD',
                BlockLot: 'WWDD',
                Street: 'DSDS',
                Barangay: 'DSDS',
                City: 'DSDS',
                Province: 'DSDSDS',
                Fathers_Name: 'SDSDS',
                Mothers_Name: 'SDSD',
                Guardian: 'SDSDS',
                Email: 'helasa@ee',
                Phone_num: '2212',
                Contact_num: '2111',
                Course_ID: 'BSIT',
                ReportCard: 'uploads/68a363bbf23fe_Screenshot 2025-06-16 at 00-17-09 Academics.png',
                Form137: 'uploads/68a366617f629_Screenshot 2025-06-16 at 00-19-31 Academics.png',
                HealthRecords: 'uploads/68a366617ff81_HOMEPAGE(2).png',
                Account_ID: 56
            },
            {
                Ad_ID: 28,
                FirstName: 'malachi',
                MiddleName: 'nugat',
                LastName: 'lama',
                Suffix: 'single',
                BirthDate: '2005-11-01',
                Sex: 'Male',
                Religion: 'Catholic',
                BlockLot: '123',
                Street: 'florid',
                Barangay: 'palico 2',
                City: 'imus',
                Province: 'cavite',
                Fathers_Name: 'yemire lama',
                Mothers_Name: 'cha res',
                Guardian: 'yemire lama',
                Email: 'emire@yahoo.com',
                Phone_num: '09345637452',
                Contact_num: '09276354254',
                Course_ID: 'BSIT',
                ReportCard: 'uploads/68a4431cada10_RobloxScreenShot20250411_014600271.png',
                Form137: 'uploads/68a4431caed7a_RobloxScreenShot20250508_223243568.png',
                HealthRecords: 'uploads/68a4431cafa00_RobloxScreenShot20250607_215900256.png',
                Account_ID: 57
            }
        ];

        // Get unique courses for the filter
        const uniqueCourses = [...new Set(admissionData.map(item => item.Course_ID))];
        const courseFilter = document.getElementById('courseFilter');
        
        // Populate course filter options
        uniqueCourses.forEach(course => {
            const option = document.createElement('option');
            option.value = course;
            option.textContent = course;
            courseFilter.appendChild(option);
        });

        // Populate the table with data
        const tableBody = document.querySelector('#dataTable tbody');
        const currentCount = document.getElementById('currentCount');
        const totalCount = document.getElementById('totalCount');
        const currentPageElement = document.getElementById('currentPage');

        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = [...admissionData];

        function populateTable() {
            tableBody.innerHTML = '';
            
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedData = filteredData.slice(start, end);
            
            paginatedData.forEach(data => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${data.Ad_ID}</td>
                    <td>${data.FirstName} ${data.MiddleName} ${data.LastName} ${data.Suffix}</td>
                    <td>${data.BirthDate}</td>
                    <td>${data.Sex}</td>
                    <td>${data.Religion}</td>
                    <td>${data.City}</td>
                    <td>${data.Province}</td>
                    <td>${data.Course_ID}</td>
                    <td>${data.Email}</td>
                `;
                tableBody.appendChild(row);
            });
            
            currentCount.textContent = paginatedData.length;
            totalCount.textContent = filteredData.length;
            currentPageElement.textContent = currentPage;
        }

        function nextPage() {
            if (currentPage * rowsPerPage < filteredData.length) {
                currentPage++;
                populateTable();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                populateTable();
            }
        }

        function applyFilters() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const sexFilterValue = document.getElementById('sexFilter').value;
            const courseFilterValue = document.getElementById('courseFilter').value;
            
            filteredData = admissionData.filter(item => {
                const matchesSearch = 
                    item.FirstName.toLowerCase().includes(searchText) ||
                    item.LastName.toLowerCase().includes(searchText) ||
                    item.Email.toLowerCase().includes(searchText) ||
                    item.Course_ID.toLowerCase().includes(searchText) ||
                    item.City.toLowerCase().includes(searchText);
                
                const matchesSex = sexFilterValue === '' || item.Sex === sexFilterValue;
                const matchesCourse = courseFilterValue === '' || item.Course_ID === courseFilterValue;
                
                return matchesSearch && matchesSex && matchesCourse;
            });
            
            currentPage = 1;
            populateTable();
        }

        function searchTable() {
            applyFilters();
        }

        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Add title
            doc.setFontSize(18);
            doc.text('Polycium University - Admission Data', 14, 15);
            doc.setFontSize(12);
            doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 14, 22);
            
            // Add table
            doc.autoTable({
                startY: 30,
                head: [['ID', 'Name', 'Birth Date', 'Sex', 'Religion', 'City', 'Course', 'Email']],
                body: filteredData.map(item => [
                    item.Ad_ID,
                    `${item.FirstName} ${item.MiddleName} ${item.LastName} ${item.Suffix}`,
                    item.BirthDate,
                    item.Sex,
                    item.Religion,
                    item.City,
                    item.Course_ID,
                    item.Email
                ]),
                theme: 'grid',
                headStyles: {
                    fillColor: [75, 94, 126]
                }
            });
            
            // Save the PDF
            doc.save('admission_data.pdf');
        }

        function exportToExcel() {
            // Prepare data for Excel
            const worksheet = XLSX.utils.json_to_sheet(filteredData.map(item => ({
                ID: item.Ad_ID,
                'First Name': item.FirstName,
                'Middle Name': item.MiddleName,
                'Last Name': item.LastName,
                Suffix: item.Suffix,
                'Birth Date': item.BirthDate,
                Sex: item.Sex,
                Religion: item.Religion,
                'Block/Lot': item.BlockLot,
                Street: item.Street,
                Barangay: item.Barangay,
                City: item.City,
                Province: item.Province,
                "Father's Name": item.Fathers_Name,
                "Mother's Name": item.Mothers_Name,
                Guardian: item.Guardian,
                Email: item.Email,
                "Phone Number": item.Phone_num,
                "Contact Number": item.Contact_num,
                Course: item.Course_ID
            })));
            
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Admission Data');
            
            // Generate Excel file and download
            XLSX.writeFile(workbook, 'admission_data.xlsx');
        }

        // Initialize the table on page load
        document.addEventListener('DOMContentLoaded', populateTable);
    </script>
</body>
</html>