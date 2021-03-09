import dayjs from 'dayjs'
import Vue from 'vue'

Vue.filter('formatDate', function (value){
    if(value){
        return dayjs(String(value)).format('YYYY-MM-DD HH:mm:ss');
    }
});
