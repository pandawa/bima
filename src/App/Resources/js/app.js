import {createApp, h} from 'vue'
import {InertiaProgress} from '@inertiajs/progress'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Base from "@/base";
import {ZiggyVue} from '../../../../vendor/tightenco/ziggy/dist/vue.m';

InertiaProgress.init()

createInertiaApp({
    resolve: name => require(`./${name}`),
    title: title => title ? `${title} - Bima` : 'Bima',
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin(Base)
            .use(VueAxios, axios)
            .use(ZiggyVue)
            .mount(el)
    },
})
