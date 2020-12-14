<?php
// Initialize the session
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="../css/main_page.css" />
  <script src="../js/jquery-3.4.1.min.js"></script>         
  <script type="text/javascript">
                                           
    $(document).ready( function() { 
        $('#loader').load('../test.php'); 
        console.log("loading test.php");
    }); 
</script> 
</head>
<body>
  <header>
    <div class="header">
      <div id="background-top">
        <h1 id="webtitle">KERO</h1>
        
      </div>
    </div>
  </header>
    <nav class="whole_nav" id="navBar">
      <ul>
        
        <li>
          <li><a id="user_nav"href="user.html" target="iframe_a"> USER </a></li>
        </li>
        <li>
          </li><a href="logout.php" class="btn btn-danger" >LOGOUT</a></li>
        </li>
        
        <li>
          <a id="shipping_info_nav"href="shipping_information.html" target="iframe_a">
            SHIPPING INFORMATION
          </a>
        </li>
         <li>

        <li>
          <a id="shopping_cart_nav"href="../shopping-cart.php" target="iframe_a">
            SHOPPING CART
          </a>
        </li>
          <li>
          <a id="checkout_nav" href="checkout.html" target="iframe_a"> CHECKOUT</a>
        </li>
        <li>
            <a id="aboutus" href="aboutus.html" target="iframe_a"></a>
        </li>
      </ul>
    </nav>
    <div class="wrapper">
      <div class="iframe-container">
        <iframe name="iframe_a" id="iframe_a"></iframe>
      </div>
      <footer>WEB TECHNOLOGY AND APPLICATIONS PROJECT BY KETAN KAPSE AND OMKAR THOMBARE</footer>
    </div>
</body>
<p style="width: 0; height: 0; visibility: hidden;" id="loader"></p>
</html>
