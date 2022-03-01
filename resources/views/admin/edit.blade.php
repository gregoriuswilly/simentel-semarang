@extends('layouts.main-admin')
@section('content')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}">
        //punya jeremy
    </script>
    <script>
        function initialize() {
            // Creating map object
            let lat = document.getElementById('txtLat').value;
            let lng = document.getElementById('txtLng').value;
            // const uluru = {
            //     lat: -7.095,
            //     lng: 110.095
            // };
            const svgMark = {
                url: "{{ url('/images/tower_marker.svg') }}",
                scaledSize: new google.maps.Size(40, 40), // scaled size
            };

            const map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 15,
                // center: new google.maps.LatLng(-7.09275, 110.32743),
                scrollwheel: false,
                center: new google.maps.LatLng(lat, lng),
                // center: uluru,
            });

            // creates a draggable marker to the given coords
            let vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                icon: svgMark,
                map: map,
                // position: uluru,
                draggable: true
            });

            // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'drag', function(evt) {
                $("#txtLat").val(evt.latLng.lat().toFixed(6));
                $("#txtLng").val(evt.latLng.lng().toFixed(6));
                map.panTo(evt.latLng);
            });

            // centers the map on markers coords
            map.setCenter(vMarker.position);

            // adds the marker on the map
            vMarker.setMap(map);
        }
    </script>

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Edit Form <span><a style="color: grey" data-toggle="tooltip"
                                data-placement="right" title="Anda hanya bisa mengubah beberapa data."><i
                                    class="fas fa-info-circle"></i></a></span></h4>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><b><i>No. Tiket: {{ $data->id }}</i></b></div>
                                <div class="card-title"><i>{{ $data->tower->idMenara }}</i></div>
                            </div>
                            <div class="card-body" style="border-bottom: 1px solid #ebecec">
                                <p><b>Anda dapat menghubungi pendaftar:</b></p>
                                <p class="mb-0">Nama: {{ $data->user->name }}</p>
                                <p class="mb-0">No HP: {{ $data->user->phone }}</p>
                                <p class="mb-0">Email: {{ $data->user->email }}</p>
                            </div>
                            {{-- Form Edit --}}
                            <form action="/admin/pendaftaran/{{ $data->id }}" method="post">
                                @method('put')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pemilik">Pemilik</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->pemilik }}" id="pemilik" name="pemilik"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tinggi">Tinggi</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $data->tower->tinggi }}" id="tinggi" name="tinggi"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">meter</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="luas">Luas</label>
                                                <input type="text" class="form-control" value="{{ $data->tower->luas }}"
                                                    id="luas" name="luas" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kecamatan">Kecamatan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->kecamatan->name }}" id="kecamatan"
                                                    name="kecamatan" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kelurahan">Kelurahan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->kelurahan->name }}" id="kelurahan"
                                                    name="kelurahan" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->latitude }}" id="txtLat" name="latitude">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->longitude }}" id="txtLng" name="longitude">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="map_canvas" style="width: auto; height: 400px;"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipesite">Tipe Site</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->tipesite->name }}" id="tipesite"
                                                    name="tipesite" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipejalan">Tipe Jalan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->tipejalan->name }}" id="tipejalan"
                                                    name="tipejalan" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi</label>
                                        <textarea class="form-control" id="kondisi" name="kondisi" rows="4"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="penyewa">Penyewa</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->penyewa }}" id="penyewa" name="penyewa">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="operator">Operator</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->operator }}" id="operator" name="operator">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="noimb">No IMB</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data->tower->noIMB }}" id="nomorIMB" name="nomorIMB">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success" type="submit">Simpan</button>
                                    {{-- <button class="btn btn-danger">Cancel</button> --}}
                                    <a class="btn btn-danger" href="/admin/pendaftaran">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
