/**
 * JavaScript logic for Switch between dark and light mode
 *
 * @team Team Pizza
 * @name darklightswitch.js
 * @usage 
 * @dateModefied 2022-02-27
 *
 * @credit Adapted from http://light-dark-mode.s3-website-us-west-2.amazonaws.com/
*/

function checkTheme(){
   var setTheme = localStorage.getItem('theme');
   if (setTheme == null) {
      swapStyleSheet('./css/light_style.css');
   }
   else {
      swapStyleSheet(setTheme);
   }
}

function swapStyleSheet(sheet) {
   document.getElementById('themestylesheet').href = sheet;
   //save preferences to local storage 
   localStorage.setItem('theme', sheet);
}

/*
//Matching HTML to go along with this function 

//link to the javascript for this file for each html file
<script src="./js/darklightswitch.js"></script>

//set theme to light mode as default, place in header of each html page
<link id = "themestylesheet" rel="stylesheet" type="text/css" href="./css/light_style.css">

//call the "checkTheme()" function when every page is loaded to check local storage for settings
//in each html body tag
<body onload="checkTheme()"> </body>

//do buttons 'sort of' like this, in settings.html page
//style of button still tbd
<button onclick="swapStyleSheet('./css/light_style.css')">Light Mode</button>
<button onclick="swapStyleSheet('./css/dark_style.css')">Dark Mode</button>
*/