<template>
  <side-bar/>
  <the-header/>
  <div class="container">
    <router-view />

  </div>
</template>

<style lang="scss">
@import '@/assets/reset.css';
@import '@/assets/css/app.scss';
#app{
  color: $color;
}

</style>
