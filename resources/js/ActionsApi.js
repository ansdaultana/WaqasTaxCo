import { router } from '@inertiajs/vue3';


const deleteCartItem=(id,item)=>{
  
    const data = {
        name: item.name ,
      };
      router.post(`/user/dashboard/cart/delete-item/${id}`, data)
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
  };

export { deleteCartItem,  };