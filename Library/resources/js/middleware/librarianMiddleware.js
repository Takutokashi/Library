export default function (to, from, next) {
    const token = localStorage.getItem('role');
    if (token === 'librarian'){

    }
    else {
        window.location.href = '/#/home';
    }
    next();
}
