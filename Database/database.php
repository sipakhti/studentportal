<?php

/**
 * a simple class to hold the student data
 * it has a constructor to initialize the data
 * it has setters to perform validation on the data
 * @throws {Exception} if the data is invalid
 */
class Student
{
  public $name;
  public $cnic;
  public $phone;
  public $email;
  public $address;
  public $father_name;
  public $dob;
  public $roll_num;
  public $password;

  public function __construct()
  {
    $this->name = "";
    $this->cnic = "";
    $this->phone = "";
    $this->email = "";
    $this->address = "";
    $this->father_name = "";
    $this->dob = "";
    $this->roll_num = "";
    $this->password = "";
  }

  public function loadStudentFromPOST()
  {
    $this->name = $_POST['name'];
    $this->cnic = $_POST['cnic'];
    $this->phone = $_POST['phone'];
    $this->email = $_POST['email'];
    $this->address = $_POST['address'];
    $this->father_name = $_POST['father-name'];
    $this->dob = $_POST['DOB'];
    $this->roll_num = $_POST['roll-num'];
    $this->password = $_POST['password'];
  }



  public function setName($name)
  {
    $this->name = $name;
  }

  public function setCnic($cnic)
  {
    $this->cnic = $cnic;
  }

  /** the setter for phone performs a regex check */
  public function setPhone($phone)
  {
    $REG_EX_PHONE = "/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/";
    if (preg_match($REG_EX_PHONE, $phone)) {
      $this->phone = $phone;
    } else {
      throw new Exception("Invalid Phone Number");
    }
  }

  /** the setter for email performs a regex check */
  public function setEmail($email)
  {
    $REG_EX_EMAIL = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
    if (preg_match($REG_EX_EMAIL, $email)) {
      $this->email = $email;
    } else {
      throw new Exception("Invalid Email");
    }
  }

  public function setAddress($address)
  {
    $this->address = $address;
  }

  public function setFatherName($father_name)
  {
    $this->father_name = $father_name;
  }

  public function setPassword($password)
  {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }
}


class DB extends mysqli
{
  private $SERVERNAME = "localhost";
  private $USERNAME = "root";
  private $PASSWORD = "";




  public function __construct()
  {

    parent::__construct($this->SERVERNAME, $this->USERNAME, $this->PASSWORD);
  }

  /**
   * 
   * @param $roll_num {string}
   * @param $password {string} 
   * @return {bool} true if the password matches the roll number
   * @throws {Exception} if the roll number is not found
   */
  public function getStudentLoginCredentials(string $roll_num, string $password): bool
  {
    try {

      $statment = $this->prepare("SELECT s_pass_key FROM student_portal.students WHERE s_roll_num = ?");
      $statment->bind_param("s", $roll_num);
      $statment->execute();
      $result = $statment->get_result();
      echo "<p>" . print_r($result->fetch_assoc()) . "<?p>";
      return true;
      // if (isset($result)){
      //   password_verify($password, $result->fetch_assoc);
      // }

    } catch (\Throwable $th) {
      return false;
    }
  }

  /**
   * the function to bind the session to the student
   * @param $roll_num {string} the roll number of the student
   * @return {bool} true if the session is binded
   */
  public function bindSession($roll_num): bool
  {
    $session = session_id();
    $statment = $this->prepare("INSERT INTO student_portal.sessions (user_id, session_id) VALUES (?,?)");
    $statment->bind_param("ss", $roll_num, $session);
    $statment->execute();
    if ($statment->error) {
      echo $statment->error;
      return false;
    } else {
      echo "SUCCESSFULLY BINDED SESSION";
      return true;
    }
  }

  /**
   * the function to add the student to the database
   * save the date as sql date
   * @param $student {Student} the student object to be added
   * @return {bool} true if the student is added
   */
  public function addStudent(Student $student): bool
  {
    try {
      $statment = $this->prepare("INSERT INTO student_portal.students (s_name, s_cnic, s_phone, s_email, s_address, s_father_name, s_dob, s_roll_num, s_pass_key) VALUES (?,?,?,?,?,?,?,?,?)");
      $statment->bind_param("sssssssss", $student->name, $student->cnic, $student->phone, $student->email, $student->address, $student->father_name, $student->dob, $student->roll_num, $student->password);
      $statment->execute();
      if ($statment->error) {
        echo $statment->error;
        return false;
      } else {
        echo "SUCCESSFULLY ADDED STUDENT";
        return true;
      }
      $statment->close();
    } catch (\Throwable $th) {
      echo $th;
      return false;
    }
  }

  /**
   * the method to match the credentials of the student
   * @param $roll_num {string} the roll number of the student 
   * @param $password {string} the password of the student
   * @return {bool} true if the credentials match
   */

  public function checkStudentCredentials($roll_num, $password): bool
  {
    // prepare and bind and execute the statement
    $statment = $this->prepare("SELECT s_pass_key FROM student_portal.students WHERE s_roll_num = ?");
    $statment->bind_param("s", $roll_num);
    $statment->execute();
    $result = $statment->get_result();
    // check if the statment has an error
    if ($statment->error) {
      echo $statment->error;
      return false;
    } else {
      // if the statment has no error, check if the result has a row
      $row = $result->fetch_assoc();
      if (isset($row['s_pass_key'])) {
        // if the result has a row, check if the password matches
        if (password_verify($password, $row['s_pass_key'])) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
        echo "The user with the roll number $roll_num does not exist";
      }
    }
  }

  /**
   * the function to check if the session is binded to the student
   * @param $roll_num {string} the roll number of the student
   * @return {bool} true if the session is binded
   */
  public function checkSession($roll_num): bool {
    $session = session_id();
    $statment = $this->prepare("SELECT * FROM student_portal.sessions WHERE user_id = ? AND session_id = ?");
    $statment->bind_param("ss", $roll_num, $session);
    $statment->execute();
    $result = $statment->get_result();
    if ($statment->error) {
      echo $statment->error;
      return false;
    } else {
      $row = $result->fetch_assoc();
      if (isset($row['user_id'])) {
        return true;
      } else {
        return false;
      }
    }
  }

  /**
   * logouts the user by deleting the session
   * @param $roll_num {string} the roll number of the student
   * @return {bool} true if the session is deleted
   */
  public function logoutUser($roll_num): bool {
    $session = session_id();
    $statment = $this->prepare("DELETE FROM student_portal.sessions WHERE user_id = ? AND session_id = ?");
    $statment->bind_param("ss", $roll_num, $session);
    $statment->execute();
    if ($statment->error) {
      echo $statment->error;
      return false;
    } else {
      return true;
    }
  }


}



$DATABASE = new DB();
// Check connection
if ($DATABASE->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

