<template>
    <div class="home_login">
        <div class="login_block ">
            <div class="login_item">
                <div class="login_title">
                    <ul>
                        <li class="red">帐号登录</li>
                    </ul>
                </div>
                <div class="login_input">
                    <div class="input_block"><input type="text" v-model="data.username" placeholder="手机"
                                                    @keyup.enter="login"></div>
                    <div class="input_block"><input type="password" v-model="data.password" placeholder="密码"
                                                    @keyup.enter="login"></div>
                </div>

                <div class="login_btn" @click="login">登 录</div>

                <div class="login_btn_b">
                    <router-link to="/register">注册</router-link>
                    |
                    <router-link to="/forget_password">忘记密码？</router-link>
                </div>
                <el-divider>其他登录方式</el-divider>
                <fb:login-button
                    scope="public_profile,email"
                    onlogin="checkLoginState();">
                </fb:login-button>
            </div>
        </div>
    </div>
</template>

<script>
window.checkLoginState = function() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response) {
    if (response.status === 'connected') {  //登陆状态已连接
        var fbToken = response.authResponse.accessToken;
        getUserInfo(fbToken);
    } else if (response.status === 'not_authorized') { //未经授权
        console.log('facebook未经授权');
    } else {
        console.log('不是登陆到Facebook;不知道是否授权');
    }
}

//获取用户信息
function getUserInfo(fbToken) {
    FB.api('/me?fields=first_name,last_name,gender,email,picture,name', function (response) {
        //response.id / response.name
        console.log('Successful login for: ' + response.name);
        console.log('token: '+fbToken)
        console.log('pic: '+response.picture.data.url)
        console.log('email: '+response.email)

        //把用户token信息交给后台
        // self.location = '/home/login.fbLogin.do?accessToken=' + fbToken;
    });
}
import {reactive, onMounted, getCurrentInstance} from "vue"
import {useStore} from 'vuex'
import {useRouter, useRoute} from 'vue-router'

export default {
    setup(props) {

        const {proxy} = getCurrentInstance()
        const store = useStore()
        const router = useRouter()
        const route = useRoute()
        const data = reactive({
            username: "",
            password: "",
            provider: "users"
        })

        const login = async () => {
            if (data.username == "" || data.password == "") {
                proxy.$message.error(proxy.$t('msg.loginAbn'));
                return;
            }

            let loginData = await proxy.R.post('/login', data)
            loginData.routeUriIndex = store.state.load.routeUriIndex
            loginData.path = '/login'
            if (!loginData.code) {
                await store.commit('login/loginAfter', loginData)
                router.push('/user')
            }

        }


        const wechatLogin = () => {
            window.location.href = "/api/oauth/weixinweb"
        }
        // onMounted
        onMounted(() => {


            // wait for facebook sdk to initialize before starting the vue app
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '2216596465175515',
                    cookie: true,
                    xfbml: true,
                    version: 'v8.0'
                });

            };

            // load facebook sdk script
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));



            let inviterId = route.query.inviter_id || 0
            let inviterIdSession = sessionStorage.getItem('inviterId')
            if (inviterId == 0 && !proxy.R.isEmpty(inviterIdSession)) inviterId = inviterIdSession
            sessionStorage.setItem('inviterId', inviterId)
            if (!proxy.R.isEmpty(route.query.code)) {
                proxy.R.get('/callback/oauth/weixinweb', {
                    code: route.query.code,
                    inviter_id: route.query.inviter_id || 0
                }).then(async res => {
                    if (!res.code && res.access_token) {
                        await store.commit('login/loginAfter', res)
                        router.push('/user')
                    }
                })
            }
        })

        return {
            data,
            wechatLogin, login,checkLoginState
        }
    },

    methods: {},
    // created: function() {
    //     var _this = this;
    //     // 判断token是否失效

    //     // 判断是否有微信code则直接请求接口获取token
    //     if(this.$route.query.code){
    //         this.$get(this.$api.homeWechatLogin,{code:this.$route.query.code}).then(function(res) {
    //             // console.log(res);
    //             if (res.code == 200) {
    //                 localStorage.setItem("token", res.data.token);
    //                 _this.$store.dispatch('homeLogin/login',res);
    //                 _this.$message.success('登录成功！');
    //                 _this.$router.push({ name: "home_user_default" });
    //             }
    //         });
    //         return
    //     }

    //     this.$get(this.$api.homeCheckLogin).then(function(res) {
    //         // console.log(res);
    //         if (res.code == 200) {
    //             _this.$router.push({ name: "home_user_default" });
    //         }
    //     });
    // },
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

    .other_login_block {
        cursor: pointer;
        text-align: center;
        line-height: 30px;

        i {
            font-size: 30px;
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

                input {
                    width: 100%;
                    border: 1px solid #e1e1e1;
                    height: 35px;
                    text-indent: 6px;
                    outline: none;
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
