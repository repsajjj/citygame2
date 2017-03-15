<?php

// make a note of the current working directory, relative to root.
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

// make a note of the directory that will recieve the uploaded files
$uploadsDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'uploaded_files/';

// make a note of the location of the upload form in case we need it
$uploadForm = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'uploader.php';

// make a note of the location of the success page
$uploadSuccess = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.success.php';

// name of the fieldname used for the file in the HTML form
$fieldname = 'file';


// possible PHP upload errors
$errors = array(1 => 'php.ini max file size exceeded',
                2 => 'html form max file size exceeded',
                3 => 'file upload was only partial',
                4 => 'no file was attached');

// check the upload form was actually submitted
isset($_POST['submit'])
    or error('the upload form is neaded', $uploadForm);

// check for standard uploading errors
($_FILES[$fieldname]['error'] == 0)
    or error($errors[$_FILES[$fieldname]['error']], $uploadForm);

// Check if the file was an HTTP upload
@is_uploaded_file($_FILES[$fieldname]['tmp_name'])
    or error('not an HTTP upload', $uploadForm);  //--> REPLACE error function to new class

// Checking if the file was an image
@getimagesize($_FILES[$fieldname]['tmp_name'])
    or error('only image uploads are allowed', $uploadForm); //--> REPLACE error function to new class

// make a unique filename (Timestamp + name)
// not taken... if it is keep trying until we find a vacant one
$now = time();
while (file_exists($uploadFilename = $uploadsDirectory.$now.'-'.$_FILES[$fieldname]['name'])) {
    $now++;
}

// Move file -> upload map with new name
@move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename)
    or error('receiving directory insuffiecient permission', $uploadForm);  //--> REPLACE error function to new class

// Everything has worked and the file has been successfully saved --> Go to succes page
header('Location: ' . $uploadSuccess);

// Error handler for if the upload fails
function error($error, $location, $seconds = 5)  //--> REPLACE error function to new class
{
    header("Refresh: $seconds; URL=\"$location\"");
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'."\n".
    '"http://www.w3.org/TR/html4/strict.dtd">'."\n\n".
    '<html lang="en">'."\n".
    '	<head>'."\n".
    '		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">'."\n\n".
    '		<link rel="stylesheet" type="text/css" href="stylesheet.css">'."\n\n".
    '	<title>Upload error</title>'."\n\n".
    '	</head>'."\n\n".
    '	<body>'."\n\n".
    '	<div id="Upload">'."\n\n".
    '		<h1>Upload failure</h1>'."\n\n".
    '		<p>An error has occured: '."\n\n".
    '		<span class="red">' . $error . '...</span>'."\n\n".
    '	 	The upload form is reloading</p>'."\n\n".
    '	 </div>'."\n\n".
    '</html>';
    exit;
} // end error handler
