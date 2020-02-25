using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;

namespace Ordering.Api.Application.Queries
{
    public interface IOrderQueries
    {
        Task<IEnumerable<ViewModels.Order>> GetOrdersAsync();
        Task<ViewModels.Order> GetOrderByIdAsync(Guid id);
        Task<IEnumerable<ViewModels.Order>> GetOrdesByProductIdAsync(Guid productId);

    }
}
