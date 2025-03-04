import { createApp } from 'vue';

const app = createApp({
    data() {
        return {
            password: '',
            isPasswordVisible: false
        };
    },
    computed: {
        passwordFieldType() {
            return this.isPasswordVisible ? 'text' : 'password';
        },
        passwordIcon() {
            return this.isPasswordVisible ? 'bi bi-eye-slash' : 'bi bi-eye';
        }
    },
    methods: {
        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        }
    }
});

// Mount ke elemen dengan ID #app
app.mount('#app');

console.log('Content loaded');
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    console.log('Event container:', document.querySelector('.event-container'));
    
    // Debug CSS loading
    const styles = document.styleSheets;
    console.log('Loaded stylesheets:', styles.length);
    
    for(let i = 0; i < styles.length; i++) {
        try {
            console.log('Stylesheet:', styles[i].href);
        } catch(e) {
            console.log('Unable to access stylesheet');
        }
    }
});
