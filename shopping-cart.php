<?php
error_reporting(0);

session_start();
$total=0;
$conn = new PDO("mysql:host=localhost;dbname=project", 'root', '');		
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$action = isset($_GET['action'])?$_GET['action']:"";

if($action=='addcart' && $_SERVER['REQUEST_METHOD']=='POST') {
	
	
	$query = "SELECT * FROM products WHERE sku=:sku";
	$stmt = $conn->prepare($query);
	$stmt->bindParam('sku', $_POST['sku']);
	$stmt->execute();
	$product = $stmt->fetch();
	
	$currentQty = $_SESSION['products'][$_POST['sku']]['qty']+1;
	$_SESSION['products'][$_POST['sku']] =array('qty'=>$currentQty,'name'=>$product['name'],'image'=>$product['image'],'price'=>$product['price']);
  $product='';
	header("Location:shopping-cart.php");
}

if($action=='emptyall') {
	$_SESSION['products'] =array();
	header("Location:shopping-cart.php");	
}

if($action=='empty') {
	$sku = $_GET['sku'];
	$products = $_SESSION['products'];
	unset($products[$sku]);
	$_SESSION['products']= $products;
	header("Location:shopping-cart.php");	
}
 
 
 
$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PHP registration form</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style=" background-color:MintCream; background-image: url(./images/t5.png); background-size:100% 100%; background-repeat: round; width: 1037x; height: 1091.19px; overflow: hidden;">
<div class="container" style="width:600px;">
  <?php if(!empty($_SESSION['products'])):?>
  <nav class="navbar navbar-inverse" style="background:#1abc9c; margin-top: 15px;">
    <div class="container-fluid pull-left" style="width:300px;">
      <div class="navbar-header"> <a class="navbar-brand" href="#" style="color:#FFFFFF;">Shopping Cart</a> </div>
    </div>
    <div class="pull-right" style="margin-top:7px;margin-right:7px;">
      <a href="shopping-cart.php?action=emptyall" class="btn btn-info">Empty cart</a>
      <a href="./html/checkout.html" class="btn btn-info">Checkout</a>
      </div>
  </nav>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Actions</th>
      </tr>
    </thead>
    <?php foreach($_SESSION['products'] as $key=>$product):?>
    <tr>
      <td><img src="<?php print $product['image']?>" width="50"></td>
      <td><?php print $product['name']?></td>
      <td>$<?php print $product['price']?></td>
      <td><?php print $product['qty']?></td>
      <td><a href="shopping-cart.php?action=empty&sku=<?php print $key?>" class="btn btn-info">Delete</a></td>
    </tr>
    <?php $total = $total+$product['price']*$product['qty'];?>
    <?php endforeach;?>
    <tr><td colspan="5" align="right"><h4>Total:$<?php print $total?></h4></td></tr>
  </table>
  <?php endif;?>
  <nav class="navbar navbar-inverse" style="background:#1abc9c; margin: 15px;">
    <div class="container-fluid">
      <div class="navbar-header"> <a class="navbar-brand" href="#" style="color:#FFFFFF;">Products</a> </div>
    </div>
  </nav>
  <div class="row">
    <div class="container" style="width:600px;">
      <?php foreach($products as $product):?>
      <div class="col-md-4">
        <div class="thumbnail"> <img src="<?php print $product['image']?>" alt="Lights">
          <div class="caption">
            <p style="text-align:center;"><?php print $product['name']?></p>
            <p style="text-align:center;color:#04B745;"><b>$<?php print $product['price']?></b></p>
            <form method="post" action="shopping-cart.php?action=addcart">
              <p style="text-align:center;color:#04B745;">
                <button id="checkoutButton" type="submit" class="btn btn-warning">Add To Cart</button>
                <input type="hidden" name="sku" value="<?php print $product['sku']?>">
              </p>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
</body>
<script>
 var itemCount = 0;
 var orderTotal = 0;
 var session = eval('(<?php echo json_encode($_SESSION)?>)');
 var obj = eval(session.products);

Object.values(obj).forEach(value=>{
   orderTotal = orderTotal + value.qty * parseInt(value.price);
   itemCount = itemCount + value.qty;
   console.log(value.price);
});

localStorage.setItem("totalPrice", orderTotal);
localStorage.setItem("itemCount", itemCount );
console.log(orderTotal);

</script>
</html>