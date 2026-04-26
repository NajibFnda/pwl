<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Is Your Email PWNED?</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
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
                    
                    <div class="breach-list" id="breachListData">
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
    // ---UNTUK MENGELUARKAN POP-UP ---
    function processCheck(event) {
        event.preventDefault(); 
        
        // Ambil input dan ubah ke huruf kecil semua agar tidak sensitif huruf besar/kecil
        const inputEmail = document.getElementById('emailInput').value.toLowerCase();
        document.getElementById('displayEmail').innerText = inputEmail;

        const modal = document.getElementById('statusModal');
        const modalBox = document.getElementById('modalBox');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        
        const cardStatus = document.getElementById('cardStatus');
        const labelStatus = document.getElementById('labelStatus');
        const textStatus = document.getElementById('textStatus');
        const breachListData = document.getElementById('breachListData');

        // Reset class
        cardStatus.className = "retro-card";
        labelStatus.className = "card-label";
        textStatus.className = "card-value-large";

        // ========================================================
        // 1. SIMULASI DATABASE MENGGUNAKAN ARRAY
        // ========================================================
        const dummyDatabase = [
            { email: "najib@gmail.com", status: "aman" },
            { email: "bocor@gmail.com", status: "tidak_aman" }
        ];

        // 2. Cari email di dalam array menggunakan fungsi .find()
        const foundData = dummyDatabase.find(data => data.email === inputEmail);

        // 3. Tentukan kondisi berdasarkan hasil pencarian
        // Jika data ditemukan DAN statusnya "tidak_aman"
        if (foundData && foundData.status === "tidak_aman") {
            
            // --- SETUP POP-UP & KARTU MERAH (PWNED) ---
            modalBox.style.borderColor = "#cc0000"; 
            modalTitle.innerText = "PWNED!";
            modalTitle.style.color = "#cc0000";
            modalDesc.innerText = "Oh no! We found your email in several data breaches.";
            
            cardStatus.classList.add('alert');
            labelStatus.classList.add('alert-text');
            textStatus.classList.add('alert-text');
            textStatus.innerHTML = 'PWNED <span style="float:right;">!</span>';
            document.getElementById('textAction').innerText = 'Change password';

            // Masukkan data dummy kebocoran
            breachListData.innerHTML = `
                <div><span>canva.com</span><span>12/2/2024</span></div>
                <div><span>tokopedia.com</span><span>05/8/2023</span></div>
                <div><span>linkedin.com</span><span>22/5/2021</span></div>
                <div><span>adobe.com</span><span>15/10/2019</span></div>
            `;

        } else {
            
            // --- SETUP POP-UP & KARTU HIJAU (SAFE) ---
            // Masuk ke sini jika statusnya "aman" atau email tidak ada di array sama sekali
            modalBox.style.borderColor = "#00ff00"; 
            modalTitle.innerText = "SAFE!";
            modalTitle.style.color = "#00ff00";
            modalDesc.innerText = "Good news! We couldn't find your email in any public data breaches.";
            
            cardStatus.classList.add('safe');
            labelStatus.classList.add('safe-text');
            textStatus.classList.add('safe-text');
            textStatus.innerHTML = 'SAFE <span style="float:right;">\\/</span>';
            document.getElementById('textAction').innerText = 'No Action Needed';

            // Kosongkan tabel kebocoran
            breachListData.innerHTML = `
                <div><span>null</span><span>-/-/-</span></div>
                <div><span>null</span><span>-/-/-</span></div>
                <div><span>null</span><span>-/-/-</span></div>
                <div><span>null</span><span>-/-/-</span></div>
            `;
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