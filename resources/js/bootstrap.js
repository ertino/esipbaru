/**
 * Application bootstrap (Vite/ESM).
 *
 * Ported from the Laravel Mix/CommonJS version of ijinnakes:
 *   window._ = require('lodash');
 *   window.axios = require('axios');
 *
 * axios stays on `window` with the X-Requested-With header so the existing
 * jQuery/AJAX calls in the Blade views keep the same behaviour.
 */

import axios from 'axios';
import _ from 'lodash';

window._ = _;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Echo/Pusher were disabled in ijinnakes, so broadcasting stays off.