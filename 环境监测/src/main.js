import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ElenmentUi from "element-ui"
import 'element-ui/lib/theme-chalk/index.css'
import axios from "axios";
import VScaleScreen from 'v-scale-screen';
import SlideVerify from 'vue-monoplasty-slide-verify';
import BaiduMap from "vue-baidu-map";
// import echarts from 'echarts'

Vue.config.productionTip = false;
Vue.use(ElenmentUi);
Vue.use(axios);
Vue.prototype.axios = axios;
Vue.use(VScaleScreen);
Vue.use(SlideVerify);
axios.defaults.baseURL = '/api'
Vue.use(BaiduMap,{
  ak:'Bm9CebO6s8bmkGxlqcpaCW4sPkHGhT3L'

})
// Vue.prototype.$echarts = echarts;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

