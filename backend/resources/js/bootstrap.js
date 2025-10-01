import Alpine from 'alpinejs';
import axios from 'axios';

import './cart';
import './echo';

window.axios = axios;
window.Alpine = Alpine

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


Alpine.start()
