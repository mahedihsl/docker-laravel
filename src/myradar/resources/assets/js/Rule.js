const myRule = {
  getMessage(field, params, data) {
      return (data && data.message) || 'Something went wrong';
  },
  validate(value) {
    return new Promise(resolve => {
      resolve({
        valid: value === 'trigger' ? false : !! value,
        data: value !== 'trigger' ? undefined : { message: 'Not this value' }
      });
    });
  }
};
