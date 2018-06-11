<?php

/**
 * 
 */

class Form
{
	private $formTitle="Appointment Form";
 		//Recupere list de domaines interdits de la base de données
	private $junkmail = ["yopmail", "jetable", "throwaway"];
 		//Recupere list d'horaires disponibles de la base de données
 	private $appointements=["1h20", "2h40", "4h30", "5h45","6h50"];
 		//Recupere list de docteurs disponibles de la base de données
 	private $doctors =["Dr Namet", "Dr Seomal", "Dr Lofer", "Dr Jaminu", "Dr Schnok"];

 	//Verifications
 	private $isValidName=3;
 	private $isValidEmail=3;
 	private $isValidDay=3;
 	private $isValidTime=3;
 	private $isValidDoctor=3;
 	private $isValidMessage=3;

 	//Champs
 	private $name="";
 	private $email="";
 	private $day="";
 	private $time="";
 	private $doctor="";
 	private $message="";
	private $style = 'style="1px solid red"';
	
	private $return = false;
	function __construct(){
	}

	function displayForm(){
		$formName = preg_replace('/\s+/', '', lcfirst(ucwords($this->formTitle)));
		echo('<h1>'.$this->formTitle.'</h1>'.PHP_EOL);
		if(($this->fieldCheck()=="full")&&($this->return==false)){
			echo ('<h3>Thank you, <b>'.$this->name.'</b> for contacting us, we will reply shortly</h3>'.PHP_EOL);
			echo ('<p>We will be contacting you at: <i>'.$this->email.'</i></p>'.PHP_EOL);
			echo('<p>Your appointment is set on the: <b><i>'.$this->day.'</i> at <i>'.$this->time.'</i> with <i>'.$this->doctor.'</i></b></p>'.PHP_EOL);
			echo('<p>We have recieved your message: <br><i>'.$this->message.'</i></p>'.PHP_EOL);

			//Envoi de mail: (necéssite configuration)
			/*
			$emailMessage = You have successfully made an appointment.

			$to = "adminMail@domain.com";

			$subject = "Appointment: ".$this->day." with ".$this->doctor." at ".$this->time;

			$txt = "".$this->emailMessage." - ".$this->name.":".$this->email."";

			$headers = "From: serverMail@domain.fr" . "\r\n" .
			"CC:";

			mail($to,$subject,$txt,$headers);
			*/

			echo('<a href="" class="form-getquote form-submit" onClick="refresh">Return</a>'.PHP_EOL);

			$this->return==true;
		}else{
			echo('<form name="'.$formName.'" method="POST">'.PHP_EOL);
			echo($this->displayNameInput());
			echo($this->displayEmailInput());
			echo($this->displayDayInput());
			echo($this->displayTimeInput());
			echo($this->displayDoctorInput());
			echo($this->displayMessageInput());

			if($this->fieldCheck()=="incomplete"){
				echo('<div class="veriftext">'.PHP_EOL);
					echo("Please fill in the entire form.".PHP_EOL);
			    echo('</div>'.PHP_EOL);
			}
			echo('<input class="form-getquote form-submit" type="submit" value="send">'.PHP_EOL);
			echo('</form>'.PHP_EOL);
			$this->return==false;
		}
	}

	function emptyField($field){
		if($field=="name"){$this->isValidName=0;}
		if($field=="email"){$this->isValidEmail=0;}
		if($field=="day"){$this->isValidDay=0;}
		if($field=="time"){$this->isValidTime=0;}
		if($field=="doctor"){$this->isValidDoctor=0;}
		if($field=="message"){$this->isValidMessage=0;}
	}
	function fieldCheck(){
		if(
			($this->isValidName==3) &&
			($this->isValidEmail==3) &&
			($this->isValidDay==3) &&
			($this->isValidTime==3) &&
			($this->isValidDoctor==3) &&
			($this->isValidMessage==3)
		){return "empty";}
		if(
			($this->isValidName==0) ||
			($this->isValidEmail==0) ||
			($this->isValidDay==0) ||
			($this->isValidTime==0) ||
			($this->isValidDoctor==0) ||
			($this->isValidMessage==0)
		){return "incomplete";}
		if(
			($this->isValidName==1) &&
			($this->isValidEmail==1) &&
			($this->isValidDay==1) &&
			($this->isValidTime==1) &&
			($this->isValidDoctor==1) &&
			($this->isValidMessage==1)
		){return "full";}
	}
// Verifications:
	function verify($field, $input){
		if($field=="name"){
			$this->name=$input;
			if(preg_match('/^(\w| |é|ü|ö|ê|å|ø|-)*$/', $input)){
				$this->isValidName=1;
			}else{
				$this->isValidName=0;
			}
		}
		
		if($field=="email"){
			$this->email=$input;
				foreach ($this->junkmail as $domain) {
					$test = preg_match('/\S*@'.$domain.'\.((\w{1,3})|\.){1,3}/', $this->email);
					$test = preg_match('/^[a-zA-Z0-9._-]{1,64}@'.$domain.'\.[a-zA-Z.]{2,6}$/', $this->email);
					if($test==true){
						$this->isValidEmail=0;
						return;
					}
				}
				$this->isValidEmail=1;
			
		}
		if($field=="day"){
			$this->day=$input;
			if(preg_match('/^(\d)*$/', $input)){
				if(!($input=="Day")){
					$this->isValidDay=1;
				}else{
					$this->isValidDay=0;
				}
			}else{
				$this->isValidDay=0;
			}
		}
		if($field=="time"){
			$this->time=$input;
			if(preg_match('/^(\d)*h(\d)*$/', $input)){
				if(!($input=="Time")){
					$this->isValidTime=1;
				}else{
					$this->isValidTime=0;
				}
			}else{
				$this->isValidTime=0;
			}
		}
		if($field=="doctor"){
			$this->doctor=$input;
			if(preg_match('/^(\w| |é|ü|ö|ê|å|ø|-)*$/', $input)){
				if(!($input=="Doctor")){
					$this->isValidDoctor=1;
				}else{
					$this->isValidDoctor=0;
				}
			}else{
				$this->isValidDoctor=0;
			}
		}
		if($field=="message"){
			$this->message=$input;
			if(preg_match('/^.*$/', $input)){
				$this->isValidMessage=1;
			}else{
				$this->isValidMessage=0;
			}
		}
		return true;
	}			
// Fields:
	function displayNameInput(){
		if($this->isValidName==0){
			echo('<input class="field-error col-md-12 col-xs-12" type="text" '.$this->style.' placeholder="Your name" name="name" value="'.$this->name.'"><br>'.PHP_EOL);
		}else{
			echo('<input class="col-md-12 col-xs-12" type="text" placeholder="Your name" name="name" value="'.$this->name.'"><br>'.PHP_EOL);
		}
	}

	function displayEmailInput(){
		$message="";
		if ($this->isValidEmail==0){
			echo('<input class="field-error col-md-12 col-xs-12" type="email" '.$this->style.' placeholder="Your email" id="email" name="email" value="'.$this->email.'">'.PHP_EOL);

			if(!$this->email==""){
				$message= '<p> Invalid Domain: <b>'.preg_replace('/^\S*@/', "", $this->email).'</b></p>'.PHP_EOL;
			}else{
				$message= '<p> </p>'.PHP_EOL;
			}

		}else{
			echo('<input class="col-md-12 col-xs-12" type="email" '.$this->style.' placeholder="Your email" id="email" name="email" value="'.$this->email.'">'.PHP_EOL);
		}	
		echo('<br>'.PHP_EOL);
		echo('<div class="veriftext">'.PHP_EOL);
		echo($message."");
		echo('</div>'.PHP_EOL);
	}

	function displayDayInput(){
		if($this->isValidDay==0){
			echo('<select class="field-error col-md-3 col-xs-3 mr-2 formdatetime" '.$this->style.' name="day">'.PHP_EOL);
		 	echo('<option value="Day" selected="selected">Day</option>'.PHP_EOL);
		}else{
			echo('<select class="col-md-3 col-xs-3 mr-2 formdatetime" name="day" value="'.$this->day.'">'.PHP_EOL);
			if($this->day!=""){
		 		echo('<option value="'.$this->day.'" selected="selected">'.$this->day.'</option>'.PHP_EOL);
		 	}else{
		 	echo('<option value="Day" selected="selected">Day</option>'.PHP_EOL);
			}
		}
		for ($i=1;$i<=31;$i++){
		    echo('<option id="day" name="day">'.$i.'</option>'.PHP_EOL);
		}
		echo('</select>'.PHP_EOL);
	}

	function displayTimeInput(){
		if($this->isValidTime==0){
			echo('<select class="field-error col-md-3 col-xs-3 mr-2 formdatetime" '.$this->style.' name="time" >'.PHP_EOL);
		 	echo('<option value="Time" selected="selected">Time</option>'.PHP_EOL);
		}else{
			echo('<select class="col-md-3 col-xs-3 mr-2 formdatetime" name="time" value="'.$this->time.'">'.PHP_EOL);

			if($this->time!=""){
		 		echo('<option value="'.$this->time.'" selected="selected">'.$this->time.'</option>'.PHP_EOL);
		 	}else{
		 	echo('<option value="Time" selected="selected">Time</option>'.PHP_EOL);
			}
		}
		$availableTimes= $this->appointements;

	 	for ($i=0;$i<sizeof($availableTimes);$i++){
	    	echo('<option id="time" name="time">'.$availableTimes[$i].'</option>'.PHP_EOL);
	    }
		echo('</select>'.PHP_EOL);
	}

	function displayDoctorInput(){
		if($this->isValidDoctor==0){
			echo('<select class="field-error col-md-5 col-xs-5" '.$this->style.' name="doctor">'.PHP_EOL);
		 	echo('<option value="Doctor" selected="selected">Doctor</option>'.PHP_EOL);
		}else{
			echo('<select  class="col-md-5 col-xs-5" name="doctor" option="'.$this->doctor.'">'.PHP_EOL);
			if($this->doctor!=""){
		 	echo('<option value="'.$this->doctor.'" selected="selected">'.$this->doctor.'</option>'.PHP_EOL);
			}else{
		 	echo('<option value="Doctor" selected="selected">Doctor</option>'.PHP_EOL);
			}
		}

		 	$availableDoctors= $this->doctors;

		 	for ($i=0;$i<sizeof($availableDoctors);$i++){
		    	echo('<option id="doctor" name="doctor">'.$availableDoctors[$i].'</option>'.PHP_EOL);
		    }
		echo('</select><br>'.PHP_EOL);
	}

	function displayMessageInput(){
		if($this->isValidMessage==0){
			echo('<textarea name="message" class="field-error col-md-12 col-xs-12 appointment-message" '.$this->style.' placeholder="Your Message" cols="16" rows="4"></textarea><br>'.PHP_EOL);
		}else{
			echo('<textarea name="message" class="col-md-12 col-xs-12 appointment-message" placeholder="Your Message" cols="16" rows="4" >'.$this->message.'</textarea><br>'.PHP_EOL);
		}
	}
}
