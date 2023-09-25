import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ElementUi from "element-ui"
import 'element-ui/lib/theme-chalk/index.css';
import axios from "axios";
import BaiduMap from "vue-baidu-map";
import VScaleScreen from 'v-scale-screen';
import SlideVerify from 'vue-monoplasty-slide-verify';
import qs from 'qs';
// import jquery from 'jquery';
// import { MessageBox, Message } from 'element-ui';

Vue.config.productionTip = false;
Vue.use(ElementUi);
Vue.use(VScaleScreen);
Vue.use(SlideVerify);
// Vue.use(jquery);
Vue.prototype.axios = axios;
axios.defaults.baseURL = '/api'
Vue.use(BaiduMap,{
  ak:'VGgpudtkzoWI3Ua3q9h2PyGThzbkfknY'

})

// Vue.prototype.$message = function(msg){
//   Message(msg)
// }
// Vue.prototype.$message = function(msg){
//   return Message({
//     message: msg,
//     duration: 1000
//   })
// }
// Vue.prototype.$message.success = function(msg){
//   return Message.success({
//     message: msg,
//     duration: 1000
//   })
// }
// Vue.prototype.$message.warning = function(msg){
//   return Message.warning({
//     message: msg,
//     duration: 1000
//   })
// }

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
