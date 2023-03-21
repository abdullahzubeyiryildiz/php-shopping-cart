<?php
include_once 'config/db.php'; 
  

class Cart { 
    
    private $items = array();
    private $useSession = false;
    private $sessionName = 'cart_items';
    private $useCookie = false;
    private $cookieName = 'cart_items';
    private $cookieExpiry = 86400; // 24 hours
    private $taxPercent = 18;

    private $conn;
 
    public function __construct($useSession = false, $useCookie = false, $taxPercent = 18, $conn = null) {
        $this->conn = $conn;
        $this->taxPercent = $taxPercent;
        if ($useSession) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->useSession = true;
            if (isset($_SESSION[$this->sessionName])) {
                $this->items = $_SESSION[$this->sessionName];
            }
        }
        if ($useCookie) {
            $this->useCookie = true;
            if (isset($_COOKIE[$this->cookieName])) {
                $this->items = json_decode($_COOKIE[$this->cookieName], true);
            }
        }
    }
    
    public function addItem($productId, $quantity, $price, $productName = "Item") {
        if (!isset($this->items[$productId])) {
          $productDetails = $this->getProductDetails($productId);
          $this->items[$productId] = array(
            'quantity' => $quantity,
            'price' => $price,
            'name' => $productDetails['name'] ?? $productName.' '.$productId,
          );
        } else {
          $this->items[$productId]['quantity'] += $quantity;
        }
        $this->updateCart();
      }
    
    public function removeItem($productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
            $this->updateCart();
        }
    }
    
    public function updateItemQuantity($productId, $quantity) {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] = $quantity;
        } 
        $this->updateCart();
    }
    
    public function clearCart() {
        $this->items = array();
        $this->updateCart();
    }
    
    public function getItems() {
        return $this->items;
    }
    
    public function getItemCount() {
        return count($this->items);
    }
    
    public function getTotalQuantity() {
        $totalQuantity = 0;
        foreach ($this->items as $item) {
            $totalQuantity += $item['quantity'];
        }
        return $totalQuantity;
    }
    
    public function getSubtotal() {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }
    
    public function getTaxAmount() {
        $taxAmount = $this->getSubtotal() * ($this->taxPercent / 100);
        return $taxAmount;
    }
    
    public function getTotal() {
        $total = $this->getSubtotal() + $this->getTaxAmount();
        return $total;
    }
    
    private function updateCart() {  
        if ($this->useSession) {
            $_SESSION[$this->sessionName] = $this->items;
        }
        if ($this->useCookie) {
            setcookie($this->cookieName, json_encode($this->items), time() + $this->cookieExpiry);
        }
       
    }

    public function clearCookie() {
        setcookie($this->cookieName, '', time() - $this->cookieExpiry);
      }
      
      public function clearSession() {
        unset($_SESSION[$this->sessionName]);
      }
 

      public function getProductDetails($productId) {  
        $query = "SELECT * FROM products WHERE id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        return $productDetails;
      }
      

      public function getCartData() {
        if ($this->useSession) {
            return json_encode($_SESSION[$this->sessionName]);
        }
        if ($this->useCookie) {
            return $_COOKIE[$this->cookieName];
        }
        return json_encode(array());
    }


    public function getCartDetails() {
        $subtotal = $this->getSubtotal();
        $taxAmount = $this->getTaxAmount();
        $itemCount = $this->getItemCount();
        $totalQuantity = $this->getTotalQuantity();
        $total = $this->getTotal();
        $items = $this->getItems();
    
        return [
            'subtotal'=>$subtotal,
            'taxAmount'=>$taxAmount,
            'itemCount'=>$itemCount,
            'totalQuantity'=>$totalQuantity,
            'total'=>$total,
            'data'=>$items
        ];
    }
}