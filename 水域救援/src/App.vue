<template>
  <div id="app">
    <!-- <div id="nav">

      <router-link to="/show">show</router-link>
    </div> -->
    <router-view/>
  </div>
</template>

<style>
html,body,#app{
  height:100%;
  padding: 0;
  margin: 0;
}

#app {
   font-family: Avenir, Helvetica, Arial, sans-serif;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   text-align: center;
   color: #2c3e50;
 }

/* // #nav {
//   padding: 30px;

//   a {
//     font-weight: bold;
//     color: #2c3e50;

//     &.router-link-exact-active {
//       color: #42b983;
//     }
//   }
// } */
</style>
