/*
Подтверждения "Точно удалить?", печать и т.д.
*/
function printDiv(divId) {
    var divToPrint = document.getElementById(divId);
    if (!divToPrint) return;
    
    // Находим таблицу внутри div
    var table = divToPrint.querySelector('table');
    if (!table) return;
    
    // Клонируем таблицу
    var cloneTable = table.cloneNode(true);
    
    var newWin = window.open('', '_blank');
    newWin.document.write('<!DOCTYPE html>');
    newWin.document.write('<html><head><title>Печать</title>');
    newWin.document.write('<style>');
    newWin.document.write('table { border-collapse: collapse; width: 100%; }');
    newWin.document.write('th, td { border: 1px solid black; padding: 5px; text-align: left; }');
    newWin.document.write('</style>');
    newWin.document.write('</head><body>');
    newWin.document.write(cloneTable.outerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    newWin.print();
    newWin.close();
}
