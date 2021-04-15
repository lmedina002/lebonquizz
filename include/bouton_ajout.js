i=1;

function AjoutRep()
{
var lab = document.createElement("LABEL");
lab.for = 'rep';
lab.innerHTML = "Réponse n°" + i;
lab.className = 'rep' + i;

var input = document.createElement("INPUT");
input.type = 'text';
input.name = 'rep' + i;
input.required = true;
input.className = 'rep' + i;

var veracite = document.createElement("LABEL");
veracite.for = 'veracite' + i;
veracite.innerHTML = '  Véracité de la réponse:  ';
veracite.className = 'rep' + i;

var labvraie = document.createElement("LABEL");
labvraie.for = 'vraie' + i;
labvraie.innerHTML = '  Vraie  ';
labvraie.className = 'rep' + i;

var vraie = document.createElement("INPUT");
vraie.type = 'radio';
vraie.id = 'vraie' + i;
vraie.name = 'veracite' + i;
vraie.value = 'vraie';
vraie.required = true;
vraie.className = 'rep' + i;

var labfaux = document.createElement("LABEL")
labfaux.for = 'faux' + i;
labfaux.innerHTML = '  Fausse  ';
labfaux.className = 'rep' + i;

var faux = document.createElement("INPUT");
faux.type = 'radio';
faux.id = 'faux' + i;
faux.name = 'veracite' + i;
faux.value = 'faux';
faux.className = 'rep' + i;		

var br = document.createElement("BR");
br.className = 'rep' + i;

var parentNode = document.getElementById('formu');

parentNode.insertBefore(lab, document.getElementById('ajout'));
parentNode.insertBefore(input, document.getElementById('ajout'));
parentNode.insertBefore(veracite, document.getElementById('ajout'));
parentNode.insertBefore(labvraie, document.getElementById('ajout'));
parentNode.insertBefore(vraie, document.getElementById('ajout'));
parentNode.insertBefore(labfaux, document.getElementById('ajout'));
parentNode.insertBefore(faux, document.getElementById('ajout'));
parentNode.insertBefore(br, document.getElementById('ajout'));

i += 1;
}

function SupprimeRep()
{
	i -= 1;
	console.log(i);
	var rep = document.getElementsByClassName('rep'+ i)
	var parentNode = document.getElementById('formu');

	for (var k = rep.length - 1; k >= 0 ; k--) {
		console.log(rep[k]);
		parentNode.removeChild(rep[k]);
	}
}

function AjoutRepRemplie(contenu, ver)
{
var lab = document.createElement("LABEL");
lab.for = 'rep';
lab.innerHTML = "Réponse n°" + i;
lab.className = 'rep' + i;

var input = document.createElement("INPUT");
input.type = 'text';
input.name = 'rep' + i;
input.required = true;
input.className = 'rep' + i;
input.value = contenu;

var veracite = document.createElement("LABEL");
veracite.for = 'veracite' + i;
veracite.innerHTML = '  Véracité de la réponse:  ';
veracite.className = 'rep' + i;

var labvraie = document.createElement("LABEL");
labvraie.for = 'vraie' + i;
labvraie.innerHTML = '  Vraie  ';
labvraie.className = 'rep' + i;

var vraie = document.createElement("INPUT");
vraie.type = 'radio';
vraie.id = 'vraie' + i;
vraie.name = 'veracite' + i;
vraie.value = 'vraie';
vraie.required = true;
vraie.className = 'rep' + i;

var labfaux = document.createElement("LABEL")
labfaux.for = 'faux' + i;
labfaux.innerHTML = '  Fausse  ';
labfaux.className = 'rep' + i;

var faux = document.createElement("INPUT");
faux.type = 'radio';
faux.id = 'faux' + i;
faux.name = 'veracite' + i;
faux.value = 'faux';
faux.className = 'rep' + i;

if(ver == "vraie") {
	vraie.checked = true;
	faux.checked = false;
}
else {
	faux.checked = true;
	vraie.checked = false;		
}

var br = document.createElement("BR");
br.className = 'rep' + i;

var parentNode = document.getElementById('formu');

parentNode.insertBefore(lab, document.getElementById('ajout'));
parentNode.insertBefore(input, document.getElementById('ajout'));
parentNode.insertBefore(veracite, document.getElementById('ajout'));
parentNode.insertBefore(labvraie, document.getElementById('ajout'));
parentNode.insertBefore(vraie, document.getElementById('ajout'));
parentNode.insertBefore(labfaux, document.getElementById('ajout'));
parentNode.insertBefore(faux, document.getElementById('ajout'));
parentNode.insertBefore(br, document.getElementById('ajout'));

i+=1;
}