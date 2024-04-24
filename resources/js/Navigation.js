import { router } from '@inertiajs/vue3';
// import route from 'vendor/tightenco/ziggy/src/js';

const gotoSignIn = ()=>
{
    router.get('/login')
}

const gotoRegister = ()=>
{
    router.get('/register')
}

const logout=()=>{
    router.post(route('logout'));
}

const gotoHome=()=>{
    router.get('/');
}

const gotoCardsRequiredUrl=(url)=>{
    router.get(`/user/dashboard/${url}`);
}

export { gotoSignIn,  gotoRegister,gotoHome,logout,gotoCardsRequiredUrl };