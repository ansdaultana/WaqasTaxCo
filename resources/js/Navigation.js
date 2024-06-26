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
    router.get('/user/dashboard');
}

const gotoCardsRequiredUrl=(url)=>{
    router.get(`/user/dashboard/${url}`);
}

const gotoDashboard=()=>{
    router.get('/user/dashboard');
}
const sole_prop_upload_docs=(id)=>
{

    router.get(`/user/dashboard/sole-proprietorship/upload-docs/${id}`);

}
const aop_upload_docs=(id)=>
{

    router.get(`/user/dashboard/aop/upload-docs/${id}`);

}
export { gotoSignIn,  gotoRegister,gotoHome,logout,gotoCardsRequiredUrl,gotoDashboard,sole_prop_upload_docs,aop_upload_docs };