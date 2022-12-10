<template>
    <h1>{{ heading }}</h1>
 </template>
 
 <script>
 export default {
    props: ["heading"],
 };
 </script>
 
 <style lang="scss" scoped>
 @import "@/assets/css/app.scss" ;
 
 h1{
    color: $primary;
    font-weight: bold;
    font-size: 50px;
 }
 
 
 </style>
 