<template>
    <div class="user_default2">
        <div class="user_info_balance">
            <dl class="item1">
                <router-link to="/user/info">

                    <dt><i class="fa fa-credit-card" /></dt>
                    <dd class="title">userinfo</dd></router-link>
            </dl>

            <dl class="item2">
                <dt><i class="fa fa-credit-card" /></dt>
                <dd class="title">Account balance</dd>
                <dd class="money">{{data.user_info.money||'0.00'}} $</dd>
            </dl>
            <dl class="item3">
                <dt><i class="fa fa-btc" /></dt>
                <dd class="title" @click="logout()">logout</dd>
            </dl>
<!--            <dl class="item3">-->
<!--                <dt><i class="fa fa-credit-card" /></dt>-->
<!--                <dd class="title">冻结资金</dd>-->
<!--                <dd class="money">{{data.user_info.frozen_money||'0.00'}} 元</dd>-->
<!--            </dl>-->

            <div class="clear"></div>
        </div>


        <div class="order_status_block">
            <ul>
                <li>
                    <router-link :to="{name:'user_order',params:{status:1}}">

                    <span><el-badge :value="data.count[0]" :hidden="data.count[0]==0" :max="99">Waiting for payment
                    </el-badge></span>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{name:'user_order',params:{status:2}}">

                    <span><el-badge :value="data.count[1]" :hidden="data.count[1]==0" :max="99">Waiting for delivery
                    </el-badge></span>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{name:'user_order',params:{status:3}}">

                    <span><el-badge :value="data.count[2]" :hidden="data.count[2]==0" :max="99">Waiting for receipt
                    </el-badge></span>
                    </router-link>
                </li>
<!--                <li>-->
<!--                    <router-link :to="{name:'user_order',params:{status:4}}">-->
<!--                    <i class="fa fa-commenting-o" />-->
<!--                    <span><el-badge :value="data.count[3]" :hidden="data.count[3]==0" :max="99">待评论</el-badge></span>-->
<!--                    </router-link>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <router-link :to="{name:'user_order',params:{status:5}}">-->
<!--                    <i class="fa fa-history" />-->
<!--                    <span><el-badge :value="data.count[4]" :hidden="data.count[4]==0" :max="99">售后处理</el-badge></span>-->
<!--                    </router-link>-->
<!--                </li>-->
            </ul>
        </div>

        <div class="user_main">
            <div class="block_title">
<!--                <span><router-link to="/user/order">more</router-link></span>-->
                Recent Orders
            </div>
            <div class="x20"></div>
            <div class="order_list" v-if="data.order.length>0">
                <div class="order_item" v-for="(v,k) in data.order" :key="k">
                    <div class="order_item_title">
                        <span>{{v.created_at}}<font :color="v.order_status==6?'#42b983':'#ca151e'">{{v.order_status_cn||'-'}}</font></span>
                        order number：{{v.order_no||'-'}}
                    </div>
                    <div class="order_item_list"  @click="$router.push('/user/order/'+v.id)">
                        <ul>
                            <li v-for="(vo,key) in v.order_goods" :key="key"><router-link to="">
                                <div class="order_thumb"><img :src="vo.goods_image||require('@/assets/Home/default.png').default" :alt="vo.goods_name"></div>
                                <div class="order_list_title">{{vo.goods_name||'-'}}</div>
                                <div class="order_list_attr">{{vo.sku_name||'-'}}</div>
                                <div class="order_list_num">x {{vo.buy_num||'1'}}</div>
                                <div class="order_list_price">${{vo.total_price||'0.00'}}</div>
                            </router-link></li>
                        </ul>
                    </div>
                </div>
            </div>
            <el-empty v-else />
        </div>

        <div class="user_main">
            <div class="block_title">
<!--                <span><router-link to="/user/favorite">more</router-link></span>-->
                Recent collection

            </div>
            <div class="x20"></div>
            <div class="fav_item_list" v-if="data.fav.length>0">
                <dl v-for="(v,k) in data.fav" :key="k"><router-link :to="'/goods/'+v.out_id">
                    <dt><img :src="v.goods_master_image" :alt="v.goods_name"></dt>
                    <dd class="title">{{v.goods_name}}</dd>
                    <dd class="price">${{v.goods_price}}</dd>
                </router-link></dl>
            </div>
            <el-empty v-else />
        </div>

        <div class="user_main">
            <div class="block_title">
                history
            </div>
            <div class="x20"></div>
            <div class="fav_item_list" v-if="data.history.length>0">
                <dl v-for="(v,k) in data.history" :key="k"><router-link :to="'/goods/'+v.id">
                    <dt><img :src="v.image||''" :alt="v.goods_name||''"></dt>
                    <dd class="title">{{v.goods_name||'-'}}</dd>
                    <dd class="price">${{v.goods_price||'0.00'}}</dd>
                </router-link></dl>
            </div>
            <el-empty v-else />
        </div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import { useStore } from 'vuex'
export default {
    setup() {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const data = reactive({
            order:[],
            fav:[],
            history:[],
            count:[],
            user_info:{},
            isLogin:false,
        })

        const loadData = ()=>{
            proxy.R.get('/user/default',{per_page:5,isResource:'Home'}).then(res=>{
                data.order = res.order.data
                data.count = res.count
                data.fav = res.fav.data
            })
        }
        const logout = ()=>{
            store.commit('login/logout')
        }
        onMounted( async ()=>{
            const token = localStorage.getItem('token')
            if(!proxy.R.isEmpty(token)) data.isLogin = true
            let user = await store.dispatch('login/getUserSer')
            Object.assign(data.user_info,user)

            loadData()

            let history = localStorage.getItem('shop_goods_historys')
            if(history) data.history = JSON.parse(history)
        })

        return {
            data,logout
        }
    },


};
</script>
<style lang="scss" scoped>

.fav_item_list{
    &:after{
        clear:both;
        display: block;
        content:'';
    }

    dl{
        width: 200px;
        float: left;
        margin-right: 32px;
        &:last-child{
            margin-right: 0;
        }
        dt{
            box-sizing: border-box;
            width: 200px;
            height: 200px;
            border:1px solid #efefef;
            img{width: 200px;}
            margin-bottom: 10px;
            background: #efefef;
        }
        dd{
            text-align: center;
            margin-bottom: 10px;
            &.price{color:#ca151e}
            &.title{height: 40px;overflow: hidden;}
        }
    }
}
.order_item_list{
    ul li{
        padding:20px 15px;
        border-top: 1px solid #efefef;
        border-left: 1px solid #efefef;
        border-right: 1px solid #efefef;
        &:last-child{
            border-bottom: 1px solid #efefef;
        }
        &:after{
            clear:both;
            display: block;
            content:'';
        }
        .order_thumb{
            width: 42px;
            height: 42px;
            background: #efefef;
            border:1px solid #efefef;
            box-sizing: border-box;
            float: left;
            margin-right: 15px;
            img{
                width: 40px;
                height: 40px;
            }
        }
        .order_list_title{
            float: left;
            font-size: 12px;
            line-height: 20px;
            height: 40px;
            overflow: hidden;
        }

        .order_list_attr{
            float: left;
            text-align: center;
            width: 190px;
            line-height: 40px;
        }
        .order_list_num{
            float: left;
            text-align: center;
            width: 140px;
            line-height: 40px;
        }
        .order_list_price{
            float: right;
            color:#ca151e;
            text-align: center;
            width: 90px;
            line-height: 40px;
            // font-weight: bold;
        }
    }
}
.order_item_title{
    background: #f6f6f6;
    line-height: 40px;
    padding: 0 15px;
    margin: 20px 0;
    span{
        float: right;
        font-size: 12px;
        font{
            margin-left:15px;
        }
    }
}
.order_status_block{
    background: #fff;
    padding: 20px;
    font-size: 14px;
    margin-top: 20px;
    margin-bottom: 20px;
    ul{
        &:after{
            clear:both;
            display: block;
            content:'';
        }
        li{
            position: relative;
            &:first-child i{
                font-weight: bold;
            }
            &:nth-child(1) i{
                top:-2px;
                font-size: 17px;
            }
            &:nth-child(2) i{
                left :36px;
                top:-3px;
            }
             &:nth-child(3) i{
                 left :35px;
                 font-size: 22px;
            }
             &:nth-child(4) i{
                 top:-3px;
                left :30px;
            }
            &:nth-child(5) i{
                top:-3px;
                left :30px;
                font-weight: normal;
            }
            float: left;
            text-align: center;
            width: 145px;
            i{
                position: absolute;
                font-size: 26px;
                margin-right: 4px;
                left :34px;
                color:#444;
            }
            :hover{
                color:#ca151e;
                i{
                    color:#ca151e;
                }
            }

        }
    }
}
.user_info_balance{
    display: flex;
    dl{
        flex: 1;
        background: #fff;
        display: block;
        padding: 20px;
        dt{
            color: #fff;
            font-size: 26px;
            float: left;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            line-height: 56px;
            text-align: center;
            margin-right: 20px;
        }
        dd{
            color:#666;
            &.title{
                font-size: 16px;
                margin-top: 8px;
            }
            &.money{
                font-size: 14px;
                padding-top:3px;
            }
        }
    }

}
.item1{
    margin-right: 20px;
    dt{background: #409eff;}
}
.item2{
    margin-right: 20px;
    dt{background: #e6a23c;}
}
.item3{
    dt{background: #f56c6c;}
}

</style>
<style lang="scss">
.order_status_block{
    .el-badge__content.is-fixed{
        right:calc(-10px + var(--el-badge-size)/ 2);
        &:hover{
            color:#fff;
        }
    }
}
</style>
