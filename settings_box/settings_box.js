$(document).ready(function () {
	
	var ColorLink = $("#colors a"),
		SettingsBoxLink = $("#layout a,#colors a"),
		LayoutLight = $("#light"),
		LayoutDark = $("#dark"),
		oSettingsBox = $(".settings_box"),
		oSettingsBoxWidth = oSettingsBox.outerWidth(),
		HTML = $("html");

	oSettingsBox.css({left: -oSettingsBoxWidth});

	$("#panel_toggler").click(function () {
		if ( parseInt(oSettingsBox.css("left")) < 0) {
			oSettingsBox.animate({left: "0"}, 500);
		}
		else {
			oSettingsBox.animate({left: -oSettingsBoxWidth}, 500);
		}
	});

	ColorLink.click(function () {
		/*localStorage.setItem('ValueHref', $(this).attr("data-href"));
		localStorage.setItem('ColorButtonId', $(this).attr("id"));*/

		$("link.colors_style").attr("href" , $(this).attr("data-href"));

		if (!$(this).hasClass('current')) {
			ColorLink.filter('.current').removeClass('current');
			$(this).addClass('current');
		}
		else {
			$(this).removeClass('current');
		}
	});

	LayoutDark.click(function () {
		HTML.addClass("dark-layout");
	});

	LayoutLight.click(function () {
		if ( HTML.hasClass("dark-layout")) {
			HTML.removeClass("dark-layout");
		};
	});

	SettingsBoxLink.click(function () {
		oSettingsBox.animate({left: -oSettingsBoxWidth}, 500);
	});

	/*function isLocalStorageAvailable() {
		try {
			return 'localStorage' in window && window['localStorage'] !== null;
		} catch (e) {
			return false;
		}
	}

	var locStorage = localStorage.getItem('ValueHref');

	if ( locStorage !== null ) {
		$("link.colors_style").attr("href" , localStorage.getItem('ValueHref'));
		 ColorLink.removeClass('current');
		$('#' + localStorage.getItem('ColorButtonId')).addClass('current');
	};*/
});