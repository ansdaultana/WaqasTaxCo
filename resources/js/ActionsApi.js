import { router } from '@inertiajs/vue3';


const deleteCartItem=(id,item)=>{
  
    const data = {
        type: item.type ,
        deleteItemId: item.id,
      };
      router.post(`/user/dashboard/cart/delete-item/${id}`, data)
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
  };

    const CalculateSalaryTax = async (MonthlySalary) => {
      const response = await fetch(`/user/dashboard/salary-tax-calculate?salary=${MonthlySalary}`);
      if (!response.ok) {
          throw new Error('Failed to fetch tax data');
      }
      const { MonthlytaxAmount, YearlytaxAmount } = await response.json();
      return { MonthlytaxAmount, YearlytaxAmount };
  }
  const FindNTN = async (cnic) => {
    const response = await fetch(`/user/dashboard/find-ntn?cnic=${cnic}`);
    if (!response.ok) {
        throw new Error('Failed to fetch tax data');
    }
    const {Data } = await response.json();
    return {Data};
}

const deleteSoleProprietorship=(id)=>{

    router.post(`/user/dashboard/sole-proprietorship/delete/${id}`)
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
    });
};


const deleteAop=(id)=>{

  router.post(`/user/dashboard/aop/delete/${id}`)
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });
};
export { deleteCartItem,  CalculateSalaryTax, FindNTN,deleteSoleProprietorship,deleteAop};