<?php
	$message = $this->GetRedirectMessage();
	$user = $this->GetUser();
      $site_base = $this->GetConfigValue("base_url");
      if ( substr_count($site_base, 'wikka.php?wakka=') > 0 ) $site_base = substr($site_base,0,-16);
?>
<h2><?php echo $this->config["wakka_name"] ?> : <a href="<?php echo $this->href('backlinks', '', ''); ?>" title="Display a list of pages linking to <? echo $this->tag ?>"><?php echo $this->GetPageTag(); ?></a></h2>
<div class="header">
	<?php echo $this->Link($this->config["root_page"]); ?> |
	<?php 
		if ($this->GetUser()) {
			echo $this->config["logged_in_navigation_links"] ? $this->Format($this->config["logged_in_navigation_links"]) : ""; 
		} else { 
			echo $this->config["navigation_links"] ? $this->Format($this->config["navigation_links"]) : ""; 
		} 
	?> 	
</div>
