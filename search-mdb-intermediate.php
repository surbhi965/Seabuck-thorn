<?php
//error handling
//secure
	session_start();
	require("connect.inc.php");
	@$pageid=$_POST["pageid"];
	@$ssrtype= $_POST["SSRtype"];
	@$ssr= $_POST["SSR"];
	@$sizeoption=$_POST["sizeoption"];
	@$size=$_POST["size"];
	@$size2=$_POST["size2"];
	//echo $ssrtype." ".$ssr." ".$sizeoption." ".$size;
	if(empty($ssr) AND empty($ssrtype) AND empty($size)) die("Choose at least one attribute to search for.");
	$sql='SELECT table1.*, table2.* from table1 LEFT OUTER JOIN table2 ON table1.ID=table2.seqid WHERE 1';
	$fields = [	'SSRtype','SSR','size'];		//fields to search
	foreach ($fields as $field) {	//adding each field to where clause
  		if (isset($_POST[$field]) AND !empty($_POST[$field])) {	//check if field is set and filled
	    	$value = $_POST[$field];
	    	if($field=="size")
	    		if($sizeoption!="BETWEEN")
		    		$sql=$sql." AND table1.`".$field."` ".$sizeoption." '".htmlentities($value)."'";
				else if(isset($_POST["size2"]) AND !empty($_POST["size2"]))
		    		$sql=$sql." AND table1.`".$field."` ".$sizeoption." '".htmlentities($value)."' AND '" .htmlentities($size2)."'";
	    		else die('"Between" option needs lower as well as upper bound.');
	    	else	    	
	    		$sql=$sql." AND table1.`".$field."` = '".htmlentities($value)."'";
  		}
	}
	$_SESSION["query"]=$sql;
	$_SESSION["countquery"]=str_replace("table1.*, table2.* from table1 LEFT OUTER JOIN table2 ON table1.ID=table2.seqid", "count(id) from table1", $sql);
	header("Location: search-mdb-result.php");
 ?>