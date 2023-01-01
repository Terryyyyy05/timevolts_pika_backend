<template>
   <header>
      <div @click="logout">登出</div>
   </header>
</template>
<script>
export default {
   methods: {
      logout() {
          this.$router.push({ path: "/" });
      }
   },
};
</script>

<style lang="scss" scoped>
@import "@/assets/css/app.scss";
div {
   color: $primary;
   width: 100%;
   height: 50px;
   padding-top: 15px;
   padding-right: 50px;
   margin: auto;
   text-align: right;
   background-color: $background;
   cursor: pointer;
}
</style>
