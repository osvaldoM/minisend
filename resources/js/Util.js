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
    statusColor
}
