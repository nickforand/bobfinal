<?php
/* Sample code to open a plain text file */

$debug = false;

if(isset($_GET["debug"])){
    $debug = true;
}

$myFileName="registration";

$fileExt=".csv";

$filename = $myFileName . $fileExt;

if ($debug) print "\n\n<p>filename is " . $filename;

$file=fopen($filename, "r");

/* the variable $file will be empty or false if the file does not open */
if($file){
    if($debug) print "<p>File Opened</p>\n";
}

/* the variable $file will be empty or false if the file does not open */
if($file){
    
    if($debug) print "<p>Begin reading data into an array.</p>\n";

    /* This reads the first row, which in our case is the column headers */
    $headers=fgetcsv($file);
    
    if($debug) {
        print "<p>Finished reading headers.</p>\n";
        print "<p>My header array<p><pre> "; print_r($headers); print "</pre></p>";
    }
    /* the while (similar to a for loop) loop keeps executing until we reach 
     * the end of the file at which point it stops. the resulting variable 
     * $records is an array with all our data.
     */
    while(!feof($file)){
        $records[]=fgetcsv($file);
    }
    
    //closes the file
    fclose($file);
    
    if($debug) {
        print "<p>Finished reading data. File closed.</p>\n";
        print "<p>My data array<p><pre> "; print_r($records); print "</pre></p>";
    }
} // ends if file was opened
    $chance = 0;
    $frank = 0;
    $kayne = 0;
/* display the data */

foreach ($records as $oneRecord) {
    if ($oneRecord[6] = "chance")   //the eof would be a "" 
    {
         print "<p>Vote for Chance</p>";   
        $chance += 1;
    }       
    if ($oneRecord[6] = "frank")   //the eof would be a "" 
    {
     print "<p>Vote for frank</p>";   
        $frank += 1;
    }
    if ($oneRecord[6] = "kayne")   //the eof would be a "" 
    {
        $kayne += 1;
        print "<p>Vote for kayne</p>";   
    }
       
    }
print "<p>Votes for Chance: </p>";
print $chance;
print "<p>Votes for Frank: </p>";
print $frank;
print "<p>Votes for Kayne: </p>";
print $kayne;


?>

