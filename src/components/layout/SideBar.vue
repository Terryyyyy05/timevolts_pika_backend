<template>
    <Menu :theme="theme" active-name="1" class="sidebar">
        
        <MenuGroup title="Timevolts後台管理 ">
            <MenuItem name="1">
                <Icon type="ios-contact" />
                <router-link to="/">會員管理</router-link> 
            </MenuItem>
            <MenuItem name="2">
                <Icon type="md-flash" />
                <router-link to="/News">最新消息管理</router-link>
            </MenuItem>
            <MenuItem name="3">
                <Icon type="ios-list-box-outline" />
                <router-link to="/History">歷史故事管理</router-link>
            </MenuItem>
            <MenuItem name="4">
                <Icon type="ios-list-box-outline" />
                <router-link to="/Itinerary">行程管理</router-link>
            </MenuItem>
            <MenuItem name="5">
                <Icon type="md-flash" />
                <router-link to="/Itineraryorder">行程訂單管理</router-link>
            </MenuItem>
            <MenuItem name="6">
                <Icon type="ios-color-palette-outline" />
                <router-link to="/Itinerarycanvas">畫布管理</router-link>
            </MenuItem>
            <MenuItem name="7">
                <Icon type="md-text" />
                <router-link to="/Itinerarycomment">行程評論管理</router-link>
            </MenuItem>
            <MenuItem name="8">
                <Icon type="ios-thumbs-up-outline" />
                <router-link to="/Product">商品管理</router-link>
            </MenuItem>
            <MenuItem name="9">
                <Icon type="md-heart-outline" />
                <router-link to="/Productorder">商品訂單管理</router-link>
            </MenuItem>
            <MenuItem name="10">
                <Icon type="ios-mail-outline" />
                <router-link to="/Qa">時空管理局管理</router-link>
            </MenuItem>
            <MenuItem name="11">
                <Icon type="md-flash" />
                <router-link to="/Coupon">折扣券管理</router-link>
            </MenuItem>
            <MenuItem name="12">
                <Icon type="md-contacts" />
                <router-link to="/Backaccount">後台帳號管理</router-link>
            </MenuItem>
        </MenuGroup>
    </Menu>
</template>
<script>
    export default {
        data () {
            return {
                theme: 'dark'
            }
        }
    }
</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';
.sidebar {
    height: 100%;
    position: fixed;
    top: 0;
    background-color: $background;
    text-decoration: none;
    color: $primary;
    margin-right: 50px;
    border-right: 2px solid $primary;
    .ivu-icon {
        color: $primary;
    }
    a {
        color: $primary;
        font-size: 17px;
        text-decoration: none;
    }
}
</style>