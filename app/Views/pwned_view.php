<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Is Your Email PWNED?</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    <style>
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Press Start 2P', cursive;
            text-align: center;
            background-color: #ffffff;
            color: #000000;
            margin: 0;
            padding: 0;
        }

        .hero-section {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .title-pwned {
            color: #cc0000;
            font-size: 24px;
            margin: 10px 0;
        }

        .search-container {
            display: inline-block;
            border: 3px solid #000;
            padding: 30px 20px;
            background-color: #f0f0f0;
            box-shadow: 6px 6px 0px #000;
            margin-top: 30px;
        }

        input[type="email"] {
            font-family: 'Press Start 2P', cursive;
            padding: 12px;
            border: 2px solid #000;
            width: 300px;
            font-size: 12px;
        }

        .btn-check {
            font-family: 'Press Start 2P', cursive;
            background-color: #0055aa;
            color: white;
            padding: 14px 20px;
            border: 2px solid #000;
            box-shadow: 3px 3px 0px #000;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-check:active {
            box-shadow: 0px 0px 0px #000;
            transform: translate(3px, 3px);
        }

        /* ================= MODAL POP-UP 8-BIT ================= */
        .modal-overlay {
            display: none; /* Sembunyikan default */
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Latar belakang gelap transparan */
            z-index: 1000; /* Agar selalu di paling atas */
            justify-content: center;
            align-items: center;
            animation: fadeInModal 0.3s ease-out;
        }

        .modal-box {
            background-color: #fff;
            padding: 30px;
            text-align: center;
            max-width: 450px;
            width: 80%;
            border: 4px solid #cc0000; /* Border alert merah */
            box-shadow: 8px 8px 0px #000;
        }

        .btn-modal-close { background-color: #555; }
        .btn-modal-show { background-color: #cc0000; }

        @keyframes fadeInModal {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        /* ================= KONTEN HASIL ================= */
        #result-section {
            display: none;
            padding-bottom: 100px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .main-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: left;
            padding: 0 20px;
        }

        /* STYLING KARTU RETRO */
        .section-title {
            font-size: 14px; color: #a0a0a0; text-transform: uppercase;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 15px; margin-top: 80px;
        }
        .section-title::before { content: ''; display: block; width: 12px; height: 12px; background-color: #d0d0d0; }

        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px; }

        .retro-card { border: 3px solid #000; background-color: #f4f4f4; padding: 15px; box-shadow: 4px 4px 0px #000; }
        .retro-card.alert { border-color: #cc0000; }
        .retro-card.alert-text { color: #cc0000; }

        .card-label { font-size: 8px; color: #888; margin-bottom: 15px; text-transform: uppercase; }
        .card-value { font-size: 12px; line-height: 1.5; }
        .card-value-large { font-size: 18px; font-weight: bold; }

        .breach-list { width: 100%; font-size: 10px; }
        .breach-list div { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed #ccc; }
        .breach-list div:last-child { border-bottom: none; }
    </style>
</head>
<body>

    <div class="hero-section">
        <h2>Is Your Email</h2>
        <h1 class="title-pwned">PWNED?</h1>
        <p style="font-size: 10px;">Check Your Email Account on Our Database</p>

        <div class="search-container">
            <form id="checkForm" onsubmit="processCheck(event)">
                <input type="email" id="emailInput" placeholder="Email here" required>
                <button type="submit" class="btn-check">CHECK</button>
            </form>
            <p style="font-size: 8px; margin-top: 20px;">🔒 Your Privacy is Safe</p>
        </div>
    </div>

    <div id="statusModal" class="modal-overlay">
        <div class="modal-box" id="modalBox">
            <h1 class="title-pwned" id="modalTitle" style="font-size: 32px; margin-bottom: 20px;">PWNED!</h1>
            <p id="modalDesc" style="font-size: 10px; line-height: 1.8; margin-bottom: 30px;">
                Oh no! We found your email in several data breaches.
            </p>
            <div style="display: flex; justify-content: center; gap: 15px;">
                <button class="btn-check btn-modal-close" onclick="closeModal()">Close</button>
                <button class="btn-check btn-modal-show" id="btnShowMore" onclick="showMore()">SHOW MORE</button>
            </div>
        </div>
    </div>


    <div id="result-section">
        <div class="main-container">
            <div id="part-analysis">
                <div class="section-title">Account Analysis</div>
                <div class="grid-3">
                    <div class="retro-card">
                        <div class="card-label">Email</div>
                        <div class="card-value" id="displayEmail">example@gmail.com</div>
                    </div>
                    <div class="retro-card alert" id="cardStatus">
                        <div class="card-label alert-text" id="labelStatus">Breach Status:</div>
                        <div class="card-value-large alert-text" id="textStatus">PWNED <span style="float:right;">!</span></div>
                    </div>
                    <div class="retro-card">
                        <div class="card-label">Next Action:</div>
                        <div class="card-value" id="textAction">Change password</div>
                    </div>
                </div>

                <div class="retro-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <div class="card-label" style="margin-bottom: 0;">Pwned On:</div>
                        <div class="card-label" style="color: #0088cc; margin-bottom: 0;">Live_Feed: Updating...</div>
                    </div>
                    
                    <div class="breach-list">
                        <div><span>canva.com</span><span>12/2/2024</span></div>
                        <div><span>tokopedia.com</span><span>05/8/2023</span></div>
                        <div><span>linkedin.com</span><span>22/5/2021</span></div>
                        <div><span>adobe.com</span><span>15/10/2019</span></div>
                    </div>
                </div>
            </div>

            <div id="part-stats">
                <div class="section-title">System Statistics</div>
                <div class="grid-3">
                    <div class="retro-card">
                        <div class="card-label">Active Scams <span style="float:right; color:#00cc00;">32%</span></div>
                        <div class="card-value-large">48</div>
                        <div style="width: 100%; background: #ccc; height: 10px; margin-top: 10px;">
                            <div style="width: 32%; background: #555; height: 10px;"></div>
                        </div>
                        <div style="font-size: 6px; margin-top: 5px;">Live Usage: 45 / 150</div>
                    </div>
                    <div class="retro-card alert">
                        <div class="card-label alert-text">Breach Rate %</div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="card-value-large alert-text">65%</div>
                            <div style="width: 30px; height: 30px; border: 4px solid #cc0000; border-radius: 50%; border-top-color: #ccc;"></div>
                        </div>
                        <div style="font-size: 6px; color: #888; margin-top: 10px;">Critical Increasing</div>
                    </div>
                    <div class="retro-card">
                        <div class="card-label">Total Breached</div>
                        <div class="card-value-large">352K</div>
                        <div style="font-size: 8px; margin-top: 15px;"><span style="color:#cc0000; background:#fdd; padding:2px;">+30.24%</span> Last 30 Days</div>
                    </div>
                </div>
                <div class="retro-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <div class="card-label" style="margin-bottom: 0;">Breach Trends / Annual_Data</div>
                        <div class="card-label" style="color: #0088cc; margin-bottom: 0;">Live_Feed: Updating...</div>
                    </div>
                    <canvas id="retroChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- 1. FUNGSI UNTUK MENGELUARKAN POP-UP ---
    function processCheck(event) {
        event.preventDefault(); 
        
        const inputEmail = document.getElementById('emailInput').value;
        document.getElementById('displayEmail').innerText = inputEmail;

        // Ambil elemen modal
        const modal = document.getElementById('statusModal');
        const modalBox = document.getElementById('modalBox');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const btnShowMore = document.getElementById('btnShowMore');

        // [SIMULASI LOGIKA] 
        // Jika email mengandung kata "aman", kita buat pop-up hijau (Aman).
        // Selain itu, pop-up merah (Bocor). Nanti ini bisa diganti dengan response API CI4.
        if (inputEmail.toLowerCase().includes('aman')) {
            modalBox.style.borderColor = "#00cc00"; // Hijau
            modalTitle.innerText = "SAFE!";
            modalTitle.style.color = "#00cc00";
            modalDesc.innerText = "Good news! We couldn't find your email in any public data breaches.";
            
            // Sembunyikan tombol Show More jika aman (optional)
            btnShowMore.style.display = "none";
            
            // Ubah teks di kartu analisis sekalian
            document.getElementById('cardStatus').classList.remove('alert');
            document.getElementById('cardStatus').style.borderColor = '#00cc00';
            document.getElementById('labelStatus').classList.remove('alert-text');
            document.getElementById('labelStatus').style.color = '#00cc00';
            document.getElementById('textStatus').classList.remove('alert-text');
            document.getElementById('textStatus').style.color = '#00cc00';
            document.getElementById('textStatus').innerHTML = 'SAFE <span style="float:right;">✓</span>';
            document.getElementById('textAction').innerText = 'You are good to go';
        } else {
            modalBox.style.borderColor = "#cc0000"; // Merah
            modalTitle.innerText = "PWNED!";
            modalTitle.style.color = "#cc0000";
            modalDesc.innerText = "Oh no! We found your email in several data breaches.";
            
            // Tampilkan tombol Show More
            btnShowMore.style.display = "inline-block";

            // Kembalikan ke style merah (jika sebelumnya mencoba email aman)
            document.getElementById('cardStatus').classList.add('alert');
            document.getElementById('cardStatus').style.borderColor = '#cc0000';
            document.getElementById('labelStatus').classList.add('alert-text');
            document.getElementById('labelStatus').style.color = '#cc0000';
            document.getElementById('textStatus').classList.add('alert-text');
            document.getElementById('textStatus').style.color = '#cc0000';
            document.getElementById('textStatus').innerHTML = 'PWNED <span style="float:right;">!</span>';
            document.getElementById('textAction').innerText = 'Change password';
        }

        // Tampilkan modal
        modal.style.display = "flex"; 
    }

    // --- 2. FUNGSI UNTUK MENUTUP POP-UP ---
    function closeModal() {
        document.getElementById('statusModal').style.display = "none";
    }

    // --- 3. FUNGSI UNTUK TOMBOL SHOW MORE & SCROLL KE BAWAH ---
    function showMore() {
        closeModal(); // Tutup pop-up
        
        // Tampilkan hasil di layar
        const resultSection = document.getElementById('result-section');
        resultSection.style.display = 'block';

        // Scroll otomatis meluncur ke bawah
        setTimeout(() => {
            document.getElementById('part-analysis').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 150);
    }

    // --- KONFIGURASI CHART 8-BIT ---
    const ctx = document.getElementById('retroChart').getContext('2d');
    Chart.defaults.font.family = "'Press Start 2P', cursive";
    Chart.defaults.font.size = 8;
    Chart.defaults.color = '#888';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Global_Avg',
                data: [10, 30, 50, 40, 70, 60, 80, 65, 55, 85, 70],
                borderColor: '#0088cc', backgroundColor: '#0088cc',
                borderWidth: 4, pointRadius: 4, tension: 0 
            }]
        },
        options: {
            scales: { y: { display: false }, x: { grid: { color: '#e0e0e0' } } },
            plugins: { legend: { position: 'bottom', align: 'end' } }
        }
    });
</script>
</body>
</html>