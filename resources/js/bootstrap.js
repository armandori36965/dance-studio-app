import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Import Bootstrap's JS
import * as bootstrap from 'bootstrap';