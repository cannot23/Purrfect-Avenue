// function for navigation menu 
const toggleMenu = () => {
    const menuToggle = document.querySelector('.toggle');
    const navigation = document.querySelector('.navigation');
    menuToggle.classList.toggle('active');
    navigation.classList.toggle('active');
};

// for menu toggle button 
const menuToggle = document.querySelector('.toggle');
menuToggle.addEventListener('click', toggleMenu); 

// swiper initialization for images in index.html 
document.addEventListener("DOMContentLoaded", function () { 
    var swiperContainer = document.querySelector(".mySwiper");
    if (swiperContainer) {
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow", 
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto", 
            coverflowEffect: {
                rotate: 0, 
                stretch: 0, 
                depth: 300, 
                modifier: 1, 
                slideShadows: true, 
            }, 
            pagination: {
                el: ".swiper-pagination", 
            }, 
            loop: true,
        }); 
        }
    });
    
// for products page
function toggleCart() {
    const cartElement = document.getElementById('cart');
    cartElement.style.display = (cartElement.style.display === 'flex') ? 'none' : 'flex';
}

const cart = {};
// Function to add an item to the cart
function addToCart(product_id, product_name, category, product_price) {
    const product = { product_id, product_name, category, product_price };
    if (!cart[category]) {
        cart[category] = [];
    }
    cart[category].push(product);
    // updateCartDisplay();
    // updateTotal();

    // Send AJAX request to add the product to the cart
    $.ajax({
        url: 'addtocart.php',
        method: 'POST',
        data: { product_id: product_id },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            $('#itemCount').text(response.numberOfItems);
        },
        error: function(xhr, status, error) {
            alert('Error adding product to cart');
        }
    });
    console.log("Product ID:", product_id);
}

function updateCartDisplay() {
    const cartElement = document.getElementById('cart');
    const cartContentElement = document.getElementById('cart-content');

    cartContentElement.innerHTML = '';

    for (const category in cart) {
        if (cart.hasOwnProperty(category)) {
            const categoryItems = cart[category];

            // Check if the category has items
            if (categoryItems.length > 0) {
                const categoryHeading = document.createElement('h3');
                categoryHeading.textContent = `${category} Items`;
                cartContentElement.appendChild(categoryHeading);

                const itemList = document.createElement('ul');
                categoryItems.forEach((item, index) => {
                    const listItem = document.createElement('li');
                    const priceText = typeof item.product_price === 'number' ? `$${item.product_price.toFixed(2)}` : 'Invalid Price';
                    listItem.textContent = `${item.product_name} - ${priceText}`;
                
                    const removeButton = document.createElement('button'); 
                    removeButton.textContent = '\u00d7';
                    removeButton.addEventListener('click', () => removeFromCart(category, index));
                
                    listItem.style.listStyle = 'none';
                    itemList.appendChild(listItem);
                });
                cartContentElement.appendChild(itemList);
            }
        }
    }
}

function updateTotal() {
    const totalElement = document.getElementById('total');
    let overallTotal = 0;
    for (const category in cart) {
        if (cart.hasOwnProperty(category)) {
            overallTotal += cart[category].reduce((sum, item) => sum + item.product_price, 0);
        }
    }

    totalElement.innerHTML = `<p>Total: $${overallTotal.toFixed(2)}</p>`;
}

function logoutAlert() {
    result = window.confirm("Are you sure you want to log out?");
    if (result){
        window.location.href = "logout.php";
    } else {
        //nothing will happen
    }
}

function ExitPostAlert() {
    result = window.confirm("Are you sure you want to exit? Changes will not be saved.");
    if (result){
        window.location.href = "products.php";
    } else {
        //nothing will happen
    }
}

