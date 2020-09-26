
<?php
    if(isset($_POST['update'])){
        $fname   = sanitizeString($_POST['Fname']);
        $lname   = sanitizeString($_POST['Lname']);
        $age   = sanitizeString($_POST['Age']);
    $result = queryMysql("SELECT * FROM members WHERE users='$fname'");

    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$user' is taken</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The username '$user' is available</span>";
    }

?>