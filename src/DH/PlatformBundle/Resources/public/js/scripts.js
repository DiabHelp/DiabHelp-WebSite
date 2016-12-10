$(window).load(function() {

	function isValidEmailAddress(emailAddress) {
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(emailAddress);
	};

	$('#reset_pwd').click(function () {
		var email = $('#fos_user_forget_pwd_form_email').val();

		$.post(server_name + "check_email_exist", { email: email },
			function (result) {
				var res = $.parseJSON(result);
				if (res.success == true)
					$('#email_exist_error').html('L\'adresse email ' + email + ' n\'est pas enregistrée, veuillez en saisir une autre.');
				else {
					$('#email_exist_error').html('');
				}
					// $('#fos_user_registration_form').submit();
			});
	});

	$('#fos_user_connexion_form_submit').click(function () {
		login();
	});

	$('#fos_user_registration_form_submit').click(function () {
		var username = $('#fos_user_registration_form_username').val();
		var email = $('#fos_user_registration_form_email').val();
		var pwd = $('#fos_user_registration_form_plainPassword_first').val();
		var pwdv = $('#fos_user_registration_form_plainPassword_second').val();
		var firstname = $('#fos_user_registration_form_firstname').val();
		var lastname = $('#fos_user_registration_form_lastname').val();


        $('.hideme').hide();

		var error = 0;
		var main_error = 0;
        $.post(server_name + "check_available", { username: username, email: email },
			function (result) {
				var res = $.parseJSON(result);
				if (res.success == false) {
					if (res.availables[0] == 0){
						$('#username_already_used').show();
						main_error++;
					}
					if (res.availables[1] == 0){
						$('#email_already_used').show();
						main_error++;
					}
					if (main_error == 0)
						$('#empty_form').show();
				} else {
					if (username.length < 2 || username.length > 25){
						$('#username_bad_lenght').show();
						error++;
					}
					if (!isValidEmailAddress(email)){
						$('#email_unvailable').show();
						error++;
					}
					if (pwd.length < 8 || pwd.length > 42){
						$('#passwords_bad_lenght').show();
						error++;
					}
					else if (pwd != pwdv){
						$('#passwords_different').show();
						error++;
					}
					if (firstname.length < 2 || firstname.length > 25 || lastname.length < 2 || lastname.length > 25){
						$('#names_bad_lenght').show();
						error++;
					}
					if (!$('#fos_user_registration_form_cgu').is(":checked")){
						$('#accept_cgu').show();
						error++;
					}
					if (error == 0 && main_error == 0)
						$('#fos_user_registration_form').submit();
				}
			});
	});

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
    animation: "slide", //String: "fade" or "slide"
    slideshow: true,
    controlNav: false, //Boolean:
    prevText: "", //String: "previous"
    nextText: "",  //String: "next"
  });

  // masonry index page
  $('#container').masonry({
    columnWidth: 1,
    itemSelector: '.item'
  });

  //load map for contacts
  loadMapScript();
});

function login() {
	var username = $('#username').val();
	var password = $('#password').val();

	$('.hideme').hide();

	var errors = 0;
	$.post(server_name + "check_email_and_username_exist", { test: username },
		function (result) {
			var res = $.parseJSON(result);
			if (res.success == false) {
				if (res.errors[0] == 1)
					$('#unknown_user').show();
				else if (res.errors[1] == 1)
					$('#account_locked').show();
				errors++;
			} else
				$.post(server_name + "../rest-login", { username: username, password: password },
					function (result) {
						var res = $.parseJSON(result);
						if (res.success == false) {
							$('#login_error').show();
							errors++;
						}
						if (errors == 0)
							$("#fos_user_connexion_form").submit();
					});
		});
}

function enter(e) {
	if (e.keyCode == 13) {
		login();
		return true;
	}
}

//vote
function voteModuleView(id, note) {
	$.ajax({
		url: "./vote/"+id+"/"+note,
		dataType: "json",
		type: "GET",
		complete : function(code_html, statut){
			location.reload();
		}
	});
}

function voteModuleIndex(id, note) {
	$.ajax({
		url: "./modules/vote/"+id+"/"+note,
		dataType: "json",
		type: "GET",
		complete : function(code_html, statut){
			location.reload();
		}
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDFMs-Ca3F9mv2r4Oa6WctxU9zzeNWy_vg&callback=mapInit";
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

function show_com_modification_form(id)
	{
		var elem = document.getElementById("modif_com_form" + id);
		var text = document.getElementById("text_com" + id);
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
	var edit_text = $("#com_change" + id).val();
	var posting = $.post("./editcomment/" + id,
		{text: edit_text}
		);
	posting.done(function(data){
		$("#text_com" + id).html(edit_text);
		show_com_modification_form(id);
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
