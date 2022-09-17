window._ = require('lodash');
import {createApp} from 'vue'
import store from '@/stores'
import ElementPlus from 'element-plus'
import i18n from '@/locales'
import router from '@/plugins/router'
import R from '@/plugins/http'
import App from '@/views/App.vue'
import '@/plugins/css/style.css'
import qInput from '@/components/common/input'

const ElementMessage = R.loadLocaleMessages()
const localeElementPlus = require(`@/locales/element/${ElementMessage[R.getLocalesName()]?R.getLocalesName():'zh-cn'}`)
let elementInit = { size: 'default', zIndex: 3000, locale: localeElementPlus.default }
// 注意：这种方式将会导入所有组件
import NutUI from "@nutui/nutui";
// 采用按需加载时  此全局css样式，需要删除
import "@nutui/nutui/dist/style.css";
router.afterEach(() => {
    window.scrollTo(0,0);
});

// 挂载初始化
const app = createApp(App)
app.component('q-input',qInput)
app.use(i18n)
.use(store)
.use(router)
.use(ElementPlus,elementInit).use(NutUI)
app.config.globalProperties.R = R
app.mount('#app')
