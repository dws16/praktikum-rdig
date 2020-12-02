// ? JSON
function aikConsoleURL(url) {
    var xhr = new XMLHttpRequest();
    var url = url;
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            // document.getElementById("hasil").innerHTML = this.responseText;
            console.log(url, this.responseText);
        }
    };
    xhr.open("GET", url, true);
    xhr.send();
}
function aikRetrieveURL(url, callback) {
    var xhr = new XMLHttpRequest();
    var url = url;
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            callback(this.responseText);
        }
    };
    xhr.open("GET", url, true);
    xhr.send();
}
function aikRetrieveJSONCustom(url, functionCB){
    $.getJSON(url, function(json){
        window[functionCB](json);
    });
}
async function aikFetchJSON(url){
    // await response of fetch call
    let response = await fetch(url);
    // only proceed once promise is resolved
    let data = await response.json();
    // only proceed once second promise is resolved

    // // 1 Line
    // let data = await (await fetch(url)).json();
    return data;

    // // trigger async function
    // // log response or catch error of fetch promise
    // aikFetchJSON()
    //     .then(data => console.log(data))
    //     .catch(reason => console.log(reason.message))
}

// ? DataTable
function aikTableIndex(dataTableName){
    dataTableName.on( 'order.dt search.dt', function () {
        dataTableName.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
}
function aikTableOptionsDefault(type){
    aikOptions = {
        order: [[ 1, 'asc' ]],
        columnDefs: [ {
            "searchable": false,
            "orderable": false,
            "targets": [0, -1]
        } ],
    }
    if(type == 1){
        aikOptions['columnDefs'] = [ {
            "searchable": false,
            "orderable": false,
            "targets": [0]
        } ];
    }
    return aikOptions;
}

// ? Submit Button
function aikdisableSubmitButton() {
    function disableField() {
        const invalidForm = document.querySelector('form:invalid');
        const submitBtn = document.getElementById('submitNilai');
        if (invalidForm) {
            submitBtn.setAttribute('disabled', true);
        } else {
            submitBtn.disabled = false;
        }
        }
        disableField();
        const inputs = document.getElementsByTagName("input");
        for (let input of inputs) {
            input.addEventListener('change', disableField);
    }
}

// ? Additional
function timer(count, data){
    let timer;
    window.clearInterval(timer);
    timer = setInterval(() => {
        if(count === 0) {
          window.clearInterval(timer);
          console.log(count, data);
        }
        console.log(count);
        count--;
    }, 1000);
}
function testObject() {
    var user = {
        name : "John",
        age  : 25
    }
    for(const property in user) {
        console.log(`user[${property}] = ${user[property]}`);
    }
}
function testObjectArray() {
    var user = {
        name : "John",
        age  : 25
    }
    data = [];
    data.push(user, user);
    console.log(data[0]);
    // for(const property in user) {
    //     console.log(`user[${property}] = ${user[property]}`);
    // }
}