import dayjs from 'dayjs'
import Vue from 'vue'

Vue.filter('formatDate', function (date){
    if(date){
        return dayjs(String(date)).format('YYYY-MM-DD HH:mm:ss');
    }
});


Vue.filter('truncate', function(text, length, suffix='...'){
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});
