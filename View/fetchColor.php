<?php

$color = sizeOrColor("colors");
?>

<?php 
mysqli_data_seek($color, 0);
while($c = mysqli_fetch_assoc($color)): ?>
   <option value="<?=$c['color_name']?>"><?=$c['color_name']?></option>
<?php endwhile; ?>
