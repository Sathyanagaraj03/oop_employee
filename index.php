<?php 
include 'navbar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Reload</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    table { width: 80%; margin: 20px auto; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid black; text-align: center; }
    th { background-color: #f2f2f2; }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Employee Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModal" onclick="openModal('add')">Add Employee</button>

    <table id="employeeTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="employeeForm">
                    <input type="hidden" id="empId">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="empName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" id="empPhone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" id="empAddress" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadEmployees();
});

function loadEmployees() {
    $.ajax({
        url: 'EmployeeController.php',
        type: 'POST',
        data: { action: 'fetch' },
        dataType: 'json',
        cache: false,
        success: function(response) {
            let rows = '';
            response.forEach(emp => {
                rows += `<tr>
                    <td>${emp.id}</td>
                    <td>${emp.name}</td>
                    <td>${emp.phone}</td>
                    <td>${emp.address}</td>
                    <td>
                        <button class="btn btn-success" onclick="openModal('edit', ${emp.id}, '${emp.name}', '${emp.phone}', '${emp.address}')">Edit</button>
                        <button class="btn btn-danger" onclick="deleteEmployee(${emp.id})">Delete</button>
                    </td>
                </tr>`;
            });
            $('#employeeTable tbody').html(rows);
            $('#employeeTable').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "ordering": true,
                "searching": true
            });
        }
    });
}
</script>

</body>
</html>
