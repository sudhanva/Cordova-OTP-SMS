<?php
include 'db.php';
if(isset($_POST['verify']))
{
	$fname=$_POST['fname']; 
	$isd=$_POST['isd'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$demo=$_POST['demo'];
	$gcm_id=$_POST['gcm_id'];
	$verifyCode = rand(1000, 9999);

	$fname = mysqli_real_escape_string($con, $fname);
	$isd = mysqli_real_escape_string($con, $isd);
	$mobile = mysqli_real_escape_string($con, $mobile);
	$email = mysqli_real_escape_string($con, $email);
	$demo = mysqli_real_escape_string($con, $demo);
	$gcm_id = mysqli_real_escape_string($con, $gcm_id);

	if($mobile == "" ||  $isd == "" ||  $email == "" ||  $fname == "") 
	{
		echo "<div class='info style=width:340px;float:left;text-align:center;'>Sorry, you have to fill in all Mandatory fields to proceed. Thanks.</div>";
		exit();
	}
	else
	{
		$sql = "SELECT * FROM registration WHERE `MobileNo` ='$mobile' and `active`= 1";
		$run_user = mysqli_query($con, $sql);  
		$check_user = mysqli_num_rows($run_user);
		if($check_user>=1)
		{
			echo "<div class='info style=width:340px;float:left;text-align:center;'>Sorry, $mobile already Exist.Thanks..</div>";
		}
		else
		{
			/*$online = file_get_contents("http://alerts.3mdigital.co.in/api/web2sms.php?workingkey=A59eda561ac9813beac4195b9dbaa86e3&sender=SRNINF&to=$mobile&message=Thank%20you%20for%20installing%20My%20Jewellery.%20OTP%20for%20completing%20your%20registration%20is%20$verifyCode.%20Visit%20http%3A%2F%2Fsharaaninfo.com%20to%20know%20more%20about%20us.");*/

			$sql="insert into registration(Name,ISDCode,MobileNo,EmailID,uuid,otp_code,gcmID,created_on,active)values
			('$fname','$isd','$mobile','$email','$demo','$verifyCode','$gcm_id',now(),0)";
			$result = mysqli_query($con,$sql);
			echo "<div class='info style=width:340px;float:left;text-align:center;'>A verification code was sent to your phone number. Please enter it below.</div>";
			?>
			<div class="list">
				<input type="hidden" id="mobile_toverify" name="mobile_toverify" value="<?php echo $mobile;?>"/>
				<div class="item">
					<input type="text" id="otp_code" name="otp_code" placeholder="OTP Code" value="" onkeyup="check_otp();"/>
				</div>
				<div class="item">
					<input type="submit" class="button button-block general_button" value="Update" onclick="verify();" style="display:none;">
				</div>
<?php
			}
		}
	}
	elseif(isset($_POST["otp_verify"]))
	{     
		$otp_code=$_POST['otp_code'];  
		$mobile_toverify=$_POST['mobile_toverify']; 
		$otp_code = mysqli_real_escape_string($con, $otp_code);
		$mobile_toverify = mysqli_real_escape_string($con, $mobile_toverify);

		if($mobile_toverify == "" ) 
		//Be sure that all the fields are filled then proceed
		{
			echo "<div class='info style=width:340px;float:left;text-align:center;'>Sorry, you have to fill in all Mandatory fields to proceed. Thanks.</div>";
		}
		else
		{       
			$sql = "SELECT otp_code FROM registration WHERE `MobileNo` ='$mobile_toverify' and `otp_code`= '$otp_code'";
			$run_user =  mysqli_query($con,$sql);  
			while($row=mysqli_fetch_array($run_user))
			{
				$db_otp = $row['otp_code'];
			}
			if(isset($db_otp) == $otp_code)
			{
				$sql="update registration set active = 1 WHERE `MobileNo` ='$mobile_toverify' and `otp_code`= '$otp_code'";
				$result = mysqli_query($con,$sql);
			/*$sql = "DELETE FROM registration WHERE `MobileNo` ='$mobile_toverify'";
			$result = mysqli_query($con,$sql);*/
			echo "<div class='info style=width:340px;float:left;text-align:center;'>Success!!!Your code has been validated</div>";
		}
		else
		{
			echo "<div class='info style=width:340px;float:left;text-align:center;'>Wrong Code!!Resend the code</div>";  
			$sql = "DELETE FROM registration WHERE `MobileNo` ='$mobile_toverify'";
			$result = mysqli_query($con,$sql);
			?>
			<div class="list">
				<div class="item">
				<input type="hidden" id="mobile_toverify_resend" name="mobile_toverify_resend" value="<?php echo $mobile_toverify;?>"/>
				<input type="submit" class="button button-block general_button" value="Resend OTP" onclick="ajax_request();">
				</div>
			</div>
			<?php
		}
	}
}
elseif(isset($_POST["session_timeout"]))
{
	$mobile=$_POST['mobile'];
	$demo=$_POST['demo'];
	//echo "<div class='info style=width:340px;float:left;text-align:center;'>Session Has been Expired</div>";  
			$sql = "DELETE FROM registration WHERE `MobileNo` ='$mobile' and `active`= 0";
			$result = mysqli_query($con,$sql);
			echo "<script type='text/javascript'>alert('Timeout!!Session Has been Expired');</script>";
}
else
{
	echo "<div class='info'>Sorry, the operation was unsuccessful.<br>Please try again or contact this website admin to report this error message if the problem persist. Thanks.</div>";
	exit();
}
?>


