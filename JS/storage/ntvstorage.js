var ntvStorage = {
    /**
     * 前4个函数，维护session级别的本地存储，在一个页面内刷新或跳转，存储一直在，退出页面存储自动删除。
     */
    set: function(key,value){
        let data = {
            data:value
        };
       return sessionStorage.setItem(key, JSON.stringify(data));
    },
    get: function(key){
       let data = sessionStorage.getItem(key);
       let jdata= JSON.parse(data);
       if(jdata && jdata.data){
           return jdata.data;
       }else{
           return data;
       }
    },
    remove:function(key){
        sessionStorage.removeItem(key);
    },
    clear:function(){
        sessionStorage.clear();
    },

    /**
     * 永久存储函数,默认存储时间是3天，可以pset方法中给出失效时间参数，单位 秒
     */
    pset: function(key,value,timeout){
        timeout = timeout || 3600*72;
        let time = (new Date()).valueOf()/1000 + timeout;
        let data = {
            timeout:time,
            data:value
        };

        return localStorage.setItem(key, JSON.stringify(data));   
    },
    pget: function(key){
        let data = localStorage.getItem(key);
        let jdata= JSON.parse(data);
        if(jdata && jdata.timeout){
            let now = (new Date()).valueOf()/1000;
            if(now>jdata.timeout){
                localStorage.removeItem(key);
                return null;
            }else{
                return jdata.data;
            }
        }

        return data;
    },
    premove:function(key){
        localStorage.removeItem(key);
    },
    pclear:function(){
        localStorage.clear();
    }
}