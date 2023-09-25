import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import gpsshow from '../views/gpsshow.vue'
import showmsg from "../views/showmsg.vue"
import test from "../views/test.vue"
import login from "../views/login.vue"
import forget from "../views/forget.vue";

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
    name: gpsshow,
    component: gpsshow
  },
  {
    path: '/showmsg',
    name: showmsg,
    component: showmsg
  },
  {
    path: '/test',
    name: test,
    component: test
  },
  {
    path: '/login',
    name: login,
    component: login
  },
  {
    path: '/forget',
    name: forget,
    component: forget
  }
]

const router = new VueRouter({
  routes
})

export default router
