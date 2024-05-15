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

const gotoDashboard=()=>{
    router.get('/user/dashboard');
}
const sole_prop_upload_docs=(id)=>
{
    console.log(id)

    router.get(`/user/dashboard/sole-proprietorship/upload-docs/${id}`);

}
export { gotoSignIn,  gotoRegister,gotoHome,logout,gotoCardsRequiredUrl,gotoDashboard,sole_prop_upload_docs };