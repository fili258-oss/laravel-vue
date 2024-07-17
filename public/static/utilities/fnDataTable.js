const BASE_URL = "http://127.0.0.1:8000/";
function destruirTable(idTable)
{
  if($.fn.DataTable.isDataTable( '#'+idTable ) == true)
  {
    window['table_'+idTable].destroy();
  }
}

function inicia_tabla(idTable)
{
  window['interval_table_'+idTable] = setInterval(()=>{inicia_tabla_delay(idTable);},100);
}

function inicia_tabla_delay(idTable)
{
  if(($(".activeDT").length)?true:false)
  {
    if($.fn.DataTable.isDataTable( '#'+idTable ) == false)
    {
      console.log("idTable", idTable);
      window['table_'+idTable] = $( '#'+idTable ).DataTable( window.lenguageButtons );
    }
    clearInterval(window['interval_table_'+idTable]);
  }
}

window.lenguage = {
  "language":
  {
    "url": BASE_URL+"static/utilities/es.json"
  },
  columnDefs: [
      { width: '120px', targets: 0 }
  ],
  ordering: false
}

window.lenguageButtons = {
  "language":
  {
    "url": BASE_URL+"static/utilities/es.json"
  },
  columnDefs: [
      { width: '120px', targets: 0 }
  ],
  ordering: false,
  dom: 'Bfrtip',
  buttons: [
    'copy', 'csv', 'excel'
  ]
}