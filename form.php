<?php
        include("top.php");

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";



//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf; 


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$firstName="";
$lastName = "";
$email = "";
$album = "Cadillactica";
$jcole = false;
$kendrick = false;
$drake = false;
$future = "chance";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$albumERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
 $dataRecord = array();

$mailed=false; // have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

   //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    } 
            
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    
    

    $firstName = htmlentities($_POST["txtFirstName"],ENT_QUOTES,"UTF-8");
    $lastName = htmlentities($_POST["txtLastName"],ENT_QUOTES,"UTF-8");
    $album = htmlentities($_POST["lstAlbums"],ENT_QUOTES,"UTF-8");
    
    $dataRecord[]=$firstName;
    $dataRecord[] =$lastName;
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord [] = $album;
    if (isset($_POST["chkJcole"])) {
    $jcole = true;}
    else {
    $jcole = false;}
    $dataRecord[] = $jcole;
    if (isset($_POST["chkKendrick"])) {
    $kendrick = true;}
    else {
    $kendrick = false;}
    $dataRecord[] = $kendrick;
    if (isset($_POST["chkDrake"])) {
    $drake = true;}
    else {
    $drake = false;}
    $dataRecord[] = $drake;
   
    $future = htmlentities($_POST["radFuture"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $future; 
    


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
   // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
    
        
    if($lastName==""){
   $errorMsg[]="Please enter your last name";
   $lastNameERROR = true;
}elseif(!verifyAlphaNum($lastName)){
   $errorMsg[]="Your last name appears to have extra characters.";
   $lastNameERROR = true;
}       
    if($firstName=="")
        {
   $errorMsg[]="Please enter your first name";
   $firstNameERROR = true;
    }
    elseif(!verifyAlphaNum($firstName)){
   $errorMsg[]="Your first name appears to have extra characters.";
   $firstNameERROR = true;
}   
        
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }   
       
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
   //
    // 
   //
     if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
       //
        // SECTION: 2e Save Data
        //
        // 
            $fileExt = ".csv";
        $myFileName = "data/registration";
        $filename = $myFileName . $fileExt;
        if ($debug)
            print "\n\n<p>filename is " . $filename;
        // now we just open the file for append
        $file = fopen($filename, 'a');
        // write the forms informations
        fputcsv($file, $dataRecord);
        // close the file
        fclose($file);
        

        

        

        
            

        
        

        
        

        
        

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Form submitted. Information recorded is as follows.</h2>';

        foreach ($_POST as $key => $value) {

            $message .= "<p>";

            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
                
            
       //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Hip Hop News You Can Use <noreply@nforand.w3.uvm.edu>";
        
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Completion of Hip-hop Form: " . $todaysDate;
        
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
      } // end form is valid
    
} // ends if form was submitted.
    
//#############################################################################
//
// SECTION 3 Display Form
//
?>

<body>
    <h1>Sign up for Email Updates!</h1>
    <?php
        //####################################
    //
    // SECTION 3a.
    //
    // 
    // 
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";

        if (!$mailed) {
            print "not ";
        }
        
    print "been processed</h1>";

   print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<p>Mail Message:</p>";
        
        print $message;  
    } else {


        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form

    if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
            
            
        //####################################
        //
        // SECTION 3c html Form
        //
       /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.


          

          
          
         */
        ?>
    
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">

            <fieldset class="wrapper">
                <legend>Register Today</legend>
                <p>We'll keep you up to date on everything you need to know!</p>

                <fieldset class="wrapperTwo">
                    <legend>Please complete the following form</legend>

                    <fieldset class="contact">
                        <legend>Contact Information</legend>
                        
                            
                                   
                                   
                                   
                                   
                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                    value="<?php print $firstName; ?>"
                                    tabindex="100" maxlength="45" placeholder="Enter your first name"
                        <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                        onfocus="this.select()"
                    autofocus>
</label>           
                      <label for="txtLastName" class="required">Last Name
<input type="text" id="txtLastName" name="txtLastName"
       value="<?php print $lastName; ?>"
       tabindex="110" maxlength="45" placeholder="Enter your last name"
       <?php if ($lastNameERROR) print 'class="mistake"'; ?>
       onfocus="this.select()">
</label>  
                        
                        <label for="txtEmail" class="required">Email 
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="nforand@uvm.edu"
                                   tabindex="120" maxlength="45" placeholder="Enter a valid email address"
                        <?php if ($emailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()">
                                   
                        </label>
                        <fieldset class="contact">
                        <legend>Opinion Questions</legend>
                        <fieldset  class="listbox">	
                        <label for="lstAlbums">Favorite Album of 2014</label>
                        <select id="lstAlbums" 
                        name="lst" 
                        tabindex="130" >
                        <option <?php if($album=="Cadillactica") print " selected "; ?>
                              value="Cadillactica">Cadillactica - Big K.R.I.T</option>
        
                        <option <?php if($album=="Oxymoron") print " selected "; ?>
                               value="Oxymoron" >Oxymoron - Schoolboy Q</option>
        
        <option <?php if($album=="Run the Jewels 2") print " selected "; ?>
            value="Run the Jewels 2" >Run the Jewels 2 - Run the Jewels</option>
    </select>
</fieldset>
                <fieldset class="checkbox">
                <legend>Which of the following artists have had the best release of this year so far?</legend>
                <label><input type="checkbox" 
                  id="chkJcole" 
                  name="chkJcole" 
                  value="jcole"
                  <?php if ($jcole) print ' checked '; ?>
                  tabindex="140">J. Cole</label>

                <label><input type="checkbox" 
                  id="chkKendrick" 
                  name="chkKendrick" 
                  value="kendrick"
                  <?php if ($cskendrick) print ' checked '; ?>
                  tabindex="150">Kendrick Lamar</label>
                <label><input type="checkbox" 
                  id="chkDrake" 
                  name="chkDrake" 
                  value="drake"
                  <?php if ($drake) print ' checked '; ?>
                  tabindex="160">Drake</label>
                
                </fieldset>
                <fieldset class="radio">
                    <legend>Who's next release are you most excited for?</legend>
                    <label><input type="radio" 
                    id="radFutureFrank" 
                    name="radFuture" 
                    value="frank"
                    <?php if($future=="frank") print 'checked'?>
                        tabindex="200">Frank Ocean</label>
                <label><input type="radio" 
                  id="radFuture" 
                  name="radFutureKanye" 
                  value="kanye"
                  <?php if($future=="kanye") print 'checked'?>
                  tabindex="210">Kanye West</label>
                <label><input type="radio" 
                  id="radFutureChance" 
                  name="radFuture" 
                  value="chance"
                  <?php if($future=="chance") print 'checked'?>
                  tabindex="220">Chance the Rapper / The Social Experiment</label>
                </fieldset>
                    </fieldset> <!-- ends contact -->
                    
                </fieldset> <!-- ends wrapper Two -->
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
                
            </fieldset> <!-- Ends Wrapper -->
        </form>

    <?php
    } // end body submit 
    ?>
 <nav>
<?php
include ("nav.php");
?>
    </nav>
    <footer>
        <?php
include ("footer.php");
?>
  
    </footer>
</body>


</html>
        
