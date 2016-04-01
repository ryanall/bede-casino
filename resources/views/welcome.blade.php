@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
         <div class="row">
            <div class="col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Find a casino</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <div id="casinoLocator"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Criteria</div>
                    <div class="panel-body">
                        <div class="form-group" id="mapSearchForm">
                            <input type="checkbox" id="filterByLocation"> <label for="filterByLocation"> Find casino(s) closest to my location</label><br>
                            <hr>
                            <label for="select">Find casino(s) closest to me</label>
                            <select class="form-control" id="filterByLocationRadius">
                                <option value="5">within 5 miles</option>
                                <option value="10">within 10 miles</option>
                                <option value="20">within 20 miles</option>
                                <option value="30">within 30 miles</option>
                                <option value="40">within 40 miles</option>
                                <option value="50">within 50 miles</option>
                            </select>
                            <br>
                          <div id="geoLocationError" class="alert alert-dismissible alert-danger" style="display:none">
                            <h5><i class="fa fa-thumbs-o-down"></i> Enable Geo Location!</h5>
                            <p>Looks like we're having issues locating you</p>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="badge" id="mapSearchResultsCount"></span> Casinos Found </div>
                    <div class="panel-body casino-map-results">
                        <ul class="list-group" id="mapSearchResults"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Used by Casino Locator -->
    <script src="//maps.googleapis.com/maps/api/js?v=3.exp&key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script src="{{ asset('js/casino_map_locator.js') }}"></script>
@endsection
