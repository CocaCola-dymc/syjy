<template>
    <div id="box">
        <div id="container"></div>
    </div>
</template>

<script>
import AMapLoader from '@amap/amap-jsapi-loader'
window._AMapSecurityConfig = {
    securityJsCode: '41e534cd0e9251839fbc4c9ee791bbf9'
}
export default{
    data(){
        return{
            map: null,
            lng: "113.535965",//经度
            lat: "23.101752",//纬度
            lng1:"",
            lat1:"",
            search_id: 'searchId',
            input: ''

        }
    },
    methods:{
        initMap(){
            AMapLoader.load({
                key: "f6c7a0cf30befbd96a9e35da908c0bc2",
                version: "2.0",
                plugins: ['AMap.Scale' ,'AMap.ToolBar', 'AMap.HawkEye', 'AMap.MapType','AMap.ControlBar'],
            }).then((AMap) =>{
                // var buildings = new AMap.Buildings({
                //     'zooms':[16,18],
                //     'zIndex':10,
                //     'heightFactor':2//2倍于默认高度，3D下有效
                // });//楼块图层                 

                this.map = new AMap.Map("container",{
                    viewMode: '3D',
                    zoom: 18,
                    center: [this.lng,this.lat],
                    // rotation: -35,
                    // features: ['bg','road','point'],
                    // mapStyle:'amap://styles/light',
                    // layers: [new AMap.TileLayer.Satellite(),//高德默认标准图层
                    //         buildings],
                    
                })

                // 比例尺
                this.map.addControl(new AMap.Scale({
                    // position: 'LB'
                }))
                // 工具条
                this.map.addControl(new AMap.ToolBar({
                    // positoin:'RT'
                    position:{
                        top: '130px',
                        left: '50px'
                    }
                }))
                // 工具条方向盘
                this.map.addControl(new AMap.ControlBar({

                }))
                // 缩略图
                this.map.addControl(new AMap.HawkEye({
                    // position:'LT'
                }))
                // 图层切换
                this.map.addControl(new AMap.MapType({
                    // position: 'RT'
                }))
                // 定位
                // this.map.addControl( new AMap.Geolocation({
                //     // position:'RT'//right top
                // }))  
                this.map.setFeatures(['road','point','bg','building'])
                var marker = new AMap.Marker({
                    position: new AMap.LngLat(this.lng,this.lat)
                })  
                this.map.add(marker);  
                AMap.plugin('AMap.Geolocation', function() {
                    var geolocation = new AMap.Geolocation({
                        // 是否使用高精度定位，默认：true
                        enableHighAccuracy: true,
                        // 设置定位超时时间，默认：无穷大
                        timeout: 10000,
                        // 定位按钮的停靠位置的偏移量
                        offset: [10, 20],
                        //  定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
                        zoomToAccuracy: true,     
                        //  定位按钮的排放位置,  RB表示右下
                        position: 'RB'
                    })

                    geolocation.getCurrentPosition(function(status,result){
                            if(status=='complete'){
                                onComplete(result)
                            }else{
                                onError(result)
                            }
                    });

                    function onComplete (data) {
                        console.log(data)
                        // data是具体的定位信息
                    }

                    function onError (data) {
                        console.log(data)
                        // 定位出错
                    }
                })    

            }).catch(e=>{
                console.log(e);
            })
        },
        sendMsg() {
            bus.$emit('share', this.input)
        },
        sendId() {
            bus.$emit('share_id', this.search_id)
        },

    },
    mounted(){
        this.initMap();
    }
}
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
}
html,body{
    height: 100%;
}
#box{
    width: 100%;
    height: 100%;
}
#input{
    width: 100%;
    height: 6%;
    background-color: antiquewhite;

}
#inputbox{
    width: 50%;
    height: 5%;
    display: flex;
    justify-content: space-between;
    /* padding-top: 10px; */
    margin-left: 30px;


}
#container{
    width: 100%;
    height: 94%;
    
    /* background-color: rgb(124, 198, 240); */
    /* margin-top: 30px; */
}

</style>