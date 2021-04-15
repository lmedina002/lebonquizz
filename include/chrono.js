var compteurMin = document.getElementById("cptmin");
var compteurSec = document.getElementById("cptsec");
var leftMin = document.getElementById("minleft");
var leftSec = document.getElementById("secleft");

function diminuerCptSec() {
    
    //Diminue le compteur de minutes
    if(compteurSec.textContent == 0 && compteurMin.textContent != 0)
    {
    	var compteurM = Number(compteurMin.textContent);        
    	compteurMin.textContent = compteurM - 1;
    	compteurSec.textContent = 59;
    	leftMin.value = compteurM - 1;
    	leftSec.value = 59; 	
    }

    //Diminue le compteur de secondes
    var compteurS = Number(compteurSec.textContent);        
    compteurSec.textContent = compteurS - 1;
    leftSec.value = compteurS - 1;


    //Fin du chrono
    if(compteurSec.textContent == 0 && compteurMin.textContent == 0)
    {
    	clearInterval(temps);
    	var form = document.getElementById('form_id');
    	form.submit();
    }


}
// On diminue le compteur toutes les 1000 millisecondes
var temps = setInterval(diminuerCptSec, 1000);