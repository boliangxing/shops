<template>
    <div class="home_login" >
        <div class="login_block">
            <div class="login_item">
                <div class="login_title">
                    <ul>
                        <li class="red">Register</li>
                        <li>|</li>
                        <li @click="$router.push('/login')">Login</li>
                    </ul>
                </div>
                <div class="login_input">
                    <div class="input_block">
                        <maz-phone-number-input v-model="data.username" @keyup.enter="login"></maz-phone-number-input>
                    </div>
                    <div class="input_block">
                        <MazInput v-model="data.password" label="password" type="password" @keyup.enter="login"/>
                    </div>
                    <div class="input_block">
                        <MazInput v-model="data.re_password" label="re_password" type="password" @keyup.enter="login"/>
                    </div>
                    <div class="input_block">

                        <MazInput class="yzm" type="code" v-model="data.code" :placeholder="$t('btn.code')"
                                  @keyup.enter="register"></MazInput>
                        <span :class="data.math>0?'yzmbtn dis':'yzmbtn'"
                              @click="sendSms"    >{{ data.code_text }}</span>

                    </div>
                </div>

                <maz-btn color="secondary" @click="register">register</maz-btn>

                <div class="login_btn_b">
                    <router-link to="/forget_password">forget password？</router-link>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
import {reactive, getCurrentInstance} from "vue"
import {useStore} from 'vuex'
import {useRouter, useRoute} from 'vue-router'
import MazBtn from 'maz-ui/components/MazBtn'

import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
// import css
import 'maz-ui/css/main.css'
import MazInput from 'maz-ui/components/MazInput'

export default {
    components: {
        MazPhoneNumberInput, MazInput, MazBtn
    },
    setup(props) {
        const {ctx, proxy} = getCurrentInstance()
        const store = useStore()
        const router = useRouter()
        const route = useRoute()
        const data = reactive({
            username: "",
            password: "",
            re_password: "",
            code: "",
            code_text: '',
            timeObj: null,
            math: 0,
        })

        let inviterId = route.query.inviter_id || 0
        let inviterIdSession = sessionStorage.getItem('inviterId')
        if (inviterId == 0 && !proxy.R.isEmpty(inviterIdSession)) inviterId = inviterIdSession
        sessionStorage.setItem('inviterId', inviterId)

        data.code_text = proxy.$t('sms.sendCode')

        const register = async () => {
            if (data.username == "" || data.password == "") {
                proxy.$message.error(proxy.$t('msg.loginAbn'));
                return;
            }

            let loginData = await proxy.R.post('/register', {
                username: data.username,
                password: data.password,
                re_password: data.re_password,
                inviterId: inviterId,
                code: data.code,
                type: 'phone',
            })

            loginData.routeUriIndex = store.state.load.routeUriIndex
            if (!loginData.code) {
                await store.commit('login/loginAfter', loginData)
                router.push('/')
            }
        }

        // 发送短信
        const sendSms = () => {
            if (data.username == '') {
                return proxy.$message.error(proxy.$t('sms.phoneEmpty'));
            }
            if (data.math > 0) {
                return proxy.$message.error(proxy.$t('manySend'));
            }
            proxy.R.post('/sms', {phone: data.username, name: 'register'}).then(res => {
                if (!res.code) return proxy.$message.success(proxy.$t('sms.sendSuc'))
            })
        }

        return {
            data,
            register, sendSms
        }
    },

};
</script>
<style lang="scss" scoped>
.login_block {
    text-align: right;

    .login_btn_b {
        text-align: right;
        font-size: 12px;
        margin-top: 15px;
        margin-bottom: 40px;

        a {
            margin: 0 8px;
            color: #999;
        }
    }

    .login_item {
        width: 400px;
        background: #fff;
        height: 450px;
        float: right;
        box-sizing: border-box;
        padding: 40px;
        margin-top: 50px;
        text-align: left;

        .login_btn {
            cursor: pointer;
            color: #fff;
            background: #ca151e;
            line-height: 35px;
            width: 100%;
            text-align: center;
            font-size: 16px;
        }

        .login_input {
            margin-top: 30px;

            .input_block {
                margin: 15px auto;
                width: 320px;

                .yzmbtn {
                    cursor: pointer;
                    width: 140px;
                    height: 35px;
                    line-height: 35px;
                    display: inline-block;
                    text-align: center;
                    background: #333;
                    color: #fff;

                    &.dis {
                        background: #ccc;
                        color: #666;
                    }
                }

                input {
                    width: 100%;
                    border: 1px solid #e1e1e1;
                    height: 35px;
                    text-indent: 6px;
                    outline: none;

                    &.yzm {
                        width: 50%;
                        margin-right: 5%;
                    }
                }
            }
        }

        .login_title {
            ul {
                margin-left: 55px;

                &:after {
                    content: '';
                    display: block;
                    clear: both;
                }
            }

            ul li {
                cursor: pointer;
                float: left;
                margin-right: 20px;
                font-size: 20px;

                &.red {
                    color: #ca151e;
                }

                &:hover {
                    color: #ca151e;
                }
            }
        }
    }
}

.home_login {
    height: 550px;
}
</style>
