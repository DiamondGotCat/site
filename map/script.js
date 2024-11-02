let startCoords = null;
let goalCoords = null;
let map;
let startMarker, goalMarker, routeLayer;

// ページロード時にLeafletの地図を初期化
document.addEventListener("DOMContentLoaded", () => {
  map = L.map('map').setView([35.6895, 139.6917], 12); // 東京の中心付近を初期表示
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'KAMU Map Search | &copy; OpenStreetMap contributors'
  }).addTo(map);

  // エンターキーでの検索実行設定
  document.getElementById('startInput').addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      searchLocation('start');
    }
  });
  
  document.getElementById('goalInput').addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      searchLocation('goal');
    }
  });
});

// 地点の検索
function searchLocation(type) {
  const query = type === 'start' ? document.getElementById('startInput').value : document.getElementById('goalInput').value;
  const resultsContainer = type === 'start' ? document.getElementById('startResults') : document.getElementById('goalResults');
  resultsContainer.innerHTML = "検索中...";

  fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
    .then(response => response.json())
    .then(data => {
      resultsContainer.innerHTML = '';
      data.forEach(place => {
        const item = document.createElement('div');
        item.className = 'box';
        item.innerHTML = `${place.display_name}`;
        item.onclick = () => selectLocation(type, place);
        resultsContainer.appendChild(item);
      });
    })
    .catch(error => {
      console.error("Error fetching location:", error);
      resultsContainer.innerHTML = "エラーが発生しました";
    });
}

// 地点の選択と地図へのマーカー表示
function selectLocation(type, place) {
  const coords = [parseFloat(place.lat), parseFloat(place.lon)];
  if (type === 'start') {
    startCoords = coords;
    if (startMarker) map.removeLayer(startMarker);
    startMarker = L.marker(coords).addTo(map).bindPopup("スタート地点").openPopup();
    map.setView(coords, 13);
    document.getElementById('startResults').innerHTML = ''; // 選択後に一覧をクリア
  } else {
    goalCoords = coords;
    if (goalMarker) map.removeLayer(goalMarker);
    goalMarker = L.marker(coords).addTo(map).bindPopup("ゴール地点").openPopup();
    map.setView(coords, 13);
    document.getElementById('goalResults').innerHTML = ''; // 選択後に一覧をクリア
  }
}

// OSRMを使用してルートを検索し、地図に表示
function calculateRoute() {
  if (!startCoords || !goalCoords) {
    alert("スタート地点とゴール地点を設定してください。");
    return;
  }

  const start = `${startCoords[1]},${startCoords[0]}`;
  const goal = `${goalCoords[1]},${goalCoords[0]}`;

  // 交通モードを取得
  const mode = document.getElementById("modeSelect").value;

  // OSRM APIを使用してルートを取得
  fetch(`https://router.project-osrm.org/route/v1/${mode}/${start};${goal}?overview=full&geometries=geojson`)
    .then(response => response.json())
    .then(data => {
      if (data.routes && data.routes.length > 0) {
        if (routeLayer) {
          map.removeLayer(routeLayer);
        }

        // 取得したルートをGeoJSONとして描画
        const route = data.routes[0].geometry;
        routeLayer = L.geoJSON(route, { style: { color: 'blue', weight: 4 } }).addTo(map);
        map.fitBounds(routeLayer.getBounds());
      } else {
        alert("ルートが見つかりませんでした。");
      }
    })
    .catch(error => {
      console.error("Error fetching route:", error);
      alert("ルートを取得できませんでした。");
    });
}

// パネルを開閉する機能
function togglePanel() {
  const panel = document.getElementById('tool-panel');
  const showButton = document.getElementById('show-panel-button');
  if (panel.classList.contains('hidden')) {
    panel.classList.remove('hidden');
    showButton.style.display = 'none';
  } else {
    panel.classList.add('hidden');
    showButton.style.display = 'block';
  }
}