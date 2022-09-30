<template>
    <nut-tabbar @tab-switch="tabSwitch" style="position:fixed;z-index:999;bottom:0px;left:0;right:0;">
        <nut-tabbar-item tab-title="Commodity" icon="find" to="/"></nut-tabbar-item>
        <!--        <nut-tabbar-item tab-title="分类" icon="category" to="/stores"></nut-tabbar-item>-->
        <nut-tabbar-item tab-title="Cart" icon="category" to="/carts"></nut-tabbar-item>
        <nut-tabbar-item tab-title="Home" icon="home" to="/user"></nut-tabbar-item>
    </nut-tabbar>

</template>

<script>
import { useStore } from 'vuex'
import {reactive,computed,getCurrentInstance} from "vue"
export default {
    setup() {
        function tabSwitch(item, index) {
            console.log(item, index);
        }

        return {
            tabSwitch,
        };
        const store = useStore()
        const common = reactive(computed(()=>store.state.init.common.common))
        return {common}
    }

};
</script>
<style lang="scss" scoped>
.shop_foot{
    padding-top: 10px;
    text-align: center;
    ul{
        margin:40px auto 0 auto;
        width: 664px;
        border-top: 1px solid #efefef;
        padding-top: 40px;
    }
    ul li{
        float: left;
        margin-right: 40px;
        margin-bottom: 60px;
        font-size: 14px;
        a:hover{
            color:#ca151e;
        }
    }
    ul li:last-child{
        margin-right: 0px;
    }
    .foot_copyright{
        clear: both;
        font-size: 12px;
        line-height: 35px;
        padding-bottom: 20px;
    }
}
</style>
