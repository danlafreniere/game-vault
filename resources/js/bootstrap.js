import axios from 'axios';
import ProgressBar from 'progressbar.js';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.ProgressBar = ProgressBar;
