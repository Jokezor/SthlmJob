<script type="text/javascript" src="zenscroll-latest/zenscroll-min.js">/* Needs to be at the very top */</script>

<!DOCTYPE html>
<html lang="se">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<title>Inextro</title>


<style type="text/css">
#sup,
#sub {
    height: 0;
    line-height: 1;
    vertical-align: baseline;
    _vertical-align: bottom;
    position: relative;

}

#sup {
bottom: 1ex;
}

sub {
top: .25ex;
}
</style>

</head>

<body>
<div class="topnav"  id="myTopnav">
  <a href="#contact" class="navigators">Kontakt</a>
  <a href="#about" class="navigators">Om Oss</a>
  <!--a href="#home" class="navigators">Hem</a-->
  <a href="#whyus" class="navigators">Varför Intro?</a>
  <a href="#register" class="navigators">Registrera</a>
  <a href="#home" class="h1">In<sub>≡</sub>xtro</a>
</div>

<a id="home" class="smooth"></a>
<div class="page1" id="page1">
  <div class="introduction">Välkommen till Intro
	<div class="subintro">Hitta ditt drömjobb</div> </div>
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

<div class="page5" id="page5">
   <a id="whyus" class="smooth"></a>
  <div class ="Why">
    Varför välja Intro?
    <div class="Describe">
      Vi vet av erfarenhet att det är en jobbig process att söka jobb och därför behöver du aldrig söka jobb igen. Du anger bara inom vilket område du vill jobba inom och vi matchar dig sedan mot jobbannonser direkt.
      Du anger vad du skulle vilja ha i lön samt vad du helst vill jobba med för så att du får erbjudanden du faktiskt vill ha.
      Enkelt, efter registrering så behöver du bara ladda ner vår app och logga in med det konto du registrerat och så får du notiser när du blir matchad mot ditt nya drömjobb.
      När du blivit tillfrågad om ett jobb tackar du bara ja eller nej. Om du tackar ja så kommer du direkt vidare till en intervju med våra rekryterare.
      Få personlig feedback på alla dina intervjuer.
      Att registrera dig hos oss på Intro är gratis för dig som jobbsökande.
    </div>
  </div>
</div>



<div class="page2" id="page2">
  <a id="about" class="smooth"></a>
  <div class ="Om">
    Om Intro

    Intro skapades för att vi själva har varit i sitsen som arbetssökande och rekryterare.

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
