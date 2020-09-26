<?php

// escape value from form
function esc(String $value)
{
	// bring the global db connect object into function
	global $conn;

	$val = trim($value); // remove empty space sorrounding string
	$data = stripslashes($val);
	$data = htmlspecialchars($data);
	$val = mysqli_real_escape_string($conn, $value);

	return $data;
}


function setImg($profile_image = array(), $username)
{
	if (!empty($profile_image)) {
		$file = $profile_image; //get the file from global variable
		//print_r($file);
		$res = "";
		$errors = array();
		//getting appropriate data
		$fileName = $profile_image['name'];
		$fileTmpName = $profile_image['tmp_name'];
		$fileError = $profile_image['error'];
		$fileSize = $profile_image['size'];

		//get extention
		$fileExt = explode('.', $fileName);
		$actualExt = strtolower(end($fileExt));
		//create array of allowed ext
		$allowedExt = array("jpg", "png", "jpeg");

		if (in_array($actualExt, $allowedExt)) { //check if ext is allowed in_array()

			if ($fileSize < 1000000) { //check if allowed file size

				if ($fileError === 0) { //check if there's error

					//create unique name for file with prefix and generated name and suffix extention
					$uniqueName = uniqid($username, false) . "." . $actualExt;

					//destination path + uniqueName
					$destination = "static/images/" . $uniqueName;


					//move file from temp location to destination
					move_uploaded_file($fileTmpName, $destination);
					$res = $uniqueName;

					//header("location: upload.html?UploadSuccessfull");


				} else {
					array_push($errors, "there was an error in the file upload. pls try again");
				}
			} else {
				array_push($errors, "file size is too large");
			}
		} else {
			array_push($errors, "this file extention is not allowed \n allowed Extentions include: .jpg,.png,.jpeg");
		}
	}
	return $res;
}

?>