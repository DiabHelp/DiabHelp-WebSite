$(window).load(function() {

	// carousel index page
  $('.flexslider').flexslider({
    animation: "slide",
    slideshow: true,
		controlNav: false,
		prevText: "",
		nextText: "",
      start: function(){
          $('#home-slider .descr').removeClass('slideLeft');
          $('#home-slider .flex-active-slide .descr').addClass('slideLeft');
      },
      after: function(){
          $('#home-slider .descr').removeClass('slideLeft');
          $('#home-slider .flex-active-slide .descr').addClass('slideLeft');
      }
  });

  // carousel for page
  $('.flexslider_page').flexslider({
    animation: "slide",
    slideshow: true,
    controlNav: false,
    prevText: "",
    nextText: ""
  });

  // carousel article index page
  $('.slider_articles').flexslider({
    animation: "slide",
    slideshow: false,
	itemWidth: 313,
    itemMargin: 0,
    move: 1,
    minItems: 1,
		controlNav: false,
		prevText: "",
		nextText: ""
  });
    $('.slider_articles_mob').flexslider({
        animation: "slide",
        slideshow: false,
        itemWidth: 200,
        itemMargin: 0,
        move: 1,
        minItems: 1,
        controlNav: false,
        prevText: "",
        nextText: ""
    });

  // carousel gallery opened page
  $('#carousel_gallery').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 162,
    itemMargin: 6,
    asNavFor: '#slider_gallery',
    prevText: "",
    nextText: ""
  });
   
  $('#slider_gallery').flexslider({
    animation: "slide",
    controlNav: false,
    smoothHeight: true,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel_gallery",
    prevText: "",
    nextText: ""
  });

  // carousel event opened page   
  $('#slider_event').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: true,
    prevText: "",
    nextText: ""
  });

  // carousel news page   
  $('.news_item_pic').flexslider({
    animation: "slide", //String: Тип анимации, "fade" или "slide"
    slideshow: true,
    controlNav: false, //Boolean: Создание навигации для постраничного управления каждым слайдом.
    prevText: "", //String: Тест для кнопки "previous" пункта directionNav
    nextText: "",  //String: Тест для кнопки "next" пункта directionNav
  });

  // masonry index page
  $('#container').masonry({
    columnWidth: 1,
    itemSelector: '.item'
  });
  
  //load map for contacts
  loadMapScript();
});

//vote
function voteModuleView(id, note) {
	$.ajax({
		url: "./vote/"+id+"/"+note,
		dataType: "json",
		type: "GET"
	});
}

function voteModuleIndex(id, note) {
	$.ajax({
		url: "./modules/vote/"+id+"/"+note,
		dataType: "json",
		type: "GET"
	});
}

//hide show menu dropdown
function HideShowMenu(){
  $('#nav_dropdown').slideToggle();
}

function mapInit() {
    var mapOptions = {
	zoom: 15,
	center: new google.maps.LatLng(43.6128836,1.4298710),
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	disableDefaultUI: true,
	navigationControl: true,
	mapTypeControl: false,
	panControl: false,
	scrollwheel: false
  }
    var map = new google.maps.Map(document.getElementById("map_contact"), mapOptions);
}

function loadMapScript() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "https://maps.googleapis.com/maps/api/js?v=3&sensor=false&callback=mapInit";
  document.body.appendChild(script);
}

function show_signup() {
	if ($("#welogin").css("display") == "block") {
		$("#welogin").slideUp("slow", function() {
			$("#inscription").slideUp("slow");
			$("#forget").slideUp("slow");
			$("#connexion").slideDown("slow");
			$(".header").fadeTo( "slow" , 1);
			$("#content").fadeTo( "slow" , 1);
			$("footer").fadeTo( "slow" , 1);
		});
	} else {
		$("#connexion").slideDown("slow", function() {
			$("#welogin").slideDown("slow");
			$(".header").fadeTo( "slow" , 0.2);
			$("#content").fadeTo( "slow" , 0.2);
			$("footer").fadeTo( "slow" , 0.2);
			});
	}
}

function show_signup_part(where) {
	if (where == "forget") {
		$("#connexion").slideUp("slow");
		$("#forget").slideDown("slow");
	} else if (where == "signup") {
		$("#connexion").slideUp("slow");
		$("#forget").slideUp("slow");
		$("#inscription").slideDown("slow");
	} else {
		$("#inscription").slideUp("slow");
		$("#forget").slideUp("slow");
		$("#connexion").slideDown("slow");
	}
}

function submit_com_mod() {
		var texte = document.forms["comform"].elements["com"].value;
		var module_name = document.forms["comform"].elements["module_name"].value;
		$.ajax({
			url:"./src/add_com_mod.php",
			dataType: "json",
			type: "POST",
			data: {text: texte, mname : module_name}
		});
}

function submit_com_news() {
		var texte = document.forms["comform2"].elements["com"].value;
		var news_name = document.forms["comform2"].elements["news_name"].value;
		$.ajax({
			url:"./src/add_com_news.php",
			dataType: "json",
			type: "POST",
			data: {text: texte, nname : news_name}
		});
}

function bonmail(mailteste) {
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	if(reg.test(mailteste)) {
		return(true);
	} else {
		return(false);
	}
}

function show_com_content(id)
  {	
  	var elem = document.getElementById(id);
    if (elem.style.display == "none")
    {
        $(elem).slideDown("slow", function () {
			document.getElementById('button_com_react').innerHTML = 'Cacher les commentaires';
		});
    }
    else
    {
		$(elem).slideUp("slow", function () {
			document.getElementById('button_com_react').innerHTML = 'Afficher les commentaires';
		});
    }
}

function show_com_modification_form(id, id_text)
	{
		var elem = document.getElementById(id);
		var text = document.getElementById(id_text);
		if (elem.style.display == "none")
		{
			$(text).slideUp("slow", function(){
				$(elem).slideDown("slow", function(){});
			});
		}
		else
		{
			$(elem).slideUp("slow", function(){
				$(text).slideDown("slow", function(){});
			});
		}
	}

function display_info_msg(id, msg, color)
{
	$(id).html(msg);
	$(id).css("color","" + "" + color);
	$(id).css("display", "block");
}

function update_com(id)
{
	var posting = $.post("./src/update_com.php",
		{text: $("#com_change" + id).val(),
		id_com: id
	});
	posting.done(function(data){
		$("#text_com" + id).html(data);
		show_com_modification_form("modif_com_form" + id, "text_com" + id);
		display_info_msg("#com_info_msg" + id, "Commentaire édité avec succès.", "#7FFF00");
	});

	posting.error(function(){
		display_info_msg("#com_info_msg" + id, "Erreur lors de l'édition, veuillez réessayer ultérieurement.", "red");
	});
}

$('input[type="file"]').change(function() {
	if (this.files[0]) {
		var file = this.files[0];
		var fil = file.name.toLowerCase();
		var ext = fil.split('.').pop();
		var authorized = "gif png jpg jpeg";
		var n = authorized.indexOf(ext);

		if (file.size > 2 * 1048576) {
			$("#UpSub").prop('disabled', true);
			alert("Fichier trop volumineux :" + file.size + " Kb");
		} else {
			if (n == -1) {
				alert(file.name + " mauvais type de fichier. (gif, png, jpg, jpeg acceptés)");
				$("#UpSub").prop('disabled', true);
			} else
				$("#UpSub").prop('disabled', false);
		}
	}
});

$(document).ready(function() { 
    setTimeout(function() { 
        $(".notif").fadeOut(); 
	},3000);
}); 

function validate_account(name, id) {
	alert("Quel est ton nom");
}

// function getEmail() {
	// gapi.client.load('oauth2', 'v2', function() {
		// var request = gapi.client.oauth2.userinfo.get();
		// request.execute(function(resp) {	
			// if (resp['email']) {
				// return (resp['email']);
				// console.log(resp['email']);
			// } else {
				// return (-1);
			// }
		// });
	// });
// }

// var g_email;
// var g_username;

// function signinCallback(authResult) {
 	// if (authResult['access_token']) {
		// // console.log(authResult['access_token']);
		// gapi.auth.setToken( authResult );
		// gapi.client.load( 'plus', 'v1', function() {
			// var request = gapi.client.plus.people.get({'userId' : 'me'});
			// request.execute(function(resp) {
				// g_email = resp['email'];
				// g_username = resp['displayName'];
			// });
		// });
	// } else if (authResult['error']) {
		// // console.log('Une erreur s\'est produite : ' + authResult['error']);
	// }
// }

// function google_signin() {
	// $.ajax({
		// url:"src/log_google.php",
		// type: "POST",
		// data: {login: g_username, email: g_email}
	// }).success(function(data) {
		// if (data == "true") {
			// var url = location.pathname;
			// window.location.assign(url);
			// } else {
				// alert("Vous n'êtes pas connecté à google.");
			// }
	// });
// }

// (function() {
	// var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    // po.src = 'https://apis.google.com/js/client:plusone.js';
    // var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
// })();

// (function() {
    // var po = document.createElement('script');
    // po.type = 'text/javascript'; po.async = true;
    // po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
    // var s = document.getElementsByTagName('script')[0];
    // s.parentNode.insertBefore(po, s);
// })();

// function render() {
    // gapi.signin.render('customBtn', {
      // //'callback': 'signinCallback',
      // 'clientid': '841077041629.apps.googleusercontent.com',
      // 'cookiepolicy': 'single_host_origin',
      // 'requestvisibleactions': 'http://schemas.google.com/AddActivity',
      // 'scope': 'https://www.googleapis.com/auth/plus.login'
	// });
// }

// function disconnectUser(access_token) {
  // var revokeUrl = 'https://accounts.google.com/o/oauth2/revoke?token=' +
      // access_token;

  // // Exécuter une requête GET asynchrone.
  // $.ajax({
    // type: 'GET',
    // url: revokeUrl,
    // async: false,
    // contentType: "application/json",
    // dataType: 'jsonp',
    // success: function(nullResponse) {
		// window.location.assign("delete_account.php");
      // // Effectuer une action maintenant que l'utilisateur est dissocié
      // // La réponse est toujours non définie.
    // },
    // error: function(e) {
      // // Gérer l'erreur
      // // console.log(e);
      // // Orienter éventuellement les utilisateurs vers une dissociation manuelle en cas d'échec
      // // https://plus.google.com/apps
    // }
  // });
// }
// // Déclenchement possible de la dissociation lorsque l'utilisateur clique sur un bouton
// $('#revokeButton').click(disconnectUser);

function deleteAccount() {
	if (confirm("Comfirmer?") == true)
		window.location.assign("delete_account.php");
}