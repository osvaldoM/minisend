import dayjs from 'dayjs'
import Vue from 'vue'

Vue.filter('formatDate', function (date){
    if(date){
        return dayjs(String(date)).format('YYYY-MM-DD HH:mm:ss');
    }
});


Vue.filter('truncate', function(text, length, clamp){
    clamp = clamp || '...';
    const node = document.createElement('div');
    node.innerHTML = text;
    const content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
});
