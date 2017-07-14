/*!
*Custom functions for the Library Wordpress Theme
*/

//COLLAPSING SIDEBAR MENU
//=======================

function expandMenus() {
    $('.sidebar-collapse .collapse').addClass('in');
    $('.sidebar-collapse .collapse').attr("aria-expanded","true");
    $('.sidebar-collapse .collapse').css('height','');
    $('.menu-toggle').attr("aria-expanded","true");
    $('.menu-toggle').removeClass('collapsed');
    $('.menu-toggle .glyphicon').removeClass("glyphicon-plus-sign").addClass("glyphicon-minus-sign");
}

function collapseMenus() {
    $('.sidebar-collapse .collapse').removeClass('in');
    $('.sidebar-collapse .collapse').attr("aria-expanded","false");
    $('.menu-toggle').attr("aria-expanded","false");
    $('.menu-toggle').addClass('collapsed');
    $('.menu-toggle .glyphicon').removeClass("glyphicon-minus-sign").addClass("glyphicon-plus-sign");
}

//Generate a random string for use in ID override
function get_random_string() {
    $text = "";
    $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 10; i++ )
        $text += $possible.charAt(Math.floor(Math.random() * $possible.length));
    return $text;
}


function collapse_sidebar(){
  
  //Collapse the sidebar menus when less than 768
  if ($(window).width() < 768){  
	collapseMenus();
	$menus_open = false;
  } else {
	$menus_open = true;
  }

  //Locate the ID of the sidebar collapse menus and give them a unique id
  $('.sidebar-collapse').each(function() {
  	$id = get_random_string();
  	$(this).find('.collapse').prop('id', $id);
  	$(this).find('.menu-toggle').prop('href', '#'+$id);
  });
  
};

$(window).resize(function(){
  if ($(window).width() >= 768 && !$menus_open){  
    expandMenus();
    $menus_open = true;
  }
  if ($(window).width() < 768 && $menus_open){  
	collapseMenus();
	$menus_open = false;
  }
});

$(document).on("hide.bs.collapse show.bs.collapse", ".collapse", function (event) {
  $(this).prev().find(".glyphicon").toggleClass("glyphicon-plus-sign glyphicon-minus-sign");
});



//Enable Tooltips
//===============
function enable_tooltips() {
    $('[data-toggle="tooltip"]').tooltip();
};

// Apply bootstrap styles to gravity forms
//========================================
function bootstrap_gravity_forms() {
  $(".gform_wrapper input:text").addClass("form-control");
  $(".gform_wrapper textarea").addClass("form-control");
  $(".gform_wrapper select").addClass("form-control");
  $(".gform_wrapper input:submit").addClass("btn btn-primary");
  $(".gform_wrapper input:radio").each(function(){
    $(this).next('label').andSelf().wrapAll('<div class="radio"/>');
  });
  // $(".gform_wrapper .clear-multi").addClass("form-inline");
};


// Scroll to Top Button
//=====================

function scroll_top_btn() {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });

    $('.scroll-top').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

};

// Share Button
//=========================================

function share_button(url, winWidth, winHeight) {
  var winTop = (screen.height / 2) - (winHeight / 2);
  var winLeft = (screen.width / 2) - (winWidth / 2);
  window.open(url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
}


// Grid / List View Toggle
//=========================================

function grid_list_toggle() {
  $('.view-button').click(function() {
    var test = $(this).children("input[name$='views']").val();
    $('.view').removeClass('view-active');
    $('#' + test + '_view').addClass('view-active');
  });
};



// Widget Area Affix
// =========================================

function widget_area_affix() {
  if ( $('#sidebar').outerHeight(true) < $('#content_area').outerHeight(true) ) {
    $('#widget-area').affix({
      offset: {
        top: function () {
          return (this.top = ( $('#ucfhb').outerHeight(true) + $('.main-header').outerHeight(true) + $('#title_bar').outerHeight(true) + 30 ) )
        },
        bottom: function () {
          return (this.bottom = ( $('footer').outerHeight(true) + 60 ) )
        }
      }
    });
  };
};


// Diverse Families Feeds
// =========================================

function diverse_families_feed(id, url, number) {
  google.load("feeds", "1");

  function initialize() {
    var feed = new google.feeds.Feed(url);
    feed.setNumEntries(number);
    feed.setResultFormat(google.feeds.Feed.MIXED_FORMAT);
    feed.load(function(result) {
      if (!result.error) {
        var $container = $('#'+ id);
        for (var i = 0; i < result.feed.entries.length; i++) {
          var entry = result.feed.entries[i];
          var $h3 = $("<h3>", {class: "title" });
          var $link = $("<a>", {class: "link" });
          $link.attr('href', entry.link);
          $link.append(entry.title);
          $h3.append($link);
          $container.append($h3);
          var $div = $("<div>", {class: "content" });
          $div.html(entry.content);
          var $img_src = $div.find('img').attr("src");
          $div.find('img').remove();
          var $img = $("<img>");
          $img.attr("src", $img_src);
          $container.append($img);
          $container.append($div);
        }
      } else {
        var $container = $('#'+ id);
        var $h3 = $("<h3>", {class: "title" });
        $h3.html('there was an error');
        $container.append($h3);          
      }
    });
  }
  google.setOnLoadCallback(initialize);
}



// Load all functions when Dom Ready
// =========================================

$(document).ready( function() {
  collapse_sidebar();
  enable_tooltips();
  bootstrap_gravity_forms();
  scroll_top_btn();
  grid_list_toggle();
  widget_area_affix();
});