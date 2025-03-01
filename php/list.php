 <!-- Student List -->
 <h3 class="mt-4">Registered Students</h3>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentList">
            <?php
            include './db/config.php';
            $result = $conn->query("SELECT * FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td>{$row['course']}</td>
                        <td>₹{$row['total_amount']}</td>
                        <td>₹{$row['paid_amount']}</td>
                        <td>₹{$row['balance_amount']}</td>
                        <td>
                            <button class='btn btn-info btn-sm' onclick='viewPayments(\"{$row['student_id']}\")'>View Payments</button>
                            <button class='btn btn-warning btn-sm' onclick='editStudent(\"{$row['student_id']}\")'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='deleteStudent(\"{$row['student_id']}\")'>Delete</button>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
