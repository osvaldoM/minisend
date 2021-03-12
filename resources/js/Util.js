import {last as _last} from "lodash-es";

const mostRecentStatus = (statuses) => {
    return _last(statuses);
};

const mostRecentStatusClassName = (statuses) => {
    return statusColor(mostRecentStatus(statuses));
};

const statusColor = (status) => {
    switch (status.name) {
        case 'Sent':
            return 'success-status';
            break;

        case 'Failed':
            return 'failed-status';
            break;

        default:
            return 'default-status';
    }
}


export {
    mostRecentStatus,
    mostRecentStatusClassName,
    statusColor
}
