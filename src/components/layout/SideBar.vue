<template>
    <Menu theme="dark" active-name="1" class="sidebar">

        <MenuGroup title="Timevolts後台管理" color="#fa0">
            <MenuItem name="1" to="/" class="item">
            <Icon type="ios-contact" />會員管理
            </MenuItem>
            <MenuItem name="2" to="/News" class="item">
            <Icon type="md-flash" />最新消息管理
            </MenuItem>
            <MenuItem name="3" to="/History" class="item">
            <Icon type="ios-list-box-outline" />歷史故事管理
            </MenuItem>
            <MenuItem name="4" to="/Itinerary" class="item">
            <Icon type="ios-list-box-outline" />行程管理
            </MenuItem>
            <MenuItem name="5" to="/Itineraryorder" class="item">
            <Icon type="md-flash" />行程訂單管理
            </MenuItem>
            <!-- <MenuItem name="6" to="/Itinerarycanvas" class="item"> -->
            <!-- <Icon type="ios-color-palette-outline" />畫布管理
            </MenuItem> -->
            <MenuItem name="7" to="/Itinerarycomment" class="item">
            <Icon type="md-text" />行程評論管理
            </MenuItem>
            <MenuItem name="8" to="/Product" class="item">
            <Icon type="ios-thumbs-up-outline" />商品管理
            </MenuItem>
            <MenuItem name="9" to="/Productorder" class="item">
            <Icon type="md-heart-outline" />商品訂單管理
            </MenuItem>
            <MenuItem name="10" to="/Qa" class="item">
            <Icon type="ios-mail-outline" />時空管理局管理
            </MenuItem>
            <MenuItem name="11" to="/Coupon" class="item">
            <Icon type="md-flash" />折扣券管理
            </MenuItem>
            <MenuItem name="12" to="/Backaccount" class="item">
            <Icon type="ios-contact" />後台帳號管理
            </MenuItem>
        </MenuGroup>
    </Menu>
</template>
<script>
    export default {
        data () {
            return {
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
    border-right: 2px solid $color;
    .ivu-icon {
        color: $color;
    }
    .item {
            color: $color;
            font-size: 17px;
            text-decoration: none;
        }
}
.ivu-menu-dark.ivu-menu-vertical .ivu-menu-item-active:not(.ivu-menu-submenu), .ivu-menu-dark.ivu-menu-vertical .ivu-menu-submenu-title-active:not(.ivu-menu-submenu),.ivu-icon{
    color: $primary;
}
</style>