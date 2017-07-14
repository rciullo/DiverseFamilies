<?php

// Website shortcodes

function books_feed( $atts, $content = null ) {
  extract(shortcode_atts( array(
      'id' => 'books_feed',
      'url' => 'http://stars.library.ucf.edu/diversefamilies-familyrelationships/bookfeed.rss',
      'number' => '5'
  ), $atts ));
  $output = '
  <div id="'.$id.'"></div>
  <script>
    $(document).ready( function() {
      diverse_families_feed("'.$id.'", "'.$url.'", '.$number.');
    });
  </script>
  ';
  return $output;
}
add_shortcode('books-feed', 'books_feed');

?>
