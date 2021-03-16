const statusColor = (status) => {
  switch (status.name) {
    case 'Sent':
      return 'success-status';

    case 'Failed':
      return 'failed-status';

    default:
      return 'default-status';
  }
};

export {
  statusColor,
};
