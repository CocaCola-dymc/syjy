import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import gpsshow from "../views/gpsshow.vue"
import Login from "../views/Login.vue";
import resetsecret from "../views/resetsecret.vue"
import addmachine from "../views/addMachine.vue"
import userIndex from "../views/userIndex.vue"
import gaodegps from '../views/gaodegps.vue'
import Search from '../views/Search.vue'
import alertcontent from "../views/alertcontent.vue";
import cardmanage from "../views/cardmanage.vue";


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/gpsshow',
    name: 'gpsshow',
    component: gpsshow
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/resetsecret',
    name: 'resetsecret',
    component: resetsecret
  },
  {
    path: '/addmachine',
    name: 'addmachine',
    component: addmachine
  },
  {
    path: '/userIndex',
    name: 'userIndex',
    component: userIndex
  },
  {
    path: '/gaodegps',
    name: 'gaodegps',
    component: gaodegps
  },
  {
    path: '/search',
    name: 'Search',
    component: Search
  },
  {
    path: '/alertcontent',
    name: 'alertcontent',
    component: alertcontent
  },
  {
    path: '/cardmanage',
    name: 'cardmanage',
    component: cardmanage
  }
]

const router = new VueRouter({
  routes
})

export default router
