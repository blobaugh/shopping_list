<div class="controls">
	<label>Click to Filter:</label>

	<button class="filter" data-filter="all">All</button>

	<?php
	foreach( $terms as $t ) {
		echo '<button class="filter" data-filter=".' . $t->slug . '" style="margin-left:5px;">';
		echo $t->name;
		echo '</button>';
	}
	?>

	<!--<br/>
	<label>Sort:</label>
  
	<button class="sort" data-sort="myorder:asc">Asc</button>
	<button class="sort" data-sort="myorder:desc">Desc</button>
-->
</div>
