// Open Add Student Form
function openAddStudent() {
  new bootstrap.Modal(document.getElementById('addStudentModal')).show();
}

// Set Course Amount
function setAmount() {
  let course = document.getElementById("course").value;
  let amount = {"Full Stack": 8000, "Frontend": 4000, "Backend": 4000, "UI/UX Design": 2500};
  document.getElementById("amount").value = amount[course] || "";
}

// Handle Student Registration
document.getElementById("addStudentForm").addEventListener("submit", function(event) {
  event.preventDefault();

  let formData = new FormData();
  formData.append("firstName", document.getElementById("firstName").value);
  formData.append("lastName", document.getElementById("lastName").value);
  formData.append("course", document.getElementById("course").value);
  formData.append("amount", document.getElementById("amount").value);

  fetch("./api/register_student.php", {
      method: "POST",
      body: formData
  }).then(response => response.text()).then(data => {
      Swal.fire("Success!", data, "success").then(() => location.reload());
  });
});
// Open Billing Form
function openBilling() {
  Swal.fire({
      title: "Enter Billing Details",
      html: `
          <input type="text" id="billingStudentID" class="swal2-input" placeholder="Student ID">
          <input type="number" id="billingAmount" class="swal2-input" placeholder="Amount">
      `,
      showCancelButton: true,
      confirmButtonText: "Submit",
      preConfirm: () => {
          let studentID = document.getElementById("billingStudentID").value;
          let amount = document.getElementById("billingAmount").value;

          if (!studentID || !amount || amount <= 0) {
              Swal.showValidationMessage("Please enter valid details!");
              return false;
          }

          return { studentID, amount };
      }
  }).then(result => {
      if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("student_id", result.value.studentID);
          formData.append("amount", result.value.amount);

          fetch("./billing.php", {
              method: "POST",
              body: formData
          })
          .then(response => response.text())
          .then(data => {
              Swal.fire("Success!", data, "success").then(() => location.reload());
          });
      }
  });
}
function viewPayments(student_id) {
  // Open the payments file in a popup window
  window.open("./api/view_payments.php?student_id=" + student_id, "Payments", "width=500,height=400");
}
// Edit Student
function editStudent(studentID) {
  fetch(`./update/get_student.php?student_id=${studentID}`)
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          Swal.fire("Error", data.error, "error");
          return;
      }
      Swal.fire({
          title: "Edit Student",
          html: `
              <input type="text" id="editFirstName" class="swal2-input" value="${data.first_name}" placeholder="First Name">
              <input type="text" id="editLastName" class="swal2-input" value="${data.last_name}" placeholder="Last Name">
          `,
          showCancelButton: true,
          confirmButtonText: "Save",
          preConfirm: () => {
              return {
                  studentID: studentID,
                  firstName: document.getElementById("editFirstName").value,
                  lastName: document.getElementById("editLastName").value
              };
          }
      }).then(result => {
          if (result.isConfirmed) {
              let formData = new FormData();
              formData.append("student_id", result.value.studentID);
              formData.append("first_name", result.value.firstName);
              formData.append("last_name", result.value.lastName);

              fetch("./update/edit_student.php", {
                  method: "POST",
                  body: formData
              })
              .then(response => response.text())
              .then(data => {
                  Swal.fire("Updated!", data, "success").then(() => location.reload());
              })
              .catch(error => Swal.fire("Error", "Failed to update student", "error"));
          }
      });
  })
  .catch(error => {
      Swal.fire("Error", "Failed to fetch student details", "error");
  });
}


// Delete Student
function deleteStudent(studentID) {
  Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to recover this student record!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!"
  }).then(result => {
      if (result.isConfirmed) {
          let formData = new FormData();
          formData.append("student_id", studentID);

          fetch("./update/delete_student.php", {
              method: "POST",
              body: formData
          })
          .then(response => response.text())
          .then(data => {
              Swal.fire("Deleted!", data, "success").then(() => location.reload());
          });
      }
  });
}
