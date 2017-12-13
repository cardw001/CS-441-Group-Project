<?php
		$db = @mysqli_connect(localhost, "root", "root")
        Or die("<div><p>ERROR: Unable to connect to database server.</p>" . "<p>Error Code " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p></div>");
		 
        @mysqli_select_db($db, "surveymonkey")
        Or die("<div><p>ERROR: The database is not available. </p>" . "<p>Error Code" . mysqli_errno() . ": " . mysqli_error() . "</p></div>");

		$q = "SELECT name, q1, q2, q3, q4, q5, q6 FROM survey";
		$query = @mysqli_query($db, $q)
         Or die("<div><p>ERROR: Unable to execute the query. </p>" . "<p>Error Code" . mysqli_errno() . ": " . mysqli_error() . "</p></div>");
        
	  //------------------
		$query = $db->query("SELECT * FROM survey");
		if($query->num_rows > 0){
		$delimiter = ",";
		$filename = "survey_" . date('Y-m-d') . ".csv";
    
		//create a file pointer
		$f = fopen('php://memory', 'w');
    
		//set column headers
		$fields = array();
	
		//output each row of the data, format line as csv and write to file pointer
		while($row = $query->fetch_assoc()){
			$lineData = array($row['name'], $row['q1'], $row['q2'], $row['q3'], $row['q4'], $row['q5'], $row['q6']);
			fputcsv($f, $lineData, $delimiter);
		}
    
		//move back to beginning of file
		fseek($f, 0);
    
		//set headers to download file rather than displayed
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
    
		//output all remaining data on a file pointer
		fpassthru($f);
		}
	  //------------------
?>
