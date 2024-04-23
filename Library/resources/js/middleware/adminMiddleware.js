export default function (to, from, next) {
    const token = localStorage.getItem('role');
    if (token === 'admin'){

    }
    else {
        window.location.href = '/#/home';
    }
    next();
}

