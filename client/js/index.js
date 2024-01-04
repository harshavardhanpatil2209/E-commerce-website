// js

// select elements

const cartContainer = document.querySelector('.cart-container');
const cart = document.querySelector('.trolley');
const closeCartIcon = document.querySelector('.close-cart');


// DOM ready func
const ready = () => {
    // remove items from cart
    const removeCartItemButtons = document.getElementsByClassName('remove-item')
    for (let i = 0; i < removeCartItemButtons.length; i++) {
        const button = removeCartItemButtons[i]
        button.addEventListener('click', removeItemFromCart)
        button.addEventListener('click', updateCartNumber)
    }
    // update quantity inputs
    const  quantityInputs = document.getElementsByClassName('quantity')
    for (let  i = 0; i < quantityInputs.length; i++) {
        const  input = quantityInputs[i]
        input.addEventListener('change', onQuantityChange)
    }
    // add items to cart
    const addToCartBtns = document.getElementsByClassName('add')
    for (let i = 0; i < addToCartBtns.length; i++) {
        const button = addToCartBtns[i]
        button.addEventListener('click', addItemToCartBtn)
        button.addEventListener('click', updateCartNumber)
    }
    document.getElementsByClassName('place-order')[0].addEventListener('click', orderPlaced)
}
// if DOM content is loaded
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

// placed order
function orderPlaced(e) {
    alert('Thank you for your purchase')
    const cartWrapper = document.getElementsByClassName('cart-wrapper')[0]
    while (cartWrapper.hasChildNodes()) {
        cartWrapper.removeChild(cartWrapper.firstChild)
    }
    updateTotal();
    updateCartNumber(e);
}
// remove items from cart
const removeItemFromCart = (e) => {
    const removeBtn = e.target;
    removeBtn.parentElement.remove();
    updateTotal();
    updateCartNumber(e);
}
// on quantity change
const onQuantityChange = (e) => {
    const input = e.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }
    updateTotal()
}
// add to cart func
const addItemToCartBtn = (e) => {
    const button = e.target;
    const productDiv = button.parentElement.parentElement;
    const productName = productDiv.firstElementChild.innerText;
    const productPrice = button.parentElement.firstElementChild.innerText;
    const  productImage = button.parentElement.previousElementSibling.firstElementChild.src;
    addItemToCart(productName, productPrice, productImage)
    updateTotal()
}
// add items to cart
const addItemToCart = (productName, productPrice, productImage) => {
    const cartDiv = document.createElement("div");
    cartDiv.classList.add('cart-item');
    const cartWrapper = document.getElementsByClassName('cart-wrapper')[0];
    const cartItemNames = document.getElementsByClassName('cart-item-name');
    for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].innerText == productName) {
            alert('This item is already added to the cart')
            return;
        }
    }
    const itemTemplate = `
    <img src="${productImage}" class="cart-item-img">
    <p class="cart-item-name">${productName}</p>
    <input type="number" name="value" class="quantity" value="1">
    <span class="item-price">${productPrice}</span>
    <i class="fa fa-trash-o remove-item"></i>
    `
    cartDiv.innerHTML = itemTemplate;
    cartWrapper.append(cartDiv);
    // remove items

    cartDiv.querySelectorAll('.remove-item')[0].addEventListener('click', removeItemFromCart);
    cartDiv.querySelectorAll('.quantity')[0].addEventListener('change', onQuantityChange);
}
// update total 
const updateTotal = (e) => {
    let total = 0;
    const quantityEls = document.getElementsByClassName('quantity');
    for (let i = 0; i < quantityEls.length; i++) {
        const quantity = parseInt(quantityEls[i].value);
        const priceElement = document.getElementsByClassName('item-price')[0];
        const price = parseFloat(priceElement.innerText.replace('N$', ''));
        total = total + (price * quantity);
    }
    total = Math.round(total * 100) / 100;
    document.getElementsByClassName('total-price')[0].innerText = "N$" + total;
}

// update cart value
const updateCartNumber = (e) => {
    let button = e.target;
    let cartNumber = parseInt(document.getElementById('count').innerText);
    let numberOfItemsInCart = document.querySelectorAll('.cart-item').length;
    cartNumber = numberOfItemsInCart;
    if (button.classList.contains('remove-item')) {
        numberOfItemsInCart -=1;
    }
    document.getElementById('count').innerText = cartNumber;
}

// display cart
const displayCart = (e) => {
    cartContainer.classList.add('active');
}
// close cart
const closeCart = (e) => {
    e.preventDefault();
    cartContainer.classList.remove('active');
}


// other events
cart.addEventListener('click', displayCart);
closeCartIcon.addEventListener('click', closeCart);

// ---------------------------------------------- Kanhalelo - 2022 -------------------------------------