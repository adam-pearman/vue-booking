export const useIsError = (err, status) => err.response && err.response.status && err.response.status === status;
