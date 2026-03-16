@extends('layouts.masterTemplatePage')

@section('content')




<style>

.container{
display:flex;
height:100vh;
}

.left{
width:25%;
border-right:1px solid #ccc;
padding:10px;
overflow:auto;
}

.right{
width:75%;
padding:10px;
}

textarea{
width:100%;
height:120px;
}

table{
border-collapse:collapse;
width:100%;
margin-top:20px;
}

table,th,td{
border:1px solid #ccc;
padding:5px;
}

ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.columns ul {
    list-style: none;
    padding-left: 15px;
}

.columns li {
    list-style: none;
    padding: 1px;

}

li:hover,           /* all li hover */
.table-item:hover,  /* the table names */
.columns li:hover { /* column names */
    cursor: pointer;
    border: 1px solid #ccc;
}

/* Main table items */
.table-item {
    cursor: pointer;
    background-color: #f0f8ff;  /* light blue */
    padding: 8px 12px;
    margin-bottom: 4px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

/* Hover effect on main li */
.table-item:hover {
    background-color: #d0e6ff; /* darker blue on hover */
}
</style>

</head>

<body>

<div class="container">
    <div class="left">
        <h3>Tables</h3>
        <ul id="tables"></ul>
    </div>

    <div class="right">
        <h3>Query</h3>
        <textarea id="query"></textarea>
        <br><br>
        <button id="execute">Execute</button>
        <div id="results" style="overflow-x: scroll"></div>
    </div>

</div>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript">
//SANI: Load datatable
$(document).ready(function()
{
    loadTables();
});

//SANI: function definition
function loadTables()
{

    $.get('/query-analyzer/tables',function(data)
    {
        data.forEach(function(table)
        {

            $('#tables').append(
            `<li class="table-item" data-table="${table.TABLE_NAME}">
                <span class="icon">+</span><b> ${table.TABLE_NAME} </b>
                <div class="columns" style="display:none"></div>
            </li>`
            )

        });

    });

}


$(document).on('click','.table-item',function()
{

    let table = $(this).data('table')
    let columnsDiv = $(this).find('.columns')
    let icon = $(this).find('.icon')

    //SANI: collapse if already open

    if(columnsDiv.is(':visible'))
    {
        
        columnsDiv.slideUp()
        icon.text('+')
        
        return
    }

    //SANI: load columns only once 

    if(columnsDiv.children().length == 0)
    {

        $.get('/query-analyzer/columns/'+table,function(cols)
        {
            let html = "<ul>"
            cols.forEach(function(col)
            {
                html += `<li>${col.COLUMN_NAME}</li>`
            });

            html += "</ul>"

            columnsDiv.html(html)

        });

    }

//SANI: show columns

columnsDiv.slideDown();
icon.text('-');

})


$('#execute').click(function()
{

    let query = $('#query').val()

    $.post('/query-analyzer/execute',
    {
    query:query,
    _token:'{{ csrf_token() }}'
    },function(res)
            {
                if(res.error)
                {
                    alert(res.error)
                    return
                }

                renderTable(res);

            });

});


function renderTable(data)
{

    if(data.length == 0)
    {
        $('#results').html("No Results")
        return
    }

    let columns = Object.keys(data[0]);

    let html = "<table><tr>"

    columns.forEach(function(col)
                    {
                        html += `<th>${col}</th>`
                    })

    html += "</tr>"

    data.forEach(function(row)
                {

                    html += "<tr>"

                    columns.forEach(function(col)
                    {
                        html += `<td>${row[col]}</td>`
                    })

                    html += "</tr>"

                })

    html += "</table>"

    $('#results').html(html)

}
</script>



@endsection