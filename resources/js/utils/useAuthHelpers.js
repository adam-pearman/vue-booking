export function hasStorageLogin() {
    return localStorage.getItem('isLoggedIn') === 'true';
}

export function storageLogin() {
    localStorage.setItem('isLoggedIn', true);
}

export function storageLogout() {
    localStorage.setItem('isLoggedIn', false);
}
