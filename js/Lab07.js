var tables = new Array();
var tablecols = new Array();
var tablerows = new Array();
var tableNames = new Array();
var tableNum = 0;
var nowTable = -1;
var line = -1;
function chooseOption(value) {
    if (value == "none"){
        line = -1;
        selectNone();
    }
    else if (value == "create") {
        line = 0;
        create();
    }
    else if (value == "add") {
        line = 10;
        addRow();
    }
    else if (value == "delete_row") {
        line = -10;
        deleteRow();
    }
    else if (value == "delete_table"){
        line = -1;
        deleteTable();
    }
}

function chooseTable(value) {
    nowTable = value;
    createTable();
}

function selectNone() {
    document.getElementById('commit').style.display = "none";
    document.getElementById('addLine').style.display = "none";
    document.getElementById('warn').style.display = "none";
}

function changeSelect() {
    var addElement = document.getElementById('nowTable');
    if (tableNum == nowTable) {
        ++tableNum;
        addElement.options.add(new Option(tableNames[nowTable], nowTable));
        addElement.value = nowTable;
    }
    createTable();
}

function checkCreate() {
    var tableName = document.getElementById('tableName').value;
    var colNum = document.getElementById('colNum').value;
    var isValid1 = (tableName == "Table Name" || tableName == "");
    var isValid2 = /^\+?[1-9][0-9]*$/.test(Number(colNum));
    if ((!isValid1) && (isValid2)) {
        nowTable = tableNum;
        tablecols[nowTable] = colNum;
        tablerows[nowTable] = 0;
        tables[nowTable] = new Array();
        tableNames[nowTable] = tableName;
        addRow();
    }
}

function create() {
    document.getElementById('createTable').style.display = "initial";
    document.getElementById('warn').style.display = "none";
    document.getElementById('commit').style.display = "none";
}

function checkRow() {
    var isValid = true;
    for (var i = 0; i < tablecols[nowTable]; i++) {
        var attrName = "attr" + i;
        var attrVal = document.getElementById(attrName).value;
        if ((attrVal == "") || (attrVal == "Attribute")) {
            isValid = false;
        }
    }
    if (isValid) {
        document.getElementById('commit').style.display = "initial";
        if ((line == 10)||(line == 0)) {
            document.getElementById('commit').addEventListener("click", addTheRow);
        }
        else if (line == -10) {
            document.getElementById('commit').addEventListener("click", findRow);
        }
    }
}

function addTheRow() {
    if ((line == 10)||(line == 0)) {
        ++tablerows[nowTable];
        tables[nowTable][tablerows[nowTable] - 1] = new Array();
        for (var i = 0; i < tablecols[nowTable]; i++) {
            var attrName = "attr" + i;
            var attrVal = document.getElementById(attrName).value;
            tables[nowTable][tablerows[nowTable] - 1][i] = attrVal;
        }
        changeSelect();
    }
}

function createTable() {
    var tableElement = document.getElementById('table');
    tableElement.innerHTML = "";
    var table = document.createElement("table");
    tableElement.appendChild(table);
    var tr = new Array(tablerows[nowTable]);
    for (var i = 0; i < tablerows[nowTable]; i++) {
        tr[i] = document.createElement("tr");
        table.appendChild(tr[i]);
        var td = new Array(tablecols[nowTable]);
        for (var j = 0; j < tablecols[nowTable]; j++) {
            if (i == 0) {
                td[j] = document.createElement("th");
                var txt = document.createTextNode(tables[nowTable][i][j]);
                td[j].appendChild(txt);
                tr[i].appendChild(td[j])
            }
            else {
                td[j] = document.createElement("td");
                var txt = document.createTextNode(tables[nowTable][i][j]);
                td[j].appendChild(txt);
                tr[i].appendChild(td[j])
            }
        }
    }
}

function addRow() {
    if (line != 0)
        document.getElementById('createTable').style.display = "none";
    document.getElementById('warn').style.display = "none";
    document.getElementById('addLine').style.display = "block";
    var addElement = document.getElementById('addLine');
    addElement.innerHTML = "";
    for (var i = 0; i < tablecols[nowTable]; i++) {
        var attrName = "attr" + i;
        addElement.innerHTML += "<input id=" + attrName + " type='text' placeholder='Attribute' onblur='checkRow()'>";
    }
}

function findRow() {
    if (line == -10){
        var row = -1;
        var contents = new Array(tablecols[nowTable]);
        for (var i = 0; i < tablecols[nowTable]; i++) {
            var attrName = "attr" + i;
            var attrVal = document.getElementById(attrName).value;
            contents[i] = attrVal;
        }
        var isRight = true;
        for (var i = 0; i < tablerows[nowTable]; i++) {
            isRight = true;
            for (var j = 0; j < tablecols[nowTable]; j++) {
                if (tables[nowTable][i][j] != contents[j]) {
                    isRight = false;
                    break;
                }
            }
            if (isRight) {
                row = i;
                break;
            }
        }

        if (isRight) {
            for (var i = row + 1; i < tablerows[nowTable]; i++) {
                for (var j = 0; j < tablecols[nowTable]; j++) {
                    tables[nowTable][i - 1][j] = tables[nowTable][i][j];
                }
            }
            tables[nowTable].splice(--tablerows[nowTable], tables[nowTable].length);
            createTable();
        }
    }

}

function deleteRow() {
    document.getElementById('warn').style.display = "none";
    addRow();
}

function deleteTable() {
    document.getElementById('createTable').style.display = "none";
    document.getElementById('addLine').style.display = "none";
    document.getElementById('warn').style.display = "initial";
    document.getElementById('commit').style.display = "initial";
    document.getElementById('commit').addEventListener("click", clearOption);
}

function clearOption() {
    if (line == -1){
        var selectElement = document.getElementById('nowTable');
        var op = selectElement.children;
        for (var i = 0; i < op.length; i++) {
            if (op[i].value == nowTable) {
                selectElement.options.remove(i);
                break;
            }
        }
        var tableElement = document.getElementById('table');
        tableElement.innerHTML = "";
    }

}

