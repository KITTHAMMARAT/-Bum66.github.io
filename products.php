<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านค้านายเบิ้ม - สินค้า</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="brand">ร้านค้านายเบิ้ม</div>
            <ul class="nav-links">
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="products.php" class="active">สินค้า</a></li>
                <li><a href="cart.php">ตะกร้า</a></li>
                <li><a href="#contact">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="products">
            <h2>สินค้าแนะนำ</h2>
            <div class="product-list" id="product-list"></div>
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
        <p>© 2025 ร้านค้านายเบิ้ม</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>