using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;

namespace Ordering.Api.Application.Queries
{
    public interface IProductQueries
    {
        Task<IEnumerable<Product>> GetProductsAsync();
        Task<Product> GetProductByIdAsync(Guid id);
        Task<IEnumerable<Product>> GetProductsByNameAsync(string name);

    }
}
