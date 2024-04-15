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
const gotoVendorRegister =()=>
{
    router.get('/vendor/registerPage')
}

const gotoMyShop =()=>
{
    router.get('/vendor/dashboard');
}
const gotoHome=()=>{
    router.get('/');
}
const gotoNewProduct=()=>{
    router.get('/vendor/dashboard/newproduct');
}
const gotoVendorProducts=()=>{
    router.get('/vendor/dashboard/products');
}
const gotoEditProduct=(id)=>{
    router.get(`/vendor/dashboard/editproduct/${id}`);
}

const DeleteProduct=(id)=>{
    router.post(`/vendor/dashboard/deleteproduct/${id}`);
}
const AddOrRemoveCartItem=(id)=>{
    router.post(`/customer/AddOrRemoveCartitem/${id}`);
}
const AddOrRemoveFavouriteitem=(id)=>{
    router.post(`/customer/AddOrRemoveFavouriteitem/${id}`);
}
export { gotoSignIn,  gotoRegister,gotoHome,logout,gotoVendorRegister, gotoMyShop,gotoNewProduct,gotoVendorProducts,gotoEditProduct,DeleteProduct,AddOrRemoveCartItem,AddOrRemoveFavouriteitem };