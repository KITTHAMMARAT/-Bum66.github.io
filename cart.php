<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านค้าออนไลน์ - ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="brand">ร้านค้าออนไลน์</div>
            <ul class="nav-links">
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="products.php">สินค้า</a></li>
                <li><a href="cart.php" class="active">ตะกร้า</a></li>
                <li><a href="#contact">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="cart-section">
            <h2>ตะกร้าสินค้าของคุณ</h2>
            <ul id="cart-items" class="cart-list"></ul>
            <p id="cart-total" class="cart-total">ราคารวม: 0 บาท</p>
            <button id="order-btn" class="action-btn order-btn">สั่งซื้อสินค้า</button>
            <div id="cart-empty" class="cart-empty" style="display:none;">
                <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" alt="empty cart" style="width: 120px; margin: 2em auto 1em auto;">
                <p>ยังไม่มีสินค้าในตะกร้า</p>
                <a href="products.php" class="action-btn">เลือกซื้อสินค้า</a>
            </div>
        </section>
    </main>
    <footer>
        <section id="contact" class="contact">
            <h2>ติดต่อเรา</h2>
            <p>คุณสามารถติดต่อผ่าน Telegram ได้ที่</p>
            <a href="https://t.me/foverning" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" style="width:32px;vertical-align:middle;">
                ร้านนายเบิ้ม 66
            </a>
        </section>
        <p>© 2025 ร้านค้าออนไลน์</p>
    </footer>
    <!-- Toast แจ้งเตือน -->
    <div id="toast" class="toast"></div>
    <script src="script.js"></script>
    <script>
    // ฟังก์ชันตะกร้าสินค้า (localStorage version)
    function getCart() {
        return JSON.parse(localStorage.getItem('cart') || "[]");
    }
    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    function renderCartPage() {
        const cart = getCart();
        const cartList = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartEmpty = document.getElementById('cart-empty');
        cartList.innerHTML = '';
        let total = 0;

        if(cart.length === 0) {
            cartEmpty.style.display = 'block';
            cartTotal.style.display = 'none';
            document.getElementById('order-btn').style.display = 'none';
            return;
        } else {
            cartEmpty.style.display = 'none';
            cartTotal.style.display = 'block';
            document.getElementById('order-btn').style.display = '';
        }

        cart.forEach(item => {
            total += item.price * item.qty;
            const li = document.createElement('li');
            li.className = "cart-item";
            li.innerHTML = `
                <div class="cart-info">
                    <img src="${item.img}" alt="${item.name}" class="cart-img">
                    <div>
                        <span class="cart-name">${item.name}</span>
                        <span class="cart-price">${item.price} บาท</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <button class="cart-btn" onclick="changeQty(${item.id}, 1)">+</button>
                    <span class="cart-qty">${item.qty}</span>
                    <button class="cart-btn" onclick="changeQty(${item.id}, -1)">-</button>
                    <button class="cart-btn cart-remove" onclick="removeCart(${item.id})">&times;</button>
                </div>
            `;
            cartList.appendChild(li);
        });
        cartTotal.textContent = `ราคารวม: ${total} บาท`;
    }
    function changeQty(id, delta) {
        let cart = getCart();
        const idx = cart.findIndex(i=>i.id===id);
        if(idx>-1) {
            cart[idx].qty += delta;
            if(cart[idx].qty < 1) cart.splice(idx,1);
            setCart(cart);
            renderCartPage();
        }
    }
    function removeCart(id) {
        let cart = getCart().filter(i=>i.id!==id);
        setCart(cart);
        renderCartPage();
    }
    window.changeQty = changeQty;
    window.removeCart = removeCart;
    document.addEventListener("DOMContentLoaded", renderCartPage);

    // Toast
    function showToast(text) {
        const toast = document.getElementById('toast');
        toast.textContent = text;
        toast.style.display = 'block';
        setTimeout(() => {toast.style.display='none';}, 2300);
    }

    // กดสั่งซื้อ (ส่งไป Telegram)
    document.getElementById('order-btn').onclick = function() {
        const cart = getCart();
        if(cart.length === 0) {
            showToast("กรุณาเลือกสินค้าเข้าตะกร้าก่อน!");
            return;
        }
        const text = cart.map(item => `${item.name} x${item.qty} = ${item.price * item.qty} บาท`).join('\n');
        const total = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
        const orderMsg = `มีออเดอร์ใหม่จากหน้าเว็บ!\n${text}\nราคารวม: ${total} บาท`;
        // ส่งไป Telegram (เปลี่ยน TOKEN กับ CHAT_ID)
        const TELEGRAM_TOKEN = "8010501055:AAGcHlAzms1L4JUba79LY4I3ArrVDLsIxOo";
        const TELEGRAM_CHAT_ID = "6813420383";
        fetch(`https://api.telegram.org/bot8010501055:AAGcHlAzms1L4JUba79LY4I3ArrVDLsIxOo/sendMessage`, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
                chat_id: TELEGRAM_CHAT_ID,
                text: orderMsg
            })
        })
        .then(res => res.ok ? showToast("แจ้งเตือนสั่งซื้อไปหลังบ้านแล้ว!") : showToast("เกิดข้อผิดพลาดในการแจ้งเตือน"))
        .catch(() => showToast("เกิดข้อผิดพลาดในการแจ้งเตือน"));
        // ล้างตะกร้า
        localStorage.setItem('cart','[]');
        setTimeout(renderCartPage,1000);
    }
    </script>
</body>
</html>