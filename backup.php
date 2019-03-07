<?php

//Enter your database information here and the name of the backup file
$mysqlDatabaseName ='Eduscape_CRM';
$mysqlUserName ='Eduscape_CRM';
$mysqlPassword ='password1';
$mysqlHostName ='localhost';
$mysqlExportPath ='public_html/crm/backup/'.date('dmy').'.sql';

//Please do not change the following points
//Export of the database and output of the status
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;

exec($command,$output=array(),$worked);

switch($worked){
case 0:

$to = 'milossundicwebdeveloper@gmail.com';
	
	//sender
	$from = 'crm@eduscape.com';
	$fromName = 'Eduscape CRM';
	
	//email subject
	$subject = "SQL Backup | ". date('d-m-y');
	
	//attachment file path
	$file = $mysqlExportPath;
	
	//email body content
	$htmlContent = '<p>SQL Backup | '. date('d-m-y').'</p>';
	
	//header for sender info
	$headers = "From: $fromName"." <".$from.">";
	
	//boundary 
	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
	//headers for attachment 
	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
	
	//multipart boundary 
	$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
	"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
	
	//preparing attachment
	if(!empty($file) > 0){
	    if(is_file($file)){
	        $message .= "--{$mime_boundary}\n";
	        $fp =    @fopen($file,"rb");
	        $data =  @fread($fp,filesize($file));
	
	        @fclose($fp);
	        $data = chunk_split(base64_encode($data));
	        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
	        "Content-Description: ".basename($file)."\n" .
	        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
	        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	    }
	}
	$message .= "--{$mime_boundary}--";
	$returnpath = "-f" . $from;
	
	//send email
	$mail = @mail($to, $subject, $message, $headers, $returnpath); 
	
	if($mail){
		$log = fopen('public_html/crmbackupLog.txt', 'a');
		$txt = "[".date('c')."][".$file."] sucessfuly send!\n";
		fwrite($log, $txt);
		fclose($log);
		unlink($file);
	}else{
		$log = fopen('backupLog.txt', 'a');
		$txt = "[".date('c')."] Backup file [.$file.] failed to send!\n";
		fclose($log);
		fwrite($log, $txt);
	}

break;
case 1:
echo 'An error occurred when exporting <b>' .$mysqlDatabaseName .'</b> zu '.getcwd().'/' .$mysqlExportPath .'</b>';
break;
case 2:
echo 'An export error has occurred, please check the following information: <br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
break;
}
	
//recipient
	
