<?php

$size = sizeOrColor("sizes");
?>

<?php 
mysqli_data_seek($size, 0);
while($s = mysqli_fetch_assoc($size)): ?>
   <option value="<?=$s['size']?>"><?=$s['size']?></option>
<?php endwhile; ?>
