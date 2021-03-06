<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<title>Survey Monkey</title>
  <link rel="stylesheet" href="stylesheet.css">
  <link rel="shortcut icon" href="logo.jpg">
</head>
<body>
<!--Navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="profile.html">
    <img src="logo.jpg" width="30" height="30" alt=""> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="about.html">About </a>
      </li>
    </ul>
  </div>
</nav>
<!-- End Of NAV BAR -->
<?php
		 $db = @mysqli_connect(localhost, "root", "root")
         Or die("<div><p>ERROR: Unable to connect to database server.</p>" . "<p>Error Code " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p></div>");
		 
         @mysqli_select_db($db, "surveymonkey")
         Or die("<div><p>ERROR: The database is not available. </p>" . "<p>Error Code" . mysqli_errno() . ": " . mysqli_error() . "</p></div>");

	if(isset($_POST['upload'])) {
    
	$file = $_FILES['file-upload']['tmp_name'];
	$count = 0;
	$size = (is_numeric($_POST['number']) ? (int)$_POST['number'] : 0); //convert to number or 0 as default
	
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	
	if($ext !== NULL){
		$handle = fopen($file, "r");
		$data = array();
		
		while((($data = fgetcsv($handle, 1000, ",")) != FALSE) && $count < $size){
			$count++;
			$name = $data[0];
			$q1 = $data[1];
			$q2 = $data[2];
			$q3 = $data[3];
			$q4 = $data[4];
			$q5 = $data[5];
			$q6 = $data[6];
							
		   $SQLquery = "INSERT INTO survey(name, q1, q2, q3, q4, q5, q6)
			VALUES( '$name', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6')";
		   
		   $q = mysqli_query($db, $SQLquery)
		   Or die("<div><p>ERROR: Unable to execute query.</p>" . "<p>Error Code " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p></div>");
		}
		
		fclose($handle);
		echo "<p> Successfully imported! </p>";
	}
	else{
		echo "<p> Invalid file. Go back and try a different file! </p>";
	}
  }
	else{
		echo "<p> Whoops, there was an error. Go back and try again! </p>";
	}
?>
<br />
<br />
      <div class="col-md-4 center-block">
	  <a href="profile.html" class="btn btn-primary btn-lg active" style="width:100%"role="button" aria-pressed="true"> Return to profile </a>
</body>
</html>