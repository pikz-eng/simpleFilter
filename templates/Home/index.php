<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<label>Countries</label>
<label>Countries</label>
<select id="countries">
</select>
<br>
<label>Regions</label>
<select id="regions">
</select>
<br>
<table id="users" class="display stripe hover row-border order-column"></table>
<script>

    $(document).ready(function () {
        $.ajax({
            url: 'http://localhost/projects/app_data/countries/getCountries',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var countries = $('#countries');
                $.each(data, function (index, country) {
                    countries.append('<option value="' + country.id + '">' + country.name + '</option>');

                });
                var countryId = $('#countries').val();
                populateRegionsSelect(countryId);

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });

    $('#countries').change(function () {
        var countryId = $(this).val();
        populateRegionsSelect(countryId);
        event.preventDefault();


    });
    $("#regions").change(function () {
        var regionId = $(this).val();
        populateUsers(regionId);
        event.preventDefault();
    });

    function populateRegionsSelect(countryId) {
        $.ajax({
            url: 'http://localhost/projects/app_data/regions/getRegionsByCountry',
            data: {country_id: countryId},
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var regions = $('#regions');
                regions.empty();
                $.each(data, function (index, region) {
                    regions.append('<option value="' + region.id + '">' + region.name + '</option>');

                });
                var regionId = $('#regions').val();
                var countryId = $('#countries').val();
                populateUsers(regionId,countryId);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function populateUsers(regionId,countryId) {
        var table = $('#users');
        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }
        var table = $('#users').DataTable({
            serverSide: true,
            processing: true,
            "ajax": {
                "url": "http://localhost/projects/app_data/users/getUsersByRegion",
                "data": {region_id: regionId,country_id:countryId},
                "dataType": 'Json',
                "dataSrc": "data"

            },
            "columns": [

                {
                    "title": "Name",
                    "data": "name",
                    "type": "text"
                },

                {
                    "title": "Region",
                    "data": "region_name",
                    "type": "text"
                },

                {
                    "title": "Country",
                    "data": "country_name",
                    "type": "text"
                }

            ]

        });

    }

</script>
<style>
    .users-table {
        border-collapse: collapse;
        border: 2px solid black;
        width: 100%;
    }

    .users-table th,
    .users-table td {
        border: 1px solid black;
        padding: 5px;
    }

    .users-table tbody tr:hover {
        cursor: pointer;
    }

    .users_wrapper {
        margin-top: 20px;
    }
</style>
