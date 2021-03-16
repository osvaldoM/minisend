import dayjs from 'dayjs';
import Vue from 'vue';

Vue.filter('formatDate', (date) => {
  if (date) {
    return dayjs(String(date)).format('YYYY-MM-DD HH:mm:ss');
  }
  return '';
});

Vue.filter('truncate', (text, length, suffix = '...') => {
  if (text.length > length) {
    return text.substring(0, length) + suffix;
  }
  return text;
});
