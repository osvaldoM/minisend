// import nprogress from 'NPro'

import nprogress from 'nprogress';

import axios from 'axios';

// create a new axios instance
const instance = axios.create({
});

instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// before a request is made start the nprogress
instance.interceptors.request.use((config) => {
  nprogress.start();
  return config;
});

// before a response is returned stop nprogress
instance.interceptors.response.use((response) => {
  nprogress.done();
  return response;
});

export default instance;
