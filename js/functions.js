// Inputs du formulaire

var radioSalle1 = document.getElementById("1");
var radioSalle2 = document.getElementById("2");
var radioSalle3 = document.getElementById("3");
var radioSalle4 = document.getElementById("4");
var radioSalle5 = document.getElementById("5");
var radioSalle6 = document.getElementById("6");
var radioSalle7 = document.getElementById("7");
var radioSalle8 = document.getElementById("8");
var radioSalle9 = document.getElementById("9");
var radioSalle10 = document.getElementById("10");
var service = document.getElementById("textService");
var date = document.getElementById("date");
var intitule = document.getElementById("intitule");
var nbPers = document.getElementById("nbpers");
var radioFormation = document.getElementById("radioFormation");
var radioReunion = document.getElementById("radioReunion");
var textDemandeur = document.getElementById("textDemandeur");
var textIntervenant = document.getElementById("textIntervenant");
var radioOuiEcran = document.getElementById("ouiEcran");
var radioNonEcran = document.getElementById("nonEcran");
var textAnnonce = document.getElementById("inputAnnonce");
var heureDebut = document.getElementById("heureDebut");
var heureFin = document.getElementById("heureFin");
var CbElu = document.getElementById("elu");
var CbExt = document.getElementById("ext");
var CbPerso = document.getElementById("perso");
var CbCafe = document.getElementById("cafe");
var CbTea = document.getElementById("tea");
var CbEau = document.getElementById("eau");
var CbBuffet = document.getElementById("buffetPresta");
var CbRien = document.getElementById("rien");
var cbConf = document.getElementById("conference");
var cbCarre = document.getElementById("carre");
var cbRonde = document.getElementById("ronde");
var cbBuffetDispo = document.getElementById("buffetDispo");
var cbAutre = document.getElementById("autre");
var textAutre = document.getElementById("autreText");
var cbPC = document.getElementById("pc");
var cbAutreMateriel = document.getElementById('autreMateriel');
var nbOrdis = document.getElementById("nbordis");
var radioOuiInternet = document.getElementById("ouiInternet");
var radioNonInternet = document.getElementById("nonInternet");
var CH_salle = document.getElementById("CHsalle");
var CB_salle = document.getElementById("CBsalle");
var CH_participant = document.getElementById("CHparticipant");
var CB_participant = document.getElementById("CBparticipant");
var CH_logistique = document.getElementById("CHlogistique");
var CB_logistique = document.getElementById("CBlogistique");
var CH_presta = document.getElementById("CHpresta");
var CB_presta = document.getElementById("CBpresta");
var btnSubmit = document.getElementById("btnForm");
var textAutreMateriel = document.getElementById('textAutreMateriel');

// Fonctions
function InputAnnonce() {
  // Affiche une zone de texte pour rentre une annonce si le bouton est coché
  if (radioOuiEcran.checked) {
    textAnnonce.disabled = false;
  } else {
    textAnnonce.value = "";
    textAnnonce.disabled = true;
  }
}

function Confirm() {
  // Fonction qui fait un pop avant de soumettre ou de réinitialiser le formulaire
  var popUpConfirm = confirm("Voulez-vous continuer ?");
  if (popUpConfirm == true) {
    document.forms[0].submit();
    btnSubmit.class = "btn btn-success";
    btnSubmit.value = "Envoyer le formulaire";
  } else {
  }
}

function HideOthers() {
  if (CbRien.checked) {
    CbCafe.disabled = true;
    CbTea.disabled = true;
    CbEau.disabled = true;
    CbBuffet.disabled = true;
    CbCafe.checked = false;
    CbTea.checked = false;
    CbEau.checked = false;
    CbBuffet.checked = false;
  } else {
    CbCafe.disabled = false;
    CbTea.disabled = false;
    CbEau.disabled = false;
    CbBuffet.disabled = false;
  }
  if (CbCafe.checked || CbEau.checked || CbTea.checked || CbBuffet.checked) {
    CbRien.checked = false;
    CbRien.disabled = false;
  }
}

function EnableCheckPresta() {
  if (CbElu.checked || (CbExt.checked && nbPers.value >= 20)) {
    CbRien.checked = false;
    CbRien.disabled = false;
    CbCafe.disabled = false;
    CbTea.disabled = false;
    CbEau.disabled = false;
    CbBuffet.disabled = false;
  } else {
    CbRien.disabled = false;
    CbCafe.disabled = true;
    CbTea.disabled = true;
    CbEau.disabled = true;
    CbBuffet.disabled = true;
    CbCafe.checked = false;
    CbTea.checked = false;
    CbEau.checked = false;
    CbBuffet.checked = false;
  }
}

function EnableTextAutreDisposition() {
  // Fait apparaître une zone de texte pour que l'utilisateur entre son autre disposition
  if (cbAutre.checked) {
    textAutre.disabled = 0;
  } else {
    textAutre.value = "";
    textAutre.disabled = 1;
  }
}

function detailsMateriels() {
  // Fait apparaitres des champs spécifiques à l'ordinateur lorsque celui ci est coché
  if (cbPC.checked) {
    nbOrdis.disabled = 0;
    radioOuiInternet.disabled = false;
    radioNonInternet.disabled = false;
  } else {
    nbOrdis.value = "";
    nbOrdis.disabled = 1;
    radioOuiInternet.checked = false;
    radioNonInternet.checked = false;
    radioOuiInternet.disabled = true;
    radioNonInternet.disabled = true;
  }
}
function nouveauMateriel() {
  // fait apparaitre la zone de texte lorsque l'utilisateur souhaite entrer un nouveau matériel
  if (cbAutreMateriel.checked) {
    textAutreMateriel.disabled=false;
  } else {
    textAutreMateriel.value= "";
    textAutreMateriel.disabled=true;
  }
}
function Affiche() {
  var d1 = new Date("01/01/2019 12:30:00");
  var d2 = new Date("01/01/2019 " + heureDebut.value + ":00");
  // Fonction qui permet l'affichage progressif du formulaire afin de simplifier son utilisation et éviter des erreurs
  if (radioReunion.checked || radioFormation.checked) {
    // les inputs radio/checkbox et les inputs text/number sont séparés --> Sinon valeur de vérité alterée
    if (
      service.value != "" &&
      textIntervenant.value != "" &&
      textDemandeur.value != "" &&
      nbPers != "" &&
      intitule.value != "" &&
      heureDebut.value != "" &&
      heureFin.value != ""
    ) {
      CH_salle.hidden = false;
      CB_salle.hidden = false;
      if (
        radioSalle1.checked ||
        radioSalle2.checked ||
        radioSalle3.checked ||
        radioSalle4.checked ||
        radioSalle5.checked ||
        radioSalle6.checked ||
        radioSalle7.checked ||
        radioSalle8.checked ||
        radioSalle9.checked ||
        radioSalle10.checked
      ) {
        CH_participant.hidden = false;
        CB_participant.hidden = false;
        if (CbElu.checked || CbExt.checked) {
          if (radioNonEcran.checked) {
            CH_logistique.hidden = false;
            CB_logistique.hidden = false;
            if (
              cbConf.checked ||
              cbCarre.checked ||
              cbRonde.checked ||
              cbBuffetDispo.checked
            ) {
              // Les prestations sont accessibles pour les élus et les participants extérieurs à n'importe quelle heure de la journée
              CH_presta.hidden = false;
              CB_presta.hidden = false;
              if (
                CbCafe.checked ||
                CbTea.checked ||
                CbEau.checked ||
                CbBuffet.checked ||
                CbRien.checked
              ) {
                // Prestations(s) choisie(s), fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
            if (cbAutre.checked && textAutre.value != "") {
              // Les prestations sont accessibles pour les élus et les participants extérieurs à n'importe quelle heure de la journée
              CH_presta.hidden = false;
              CB_presta.hidden = false;
              if (
                CbCafe.checked ||
                CbTea.checked ||
                CbEau.checked ||
                CbBuffet.checked ||
                CbRien.checked
              ) {
                // Prestations(s) choisie(s), fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
          }
          if (radioOuiEcran.checked && textAnnonce.value != "") {
            CH_logistique.hidden = false;
            CB_logistique.hidden = false;
            if (
              cbConf.checked ||
              cbCarre.checked ||
              cbRonde.checked ||
              cbBuffetDispo.checked
            ) {
              // Les prestations sont accessibles pour les élus et les participants extérieurs à n'importe quelle heure de la journée
              CH_presta.hidden = false;
              CB_presta.hidden = false;
              if (
                CbCafe.checked ||
                CbTea.checked ||
                CbEau.checked ||
                CbBuffet.checked ||
                CbRien.checked
              ) {
                // Prestations(s) choisie(s), fin du formulaire
                btnSubmit.onclick = Confirm();
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
            if (cbAutre.checked && textAutre.value != "") {
              // Les prestations sont accessibles pour les élus et les participants extérieurs à n'importe quelle heure de la journée
              CH_presta.hidden = false;
              CB_presta.hidden = false;
              if (
                CbCafe.checked ||
                CbTea.checked ||
                CbEau.checked ||
                CbBuffet.checked ||
                CbRien.checked
              ) {
                // Prestations(s) choisie(s), fin du formulaire
                btnSubmit.onclick = Confirm();
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
          }
        }
        if (CbPerso.checked) {
          if (radioNonEcran.checked) {
            CH_logistique.hidden = false;
            CB_logistique.hidden = false;
            if (
              cbConf.checked ||
              cbCarre.checked ||
              cbRonde.checked ||
              cbBuffetDispo.checked
            ) {
              if (nbPers.value >= 20 && d1.getTime() > d2.getTime()) {
                // Si il y a plus de 20 participants venant du personnel et que c'est le matin, on affiche les prestas
                // Le premier janvier ne signifie rien, il est là que pour la comparaison utilisant la classe "Date"
                CH_presta.hidden = false;
                CB_presta.hidden = false;
                if (
                  CbCafe.checked ||
                  CbTea.checked ||
                  CbEau.checked ||
                  CbBuffet.checked ||
                  CbRien.checked
                ) {
                  // Prestations(s) choisie(s), fin du formulaire
                  btnSubmit.onclick = Confirm();
                } else {
                  // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                  btnSubmit.onclick = Confirm();
                }
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
            if (cbAutre.checked && textAutre.value != "") {
              if (nbPers.value >= 20 && d1.getTime() > d2.getTime()) {
                // Si il y a plus de 20 participants venant du personnel et que c'est le matin, on affiche les prestas
                // Le premier janvier ne signifie rien, il est là que pour la comparaison utilisant la classe "Date"
                CH_presta.hidden = false;
                CB_presta.hidden = false;
                if (
                  CbCafe.checked ||
                  CbTea.checked ||
                  CbEau.checked ||
                  CbBuffet.checked ||
                  CbRien.checked
                ) {
                  // Prestations(s) choisie(s), fin du formulaire
                  btnSubmit.onclick = Confirm();
                }
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
          }
          if (radioOuiEcran.checked && textAnnonce.value != "") {
            CH_logistique.hidden = false;
            CB_logistique.hidden = false;
            if (
              cbConf.checked ||
              cbCarre.checked ||
              cbRonde.checked ||
              cbBuffetDispo.checked
            ) {
              if (nbPers.value >= 20 && d1.getTime() > d2.getTime()) {
                // Si il y a plus de 20 participants venant du personnel et que c'est le matin, on affiche les prestas
                // Le premier janvier ne signifie rien, il est là que pour la comparaison utilisant la classe "Date"
                CH_presta.hidden = false;
                CB_presta.hidden = false;
                if (
                  CbCafe.checked ||
                  CbTea.checked ||
                  CbEau.checked ||
                  CbBuffet.checked ||
                  CbRien.checked
                ) {
                  // Prestations(s) choisie(s), fin du formulaire
                  btnSubmit.onclick = Confirm();
                }
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
            if (cbAutre.checked && textAutre.value != "") {
              if (nbPers.value >= 20 && d1.getTime() > d2.getTime()) {
                // Si il y a plus de 20 participants venant du personnel et que c'est le matin, on affiche les prestas
                // Le premier janvier ne signifie rien, il est là que pour la comparaison utilisant la classe "Date"
                CH_presta.hidden = false;
                CB_presta.hidden = false;
                if (
                  CbCafe.checked ||
                  CbTea.checked ||
                  CbEau.checked ||
                  CbBuffet.checked ||
                  CbRien.checked
                ) {
                  // Prestations(s) choisie(s), fin du formulaire
                  btnSubmit.onclick = Confirm();
                }
              } else {
                // L'utilisateur n'a pas accès aux prestations, c'est la fin du formulaire
                btnSubmit.onclick = Confirm();
              }
            }
          }
        }
      }
    }
  }
}
