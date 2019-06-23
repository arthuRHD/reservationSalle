<?php
require "./includes/functions.php";
startSession();
if (isset($_POST['session'])) {
  Logout();
}
$validations = $_POST['valid'] ?? null;
?>
<!DOCTYPE html>
<html>
<!-- Créateur : Arthur RICHARD -->
<!-- Site : http://richardinfo.tk -->
<!-- Email : arthur.richard2299@gmail.com -->
<!-- LinkedIn : https://www.linkedin.com/in/arthur-richard-884645176/ -->

<head>
  <meta charset='utf-8' />  
  <meta http-equiv="refresh" content="600;./index.php">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.png" type="image/png">
  <link rel="icon" sizes="32x32" href="favicon-32.png" type="image/png">
  <link rel="icon" sizes="64x64" href="favicon-64.png" type="image/png">
  <link rel="icon" sizes="96x96" href="favicon-96.png" type="image/png">
  <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
  <link href='./packages/core/main.css' rel='stylesheet' />
  <link href='./packages/bootstrap/main.css' rel='stylesheet' />
  <link href='./packages/timegrid/main.css' rel='stylesheet' />
  <link href='./packages/daygrid/main.css' rel='stylesheet' />
  <link href='./packages/list/main.css' rel='stylesheet' />
  <link href="./css/contextMenu.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/calendar.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src='./packages/core/main.js'></script>
  <script src='./packages/core/locales-all.js'></script>
  <script src='./packages/interaction/main.js'></script>
  <script src='./packages/bootstrap/main.js'></script>
  <script src='./packages/daygrid/main.js'></script>
  <script src='./packages/timegrid/main.js'></script>
  <script src='./packages/list/main.js'></script>
  <script src="./packages/google-calendar/main.js"></script>
  <script src='./js/theme-chooser.js'></script>
  <script src="//code.jquery.com/jquery.js"></script>
  <title>Planning</title>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./js/contextMenu.js"></script>
  <?php 
  if (isset($_GET['delete'])) {
    if ($_GET['delete']==1) {
      echo "<script>alert('La réservation a été supprimée ! ');</script>";
    } else {
      echo "<script>alert('La suppression a échoué ! ');</script>";
    }
  }
  if (isset($_GET['modif'])) {
    if ($_GET['modif']==1) {
      echo "<script>alert('La réservation a été modifiée ! ');</script>";
    } else {
      echo "<script>alert('La modification a échoué ! ');</script>";
    }
  }
  ?>  
  <script>  
  $( document ).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
  });
  function createCookie(name, value, days) {
  var expires;
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();
  } else {
   expires = "";
  }
  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}
function momentDay(date) {
  moment(date).format('LLLL');
  moment(date).locale('fr');
  var jour = moment(date).isoWeekday();
  return jour;
}
function formatHour(date) {
  var heure = moment(date).format('LT');
  return heure;
}
    document.addEventListener('DOMContentLoaded', function() {
          var initialLocaleCode = 'fr';
          var localeSelectorEl = document.getElementById('locale-selector');
          var calendarEl = document.getElementById('calendar');          
          var calendar;

          initThemeChooser({

            init: function(themeSystem) {
              calendar = new FullCalendar.Calendar(calendarEl, {
                  plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                  themeSystem: themeSystem,
                  header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                  },
                  defaultDate: Date.now(),
                  defaultView: 'dayGridMonth',
                  nowIndicator: true,
                  locale: initialLocaleCode,
                  weekNumbers: true,
                  minTime: "07:00:00",
                  navLinks: true,
                  <?php if (isset($_SESSION['user']) && giveRightsAccueil($_SESSION['user'])) {
                  echo 'editable: true,';
                  echo 'droppable: true,';
                  echo 'revert: true, ';
                  } else {
                  echo 'editable: false,';
                  }?>                 
                  eventLimit: true,
                  events: [
                    <?php foreach (event() as $infos) {
                      $stuff = getMateriel($infos['Id']);
                      $prestations = getPresta($infos['Id']);
                      if ($infos['validation'] == 0) {
                        ?> {
                            id: "<?php echo $infos['Id'] ?>",                            
                            start: "<?php echo $infos['start'] ?>",
                            <?php if (isset($infos['repeatWeek'])&&$infos['repeatWeek']==1) { ?>                                                
                            daysOfWeek: [ momentDay('<?php echo $infos['start'];?>') ],
                            startTime: formatHour("<?php echo $infos['start'] ?>"),
                            startRecur: "<?php echo $infos['start'] ?>",
                            stopTime: formatHour('<?php echo $infos['end'] ?>'),
                            <?php } ?>
                            end: "<?php echo $infos['end'] ?>",
                            color: 'lightgrey',
                            textColor: 'black',
                            borderColor: 'red',
                            <?php if (isset($infos['allDay'])&&$infos['allDay']==1) { ?>
                            allDay: true,
                            <?php } else {?>
                            allDay: false,
                            <?php }  if ($infos['validationPresta'] == 0) { ?>
                            title: "NON VALIDÉE" + "\n" + "<?php echo $infos['typeReservation'] ?>" + "\n" + "<?php echo $infos['title'] ?>" + "\n" + "\n" + "<?php echo $infos['nomIntervenant'] ?>" + "\n" + "<?php echo $infos['libelle'] ?>" + "\n" + "<?php echo $infos['nbPers'] ?> personnes" + "\n" + "Disposition de la salle : <?php echo $infos['Libelle']?>"+ "\n" +"Participants : <?php echo $infos['typeParticipants'] ?>" + "\n" + "Prestations : NON VALIDÉE "+"\n "+"Matériels: "<?php foreach ($stuff as $value) { ?>+" ["+"<?php if ($value['libelle'] != "Ordinateur") {echo $value['libelle'];echo ']"';} else {echo $value['libelle'];echo '(quantité : ';echo $value['nbOrdis'];echo ',';if ($value['internet'] == 1) {echo 'internet requis)]';echo '"';} else {echo 'internet non-requis)]';echo '"';}}} ?>,
                            <?php } else { ?>
                            title: "NON VALIDÉE" + "\n" + "<?php echo $infos['typeReservation'] ?>" + "\n" + "<?php echo $infos['title'] ?>" + "\n" + "\n" + "<?php echo $infos['nomIntervenant'] ?>" + "\n" + "<?php echo $infos['libelle'] ?>" + "\n" + "<?php echo $infos['nbPers'] ?> personnes" + "\n" + "Disposition de la salle : <?php echo $infos['Libelle']?>"+ "\n" +"Participants : <?php echo $infos['typeParticipants'] ?>" + "\n" + "Prestations : "<?php foreach ($prestations as $value) { ?> + "[" + "<?php echo $value['libelle'];echo ']"';} ?>+"\n "+"Matériels: "<?php foreach ($stuff as $value) { ?>+" ["+"<?php if ($value['libelle'] != "Ordinateur") {echo $value['libelle'];echo ']"';} else {echo $value['libelle'];echo '(quantité : ';echo $value['nbOrdis'];echo ',';if ($value['internet'] == 1) {echo 'internet requis)]';echo '"';} else {echo 'internet non-requis)]';echo '"';}}} ?>,
                            <?php } ?>
                          },
                        <?php } else { ?> {
                            start: "<?php echo $infos['start'] ?>",
                            end: "<?php echo $infos['end'] ?>",
                            <?php if (isset($infos['repeatWeek'])&&$infos['repeatWeek']==1) { ?>                                                
                            daysOfWeek: [ momentDay('<?php echo $infos['start'];?>') ],
                            startTime: formatHour("<?php echo $infos['start'] ?>"),
                            startRecur: "<?php echo $infos['start'] ?>",
                            stopTime: formatHour('<?php echo $infos['end'] ?>'),
                            <?php } ?>
                              id: "<?php echo $infos['Id'] ?>",
                              <?php if ($infos['libelle'] == "Salle des mariages (les 3 salles)") { ?>
                                color: "pink",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salon d'Honneur") { ?>
                                color: "gold",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle des Commissions") { ?>
                                color: "forestgreen",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle du Conseil Municipal (les 2 salles)") { ?>
                                color: "red",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle du Conseil") { ?>
                                color: "purple",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle Louise A. Boyd") { ?>
                                color: "lightblue",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle des Fêtes") { ?>
                                color: "orange",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle Rosalind Franklin") { ?>
                                color: "teal",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle Bleue") { ?>
                                color: "blue",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Bureau d'Acceuil") { ?>
                                color: "wheat",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Grande salle Ambroise Croizat") { ?>
                                color: "olive",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Petite salle Ambroise Croizat") { ?>
                                color: "darkolivegreen",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Grenier du petit bois") { ?>
                                color: "rosybrown",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Château d’eau") { ?>
                                color: "steelblue",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Marcel Lods") { ?>
                                color: "orchid",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Maison citoyenne Gadeau de Kerville") { ?>
                                color: "salmon",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Maison citoyenne Ferdinand Buissons") { ?>
                                color: "lightsalmon",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Maison des Associations") { ?>
                                color: "darkslategray",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Rez-de-chaussée (CMS Bernard Lawday)") { ?>
                                color: "peachpuff",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Salle Jaune (CMS Bernard Lawday)") { ?>
                                color: "yellow",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Ecoles maternelle Jean Rostand") { ?>
                                color: "seagreen",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "École élémentaire publique Jean Rostand") { ?>
                                color: "seagreen",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "École Franklin Raspail") { ?>
                                color: "sienna",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Ecoles Maternelle Jean Jaurès") { ?>
                                color: "plum",
                              <?php } ?>
                              <?php if ($infos['libelle'] == "Ecole Maternelle Jules Michelet") { ?>
                                color: "darkslateblue",
                              <?php } ?>
                              <?php if ($infos['allDay']==1) { ?>
                                allDay: true,
                               <?php } else {?>
                                allDay: false,
                                <?php } if ($infos['validationPresta'] == 0) { ?>
                                title: "[<?php echo $infos['typeReservation'] ?> <?php echo $infos['libelleService']?>]" + "\n" + "<?php echo $infos['title'] ?>" + "\n" + "\n" + "<?php echo $infos['nomIntervenant'] ?>" + "\n" + "<?php echo $infos['libelle'] ?>" + "\n" + "<?php echo $infos['nbPers'] ?> personnes" + "\n" + "Disposition de la salle : <?php echo $infos['Libelle']?>"+ "\n" + "Participants : <?php echo $infos['typeParticipants'] ?>" + "\n" + "Prestations : NON VALIDÉE "<?php foreach ($prestations as $value) { ?> + "[" + "<?php echo $value['libelle'];echo ']" ';} ?>+"\n"+"Matériels: "<?php foreach ($stuff as $value) { ?>+" ["+"<?php if ($value['libelle'] != "Ordinateur") {echo $value['libelle'];echo ']"';} else {echo $value['libelle'];echo '(quantité : ';echo $value['nbOrdis'];echo ',';if ($value['internet'] == 1) {echo 'internet requis)]';echo '"';} else {echo 'internet non-requis)]';echo '"';}}} ?>,
                            <?php } else { ?>
                                title: "[<?php echo $infos['typeReservation'] ?> <?php echo $infos['libelleService']?>]" + "\n" + "<?php echo $infos['title'] ?>" + "\n" + "\n" + "<?php echo $infos['nomIntervenant'] ?>" + "\n" + "<?php echo $infos['libelle'] ?>" + "\n" + "<?php echo $infos['nbPers'] ?> personnes" + "\n" + "Disposition de la salle : <?php echo $infos['Libelle']?>"+ "\n" +"Participants : <?php echo $infos['typeParticipants'] ?>" + "\n" + "Prestations : VALIDÉE "<?php foreach ($prestations as $value) { ?> + "[" + "<?php echo $value['libelle'];echo ']" ';} ?>+"\n"+"Matériels: "<?php foreach ($stuff as $value) { ?>+" ["+"<?php if ($value['libelle'] != "Ordinateur") {echo $value['libelle'];echo ']"';} else {echo $value['libelle'];echo '(quantité : ';echo $value['nbOrdis'];echo ',';if ($value['internet'] == 1) {echo 'internet requis)]';echo '"';} else {echo 'internet non-requis)]';echo '"';}}} ?>,
                            <?php } ?>
                                },
                          <?php }
                      } ?>                                
                      ],
                      eventClick: function(info) {
                        var debut = moment(info.event.start).format('LLLL');
                        var fin = moment(info.event.end).format('LLLL'); // pas de risques pour la prochaine mise à jour de moment.js car le format de la date est YYYY-MM-DD HH:mm
                        moment(fin).locale('fr');
                        moment(debut).locale('fr');
                        if (info.event.allDay == true || info.event.daysOfWeek != null) {
                          var str = info.event.title + '\n' + "Horaire de début : " + debut;
                        } else {
                          var str = info.event.title + '\n' + "Horaire de début : " + debut + '\n' + "Horaire de fin : " + fin;
                        }
                        alert(str);                        
                      },
                      eventMouseEnter: function(info) {
                        <?php 
                        if (isset($_SESSION['user']) && giveRightsAccueil($_SESSION['user'])) {
                        ?>
                        var contextmenu = new ContextMenu();
                        var LinkModif = document.getElementById("hrefModif");
                        var LinkSuppr = document.getElementById("hrefSuppr");                   
                        LinkModif.href = "/pages/modification.php/";
                        LinkSuppr.href = "/includes/suppression.php/";
                        LinkModif.onclick = createCookie("IdReservation",info.event.id,"10");
                        LinkSuppr.onclick = createCookie("IdReservation",info.event.id,"10");
                        <?php } ?>
                      }, 
                      eventDrop: function(info) {
                        var dow = info.event.daysOfWeek;
                        var start = info.event.start; 
                        var end = info.event.end; 
                        var allDay = info.event.allDay;
                        start = moment(start).toISOString();
                        end = moment(end).toISOString();
                        moment(start).locale('fr');
                        moment(end).locale('fr');
                        var heure = start.getHours();
                        var start = start.setHours(heure + 2);
                        if (allDay==true) {
                          allDay=1;
                        } else {
                          allDay=0;
                        }
                        if (dow==null) {
                          dow=0
                        }
                        var Id = info.event.id;
                        console.log(start);
                        console.log(info.oldEvent.end);
                        console.log(end);
                        console.log(dow);
                        console.log(allDay);
                        console.log(Id);
                        $.ajax({
                            url: './includes/update_time.php',
                            method: 'post',
                            data: {dow : dow , start : start , end : end, allDay : allDay , Id : Id},
                            success: function(response) {
                              var alertYes = "<div id='alertYes' class='alert alert-success alert-dismissible fade show' role='alert'><strong>Félicitations !</strong> la modification des horaires a fonctionnée</div>"
                              $("#calendar").append(alertYes);
                              $("#alertNo").remove();
                              console.log(response);
                            },
                            error: function(response) {
                              var alertNo = "<div id='alertYes' class='alert alert-success alert-dismissible fade show' role='alert' hidden><strong>Erreur</strong> la modification des horaires n'a pas fonctionnée</div>"
                              $("#calendar").append(alertNo);
                              $("#alertYes").remove();
                              console.log(response);
                            }
                        })
                      },/* 
                      eventResize: function(info) { 
                        var dow = info.event.daysOfWeek;
                        var start = info.event.start; 
                        var end = info.event.end; 
                        var allDay = info.event.allDay;
                        var Id = info.event.id;
                        start = moment(start).toISOString();
                        end = moment(end).toISOString();
                        moment(start).locale('fr');
                        moment(end).locale('fr');
                        if (allDay==true) {
                          allDay=1;
                        } else {
                          allDay=0;
                        }
                        if (dow==null) {
                          dow=0
                        }
                        console.log(start);
                        console.log(end);
                        console.log(dow);
                        console.log(allDay);
                        console.log(Id);
                        $.ajax({
                            url: './includes/update_time.php',
                            method: 'post',
                            data: {dow : dow , start : start , end : end, allDay : allDay , Id : Id},
                            success: function(response) {
                              var alertYes = "<div id='alertYes' class='alert alert-success alert-dismissible fade show' role='alert'><strong>Félicitations !</strong> la modification des horaires a fonctionnée</div>"
                              $("#calendar").append(alertYes);
                              $("#alertNo").remove();
                              console.log(response);
                            },
                            error: function(response) {
                              var alertNo = "<div id='alertYes' class='alert alert-success alert-dismissible fade show' role='alert' hidden><strong>Erreur</strong> la modification des horaires n'a pas fonctionnée</div>"
                              $("#calendar").append(alertNo);
                              $("#alertYes").remove();
                              console.log(response);
                            }
                        })
                      },*/
                      eventRender: function(info) {
                        if (info.event.end == null) {
                          str = info.event.title + "\n" + "Début : " + info.event.start;
                        } else {
                          str = info.event.title + "\n" + "Début : " + info.event.start + "\n" + "Fin : " + info.event.end;
                        }
                        info.el.setAttribute("data-toggle","tooltip");
                        info.el.setAttribute("title",str);
                      }
                    });

                  calendar.render();

                },
                change: function(themeSystem) {
                  calendar.setOption('themeSystem', themeSystem);
                }
              });
          });
          moment.locale('fr', {
            months: 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
            monthsShort: 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
            monthsParseExact: true,
            weekdays: 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
            weekdaysShort: 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
            weekdaysMin: 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
            weekdaysParseExact: true,
            longDateFormat: {
              LT: 'HH:mm',
              LTS: 'HH:mm:ss',
              L: 'DD/MM/YYYY',
              LL: 'D MMMM YYYY',
              LLL: 'D MMMM YYYY HH:mm',
              LLLL: 'dddd D MMMM YYYY HH:mm'
            },
            calendar: {
              sameDay: '[Aujourd’hui à] LT',
              nextDay: '[Demain à] LT',
              nextWeek: 'dddd [à] LT',
              lastDay: '[Hier à] LT',
              lastWeek: 'dddd [dernier à] LT',
              sameElse: 'L'
            },
            relativeTime: {
              future: 'dans %s',
              past: 'il y a %s',
              s: 'quelques secondes',
              m: 'une minute',
              mm: '%d minutes',
              h: 'une heure',
              hh: '%d heures',
              d: 'un jour',
              dd: '%d jours',
              M: 'un mois',
              MM: '%d mois',
              y: 'un an',
              yy: '%d ans'
            },
            dayOfMonthOrdinalParse: /\d{1,2}(er|e)/,
            ordinal: function(number) {
              return number + (number === 1 ? 'er' : 'e');
            },
            meridiemParse: /PD|MD/,
            isPM: function(input) {
              return input.charAt(0) === 'M';
            },
            meridiem: function(hours, minutes, isLower) {
              return hours < 12 ? 'PD' : 'MD';
            },
            week: {
              dow: 1,
              doy: 4
            }
          });

          function triSalle() {
            var events = document.getElementsByClassName('fc-event');
            var mariage = document.getElementById('mariages');
            var honneur = document.getElementById('honneur');
            var bleue = document.getElementById('bleue');
            var conseilMuni = document.getElementById('conseilMuni');
            var conseil = document.getElementById('conseil');
            var louise = document.getElementById('louise');
            var commission = document.getElementById('commissions');
            var fetes = document.getElementById('fetes');
            var rosalind = document.getElementById('rosalind');
            var accueil = document.getElementById('accueil');
            var toutes = document.getElementById('toutes');
            var notValid = document.getElementById('notValid');
           /* var Ga_c = document.getElementById('Ga_c');
            var Pa_c = document.getElementById('Pa_c');
            var petitbois = document.getElementById('petitbois');
            var chateau = document.getElementById('chateau');
            var lods = document.getElementById('lods');
            var MC_kerville = document.getElementById('MC_kerville');
            var MC_buissons = document.getElementById('MC_buissons');
            var assoc = document.getElementById('assoc');
            var CMS_rez = document.getElementById('CMS_rez');
            var CMS_jaune = document.getElementById('CMS_jaune');
            var rostand = document.getElementById('rostand');
            var jaures = document.getElementById('jaures');
            var raspail = document.getElementById('raspail');
            var michelet = document.getElementById('michelet');
            if (toutes.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                event.hidden = false;
              }
            }
            if (michelet.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "darkslateblue") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (raspail.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "sienna") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (jaures.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "plum") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (rostand.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "seagreen") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (CMS_jaune.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "yellow") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (CMS_rez.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "peachpuff") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (assoc.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "darkslategray") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (MC_buissons.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "lightsalmon") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (MC_kerville.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "salmon") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (lods.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "orchid") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (chateau.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "steelblue") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (petitbois.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "rosybrown") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (Ga_c.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "olive") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (Pa_c.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "darkolivegreen") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }*/
            if (notValid.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "lightgray") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (mariage.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "pink") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (bleue.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "blue") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (accueil.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "wheat") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (commission.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "forestgreen") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (fetes.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "orange") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (rosalind.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "teal") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (conseil.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "purple") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (conseilMuni.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "red") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (louise.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                event.hidden = true;
                if (event.style.backgroundColor == "lightblue") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
            if (honneur.checked) {
              for (let j = 0; j < events.length; j++) {
                const event = events[j];
                if (event.style.backgroundColor == "gold") {
                  event.hidden = false;
                } else {
                  event.hidden = true;
                }
              }
            }
          
          }
          
</script>
</head>
<nav class="menu">
  <div class="left">
    <?php if (isset($_SESSION['user']) && giveRightsAccueil($_SESSION['user'])) {
      echo "<a class='btn btn-dark' href='./pages/validation.php'>Valider les réservations</a>";
    } ?>
    <?php if (isset($_SESSION['user']) && giveRightsRP($_SESSION['user'])) {
      echo "<a class='btn btn-dark' href='./pages/validationPresta.php'>Valider les prestations</a>";
    } ?>
    <a class="btn btn-dark" href="./pages/reservation.php">Réserver une salle</a>
    <a class="btn btn-primary" href="./pages/Guide.pdf" target="_blank">Doc</a>
    <?php 
    if (isset($_SESSION['user']) && giveRightsBDD($_SESSION['user'])) {
      echo "<a class='btn btn-primary' href='./includes/reset.php' target='_blank'>Vider les réservations</a>";
    }
    ?>
  </div>
  <div class="btn-group">
    <?php
    if (isAuth()) {
      $pseudo = $_SESSION['user'];
      echo "<a class='btn btn-secondary' href='#' disabled>Bonjour $pseudo</a>";
      echo "<a class='btn btn-danger' href='./includes/logout.php'>Déconnexion</a>";
    } else {
      echo "<a class='btn btn-secondary' href='./pages/login.php'>Se connecter</a>";
    }
    ?>
  </div>

<body>
<div id="context-menu" class="contextMenu">
					<ul class="contextMenu-items">						
						<li class="contextMenu-item">
							<a id="hrefModif" href="#" class="contextMenu-action" data-action="Edit" target="_blank">
								<i class="fa fa-edit"></i> Modifier</a>
						</li>
						<li class="contextMenu-item">
							<a id="hrefSuppr" href="#" class="contextMenu-action" data-action="Delete" target="_blank">
								<i class="fa fa-trash"></i> Supprimer</a>
						</li>
					</ul>
</div>
</body>
<footer>

  <div class="top" id='top'>

    <div class='left'>

      <div id='theme-system-selector' class='selector' hidden>
        Système :

        <select>
          <option value='bootstrap' selected>Bootstrap 4</option>
        </select>
      </div>
      <button class="btn btn-light btn-sm" onclick="document.getElementById('bartool').hidden=!document.getElementById('bartool').hidden;">Tri par salle</button>
      <div data-theme-system="bootstrap" class='selector' style='display:none'>
        Thème :

        <select>
          <option value=''>Default</option>
          <option value='cerulean'>Cerulean</option>
          <option value='cosmo'>Cosmo</option>
          <option value='cyborg'>Cyborg</option>
          <option value='darkly'>Darkly</option>
          <option value='flatly'>Flatly</option>
          <option value='journal'>Journal</option>
          <option value='litera'>Litera</option>
          <option value='lumen'>Lumen</option>
          <option value='lux'>Lux</option>
          <option value='materia'>Materia</option>
          <option value='minty'>Minty</option>
          <option value='pulse'>Pulse</option>
          <option value='sandstone'>Sandstone</option>
          <option value='simplex'>Simplex</option>
          <option value='sketchy'>Sketchy</option>
          <option value='slate'>Slate</option>
          <option value='solar'>Solar</option>
          <option value='spacelab'>Spacelab</option>
          <option value='superhero'>Superhero</option>
          <option value='united' selected>United</option>
          <option value='yeti'>Yeti</option>
        </select>
      </div>
      <div class='selector'>

      </div>

      <span id='loading' style='display:none'>loading theme...</span>

    </div>

    <div class='clear'></div>
  </div>
  <div class="row">
    <div class="bartool col-3" id="bartool" style="background-color : rgb(211, 211, 211);">
      <br>
      
      <ul class="slideOne" style="list-style:none;text-align:left;">
        <li>
          <h4>Les salles de la mairie</h4>          
        </li>
        <li><input type="radio" id="toutes" onclick='triSalle()' name="tri"><label for="toutes"> Toutes les salles</label></li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='notValid'><label for="notValid"> Salles en cours de validation</li>
        <li><input type="radio" id="mariages" onclick='triSalle()' name="tri"><label for="mariages"> Salle des mariages (les 3 salles)</label></li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='honneur'><label for="honneur"> Salon d'Honneur</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='commissions'><label for="commissions"> Salle des Commissions</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='conseilMuni'><label for="conseilMuni"> Salle du Conseil Municipal (les 2 salles)</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='conseil'><label for="conseil"> Salle du Conseil</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='louise'><label for="louise"> Salle Louise A. Boyd</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='fetes'><label for="fetes"> Salle des Fêtes</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='rosalind'><label for="rosalind"> Salle Rosalind Franklin</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='bleue'><label for="bleue"> Salle Bleue</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='accueil'><label for="accueil"> Bureau d'Accueil</li> <br>
        <!-- <li>
          <h4>Les salles extèrieures</h4>          
        </li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='Ga_c'><label for="Ga_c"> Grande salle Ambroise Croizat</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='Pa_c'><label for="Pa_c"> Petite salle Ambroise Croizat</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='petitbois'><label for="petitbois"> Grenier du petit bois</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='chateau'><label for="chateau"> Château d’eau</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='lods'><label for="lods"> Marcel Lods</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='MC_kerville'><label for="MC_kerville"> Maison citoyenne Gadeau de Kerville</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='MC_buissons'><label for="MC_buissons"> Maison citoyenne Ferdinand Buissons</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='assoc'><label for="assoc"> Maison des Associations</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='CMS_rez'><label for="CMS_rez"> Rez-de-chaussée (CMS Bernard Lawday)</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='CMS_jaune'><label for="CMS_jaune"> Salle Jaune (CMS Bernard Lawday)</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='rostand'><label for="rostand"> Ecoles Jean Rostand</li><li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='jaures'><label for="jaures"> Ecoles Jean Jaurès</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='raspail'><label for="raspail"> Ecoles Franklin Raspail</li>
        <li><input type='radio' onclick='triSalle()' name="tri" id='michelet'><label for="michelet"> Ecole Maternelle Jules Michelet</li> -->
      </ul>
     
    </div>
  
    

    <div class="col-9" id='calendar'></div>
    
  </div>
  </div>  
</footer>
</html>