using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Ordering.Api.Application.ViewModels;

namespace Ordering.Api.Application.Queries
{
    public interface IOrderQueries
    {
        Task<IEnumerable<Order>> GetOrdersAsync();
        Task<Order> GetOrderByIdAsync(Guid id);
        Task<IEnumerable<Order>> GetOrdersByProductIdAsync(Guid productId);

    }
}
