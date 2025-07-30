<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bananaroll Store</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff0f5;
      padding: 20px;
    }
    .header-img {
      text-align: center;
      margin-bottom: 10px;
    }
    .header-img img {
      max-width: 200px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #d63384;
      text-align: center;
      font-size: 2.5rem;
    }
    .menu {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 20px;
    }
    .item {
      background: #ffe6f0;
      border-radius: 12px;
      padding: 15px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .item h3 {
      margin: 0 0 8px;
      color: #6b0036;
      font-size: 1.2rem;
    }
    .item p {
      margin: 5px 0;
      font-weight: 500;
      color: #8a4b6f;
    }
    button {
      padding: 7px 14px;
      background: #ff69b4;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #e754a3;
    }
    #keranjang {
      margin-top: 40px;
      background: #ffd6e8;
      padding: 20px;
      border-radius: 12px;
    }
    #keranjang h2 {
      margin-top: 0;
      color: #c9184a;
    }
    #daftarPesanan li {
      margin-bottom: 6px;
    }
    #qris {
      margin-top: 25px;
      text-align: center;
    }
    #qris img {
      max-width: 200px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .top-banner {
      text-align: center;
      margin-bottom: 20px;
    }
    .top-banner img {
      max-width: 250px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- LOGO BANANAROLL -->
  <div class="header-img">
    <img src="banana.JPG" alt="Logo Bananaroll" />
  </div>

  <h1>Menu Bananaroll</h1>
  <div class="menu" id="menuList"></div>

  <div id="keranjang">
    <h2>Keranjang</h2>
    <ul id="daftarPesanan"></ul>
    <p><strong>Total: Rp <span id="total">0</span></strong></p>
    <button onclick="kirimPesanan()">Kirim Pesanan</button>

    <!-- QRIS -->
    <div id="qris">
      <h3>Scan QRIS untuk Pembayaran</h3>
      <img src="seungkwan.JPG" alt="QRIS" />
      <!-- Ganti 'seungkwan.JPG' dengan gambar QRIS kamu -->
    </div>
  </div>

  <script>
    const menu = [
      { nama: "Bananaroll Cokelat", harga: 12000 },
      { nama: "Bananaroll Keju", harga: 13000 },
      { nama: "Bananaroll Matcha", harga: 14000 },
      { nama: "Bananaroll Red Velvet", harga: 15000 },
      { nama: "Bananaroll Tiramisu", harga: 16000 }
    ];

    const menuList = document.getElementById("menuList");
    const daftarPesanan = document.getElementById("daftarPesanan");
    const totalEl = document.getElementById("total");
    let total = 0;
    const keranjang = [];

    menu.forEach((item, index) => {
      const div = document.createElement("div");
      div.className = "item";
      div.innerHTML = `
        <h3>${item.nama}</h3>
        <p>Harga: Rp ${item.harga.toLocaleString()}</p>
        <button onclick="tambahPesanan(${index})">Pesan</button>
      `;
      menuList.appendChild(div);
    });

    function tambahPesanan(index) {
      const item = menu[index];
      keranjang.push({ nama: item.nama, harga: item.harga });
      const li = document.createElement("li");
      li.textContent = `${item.nama} - Rp ${item.harga.toLocaleString()}`;
      daftarPesanan.appendChild(li);
      total += item.harga;
      totalEl.textContent = total.toLocaleString();
    }

    function kirimPesanan() {
      if (keranjang.length === 0) {
        alert("Belum ada pesanan.");
        return;
      }

      const pesanan = {
        waktu: new Date().toLocaleString(),
        list: keranjang,
        total: total
      };

      const semuaPesanan = JSON.parse(localStorage.getItem("pesanan")) || [];
      semuaPesanan.push(pesanan);
      localStorage.setItem("pesanan", JSON.stringify(semuaPesanan));

      // Kosongkan tampilan & data
      daftarPesanan.innerHTML = "";
      totalEl.textContent = "0";
      keranjang.length = 0;
      total = 0;

      // Munculin notif
      showNotif(`✅ Pesanan berhasil dikirim!<br>Total: Rp ${pesanan.total.toLocaleString()}<br>🎉 Terima kasih sudah belanja di <b>Bananaroll Store!</b>`);
    }

    function showNotif(teks) {
      const notif = document.createElement("div");
      notif.style.position = "fixed";
      notif.style.top = "20px";
      notif.style.right = "20px";
      notif.style.backgroundColor = "#ffb3cc";
      notif.style.color = "#6b0036";
      notif.style.padding = "15px 20px";
      notif.style.borderRadius = "10px";
      notif.style.boxShadow = "0 5px 15px rgba(0,0,0,0.2)";
      notif.style.zIndex = 9999;
      notif.style.fontWeight = "600";
      notif.style.fontSize = "15px";
      notif.innerHTML = teks;

      document.body.appendChild(notif);

      setTimeout(() => {
        notif.remove();
      }, 4000);
    }
  </script>

</body>
</html>






