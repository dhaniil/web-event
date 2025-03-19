// Set Vue.js ke production mode
if (process.env.NODE_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.productionTip = false;
} 