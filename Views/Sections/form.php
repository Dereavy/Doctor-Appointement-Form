<div class="section form">
<div class="formblue">
	<div class="formwrap container">
		<div class="row">
			<div class="formleft col-sm-12 col-md-6">
				<h1>By Over 6000 patients<br>Trust us with their sweet love</h1>
				<p>Blanditiis praesentium voluptatum delniti atque corrupti quos dlores quas
				molestias excepturi sint occaecati cupiditate non provident siili sunt in culpa qui
				officia deserAccusamus et iusto odio dignissimos ducimus qui blanditiis
				praesentium corrupti quos dolores et quas. </p>
				 <a href="#" class="form-getquote">Get a Quote</a> 
			</div>
			<div class="formright col-sm-12 col-md-6 float-right">
				<!-- Form généré par php -->
				<?php
				$form = new Form();
				if(
					isset($_POST["name"])&&
					isset($_POST["email"])&&
					isset($_POST["day"])&&
					isset($_POST["time"])&&
					isset($_POST["doctor"])&&
					isset($_POST["message"])
				){ 
					function isEmpty($input){
						if($input==""){return true;}
						return false;
					}
					if(
						isEmpty($_POST["name"])&&
						isEmpty($_POST["email"])&&
						isEmpty($_POST["day"])&&
						isEmpty($_POST["time"])&&
						isEmpty($_POST["doctor"])&&
						isEmpty($_POST["message"])
						){
					}else{
						$name=$_POST["name"];
						$email=$_POST["email"];
						$day=$_POST["day"];
						$time=$_POST["time"];
						$doctor=$_POST["doctor"];
						$message=$_POST["message"];

						isEmpty($name)?$form->emptyField("name"):$form->verify("name", $name);
						isEmpty($email)?$form->emptyField("email"):$form->verify("email", $email);
						isEmpty($day)?$form->emptyField("day"):$form->verify("day", $day);
						isEmpty($time)?$form->emptyField("time"):$form->verify("time", $time);
						isEmpty($doctor)?$form->emptyField("doctor"):$form->verify("doctor", $doctor);
						isEmpty($message)?$form->emptyField("message"):$form->verify("message", $message);
					}
				}
				$form->displayForm();
				?>
				<!-- Fin Form généré par php -->
			</div>
		</div>
	</div>
</div>
</div>
