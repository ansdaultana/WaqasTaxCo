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

const gotoHome=()=>{
    router.get('/');
}

export { gotoSignIn, gotoRegister,gotoHome};