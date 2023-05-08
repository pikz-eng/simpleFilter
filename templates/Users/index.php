


<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>


<table id="users-table" class="table table-striped dtr-control sorting_1 ">


    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Region</th>
        <th>Country</th>
    </tr>

    </thead>
    <tfoot>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Region</th>
        <th>Country</th>


    </tr>
    </tfoot>

</table>

<script>
    $(document).ready(function () {
        $('#users-table').DataTable({

            "rowId": 'id',
            "processing": true,
            "serverSide": true,

            "ajax": {

                "url": "http://localhost/projects/app_data/users/getData",
                "type": "GET",
                "dataType": "json",
                "data": "data.data",

            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "region"},
                {"data": "country"},

            ],

        });
    })


</script>






<style>
    #users-table {
        border-collapse: collapse;
        border: 2px solid black;
        width: 100%;
    }

    #usersTable th,
    #usersTable td {
        border: 1px solid black;
        padding: 5px;
    }
</style>
<style>
    #users-table tbody tr:hover {
        cursor: pointer;
    }
</style>
























