
<?php
if (isset($_SESSION['authorized'])) {
    if ($_SESSION['authorized'] == false) {
        header("Location: login.php?error=not-authorized");
    }
} else {
    header("Location: login.php?error=not-authorized");
    
}
?>

<!-- recieves the form data from post request -->
<?php
//  logs the post array

print_r($_POST);
// logs the post array with each elements data type
print_r(array_map('gettype', $_POST));

require('Database/database.php');
if (isset($_POST['name'])){
    $student = new Student();
    $student->loadStudentFromPOST();
    $DATABASE->addStudent($student);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Entry</title>

    <style>
        .highlighted {
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <div style="margin: auto; max-width: 30%;">
    <form name="addStudent" action="addStudent.php" method="post" onsubmit="return addStudentValidation()" style="display: flex;flex-direction: column;">
        <label for="name">Student Name</label>
        <input type="text" name="name" id="" required>
        <label for="cnic">CNIC</label>
        <input type="text" name="cnic" id="" required maxlength="13">
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="" required>
        <label for="address">address</label>
        <input type="text" name="address" id="" required>
        <label for="father-name">Father's Name</label>
        <input type="text" name="father-name" id="" required>
        <label for="DOB">Date of Birth</label>
        <input type="date" name="DOB" id="" required>
        <label for="roll-num">Roll Number</label>
        <input type="text" name="roll-num" id="" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="" required>
        <button type="submit">Create Student</button>
    </form>
    </div>


</body>
<script>
    function addStudentValidation() {
        let form = document.querySelector("body > div > form")
        const REG_EX_PHONE = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/

        if (REG_EX_PHONE.test(form['phone'] === false)){
            form.preventDefault();
            console.log("meh");
            form['phone'].classList.toggle('highlighted')
            return false;
        }
        return true;
    }
</script>
</html>