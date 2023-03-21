<div>
    <h1>How to Use the Cart Class</h1>
    <p>This class was designed to create a shopping cart using PHP and PDO. The class can store the cart data using session or cookies. It can also include product details by pulling product information from the database.</p>
    <p>First, include the Cart class in your PHP file:</p>

  <ol>
        <li>Clone the repository or download the zip file.</li>
        <li>Create a new database and import the <code>database.sql</code> file located in the <code>db</code> folder.</li>
        <li>Configure your database credentials in <code>config/db.php</code>.</li> 
        <li>Run the project in your local server.</li>
    </ol>

```php
 include_once 'Cart.php'; 
```

<p>Next, create a new instance of the Cart class, passing the desired parameters:</p>

```php
    /*
     new Cart(useSession, useCookie, taxPercent, dbconnection) 
    */

    $cart = new Cart(true, false, 18);  
``` 

#### If the database is to be used
```php 
    $database = new Database(); 
    $conn = $database->getConnection(); 
    $cart = new Cart(true, false, 18, $conn);
```

### Adding an Item to the Cart
You can add an item to the cart using the addItem method:


```php
 $cart->addItem($productId, $quantity, $price);
 $cart->addItem($productId, $quantity, $price, 'Product');
```

### Updating the Quantity of an Item
You can update the quantity of an item in the cart using the updateItemQuantity method:
```php
$cart->updateItemQuantity($productId, $quantity);
```

### Removing an Item from the Cart
You can remove an item from the cart using the removeItem method:
```php
$cart->removeItem($productId);
```

### Clearing the Cart
You can clear the entire cart using the clearCart method:
```php
$cart->clearCart();
```


### Clearing the Cart
You can clear the entire cart using the clearCart method:
```php
$cart->clearCart();
```

### Retrieving the Cart Data
You can retrieve the cart data using the following methods:
```php
$cart->getItems();
$cart->getItemCount();
$cart->getTotalQuantity();
$cart->getSubtotal();
$cart->getTaxAmount();
$cart->getTotal();
```

### Clearing Session and Cookie
You can clear the session and cookie data using the following methods:
```php 
$cart->clearSession();
$cart->clearCookie();
```

### Retrieving Product Details
You can retrieve the product details from the database using the getProductDetails method:
```php 
$cart->getProductDetails($productId);
```


### Retrieving Cart Details
The getCartDetails() function returns cart details. The returned details include:

- subtotal
- tax amount
- item count
- total quantity
- total (including tax)
- item data

```php 
$cart->getCartDetails();
```
 
<p>
In this way, using the cart class, you can add products, update their quantity, remove them, or completely clean the cart. You can store the cart information in the $cart Data array and use it to display it on the display page.
</p>