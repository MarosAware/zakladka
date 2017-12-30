
function makexmllhttp() {
   var xmlhttp =  false;
   try {
      //for other browsers
      xmlhttp = new XMLHttpRequest();
   } catch (err) {
      try {
         //for some IE version browser
         xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (err) {
         try {
            //for other IE browser
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (err) {
            xmlhttp = false;
         }
     }
   }

   return xmlhttp;
}


//XMLhttp test
function add_new_url() {
    var xmlhttp = makexmllhttp(); //it's make new instance of XMLHttpRequest for proper browser
    var file = "includes/add_url.php"; //this is file in the server executed when request send

    var parametrs = "url="+ encodeURI(document.getElementsByName('input_url')[0].value)
    +"&opis="+document.getElementsByName('input_opis')[0].value 
    +"&add_url="+document.getElementsByName('add_url')[0].value;

    //async: true (asynchronous) or false (synchronous)
    xmlhttp.open("POST", file, true);
    //one of required Header when send in POST
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    

    xmlhttp.onreadystatechange = function() {
    	if (this.readyState == 4 ) { //when operation complete
    		if(this.status == 200) { // when status OK
    			document.getElementById("demo").innerHTML =
    			this.responseText;
    		}
    	}
    	else {
    		document.getElementById("demo").innerHTML = '<img src="includes/images/ajax-ladowanie.gif"/>';
    	}
    	
    };

    xmlhttp.send(parametrs);
}



//funkcja toggle bierze za parametr element DOM ktory ja wywoluje w momencie klikniecia
function toggle(source) {
// kazdy checkbox jest brany do zmiennej 'checkboxes' i jest w niej przechowywany w formie tablicy
  checkboxes = document.getElementsByName('del_tab[]');
  // petla wywoluje sie tyle razy ile elementow 'checkboxes';
  for(var i=0, n=checkboxes.length;i<n;i++) {
  	// dla kazdego jednego elementu z osobna jest nadawana wartosc 'source.checked' czyli, wartosc pochodzaca od elementu wywolujacego o atrybucie 'checked',
  	// ktory w momencie klikniecia na element (a wiec jest zaznaczony) przyjmuje wartosc true, a po ponownym kliknieciu (odznacza go) przyjmuje wartosc false.
    checkboxes[i].checked = source.checked;
  }
}

// function active(elem) {

//      var a = document.getElementsByTagName('a');
//     //loop through all 'a' elements
//     for (i = 0; i < a.length; i++) {
//         // Remove the class 'active' if it exists
//         a[i].classList.remove('active');
//     }
//     //add 'active' classs to the element that was clicked
//      elem.classList.add('active');
//   }



