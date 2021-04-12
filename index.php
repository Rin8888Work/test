<?php
 require('api.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{margin:0; padding: 0;}
    img{max-width: 100%;}
    .wrap{width: 100%; max-width: 1300px; margin: 0 auto; position: relative; padding: 50px 0;}
    .product_list{display:grid; grid-template-columns: repeat(3, 1fr); grid-gap: 20px;}
    .product_item, .image_zoom{position: relative; cursor: pointer;  }
    .product_item{height: 100%;}
    .product_item img, .image_zoom, .image_zoom_init{width: 100%; height: 100%; object-fit:cover;}
    .product_control{position: absolute; right: 20px; top: 20px; z-index: 3;}
    .product_control p{background: rgba(0,0,0,0.3); width: 50px; height: 50px; border-radius: 50%; color: white; font-size: 35px; font-weight: bold; display: flex; align-items: center; justify-content: center;  transition: all .3s ease;  cursor: pointer; margin: 0;}
    .product_control p:hover{background: rgba(0,0,0,0.9);}
    .presential{position: fixed; width: 100%; height: 100%; background:  rgba(0,0,0,0.6); top:0; z-index: 999; transition: all .3s ease; opacity: 0; visibility: hidden;}
    .presential_show{opacity: 1; visibility: visible;}
    .modal_zoom {transition: all .4s ease; display: block;position: fixed;max-width: 960px; max-height: 800px;visibility: hidden;-webkit-backface-visibility: hidden;backface-visibility: hidden;z-index: 1000;}
    .modal_zoom.add_content{background: white;}
    .modal_zoom.is_visible{visibility: visible;-webkit-backface-visibility: visible;backface-visibility: visible; }
    </style>
</head>
<body>
  <div class="wrap">
    <div class="product_list">
      <?php foreach($response_data as $k => $v){?>
        <div class="product_item">
          <div class="image_zoom">
            <div class="image_zoom_init image_modal_<?=$v->id?>">
                <img src="<?=$v->download_url?>"  title=""/>
            </div>
          </div>
          <div class="product_control">
            <p 
              class="zoom_animate" 
              data-zoom="<?=$v->id?>" data-place="image_modal_<?=$v->id?>" 
              data-info="<?=$v?>"
            >+</p>
          </div>
        </div>
      <?php }?>
    </div>
  </div>
  <div class="presential"></div>
  <div class="modal_zoom">

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(".zoom_animate").on("click", function(){
      var indexZoom = $(this).data('zoom');
      var data = $(this).data('info');
      let place = $(this).data('place');
      var topOpen= $('.' + place).offset().top- $(window).scrollTop();
      var leftOpen = $('.' + place).offset().left;
      $(".modal_zoom").css({left: leftOpen,top: topOpen});
      $(this).html('...');
      setTimeout(() => {
        showModal();
        $(this).html('+');
      }, 500);

      function showModal(){
      $(".presential").addClass("presential_show");
      $(".presential").attr("place", place);
      $(".modal_zoom").addClass("is_visible add_content");
      $(".modal_zoom").animate({left: '50%', top: '50%'});
      $(".modal_zoom").css({transform: 'translate(-50%, -50%)'});
    }

      $.ajax({
      type: "POST",
      url: "ajax_modal.php",
      data: {data: data}
      }).done(function (data) {
        $(".modal_zoom").html(data);
      });

      return false;
    });

    $("body").on("click", ".presential", function(){
      let place = $(this).attr('place');
      var widthClose = $('.' + place).width();
      var topClose = $('.' + place).offset().top - $(window).scrollTop();
      var leftClose = $('.' + place).offset().left;
      $(this).removeClass("presential_show");
      $(".modal_zoom").removeClass("is_visible add_content");
      $(".modal_zoom").css({width: widthClose, top: topClose, left: leftClose, transform: 'translate(0, 0)'});
    });
  </script>
</body>
</html>
