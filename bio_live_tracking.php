<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rep Live Tracking</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: #f1f3f6;
    }
    .container {
      display: flex;
      height: 100%;
    }
    /* Sidebar */
    .sidebar {
      width: 320px;
      background: #ffffff;
      border-right: 1px solid #ddd;
      padding: 15px;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    }
    .sidebar h2 {
      margin: 0 0 10px;
      text-align: center;
      font-size: 20px;
      font-weight: 600;
      color: #333;
    }
    .search-box {
      margin-bottom: 10px;
    }
    .search-box input {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      outline: none;
      transition: 0.2s;
    }
    .search-box input:focus {
      border-color: #007bff;
      box-shadow: 0 0 4px rgba(0,123,255,0.3);
    }
    .status-group {
      margin-top: 10px;
      flex: 1;
      overflow-y: auto;
    }
    .status-title {
      font-size: 14px;
      font-weight: bold;
      margin: 10px 0 6px;
      color: #666;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .rep-card {
      background: #fafafa;
      padding: 10px;
      margin-bottom: 8px;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .rep-card:hover {
      background: #f0f8ff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .rep-name {
      font-weight: 500;
      font-size: 14px;
      color: #222;
    }
    .status-badge {
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: bold;
      text-transform: capitalize;
    }
    .status-walking {
      background: #e8f5e9;
      color: #28a745;
      border: 1px solid #28a745;
    }
    .status-riding {
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffc107;
    }
    .status-halt, .status-offline {
      background: #f8d7da;
      color: #dc3545;
      border: 1px solid #dc3545;
    }
    #map {
      flex: 1;
      height: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>🚀 Rep Tracker</h2>
      <div class="search-box">
        <input type="text" id="search" placeholder="🔍 Search rep...">
      </div>
      <div class="status-group">
        <div class="status-title">🟢 Online</div>
        <div id="online-list"></div>
        <div class="status-title">🔴 Offline</div>
        <div id="offline-list"></div>
      </div>
    </div>

    <!-- Map -->
    <div id="map"></div>
  </div>

  <!-- Leaflet -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Firebase -->
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

    // Firebase Config
    const firebaseConfig = {
      databaseURL: "https://biophoenix-10-default-rtdb.firebaseio.com"
    };

    // Init Firebase + DB
    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);

    // Init Map
    var map = L.map('map').setView([20.5937, 78.9629], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Custom icons
    const icons = {
      walking: L.icon({ iconUrl: "http://seppro.net/map_image/walking.png", iconSize: [40, 40], iconAnchor: [20, 40] }),
      riding: L.icon({ iconUrl: "http://seppro.net/map_image/ride.png", iconSize: [40, 40], iconAnchor: [20, 40] }),
      halt: L.icon({ iconUrl: "http://seppro.net/map_image/halt.png", iconSize: [40, 40], iconAnchor: [20, 40] }),
      default: L.icon({ iconUrl: "https://unpkg.com/leaflet/dist/images/marker-icon.png", iconSize: [25, 41], iconAnchor: [12, 41] })
    };

    var markers = {};

    // Listener
    const statusRef = ref(db, "LiveLocationsRep");
    onValue(statusRef, (snapshot) => {
      const data = snapshot.val();
      let onlineHTML = "";
      let offlineHTML = "";

      if (data) {
        for (let repId in data) {
          const rep = data[repId];
          const status = rep.status || "offline";
          const isOnline = status === "walking" || status === "riding";

          const badgeClass =
            status === "walking" ? "status-walking" :
            status === "riding" ? "status-riding" :
            "status-offline";

          const repCard = `
            <div class="rep-card" onclick="focusRep('${repId}')">
              <span class="rep-name">${rep.repName || `Rep ${repId}`}</span>
              <span class="status-badge ${badgeClass}">${status}</span>
            </div>
          `;

          if (isOnline) onlineHTML += repCard;
          else offlineHTML += repCard;

          // Marker update
          if (rep.latitude && rep.longitude) {
            const pos = [parseFloat(rep.latitude), parseFloat(rep.longitude)];
            const icon = icons[status] || icons.default;
            const popupHtml = `
              <b>${rep.repName || `Rep ${repId}`}</b><br/>
              <b>Status:</b> ${status}<br/>
              <b>Lat:</b> ${rep.latitude}, <b>Long:</b> ${rep.longitude}<br/>
              <b>Updated:</b> ${new Date(rep.timestamp || rep.lastMovedTimestamp || Date.now()).toLocaleString()}
            `;
            if (markers[repId]) {
              markers[repId].setLatLng(pos).setIcon(icon).setPopupContent(popupHtml);
            } else {
              markers[repId] = L.marker(pos, { icon }).addTo(map).bindPopup(popupHtml);
            }
          }
        }
      }

      document.getElementById("online-list").innerHTML = onlineHTML;
      document.getElementById("offline-list").innerHTML = offlineHTML;
    });

    // Search filter
    document.getElementById("search").addEventListener("input", (e) => {
      const val = e.target.value.toLowerCase();
      document.querySelectorAll(".rep-card").forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(val) ? "flex" : "none";
      });
    });

    // Focus on Rep marker
    window.focusRep = (repId) => {
      if (markers[repId]) {
        map.setView(markers[repId].getLatLng(), 14);
        markers[repId].openPopup();
      }
    };
  </script>
</body>
</html>
