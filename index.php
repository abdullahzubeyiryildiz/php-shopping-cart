<?php
require_once "cart.php"; 

$database = new Database();

$conn = $database->getConnection();

$cart = new Cart(true, false, 18, $conn);
 

//$cart->clearCookie(); 
//$cart->clearSession();

 
//$cart->addItem(1, 2, 100);
//$cart->addItem(2, 3, 200); 
//echo  json_encode($cart->getProductDetails(1));
echo  json_encode($cart->getCartDetails());
 

/*
$cart->updateItemQuantity(2,1);
  
$subtotal = $cart->getSubtotal();
 
$taxAmount = $cart->getTaxAmount();
 
$total = $cart->getTotal();
  
$itemCount = $cart->getItemCount();
 
$totalQuantity = $cart->getTotalQuantity();
 
$items = $cart->getItems();
 
echo json_encode([
    'subtotal'=>$subtotal,
    'taxAmount'=>$taxAmount,
    'itemCount'=>$itemCount,
    'totalQuantity'=>$totalQuantity,
    'total'=>$total,
    'data'=>$items
]);
*/

/*   
$cart->removeItem(1);
 
$cart->clearCart();
*/