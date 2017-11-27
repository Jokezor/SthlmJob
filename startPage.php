<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://github.com/kswedberg/jquery-smooth-scroll/blob/master/jquery.smooth-scroll.min.js"></script>
<script>
$('.smooth').on('click', function() {
    $.smoothScroll({
        scrollElement: $('body'),
        scrollTarget: '#' + this.id
    });

    return false;
});
</script>

<html lang="se">

<head>
<style>
h1 {
    color: #125186;
    margin-left: 0%;
    margin-top: 0%;
}
</style>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<div class="topnav"  id="myTopnav">
  <a href="#contact">Kontakt</a>
  <a href="#register">Registrera</a>
  <a href="#about" class="smooth">Om Oss</a>
  <a href="#home" class="smooth">Hem</a>

</div>
 <h1> Intro </h1>
<a id="home" class="smooth"></a>
<div class="page1" id="page1">
  <div class="introduction">Välkommen till Intro
	<div class="subintro">Hitta ditt drömjobb</div> </div>
</div>

</head>
<title>Intro</title>


<body>

<a id="about" class="smooth"></a>
<div class="page2" id="page2">
  <a id="about" class="smooth"></a>
  <div class ="Om">
    Om Tjänsten
  </div>

</div>

<a id="register" class="smooth"></a>
<div class="page3" id="page3">
    <div class ="Reg">
      Registrera Din Profil
    </div>
    <div id='errorMessages' class="formErrors">
       <p id='nameError'></p>
       <p id='addressError'></p>
       <p id='emailError'></p>
       <p id='passwordError'></p>
    </div>
    <div class ="formTable">
      <?php include "formtable.php"?>
    </div>
</div>
<?php /*include "checkFormEntries.php"*/ ?>


<a id="contact" class="smooth"></a>
<div class="page4" id="page4">
  <div class ="Cont">
    Kontakta Oss På
    <?php include "showEntriesInDB.php" ?>
  </div>
</div>

</body>
</html>
