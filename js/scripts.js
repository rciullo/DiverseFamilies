/*!
*Custom functions for the Library Wordpress Theme
*/

//Enable Tooltips
//===============
function enable_tooltips() {
    $('[data-toggle="tooltip"]').tooltip();
};

// Apply bootstrap styles to gtranslate
//========================================
function bootstrap_gtranslate() {
  $("#gtranslate_selector").addClass("form-control");
};

// Share Button
//=========================================

function share_button(url, winWidth, winHeight) {
  var winTop = (screen.height / 2) - (winHeight / 2);
  var winLeft = (screen.width / 2) - (winWidth / 2);
  window.open(url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
}


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
          var $book_item = $("<div>", {class: "book-item" });
          var $title = $("<span>", {class: "title" });
          var $link = $("<a>", {class: "link" });
          var $content = $("<div>", {class: "content" });
          $content.html(entry.content);
          var $img_src = $content.find('img').attr("src");
          $content.find('img').remove();
          var $img = $("<img>");
          $img.attr("src", $img_src);
          $link.attr('href', entry.link);
          $link.append($img);
          $title.append(entry.title);
          $link.append($title);
          $book_item.append($link);
          $book_item.append($content);
          $container.append($book_item);
        }
      } else {
        var $container = $('#'+ id);
        var $title = $("<h3>", {class: "title" });
        $title.html('there was an error');
        $container.append($title);          
      }
    });
  }
  google.setOnLoadCallback(initialize);
}

// function diverse_families_logo_color(){
//   var textID = document.getElementById('site_title'); // get logo ID
//   var text = textID.innerHTML; // grab text
//   var toChange = text.split(''); // separate each letter into array
//   var outputText = ''; // buffer text
//   var colorClassName = ['logo-red', 'logo-orange', 'logo-yellow', 'logo-green', 'logo-blue', 'logo-purple']; // class name that you want
//   var colorNumber = 0; // counter to loop into your class

//   for (var i=0, ii=toChange.length; i<ii; i++){
//     if(colorNumber == colorClassName.length){ // if you reach the end of your class array
//       colorNumber = 0; //Set it back to 0
//     }
//     if(toChange[i] != ' ') {
//       // Add between each letter the span with your class
//       outputText += '<span class="logo '+colorClassName[colorNumber]+'">'+toChange[i]+'<\/span>';
//       colorNumber++
//     }
//     if(toChange[i] == ' ') {
//       outputText += '<span class="logo">&nbsp;</span>';
//     }
//   }
//   // Output your text into the web
//   textID.innerHTML = outputText;
// }



// Load all functions when Dom Ready
// =========================================

$(document).ready( function() {
  bootstrap_gtranslate();
  // diverse_families_logo_color();
//  widget_area_affix();
});