<?php
    if(isset($_COOKIE["user_name"]) || isset($_COOKIE["admin_name"])){
      include("include/connect.php");
      (isset($_GET['start']))?$start = $_GET['start'] : $start = 1;
      //في حاله اذاكان اختار شئ محدد
      $length = 4;
      $limit = ($start - 1) * $length;
      if(isset($_COOKIE["cities"]) && isset($_COOKIE["type"])){
        $type = $_COOKIE["type"];
        $city = $_COOKIE["cities"];
        
        $count = $db->query("SELECT  products.id from products INNER JOIN users on products.id_user = users.id where category = '$type' and citys= '$city'");
        $count = $count->rowCount();
        $count = ceil($count / $length);

        $cat = $db->query("SELECT users.User_name , products.id , price , img_name, category ,citys from products INNER JOIN users on products.id_user = users.id
        where category = '$type' and citys= '$city' limit $limit , $length");
        $cat = $cat->fetchAll(pdo::FETCH_ASSOC);
      }else if(isset($_COOKIE["cities"])){
        $city = $_COOKIE["cities"];
        $count = $db->query("SELECT products.id from products INNER JOIN users on products.id_user = users.id where citys= '$city'");
        $count = $count->rowCount();;
        $count = ceil($count / $length);

        $cat = $db->query("SELECT users.User_name , products.id , price , img_name, category ,citys from products INNER JOIN users on products.id_user = users.id
        where citys= '$city' limit $limit , $length");
        $cat = $cat->fetchAll(pdo::FETCH_ASSOC);
      }else if(isset($_COOKIE["type"])){
        $type = $_COOKIE["type"];
        $count = $db->query("SELECT  products.id from products INNER JOIN users on products.id_user = users.id where category = '$type'");
        $count = $count->rowCount();
        $count = ceil($count / $length);

        $cat = $db->query("SELECT users.User_name , products.id , price , img_name, category ,citys from products INNER JOIN users on products.id_user = users.id
        where category = '$type' limit $limit , $length");
        $cat = $cat->fetchAll(pdo::FETCH_ASSOC);
      }else{
        $count = $cat = $db->query("SELECT products.id  from products INNER JOIN users on products.id_user = users.id");
        $count = $count->rowCount();
        $count = ceil($count / $length);

        $cat = $db->query("SELECT users.User_name , products.id , price , img_name, category ,citys from products INNER JOIN users on products.id_user = users.id  limit $limit , $length");
        $cat = $cat->fetchAll(pdo::FETCH_ASSOC);
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/Services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@300&family=Kufam:ital,wght@1,500&family=Marhey&family=Reem+Kufi:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title> Petco </title>
</head>
<body>
  <!--_______header_______________-->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
    <a class="navbar-brand" href="#" data-aos="fade-right" data-aos-delay="400"> <span>Pet</span>co </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" data-aos="fade-left" data-aos-delay="400">
      <span><i class="fa-solid fa-bars-staggered"></i></span>
    </button>
  </div>
  <!--__________dropdown____________-->
  <div class="dropdown">
    <li class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-aos="fade-left" data-aos-delay="400">
      cities
    </li>
    <ul class="dropdown-menu">
      <?php //اخراج اسامي المدن الموجوده
        $cities = $db->query('SELECT citys from products group by citys');
        $cities = $cities->fetchAll(pdo::FETCH_ASSOC);
        foreach($cities as $c){
      ?>
      <li><a class="dropdown-item" href="change.php?cities=<?php echo $c["citys"]?>"><?php echo $c["citys"]?></a></li>
        <?Php }?>
      <li><a class="dropdown-item" href="change.php?cities=All">all</a></li>
    </ul>
  </div>
  <!--__________dropdown____________-->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
          <?php if(isset($_COOKIE["admin_name"])){?>
      <li class="nav-item" data-aos="fade-left" data-aos-delay="400">
          <a class="nav-link" href="../admin/index.php">Dashboard</a>
        </li>
          <?php }?>
        <li class="nav-item" data-aos="fade-left" data-aos-delay="400">
          <a class="nav-link " href="../index.php">home</a>
        </li>
      </ul>
  </div>
  <div class="btn_login" data-aos="fade-left" data-aos-delay="400">
      <?PHP if(!isset($_COOKIE["admin_name"])) {?>
  <a href="out.php" class="c-button c-button--gooey"> log out <i class="fa-solid fa-right-to-bracket fa-fade"></i><div class="c-button__blobs"><div></div><div></div><div></div></div></a>
      <?php }?>
  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
    <defs>
      <filter id="goo">
        <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
        <feBlend in="SourceGraphic" in2="goo"></feBlend>
      </filter>
    </defs>
  </svg>
</div>
</nav>
</header>
<!--_______header_______________-->

<div class = "wrapper">
  <div class = "category-filter">
      <div class = "container">
          <div class = "title" data-aos="fade-right" data-aos-delay="500">
              <h1>Advertisement display page</h1>
          </div>
            <!--_________________________________btn-filter_____________________-->
            <div class = "filter-btns" data-aos="fade-left" data-aos-delay="500">
                <button type = "button" class = "filter-btn"><a href="change.php?type=All" class="link">all</a></button>
                <button type = "button" class = "filter-btn"><a href="change.php?type=Apartment" class="link">apartment</a></button>
                <button type = "button" class = "filter-btn"><a href="change.php?type=Room" class="link">rooms</a></button>
                <button type = "button" class = "filter-btn"><a href="change.php?type=Bed" class="link">beds</a></button>
            </div>
            <!--_________________________________btn-filter_____________________-->

          <div class = "filter-items">
            <!--________________product-card__________________-->
            
            <!--________________product-card__________________-->
            <?php
              if(isset($_COOKIE["user_name"])){
                $owner_name = $_COOKIE["user_name"];
              }else{
                $owner_name = "not";
              }
              foreach($cat as $caty){
                $img = explode("?", $caty['img_name']);

            ?>
              <div class = "filter-item all rooms" data-aos="fade-up" data-aos-delay="300">
                  <div class = "item-img">
                      <img src = "img/<?php echo $img[0] ?>" alt = "Item image">
                      <span class = "discount"><?php echo $caty['citys']?></span>
                  </div>
                  <div class = "item-info">
                      <p><?php echo $caty['category']?></p>
                      <div>
                          <span class = "apartment-price"><?php echo $caty['price']?></span>
                      </div>
                      <a href = "More_details.php?id=<?php echo $caty['id']?>" class ="add-btn">more details</a>
                      <?php if($owner_name == $caty["User_name"] || isset($_COOKIE["admin_name"])){?>  
                      <a href = "update.php?update_id=<?php echo $caty['id']?>" class ="add-btn">update</a>
                <?php }?>
                  </div>
              </div>
              <?php }?>
              </div>




          <!--________footer_scroll__________-->
          <div class="footer_scroll" data-aos="fade-up" data-aos-delay="400">
            <div class="Go_Back">
            <?php
                if($start > 1){//تظهر اذاكان هناك قوائمه قبل هذه القائمه 
                ?>
            <a href="services.php?start=<?php echo $start - 1?>"><i class="fas fa-solid fa-angle-left"></i> Back</a>
            <?php }?>
            </div>
            <div class="Nmber_list">
              <?php for($i = 1;$i <= $count;$i++){?>
              <a href="services.php?start=<?php echo $i?>"><?php echo $i?></a>
              <?php }?>
            </div>
            <div class="Next_to">
            <?php
                if($start < $count){//تظهر اذاكان هناك قوائم بعد هذه القائمه
                ?>
              <a href="services.php?start=<?php echo $start + 1?>">Next <i class="fas fa-solid fa-chevron-right"></i></a> 
              <?php }?>
            </div>
          </div>
          <!--________footer_scroll__________-->


          </div>
      </div>
  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../js/jquery-1.12.4.min.js" ></script>
<script src="../js/main.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset:150,
        });
    </script>
</body>
</html>
<?php
    }else{
        header("location:login.php");
    }

?>