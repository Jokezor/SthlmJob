
<!DOCTYPE html>
<html lang="se">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<script type="text/javascript" src="zenscroll-latest/zenscroll-min.js"></script>
<title>Intro</title>
</head>

<body>
<div class="topnav"  id="myTopnav">
  <a href="#contact" class="navigators">Kontakt</a>
  <a href="#register" class="navigators">Registrera</a>
  <a href="#about" class="navigators">Om Oss</a>
  <a href="#home" class="navigators">Hem</a>
  <a href="#home" class="h1">Intro</a>
</div>

<a id="home" class="smooth"></a>
<div class="page1" id="page1">
  <div class="introduction">Välkommen till Intro
	<div class="subintro">Hitta ditt drömjobb</div> </div>
</div>

<div class="page2" id="page2">
  <a id="about" class="smooth"></a>
  <div class ="Om">
    Om Tjänsten
  </div>

</div>


<div class="smooth" id="page3">
   <a id="register" class="smooth"></a>
    <div class = "space">
    </div>
    <div class ="Reg">
      Registrera Din Profil
    </div>
    <div id = "registerform">
       <div id='errorMessages'>
         <p id='nameError'></p>
         <p id='addressError'></p>
         <p id='emailError'></p>
         <p id='fileError'></p>
         <p id='passwordError'></p>
         <p id='passwordError1'></p>
         <p id='passwordError2'></p>
       </div>
       <div class ="formTable">
         <?php include "formtable.php" ?>
       </div>
    </div>
</div>


<div class="page4" id="page4">
   <a id="contact" class="smooth"></a>
  <div class ="Cont">
    Kontakta Oss På
    <?php include "showEntriesInDB.php" ?>
  </div>
</div>

<script language='javascript' type='text/javascript'>
var email = document.getElementById("mail");
email.addEventListener("input", function (event) {
  if (email.validity.typeMismatch) {
    email.setCustomValidity("Ogiltig mailadress");
  } else {
    email.setCustomValidity("");
  }
});
</script>

<script language='javascript' type='text/javascript'>
    function checkIfPasswordsEqual(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Lösenorden stämmer ej överens');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
</script>


<script language='javascript' type='text/javascript'>
    function checkIfPasswordValid(input) {
      var numbers = /[0-9]/g;
      var lowerCaseLetters = /[a-z]/g;
      var upperCaseLetters = /[A-Z]/g;

      if (input.value.length < 8) {
         input.setCustomValidity('Minst åtta tecken');
      }
      else if(!input.value.match(numbers)) {
         input.setCustomValidity('Minst en siffra');
      }
      else if(!input.value.match(lowerCaseLetters) && !input.value.match(upperCaseLetters)) {
         input.setCustomValidity('Minst en bokstav');
      }
      else{
      // input is valid -- reset the error message
      input.setCustomValidity('');
      }
    }
</script>

</body>
</html>
