@extends('layouts.admin')

@section('title', 'NEW ROUTE MAP // RANGO ADMIN')
@section('header', 'CREATE INTERACTIVE ROUTE MAP')

@section('content')
<!-- โหลด Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="space-y-8 max-w-7xl mx-auto" x-data="routeMapEditor()">

    <!-- Top Action -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.route-maps.index') }}" class="text-xs font-mono-code text-emerald-400">&larr; Back to Route Maps</a>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight mt-1">Plot New Tour Route</h2>
        </div>
    </div>

    <form action="{{ route('admin.route-maps.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Config: Form Inputs & Waypoints List -->
            <div class="lg:col-span-6 space-y-6">
                <!-- 01 Info -->
                <div class="glass-panel p-6 rounded-3xl border border-emerald-500/15 space-y-4">
                    <h3 class="text-xs font-mono-code uppercase font-bold text-emerald-400 tracking-wider">// 01 ROUTE DETAILS</h3>
                    
                    <div>
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Route Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Cheow Lan Lake &amp; Guilin Highlights" 
                               class="w-full bg-black/80 text-white border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Link to Tour Package</label>
                            <select name="tour_id" class="w-full bg-black/80 text-white border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs focus:outline-none">
                                <option value="">-- Standalone Route Map --</option>
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Route Polyline Color</label>
                            <input type="color" name="route_color" x-model="routeColor" @change="updatePolyline()" 
                                   class="w-full h-12 bg-black/80 border border-zinc-800 rounded-2xl p-1 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Description Narrative</label>
                        <textarea name="description" rows="3" placeholder="Explain the scenic route, boat transfers, and terrain..." 
                                  class="w-full bg-black/80 text-white border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- 02 Waypoints List -->
                <div class="glass-panel p-6 rounded-3xl border border-emerald-500/15 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-mono-code uppercase font-bold text-emerald-400 tracking-wider">// 02 WAYPOINTS (<span x-text="waypoints.length"></span> POINTS)</h3>
                        <button type="button" @click="addWaypoint()" class="px-3 py-1.5 bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-black font-mono-code text-[11px] font-bold rounded-xl transition">
                            + Add Waypoint
                        </button>
                    </div>
                    <p class="text-[11px] text-zinc-400 font-mono-code">💡 คลิกบนแผนที่ทางขวา หรือกดปุ่มด้านบน เพื่อปักหมุดจุดแวะและสร้างเส้นเชื่อมต่ออัตโนมัติ</p>

                    <!-- Points Accordion / List -->
                    <div class="space-y-3 max-h-[480px] overflow-y-auto pr-1">
                        <template x-for="(point, idx) in waypoints" :key="idx">
                            <div class="p-4 bg-black/60 border border-zinc-800 rounded-2xl space-y-3 relative group hover:border-emerald-500/40 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center" x-text="idx + 1"></span>
                                        <input type="text" :name="'waypoints['+idx+'][name]'" x-model="point.name" @input="updateMarkers()" placeholder="Point Name (e.g. ท่าเรือเชี่ยวหลาน)" required 
                                               class="bg-transparent text-white font-bold text-xs border-b border-zinc-700 focus:border-emerald-400 focus:outline-none px-1 py-0.5">
                                    </div>
                                    <button type="button" @click="removeWaypoint(idx)" class="text-rose-400 hover:text-rose-300 font-mono-code text-xs px-2 py-1">✕ Remove</button>
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-[10px] font-mono-code text-zinc-500 uppercase">Type</label>
                                        <select :name="'waypoints['+idx+'][type]'" x-model="point.type" @change="updateMarkers()" class="w-full bg-zinc-900 text-white text-[11px] border border-zinc-800 rounded-xl p-2 focus:outline-none">
                                            <option value="boat">🚤 Longtail Boat</option>
                                            <option value="van">🚐 VIP Minivan</option>
                                            <option value="trekking">🥾 Trekking / Hiking</option>
                                            <option value="kayak">🛶 Kayak / Canoe</option>
                                            <option value="resort">🛖 Raft House Resort</option>
                                            <option value="viewpoint">📸 Landmark Viewpoint</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-mono-code text-zinc-500 uppercase">Latitude</label>
                                        <input type="number" step="any" :name="'waypoints['+idx+'][lat]'" x-model.number="point.lat" @input="refreshMap()" required 
                                               class="w-full bg-zinc-900 text-emerald-400 font-mono-code text-[11px] border border-zinc-800 rounded-xl p-2 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-mono-code text-zinc-500 uppercase">Longitude</label>
                                        <input type="number" step="any" :name="'waypoints['+idx+'][lng]'" x-model.number="point.lng" @input="refreshMap()" required 
                                               class="w-full bg-zinc-900 text-emerald-400 font-mono-code text-[11px] border border-zinc-800 rounded-xl p-2 focus:outline-none">
                                    </div>
                                </div>

                                <div>
                                    <input type="text" :name="'waypoints['+idx+'][description]'" x-model="point.description" placeholder="Brief note e.g. จุดลงเรือและซื้อตั๋วอุทยาน..." 
                                           class="w-full bg-zinc-900 text-zinc-300 text-[11px] border border-zinc-800 rounded-xl px-3 py-2 focus:outline-none">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Interactive Map Area -->
            <div class="lg:col-span-6 space-y-6">
                <div class="glass-panel p-6 rounded-3xl border border-emerald-500/15 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-mono-code uppercase font-bold text-emerald-400 tracking-wider">// LIVE MAP PLOTTER</h3>
                        <span class="text-[10px] font-mono-code text-zinc-400">Click map to drop point</span>
                    </div>

                    <!-- Hidden Inputs for Center & Zoom -->
                    <input type="hidden" name="center_lat" :value="centerLat">
                    <input type="hidden" name="center_lng" :value="centerLng">
                    <input type="hidden" name="zoom_level" :value="zoomLevel">

                    <!-- Leaflet Container -->
                    <div id="adminRouteMap" class="w-full h-[600px] rounded-2xl overflow-hidden border border-zinc-800 shadow-2xl relative z-10"></div>
                </div>

                <!-- Submit Bar -->
                <div class="glass-panel p-6 rounded-3xl border border-emerald-500/20 flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="status" value="1" checked class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                        <span class="text-xs font-bold text-white uppercase">Publish Route Map</span>
                    </label>

                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-400 text-neutral-950 font-black uppercase text-xs rounded-2xl shadow-xl shadow-emerald-500/20 hover:scale-105 transition">
                        💾 Save Tour Route
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function routeMapEditor() {
    return {
        map: null,
        polyline: null,
        markersGroup: null,
        routeColor: '#10b981',
        centerLat: 8.9772,
        centerLng: 98.8202,
        zoomLevel: 11,
        waypoints: [
            { name: 'Cheow Lan Pier (ท่าเรือเชี่ยวหลาน)', lat: 8.9772, lng: 98.8202, type: 'boat', description: 'จุดลงเรือหางยาวมุ่งหน้าสู่เขื่อน' },
            { name: 'Khao Sam Kloe (เขาสามเกลอ)', lat: 8.9420, lng: 98.6630, type: 'viewpoint', description: 'กุ้ยหลินเมืองไทย จุดถ่ายรูปไฮไลต์' },
            { name: 'Pakarang Cave (ถ้ำปะการัง)', lat: 8.9300, lng: 98.6100, type: 'trekking', description: 'เดินป่าสั้นและนั่งแพไม้ไผ่ชมหินงอกหินย้อย' }
        ],

        init() {
            this.$nextTick(() => {
                this.initLeaflet();
            });
        },

        initLeaflet() {
            // สร้าง Leaflet Map และใช้ Tile CartoDB Dark Matter เพื่อให้เข้ากับธีม Dark Emerald
            this.map = L.map('adminRouteMap').setView([this.centerLat, this.centerLng], this.zoomLevel);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                maxZoom: 19
            }).addTo(this.map);

            this.markersGroup = L.layerGroup().addTo(this.map);

            // เมื่อคลิกบนแผนที่ ให้สร้างจุดแวะใหม่ทันที
            this.map.on('click', (e) => {
                this.waypoints.push({
                    name: 'Waypoint #' + (this.waypoints.length + 1),
                    lat: parseFloat(e.latlng.lat.toFixed(6)),
                    lng: parseFloat(e.latlng.lng.toFixed(6)),
                    type: 'boat',
                    description: ''
                });
                this.refreshMap();
            });

            this.map.on('moveend', () => {
                const c = this.map.getCenter();
                this.centerLat = parseFloat(c.lat.toFixed(6));
                this.centerLng = parseFloat(c.lng.toFixed(6));
                this.zoomLevel = this.map.getZoom();
            });

            this.refreshMap();
        },

        addWaypoint() {
            const center = this.map.getCenter();
            this.waypoints.push({
                name: 'New Destination Point',
                lat: parseFloat(center.lat.toFixed(6)),
                lng: parseFloat(center.lng.toFixed(6)),
                type: 'boat',
                description: ''
            });
            this.refreshMap();
        },

        removeWaypoint(idx) {
            this.waypoints.splice(idx, 1);
            this.refreshMap();
        },

        refreshMap() {
            if (!this.map) return;
            this.markersGroup.clearLayers();

            const latLngs = [];

            this.waypoints.forEach((pt, index) => {
                if (pt.lat && pt.lng) {
                    const coord = [pt.lat, pt.lng];
                    latLngs.push(coord);

                    // Custom Circle Marker
                    const marker = L.circleMarker(coord, {
                        radius: 8,
                        fillColor: this.routeColor,
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9
                    });

                    marker.bindPopup(`<b>#${index + 1} ${pt.name}</b><br><small>${pt.type.toUpperCase()}</small><br>${pt.description || ''}`);
                    this.markersGroup.addLayer(marker);
                }
            });

            // ลากเส้นโยงระหว่างจุดทั้งหมด (Polyline)
            if (this.polyline) {
                this.map.removeLayer(this.polyline);
            }

            if (latLngs.length > 1) {
                this.polyline = L.polyline(latLngs, {
                    color: this.routeColor,
                    weight: 4,
                    opacity: 0.85,
                    dashArray: '8, 8'
                }).addTo(this.map);
            }
        },

        updatePolyline() {
            this.refreshMap();
        },

        updateMarkers() {
            this.refreshMap();
        }
    }
}
</script>
@endsection