import API from './api';

export const ValidateTFN = (tfn: string) => {
    return API.post(`/validate`, { TFN: tfn })
        .then(response => response)
        .catch(error => {
            throw error;
        });
};