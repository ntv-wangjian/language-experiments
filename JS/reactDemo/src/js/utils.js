export function setSessionStorage(key,value){
    let data = {
        data:value
    };
   return sessionStorage.setItem(key, JSON.stringify(data));
}

export function getSessionStorage(key){
    let data = sessionStorage.getItem(key);
    let jdata= JSON.parse(data);
    if(jdata && jdata.data){
        return jdata.data;
    }else{
        return data;
    }
}

export function setStorage(key,json) {
    try{
        localStorage.setItem(key, JSON.stringify(json));
    }catch(err){
        console.log(err.message);
    }
}

export function getStorage(key) {
    var json = localStorage.getItem(key);
    if(typeof json == 'string'){
        try{
            var data=JSON.parse(json);
            return data;
        }catch(err){
            console.log(err);
            return false;
        }
    }
    
}
export function removeStorage(key) {
    localStorage.removeItem(key);
}

export function removeAllStorage() {
    localStorage.clear();
}


//获取地址栏参数
export function urlPara() {
    var url = window.location.search;
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        var strs = str.split("&");
        for(var i = 0; i < strs.length; i ++) {
            theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}