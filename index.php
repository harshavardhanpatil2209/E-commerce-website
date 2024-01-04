<?php
ob_start();
session_start();

if(isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/server/db.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    
$result = $mysqli->query($sql);

$user = $result->fetch_assoc();

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
*, ::before, ::after {
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Source Sans Pro', sans-serif;
    background: #eee;
    width: 100vw;
    height: 100vh;
    display: block;
    position: relative;
    overflow-x: hidden;
}

.main-nav {
    position: fixed;
    top: 0;
    left: 0;
    background: rgba(255, 253, 253, 0.664);
    color: azure;
    width: 100%;
    height: calc(100vh - 80vh);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 10;
}
.logo-container {
    width: 150px;
    height: 150PX;
    padding: .8rem;
    display: grid;
    place-items: center;
}
img {
    max-width: 150px;
    object-fit: cover;
    border-radius: 60%;
}

.cart {
    display: flex;
    flex-flow: column;
    font-size: 20px;
    font-weight: 600;
}
.menu li{
    display: inline;
    list-style-type: none;
    font-size: 20px;
    font-weight: 600;
    margin-right: 3rem;
}
.logout-a {
    text-align: center;
    text-decoration: none;
    color: azure;
    background: darkcyan;
    padding: .2rem 0.2rem;
    border-radius: 7px;
}
a:hover {
    background-color: azure;
    transition: 0.3s linear;
    color: black;
    border: 1px solid #121212;
}
.welcome-msg {
    color: #121212;
}
.name {
    color: brown;
}
.item-content {
    margin-top: 130px;
    background: rgba(255, 253, 253, 0.664);
    color: azure;
    width: 100%;
    height: fit-content;
    padding: 1.5rem 1rem;
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    flex: 1;
}
.item {
    width: 350px;
    height: fit-content;
    display: block;
    margin: 1.5rem 1rem 0;
    background: rgba(3, 41, 87, 0.84);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
}
.item-name {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 0.5rem 0;
    background: #eee;
    color: #121212;
    font-size: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    padding: .5rem 0;
}
.item-img {
    width: 100%;
    display: grid;
    place-items: center;
    background-color: #eee;
}

.add-to-cart-container {
    width: 100%;
    background: #eee;
    color: #121212;
    font-size: 16px;
    font-weight: 600;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    padding: .6rem .2rem;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.add {
    padding: .4rem 0.4rem;
    background: #eff;
    color: #121212;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    outline: none;
    cursor: pointer;
    font-weight: 600;
    border: none;
    border-radius: 5px;
}
.add:hover {
    color: #eee;
    background: rgba(3, 41, 87, 0.84);
    transition: .4s linear;
}
.cart-div {
    display: flex;
    flex-flow: column;
    position: relative;
    padding: .4rem .2rem;
}
#count {
    position: absolute;
    top: -20px;
    left: 16.6px;
    color: #121212;
    align-self: center;
}
.trolley {
    font-size:36px;
    color:blue;
    cursor: pointer;
}
footer {
    width: 100%;
    background: #eee;
    color: #121212;
    font-size: 24px;
    padding: 3rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.session-not-set {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    padding: 1rem 0.3rem;
    width: fit-content;
    font-size: 24px;
    font-weight: 600;
}
.session-not-set a {
    text-decoration: none;
    margin: 0 .4rem;
    border: none;
    outline: none;
}
.session-not-set a:hover {
    text-decoration: underline;
    color: tomato;
}
/* cart container */
.cart-container {
    position: fixed;
    top: 125px;
    right: -100%;
    width: 396px;
    min-height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    display: flex;
    flex-flow: column;
    transition: .4s;
    padding: .4rem .2rem;
    z-index: 20;
    overflow: auto;
    -webkit-overflow: scroll;
}
.cart-container.active {
    right: 0;
    overflow-y: visible;
}
.card-wrapper{
    padding: 0 .5rem;
}
/* cart items */
.cart-item {
    display: flex;
    flex-grow: 0;
    align-items: center;
    justify-content: space-between;
    flex-flow: row nowrap;
    background: #fff;
    color: #121212;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    padding: 0 0.3rem;
    margin: .2rem auto;
    position: relative;
    border-radius: 10px;
}
/* cart hearder */
.cart-header h2 {
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    padding: .2rem 0;
    margin-bottom: 1rem;
}
/* cart image */
.cart-item-img {
    max-width: 70px;
}
/* cart item name */
.cart-item-name {
    padding: 1rem;
    font-size: small;
}
/* quantity */
.quantity {
    width: 30px;
    margin: 0 1rem;
    border: none;
    outline: none;
    color: tomato;
}

/* cart item price */
.item-price {
    margin-right: 1rem;
    padding: 0 .4rem;
    font-size: small;
    border-left: 1px solid #121212;
    border-right: 1px solid #121212;
}
/* total price div */
.total{
    display: flex;
    justify-content: flex-end;
    width: 100%;
    border-top: 2px solid #121212;
    padding: 1rem 1rem;
    margin-top: 1rem;
    font-size: 20px;
    font-weight: 500;
}
/* place order */
.place-order {
    align-self: center;
    width: fit-content;
    border: none;
    background: tomato;
    color: #eee;
    padding: 0.5rem .3rem;
    margin-top: 1.4rem;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    cursor: pointer;
}
.place-order:hover {
    opacity: .8;
    background: #eee;
    outline: 1px solid #121212;
    color: #121212;
    transition: 0.3s ease-in;
}
/* remove item */
.remove-item {
    color: #121212;
    font-size: 24px;
    margin-right: 1rem;
    padding: 0 1rem;
    cursor: pointer;
}
/* remove item from cart */
.remove-item:hover {
    color: tomato;
    opacity: .6;
}


/* close cart */
.close-cart {
    position: absolute;
    top: 0;
    right: 0;
    margin: 1rem 1rem;
    font-size: 20px;
    color: red;
    cursor: pointer;
    background: #fff;
    padding: 0.2rem 0.4rem;
    border-radius: 50px;
}
.close-cart:hover {
    opacity: .5;
}
@media screen and (max-width: 600px) {
  .item-content {
    margin-top: 300px !important;
    width: auto;
  }
  .logo-container {
    height: auto;
  }
  .main-nav {
    flex-direction: column !important;
    align-items: center !important;
    height: 250px !important;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
  }
  .menu {
    display: flex;
    align-items: center;
    justify-content: space-around;
    width: 100%;
  }
  .cart-container {
    top: 300px;
    width: 100%;
  }
  .welcome-msg {
    font-size: 14px;
  }
}
</style>
<body>
    <?php if (isset($user)): ?>
        <nav class="main-nav">
        <div class="logo-container">
            <img src="https://i.pinimg.com/originals/12/d6/00/12d60046505b41fe3ca8a71e0d186c62.png" alt="logo" class="logo">
        </div>
        <h1 class="welcome-msg">Welcome To Our Shop - <b class="name"><?= htmlspecialchars($user["name"]) ?></b></h1>
        <ul class="menu">
            <li><a class="logout-a" href="./server/logout.php">Logout</a></li>
            <li class="cart-div"><span id="count">0</span><i class="fa fa-shopping-cart trolley"></i></li>
        </ul>
    </nav>
    <div class="cart-container">
        <i class="fa fa-remove close-cart"></i>
        <div class="cart-header">
            <h2>Your Cart</h2>
        </div>
        <div class="cart-wrapper">
            
        </div>
        <div class="total">
            <span class="total-price">$123</span>
        </div>
        <button class="place-order">Place Order</button>
    </div>
     <div class="item-content">
        <div class="item">
            <p class="item-name">Granny Smith Apples Pack 1.5kg</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3tLyXNy" alt="apples">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$24.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Satsuma Oranges Bulk Pack</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/39CdkZi" alt="oranges">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$29.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">White Seedless grapes</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/39zn1HR" alt="grapes">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$44.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Strawberries  pack 400g</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3tMiA3f" alt="strawberries">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$19.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Fresh organic Bananas 1.5kg </p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3OrE90Y" alt="Bananas">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$29.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Tomatoes pack 1kg</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3xGPkfp" alt="Tomatoes">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$45.00</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Mixed Pepper pack 500g</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3O6gcg2" alt="Pepper">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$18.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Pickled Onions pack 1kg</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3b0K6Uc" alt="onions">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$29.89</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
        <div class="item">
            <p class="item-name">Green Gaby Cabbages 2 pack</p>
            <div class="item-img">
                <img id="product-img" src="https://bit.ly/3OcCrBa" alt="Cabbage">
            </div>
            <div class="add-to-cart-container">
                <span class="price">N$19.99</span>
               <button class="add">Add to cart</button>
            </div>
        </div>
     </div>  
     <footer>
        <small>All rights reserve &copy; <a href="https://kanhalelor.github.io/">Kanhalelo</a></small>
     </footer> 
    <?php else:?>
        <?php header("location: ./index.html", true, 302);?>
    <?php endif; ?>
    <script src="./client/js/index.js"></script>
</body>
</html>