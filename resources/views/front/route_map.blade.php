@extends('layouts.app')

@section('title', 'Expedition Packages & Route Maps - Khao Sok Rango Tour')

@section('content')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    /* Custom Glow for Map Markers */
    .leaflet-popup-content-wrapper {
        background: rgba(10, 12, 16, 0.95) !important;
        color: #f4f4f5 !important;
        border: 1px solid rgba(16, 185, 129, 0.4) !important;
        border-radius: 1rem !important;
        backdrop-filter: blur(12px) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.7) !important;
    }
    .leaflet-popup-tip {
        background: #0a0c10 !important;
    }
    .custom-marker-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(0, 0, 0, 0.92);
        border: 1.5px solid #10b981;
        padding: 4px 10px;
        border-radius: 9999px;
        color: #ffffff;
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 0 18px rgba(16, 185, 129, 0.6), 0 4px 6px -1px rgba(0, 0, 0, 0.8);
        white-space: nowrap;
    }
    .marker-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #34d399;
        box-shadow: 0 0 8px #34d399;
        animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="rangoMultiRouteMap()">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-neutral-900">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-xs font-mono-code font-bold uppercase tracking-widest text-emerald-400">
                    SATELLITE EXPEDITION CORRIDORS // MULTI-PACKAGE ROUTES
                </span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white uppercase">
                Tour Package Routes
            </h1>
            <p class="text-xs sm:text-sm text-neutral-400 mt-2 max-w-2xl">
                Explore our signature expedition itineraries on high-definition satellite terrain. Select any tour package below to view its specific transit points, lake boat routes, and trekking milestones.
            </p>
        </div>

        <!-- Package Selector Tabs (ดึงจากฐานข้อมูลหลังบ้าน) -->
        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 bg-neutral-900/90 p-1.5 rounded-2xl border border-neutral-800 self-start md:self-auto">
            <template x-for="(pkg, key) in packages" :key="key">
                <button type="button" 
                        @click="switchPackage(key)" 
                        :class="selectedKey === key ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/20' : 'text-neutral-400 hover:text-white'"
                        class="px-3.5 py-2 rounded-xl text-xs font-mono-code uppercase tracking-wider transition text-center flex items-center justify-center gap-1.5">
                    <span x-text="pkg.badge" class="text-[9px] px-1.5 py-0.5 rounded-md font-bold uppercase"
                          :class="selectedKey === key ? 'bg-black/20 text-neutral-950' : 'bg-neutral-800 text-emerald-400'"></span>
                    <span x-text="pkg.shortName"></span>
                </button>
            </template>
        </div>
    </div>

    <!-- Map & Itinerary Details Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Left: Package Details & Waypoint Milestones (4 Cols) -->
        <div class="lg:col-span-4 bg-neutral-900/90 rounded-3xl border border-neutral-800 p-6 flex flex-col justify-between space-y-6 shadow-2xl">
            
            <div class="space-y-5">
                <!-- Current Package Summary Card -->
                <div class="p-4 rounded-2xl bg-black/60 border border-emerald-500/20 space-y-3">
                    <div class="flex items-center justify-between text-xs font-mono-code text-neutral-400">
                        <span class="px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 font-bold border border-emerald-500/30" x-text="currentPkg.badge"></span>
                        <span class="text-teal-400 font-bold font-mono-code" x-text="currentPkg.duration"></span>
                    </div>
                    <h3 class="text-base font-black text-white uppercase leading-snug" x-text="currentPkg.title"></h3>
                    <p class="text-xs text-neutral-400 leading-relaxed" x-text="currentPkg.description"></p>
                    
                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-neutral-800 text-xs font-mono-code">
                        <div>
                            <span class="text-neutral-500 text-[10px] block uppercase">TOTAL NODES</span>
                            <span class="text-emerald-400 font-bold" x-text="currentPkg.waypoints.length + ' Waypoints'"></span>
                        </div>
                        <div>
                            <span class="text-neutral-500 text-[10px] block uppercase">INDICATIVE RATE</span>
                            <span class="text-white font-bold" x-text="currentPkg.rate"></span>
                        </div>
                    </div>
                </div>

                <!-- Waypoint Nodes Timeline -->
                <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                    <span class="text-[11px] font-mono-code uppercase text-neutral-400 font-bold block tracking-wider">// ITINERARY MILESTONES (<span x-text="currentPkg.waypoints.length"></span> NODES)</span>
                    
                    <div class="relative pl-6 space-y-4 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-emerald-500 before:via-teal-400 before:to-emerald-500">
                        <template x-for="(point, idx) in currentPkg.waypoints" :key="idx">
                            <div class="relative group cursor-pointer" @click="focusWaypoint(point.lat, point.lng)">
                                <!-- Step Circle Indicator -->
                                <div class="absolute -left-6 top-1 w-5 h-5 rounded-full bg-black border-2 border-emerald-400 flex items-center justify-center text-[9px] font-mono-code font-bold text-emerald-300 group-hover:scale-110 transition">
                                    <span x-text="idx + 1"></span>
                                </div>

                                <div class="bg-black/60 hover:bg-black/90 p-3 rounded-xl border border-neutral-800/80 hover:border-emerald-500/50 transition">
                                    <div class="flex items-center justify-between gap-1">
                                        <h4 class="text-xs font-bold text-white uppercase truncate" x-text="point.title"></h4>
                                        <span class="text-[9px] font-mono-code text-emerald-400 font-bold shrink-0" x-text="point.mode"></span>
                                    </div>
                                    <p class="text-[11px] text-neutral-400 mt-1 leading-relaxed" x-text="point.description"></p>
                                    <span class="text-[9px] font-mono-code text-neutral-500 block mt-1" x-text="Number(point.lat).toFixed(4) + '° N, ' + Number(point.lng).toFixed(4) + '° E'"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Booking / Chat Dispatch Button -->
            <div class="pt-4 border-t border-neutral-800">
                <button type="button" 
                        @click="$dispatch('open-rango-chat', { message: 'Hello! I am inquiring about the itinerary and availability for: ' + currentPkg.title })"
                        class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider py-4 rounded-xl shadow-xl shadow-emerald-500/20 transition">
                    <span>💬 Inquire &amp; Book This Package</span>
                </button>
            </div>

        </div>

        <!-- Right: Leaflet Interactive Satellite Viewport (8 Cols) -->
        <div class="lg:col-span-8 bg-neutral-900 rounded-3xl overflow-hidden border border-neutral-800 shadow-2xl relative min-h-[520px] lg:min-h-[660px]">
            <div id="rangoMap" class="w-full h-full min-h-[520px] lg:min-h-[660px] z-10"></div>
            
            <!-- Map Layer Toggle: Satellite / Dark Mode -->
            <div class="absolute top-4 left-4 z-20 flex items-center bg-black/85 backdrop-blur-md rounded-2xl border border-neutral-800 p-1 font-mono-code text-xs">
                <button type="button" 
                        @click="setMapType('satellite')" 
                        :class="mapType === 'satellite' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'"
                        class="px-3 py-1.5 rounded-xl transition flex items-center gap-1.5">
                    <span>🛰️ Satellite</span>
                </button>
                <button type="button" 
                        @click="setMapType('dark')" 
                        :class="mapType === 'dark' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'"
                        class="px-3 py-1.5 rounded-xl transition flex items-center gap-1.5">
                    <span>🌃 Dark Map</span>
                </button>
            </div>

            <!-- Map Overlay Legend -->
            <div class="absolute bottom-6 left-6 z-20 bg-black/85 backdrop-blur-md p-3.5 rounded-2xl border border-neutral-800 text-[11px] font-mono-code space-y-2 pointer-events-none hidden sm:block">
                <div class="flex items-center gap-2 text-white">
                    <span class="w-3 h-1 bg-emerald-400 rounded-full"></span>
                    <span>Direct Transit Path</span>
                </div>
                <div class="flex items-center gap-2 text-white">
                    <span class="w-3 h-1 bg-teal-300 rounded-full border-b border-dashed border-white"></span>
                    <span>Cheow Lan Lake Boat / Safari Corridor</span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Multi-Package Dynamic Interactive Routing Engine -->
<script>
    function rangoMultiRouteMap() {
        // ดึงข้อมูล Route Maps จากฐานข้อมูลหลังบ้าน
        const dbRouteMaps = @json($routeMaps ?? []);

        // กำหนด Default Fallback เมื่อยังไม่มีข้อมูลในระบบหลังบ้าน
        const defaultPackages = {
            pkg_1day: {
                badge: '1 DAY',
                shortName: 'Cheow Lan Day Trip',
                title: '1-Day Cheow Lan Scenic Explorer',
                duration: 'Full Day (08:00 - 18:30)',
                rate: 'From ฿2,500 / person',
                color: '#10b981',
                description: 'Cruise past the majestic limestone karst pillars of Khao Sam Kloe, hike into Pra Kie Phet Cave, and paddle kayaks at the floating raft house.',
                center: [8.9950, 98.7400],
                zoom: 11,
                waypoints: [
                    { title: 'Cheow Lan Municipal Pier', lat: 8.9774, lng: 98.8202, mode: '🚤 Boat Boarding', description: 'Morning safety briefing and embarkation on a private traditional longtail boat.' },
                    { title: 'Khao Sam Kloe (Guilin of Thailand)', lat: 8.9950, lng: 98.7120, mode: '📸 Scenic Photo Stop', description: 'Iconic three jagged limestone towers rising from emerald waters.' },
                    { title: 'Pra Kie Phet Cave (Diamond Cave)', lat: 9.0450, lng: 98.6150, mode: '🔦 Cave Exploration', description: 'Guided trek through shimmering stalagmites and ancient limestone caverns.' },
                    { title: 'Floating Restaurant & Lagoon', lat: 9.0125, lng: 98.6650, mode: '🍽️ Southern Thai Lunch', description: 'Authentic local buffet lunch followed by swimming and self-guided kayaking.' },
                    { title: 'Return to Ratchaprapha Marina', lat: 8.9774, lng: 98.8202, mode: '🚐 Evening Transfer', description: 'Return to the main pier and private transfer to your onward destination.' }
                ]
            },
            pkg_2d1n: {
                badge: 'POPULAR 2D1N',
                shortName: '2D1N Lake Escape',
                title: '2D1N Luxury Floating Bungalow & Safari',
                duration: '2 Days / 1 Night',
                rate: 'From ฿6,900 / person',
                color: '#10b981',
                description: 'The definitive Khao Sok experience: stay in floating glass-front bungalows, experience dusk wildlife boat safaris, and wake up to serene morning mist.',
                center: [9.0200, 98.8000],
                zoom: 10,
                waypoints: [
                    { title: 'Surat Thani Airport / Hotel', lat: 9.1326, lng: 99.1411, mode: '🚐 VIP Minivan Pickup', description: 'Flight meet-and-greet with luxury air-conditioned transfer.' },
                    { title: 'Ratchaprapha Dam Viewpoint', lat: 8.9740, lng: 98.8160, mode: '📷 Panoramic Vista', description: 'Overlook the majestic reservoir and hydroelectric reservoir ridge.' },
                    { title: 'Cheow Lan Pier Departure', lat: 8.9774, lng: 98.8202, mode: '🚤 Private Boat Cruise', description: 'Scenic cruise heading deep into the inner lake national park boundary.' },
                    { title: 'Khao Sam Kloe Karsts', lat: 8.9950, lng: 98.7120, mode: '📸 Iconic Landmark', description: 'Pass the legendary karst pinnacles on the way to the floating sanctuary.' },
                    { title: 'Luxury Floating Raft Resort', lat: 9.0125, lng: 98.6650, mode: '🏝️ Overnight Stay', description: 'Check-in to your private over-water bungalow with direct lagoon access.' },
                    { title: 'Dusk Wildlife Boat Safari', lat: 9.0380, lng: 98.6400, mode: '🦧 Sunset Safari', description: 'Spot wild elephants, hornbills, and gibbons along the remote forested shoreline.' }
                ]
            },
            pkg_3d2n: {
                badge: 'SIGNATURE 3D2N',
                shortName: '3D2N Jungle & Lake',
                title: '3D2N Ultimate Rainforest & Lake Expedition',
                duration: '3 Days / 2 Nights',
                rate: 'From ฿11,500 / person',
                color: '#10b981',
                description: 'Combine the ancient terrestrial jungle of Khao Sok National Park HQ with the floating tranquil paradise of Cheow Lan Lake and Coral Cave.',
                center: [8.9600, 98.6700],
                zoom: 10,
                waypoints: [
                    { title: 'Khao Sok National Park HQ', lat: 8.9142, lng: 98.5300, mode: '🌿 Jungle Basecamp', description: 'Arrival at rainforest eco-lodge and visit the ethical elephant sanctuary.' },
                    { title: 'Sok River Bamboo Rafting', lat: 8.9050, lng: 98.5200, mode: '🎋 Bamboo Drift', description: 'Drift past vertical cliffs with fresh jungle drip-coffee served in bamboo cups.' },
                    { title: 'Cheow Lan Lake Pier', lat: 8.9774, lng: 98.8202, mode: '🚤 Embark Longtail', description: 'Transition from rainforest canopy to deep turquoise freshwater lake.' },
                    { title: 'Luxury Floating Bungalow', lat: 9.0125, lng: 98.6650, mode: '🏝️ Floating Resort', description: 'Overnight in pristine stillness surrounded by limestone cliffs.' },
                    { title: 'Coral Cave (Pakarang Cave)', lat: 8.9800, lng: 98.6300, mode: '🔦 500-Rai Trek', description: 'Jungle trek crossing an inland lagoon on bamboo rafts into Coral Cave.' },
                    { title: 'Sunrise Morning Mist Safari', lat: 9.0300, lng: 98.6700, mode: '🌅 Dawn Safari', description: 'Early morning silent cruise listening to the calls of wild gibbons.' }
                ]
            }
        };

        // แปลงข้อมูลจาก DB ให้ตรงตามโครงสร้างของแผนที่
        let dynamicPackages = {};
        if (Array.isArray(dbRouteMaps) && dbRouteMaps.length > 0) {
            dbRouteMaps.forEach((mapItem, idx) => {
                const key = 'pkg_map_' + mapItem.id;
                const waypoints = (mapItem.waypoints || []).map(wp => ({
                    title: wp.name || wp.title || 'Waypoint',
                    lat: parseFloat(wp.lat),
                    lng: parseFloat(wp.lng),
                    mode: (wp.type || wp.mode || 'transit').toUpperCase(),
                    description: wp.description || ''
                }));

                dynamicPackages[key] = {
                    badge: mapItem.tour ? (mapItem.tour.duration_days + 'D' + mapItem.tour.duration_nights + 'N') : 'ROUTE ' + (idx + 1),
                    shortName: mapItem.title.length > 18 ? mapItem.title.substring(0, 16) + '..' : mapItem.title,
                    title: mapItem.title,
                    duration: mapItem.tour ? (mapItem.tour.duration_days + ' Days / ' + mapItem.tour.duration_nights + ' Nights') : 'Scenic Route',
                    rate: mapItem.tour ? ('From ฿' + Number(mapItem.tour.price).toLocaleString() + ' / person') : 'Customized Route',
                    color: mapItem.route_color || '#10b981',
                    description: mapItem.description || 'Full-guided navigation pathway across Khao Sok & Cheow Lan Lake.',
                    center: [parseFloat(mapItem.center_lat) || 8.9774, parseFloat(mapItem.center_lng) || 98.8202],
                    zoom: parseInt(mapItem.zoom_level) || 11,
                    waypoints: waypoints
                };
            });
        } else {
            dynamicPackages = defaultPackages;
        }

        const keys = Object.keys(dynamicPackages);
        const firstKey = keys.length > 0 ? keys[0] : 'pkg_1day';

        return {
            map: null,
            mapType: 'satellite',
            tileLayers: {},
            polylineGlow: null,
            polylineCore: null,
            markersGroup: null,
            packages: dynamicPackages,
            selectedKey: firstKey,

            get currentPkg() {
                return this.packages[this.selectedKey] || this.packages[Object.keys(this.packages)[0]];
            },

            init() {
                this.$nextTick(() => {
                    this.initMap();
                });
            },

            initMap() {
                const initial = this.currentPkg;
                
                // 1. Initialize Leaflet Map
                this.map = L.map('rangoMap', {
                    zoomControl: false,
                    attributionControl: false
                }).setView(initial.center, initial.zoom);

                L.control.zoom({ position: 'topright' }).addTo(this.map);

                // 2. Define High-Def Tile Layers
                // A. ดาวเทียม Esri World Imagery ความละเอียดสูง
                this.tileLayers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19
                });

                // B. แผนที่ Dark Mode CartoDB
                this.tileLayers.dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    maxZoom: 18,
                    subdomains: 'abcd'
                });

                // Default layer: Satellite
                this.tileLayers.satellite.addTo(this.map);

                // 3. Render Route & Markers
                this.renderRoute();
            },

            setMapType(type) {
                if (this.mapType === type) return;
                this.mapType = type;

                if (type === 'satellite') {
                    this.map.removeLayer(this.tileLayers.dark);
                    this.tileLayers.satellite.addTo(this.map);
                } else {
                    this.map.removeLayer(this.tileLayers.satellite);
                    this.tileLayers.dark.addTo(this.map);
                }
            },

            renderRoute() {
                const pkg = this.currentPkg;
                if (!pkg || !pkg.waypoints || pkg.waypoints.length === 0) return;

                const latlngs = pkg.waypoints.map(w => [w.lat, w.lng]);
                const baseColor = pkg.color || '#10b981';

                if (this.polylineGlow) this.map.removeLayer(this.polylineGlow);
                if (this.polylineCore) this.map.removeLayer(this.polylineCore);
                if (this.markersGroup) this.map.removeLayer(this.markersGroup);

                // 1. เส้นเรืองแสงด้านนอก (Glow)
                this.polylineGlow = L.polyline(latlngs, {
                    color: baseColor,
                    weight: 9,
                    opacity: 0.65,
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(this.map);

                // 2. เส้นประนีออนด้านใน (Neon Dash)
                this.polylineCore = L.polyline(latlngs, {
                    color: '#6ee7b7',
                    weight: 3.5,
                    opacity: 1,
                    dashArray: '8, 8',
                    lineCap: 'round'
                }).addTo(this.map);

                // 3. Markers Group
                this.markersGroup = L.layerGroup().addTo(this.map);

                pkg.waypoints.forEach((wp, index) => {
                    const customIcon = L.divIcon({
                        className: 'custom-leaflet-marker',
                        html: `
                            <div class="custom-marker-badge" style="border-color: ${baseColor}">
                                <span class="marker-dot" style="background-color: ${baseColor}; box-shadow: 0 0 8px ${baseColor};"></span>
                                <span>#${index + 1} ${wp.title}</span>
                            </div>
                        `,
                        iconSize: [160, 32],
                        iconAnchor: [20, 16]
                    });

                    const marker = L.marker([wp.lat, wp.lng], { icon: customIcon })
                        .bindPopup(`
                            <div class="p-2 space-y-1">
                                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">${wp.mode}</span>
                                <h4 class="text-xs font-black text-white uppercase">${wp.title}</h4>
                                <p class="text-[11px] text-zinc-300 leading-relaxed">${wp.description}</p>
                            </div>
                        `);

                    this.markersGroup.addLayer(marker);
                });

                // Smoothly zoom and fit bounds
                if (latlngs.length > 1) {
                    this.map.fitBounds(latlngs, { padding: [50, 50] });
                } else if (latlngs.length === 1) {
                    this.map.setView(latlngs[0], 12);
                }
            },

            switchPackage(key) {
                this.selectedKey = key;
                this.renderRoute();
            },

            focusWaypoint(lat, lng) {
                if (this.map) {
                    this.map.flyTo([lat, lng], 13, { duration: 1.2 });
                }
            }
        }
    }
</script>
@endsection