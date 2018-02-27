<?php
/*
Description: Code for the website search form.
*/
?>

<form method="get" action="https://stars.library.ucf.edu/do/search/" id="sidebar-search">
  <fieldset>      
    <label for="search" class="sr-only">Search </label>          
    <div class="input-group">
      <input class="form-control" type="text" name="q" class="search" id="search" placeholder="Search Collection">
      <input name="fq" type="hidden" value="virtual_ancestor_link:&quot;https://stars.library.ucf.edu/diversefamilies&quot;">
      <span class="input-group-btn">  
        <button type="submit" class="btn btn-default" name="query" value="Search"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Search</span></button>
      </span>        
    </div>     
  </fieldset>
</form>
