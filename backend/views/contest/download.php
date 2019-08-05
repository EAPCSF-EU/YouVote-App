<?php
$categories = $project->contest->categories;

$filename = $project->title.".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache"); 
header("Expires: 0");

?>
<table class='table'>
	<caption><?=$project->title;?></caption>
	<tr>
		<th>Time</th>
		<?php 
			foreach ($categories as $key => $value) {
				echo "<th>".$value->title."</th>";
			}
		?>

	</tr>
	<?php
	
				foreach($voters as $voter){
					echo "<tr>";
					echo "<td>".$voter['created_at']."</td>";
					foreach ($categories as $category2) {
						foreach($votes as $vote){
							if($voter['user_id'] == $vote->user_id 
								&& $category2->id == $vote->category_id){
								echo "<td>".$vote->score."</td>";
								break;
							}
						}
					}
					echo "</tr>";
				}
	?>
</table>

<? exit(); ?>