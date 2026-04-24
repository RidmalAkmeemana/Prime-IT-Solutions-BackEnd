<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title><?php echo htmlspecialchars($companyName ?: 'Dashboard'); ?> - Admin Dashboard</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dark_mode_style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet.js (Free, No API Key) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .tile-number {
            font-size: 22px;
            font-weight: 700;
        }

        .tile-label {
            font-size: 13px;
            color: #666;
        }

        #vacanciesMap {
            width: 100%;
            height: 450px;
            border-radius: 6px;
            z-index: 0;
        }

        .map-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .map-legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .map-legend-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="content container-fluid">

        <!-- Monetary Totals -->
        <div class="row g-3 mb-3" id="tiles-money"></div>

        <!-- ROW 1: Application Count per Status (Full Width Bar Graph) -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Application Count by Status</h5>
                        <canvas id="applicationStatusChart" height="80"></canvas>
                        <div id="applicationStatusNoData" class="text-center py-5 my-xl-3 text-muted" style="display:none;"><strong>No Results</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 2: Vacancies per Department (Pie) + Top 5 Vacancies by Applications (Bar) -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Vacancies by Department</h5>
                        <canvas id="vacanciesByDeptChart"></canvas>
                        <div id="vacanciesByDeptNoData" class="text-center py-5 my-xl-3 text-muted" style="display:none;"><strong>No Results</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Top 5 Vacancies by Applications</h5>
                        <canvas id="topVacanciesChart"></canvas>
                        <div id="topVacanciesNoData" class="text-center py-5 my-xl-3 text-muted" style="display:none;"><strong>No Results</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 3: Vacancies by Location on Leaflet Map (Full Width) -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Vacancies by Location</h5>
                        <div id="vacanciesMapNoData" class="text-center py-5 text-muted" style="display:none;"><strong>No Results</strong></div>
                        <div id="vacanciesMap"></div>
                        <div class="map-legend" id="mapLegend"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
        function formatMoney(v) {
            return Number(v).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // --- Make Tile HTML with card ---
        function makeTileHtml(label, value) {
            return `<div class="col-sm-6 col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center p-3">
                <div class="tile-number" data-target="${value}">0</div>
                <div class="tile-label">${label}</div>
            </div>
        </div>
    </div>`;
        }

        // --- Animate numbers ---
        function animateNumbers(containerSelector, duration = 800, isCurrency = false) {
            const tiles = document.querySelectorAll(containerSelector + ' .tile-number');
            tiles.forEach(tile => {
                const target = parseFloat(tile.getAttribute('data-target')) || 0;
                let count = 0;
                const steps = 100;
                const increment = target / steps;
                const stepTime = duration / steps;

                const interval = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        tile.innerText = isCurrency ?
                            Number(target).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) :
                            Math.round(target).toLocaleString();
                        clearInterval(interval);
                    } else {
                        tile.innerText = isCurrency ?
                            Number(count).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) :
                            Math.round(count).toLocaleString();
                    }
                }, stepTime);
            });
        }

        // --- Render Tiles ---
        function renderTiles(pageData) {
            // Monetary Tiles
            const moneyHtml = `
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="tile-number" data-target="${pageData.Count_ActiveVacancies || 0}">0</div>
                            <div class="tile-label">Active Vacancies</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="tile-number" data-target="${pageData.Count_Applicants || 0}">0</div>
                            <div class="tile-label">Total Applicants</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="tile-number" data-target="${pageData.Count_PendingApplications || 0}">0</div>
                            <div class="tile-label">Pending Applications</div>
                        </div>
                    </div>
                </div>
                `;
            document.getElementById('tiles-money').innerHTML = moneyHtml;
            animateNumbers('#tiles-money', 800, false);
        }

        // --- Chart 1: Application Count per Status (Bar Graph) ---
        function renderApplicationStatus(data) {
            const canvas = document.getElementById('applicationStatusChart');
            const noData = document.getElementById('applicationStatusNoData');

            if (!data.applicationStatus || data.applicationStatus.length === 0) {
                canvas.style.display = 'none';
                noData.style.display = 'block';
                return;
            }

            canvas.style.display = 'block';
            noData.style.display = 'none';

            const colorMap = {
                'Pending':     '#f39c12',
                'Sort Listed': '#009efb',
                'Interview':   '#8207DB',
                'Hired':       '#26af48',
                'Rejected':    '#e74c3c'
            };

            const labels = data.applicationStatus.map(r => r.status);
            const counts = data.applicationStatus.map(r => r.count);
            const bgColors = labels.map(l => colorMap[l] || '#b19316');

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Applications',
                        data: counts,
                        backgroundColor: bgColors,
                        borderColor: bgColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` Count: ${ctx.raw}`
                            }
                        }
                    },
                    scales: {
                        x: { title: { display: true, text: 'Application Status' } },
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            title: { display: true, text: 'Number of Applications' }
                        }
                    }
                }
            });
        }

        // --- Chart 2: Vacancies per Department (Pie Chart) ---
        function renderVacanciesByDept(data) {
            const canvas = document.getElementById('vacanciesByDeptChart');
            const noData = document.getElementById('vacanciesByDeptNoData');

            if (!data.vacanciesByDept || data.vacanciesByDept.length === 0) {
                canvas.style.display = 'none';
                noData.style.display = 'block';
                return;
            }

            canvas.style.display = 'block';
            noData.style.display = 'none';

            const labels = data.vacanciesByDept.map(r => r.department);
            const counts = data.vacanciesByDept.map(r => r.count);
            const colors = ['#b19316', '#000000', '#26af48', '#009efb', '#f39c12', '#8207DB', '#53EAFD', '#FFA2A2', '#162456', '#31C950'];

            new Chart(canvas, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: labels.map((_, i) => colors[i % colors.length]),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'right' },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.raw} Vacancies`
                            }
                        }
                    }
                }
            });
        }

        // --- Chart 3: Top 5 Vacancies with Most Applications (Horizontal Bar Graph) ---
        function renderTopVacanciesByApplications(data) {
            const canvas = document.getElementById('topVacanciesChart');
            const noData = document.getElementById('topVacanciesNoData');

            if (!data.topVacanciesByApplications || data.topVacanciesByApplications.length === 0) {
                canvas.style.display = 'none';
                noData.style.display = 'block';
                return;
            }

            canvas.style.display = 'block';
            noData.style.display = 'none';

            const labels = data.topVacanciesByApplications.map(r => r.job_title);
            const counts = data.topVacanciesByApplications.map(r => r.application_count);
            const colors = ['#b19316', '#26af48', '#009efb', '#8207DB', '#f39c12'];

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Applications',
                        data: counts,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` Applications: ${ctx.raw}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            title: { display: true, text: 'Number of Applications' }
                        }
                    }
                }
            });
        }

        // --- Map: Vacancies by Location using Leaflet.js + OpenStreetMap (FREE) ---
        function renderVacanciesMap(data) {
            const mapDiv    = document.getElementById('vacanciesMap');
            const noData    = document.getElementById('vacanciesMapNoData');
            const legendDiv = document.getElementById('mapLegend');

            // Filter out "Remote" — not a geocodable place
            const locations = (data.vacanciesByLocation || []).filter(
                r => r.location.toLowerCase() !== 'remote'
            );

            if (locations.length === 0) {
                mapDiv.style.display = 'none';
                noData.style.display = 'block';
                legendDiv.style.display = 'none';
                return;
            }

            mapDiv.style.display = 'block';
            noData.style.display = 'none';
            legendDiv.innerHTML  = '';

            const pinColors = ['#b19316', '#26af48', '#009efb', '#8207DB', '#f39c12', '#e74c3c', '#53EAFD', '#162456', '#31C950', '#000000'];

            // Initialize Leaflet map centered on Sri Lanka
            const map = L.map('vacanciesMap').setView([7.8731, 80.7718], 8);

            // OpenStreetMap tile layer — FREE, no API key
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18
            }).addTo(map);

            const bounds = [];
            let geocoded = 0;

            locations.forEach((loc, i) => {
                const color = pinColors[i % pinColors.length];

                // Nominatim — FREE geocoding by OpenStreetMap (no key needed)
                const query = encodeURIComponent(loc.location);
                fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&limit=1`)
                    .then(res => res.json())
                    .then(results => {
                        geocoded++;

                        if (results && results.length > 0) {
                            const lat = parseFloat(results[0].lat);
                            const lng = parseFloat(results[0].lon);
                            bounds.push([lat, lng]);

                            // Custom coloured circle marker
                            const marker = L.circleMarker([lat, lng], {
                                radius: 14,
                                fillColor: color,
                                color: '#ffffff',
                                weight: 2,
                                opacity: 1,
                                fillOpacity: 0.9
                            }).addTo(map);

                            // Vacancy count label inside marker using divIcon
                            const icon = L.divIcon({
                                className: '',
                                html: `<div style="
                                    background:${color};
                                    color:#fff;
                                    border: 2px solid #fff;
                                    border-radius: 50%;
                                    width: 30px;
                                    height: 30px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 700;
                                    font-size: 12px;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                                ">${loc.count}</div>`,
                                iconSize: [30, 30],
                                iconAnchor: [15, 15]
                            });

                            L.marker([lat, lng], { icon })
                                .addTo(map)
                                .bindPopup(`
                                    <div style="padding:4px 2px; min-width:140px;">
                                        <strong style="font-size:14px;">${loc.location}</strong><br>
                                        <span style="color:#555; font-size:13px;">
                                            Vacancies: <strong>${loc.count}</strong>
                                        </span>
                                    </div>
                                `);
                        }

                        // Fit map to all markers after last geocode
                        if (geocoded === locations.length && bounds.length > 0) {
                            map.fitBounds(bounds, { padding: [40, 40] });
                        }

                        // Build legend
                        const item = document.createElement('div');
                        item.className = 'map-legend-item';
                        item.innerHTML = `
                            <div class="map-legend-dot" style="background:${color};"></div>
                            <span>${loc.location} &mdash; <strong>${loc.count}</strong> ${loc.count === 1 ? 'vacancy' : 'vacancies'}</span>
                        `;
                        legendDiv.appendChild(item);
                    })
                    .catch(() => { geocoded++; });
            });
        }

        // --- Fetch Dashboard Data ---
        function fetchDashboard() {
            $.ajax({
                url: '../../API/Admin/getDashboardUserData.php',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (!res || res.success !== 'true') {
                        alert('Failed to fetch dashboard data');
                        return;
                    }
                    renderTiles(res.pageData || {});
                    renderApplicationStatus(res);
                    renderVacanciesByDept(res);
                    renderTopVacanciesByApplications(res);
                    renderVacanciesMap(res);
                }
            });
        }

        $(document).ready(fetchDashboard);
    </script>
</body>

</html>