import './bootstrap';
import '../css/app.css';
//import '../css/admin.css'

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { InertiaProgress } from '@inertiajs/progress';
import Antd from 'ant-design-vue';
import { i18nVue } from 'laravel-vue-i18n'
import 'ant-design-vue/dist/antd.css';


// import { createI18n } from 'vue-i18n';
// import messages from '@/lang/messages.js'
// const i18n = createI18n({
//     locale: 'nl',
//     fallbackLocale: 'en',
//     messages,
// });

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Antd)
            .use(i18nVue, {
                lang:'zh-TW',
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();

                },
            })
            .component('inertia-head', Head)
            .component('inertia-link', Link)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
