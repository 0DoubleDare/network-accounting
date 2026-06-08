/*
Подтверждения "Точно удалить?", печать.
*/

/**
 * Функици
 */
function printDiv(divId) {
    let divToPrint = document.getElementById(divId);
    if (!divToPrint) return;
    
    // Находим таблицу внутри div
    let table = divToPrint.querySelector('table');
    if (!table) return;
    
    // Клонируем таблицу
    let cloneTable = table.cloneNode(true);

    // Убирает кнопки
    cloneTable.querySelectorAll('tr').forEach(row => row.lastElementChild?.remove());
    
    let newWin = window.open('', '_blank');
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

// Материалы
function printDiv2(divId) {
    printDiv(divId);
}

// Расход материалов
function printDiv3(divId) {
    printDiv(divId);
}

//Дефекты
function printDiv4(divId){
    printDiv(divId);
}