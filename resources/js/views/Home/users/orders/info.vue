<template>
    <div class="user_main">
        <div class="block_title">
            detail
        </div>
        <div class="x20"></div>


        <div class="admin_form">
            <div class="order_info_list">
                <el-row>
                    <el-col :span="12">
                        order number：<span class="content">{{data.info.order_no||'-'}}</span>
                    </el-col>
                    <el-col :span="12">
                        status：
                        <span class="content">
                            <el-tag type="danger" v-show="data.info.order_status==0">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="warning" v-show="data.info.order_status==1">{{data.info.order_status_cn}}</el-tag>
                            <el-tag v-show="data.info.order_status>1 && data.info.order_status<6">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="info" v-show="data.info.order_status==6">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="success" v-show="data.info.order_status>=7">{{data.info.order_status_cn}}</el-tag>
                        </span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">Order payment

</span></div>
            <div class="x20"></div>

            <div class="order_info_list">
                <el-row>
                    <el-col :span="8">
                        Payment method ：<span class="content">{{data.info.payment_name_cn||'-'}}</span>
                    </el-col>
                    <el-col :span="8">
                        Payment time ：<span class="content">{{data.info.pay_time||'-'}}</span>
                    </el-col>
                    <el-col :span="8">
                        courier number ：<span class="content">{{data.info.delivery_no||'-'}}</span>
                    </el-col>
                </el-row>
            </div>
            <div class="order_info_list">
                <el-row>
                    <el-col :span="24">
                        remake：<span class="content">{{data.info.remark||'-'}}</span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">address</span></div>
            <div class="x20"></div>

            <div class="order_info_list">
                <el-row>
                    <el-col :span="8">
                        consignee ：<span class="content">{{data.info.receive_name}}</span>
                    </el-col>
                    <el-col :span="8">
                        phone：<span class="content">{{data.info.receive_tel}}</span>
                    </el-col>
                    <el-col :span="8">
                        Picking address ：<span class="content">{{data.info.receive_area+data.info.receive_address}}</span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">Product information</span></div>
            <div class="x20"></div>

            <div class="admin_table_list">
                <!-- <a-table :columns="columns" :data-source="data.info.order_goods" :pagination="false"  >
                    <span slot="name" slot-scope="rows">
                        <div class="admin_pic_txt">
                            <div class="img"><img v-if="rows.goods_image" :src="rows.goods_image"><a-icon v-else type="picture" /></div>
                            <div class="text" style="max-width:475px;line-height:20px">{{rows.goods_name}}</div>
                            <div class="clear"></div>
                        </div>
                    </span>
                    <span slot="buy_num" slot-scope="rows">
                        x {{rows.buy_num}}
                    </span>
                    <span slot="goods_price" slot-scope="rows">
                        <font color="#ca151e">￥{{rows.goods_price}}</font>
                    </span>
                </a-table> -->
            </div>


            <div class="order_info_right_price">total：$ {{data.info.total_price}}<span data-v-01d38243="">（freight：{{data.info.freight_money}}）</span></div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">Express information</span></div>
            <div class="x20"></div>

            <div class="order_info_kd">
                <el-timeline v-if="data.info.delivery_list && data.info.delivery_list.length>0">
                    <el-timeline-item  v-for="(v,k) in data.info.delivery_list" :key="k" :timestamp="v.time" :color="k==0?'red':'gray'">
                    {{v.context}}
                    </el-timeline-item>
                </el-timeline>
                <el-empty v-else />
            </div>
            <br>
        </div>


    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import {useRoute} from "vue-router"
export default {
    components: {},
    setup() {
        const {proxy} = getCurrentInstance()
        const route = useRoute()
        const data = reactive({
            id:0,
            info:{
                order_status:0
            },
            columns:[
                //   {title:'#',dataIndex:'id',fixed:'left'},
                {title:'商品名称',key:'id',fixed:'left',scopedSlots: { customRender: 'name' }},
                {title:'规格属性',dataIndex:'sku_name'},
                {title:'购买数量',key:'id',scopedSlots: { customRender: 'buy_num'}},
                {title:'商品价格',key:'id',scopedSlots: { customRender: 'goods_price'} },
            ],
            list:[],
        })

        const loadData = ()=>{
            if(!proxy.R.isEmpty(route.params.id)) data.id = route.params.id
            proxy.R.get('/user/order/'+data.id+'?isResource=Home').then(res=>{
                if(!res.code) data.info = res
            }).catch(error=>{
                console.log(error)
            })
        }

        onMounted(() => {
            loadData()
        })

        return {
            data,
        }
    },

};
</script>
<style lang="scss" scoped>
.order_info_list{
    margin-bottom: 20px;
}
</style>
