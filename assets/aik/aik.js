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
function aikRetrieveJSONCustomSession(url, functionCB, param){
    // $.getJSON(url+param, function(json){
    //     window[functionCB](json);
    // });
    console.log(param);
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