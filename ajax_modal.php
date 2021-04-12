<?php
    $data = $_POST['data'];
?>

<div class="product_modal">
    <div class="image_modal">
        <img src="<?=$data->download_url?>" />
    </div>
    <div class="info_modal">
        <p><?=$data->author?></p>
    </div>
</div>