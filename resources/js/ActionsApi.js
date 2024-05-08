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

    const CalculateSalaryTax = async (MonthlySalary) => {
      const response = await fetch(`/user/dashboard/salary-tax-calculate?salary=${MonthlySalary}`);
      if (!response.ok) {
          throw new Error('Failed to fetch tax data');
      }
      const { MonthlytaxAmount, YearlytaxAmount } = await response.json();
      return { MonthlytaxAmount, YearlytaxAmount };
  }
export { deleteCartItem,  CalculateSalaryTax};