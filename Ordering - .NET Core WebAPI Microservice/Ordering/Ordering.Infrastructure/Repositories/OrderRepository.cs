using MedicalHistory.Infrastructure.Repositories;
using Ordering.Domain.Models.ProductAggregate;
using System;
using System.Collections.Generic;
using System.Text;
using System.Threading.Tasks;
using Ordering.Domain.Models.OrderAggregate;

namespace Ordering.Infrastructure.Repositories
{
    public class OrderRepository : BaseEntityRepository<Order>
    {
        public OrderRepository(OrderContext context)
         : base(context, context.Orders)
        {
        }

        public override async Task<Order> GetAsync(Guid id)
        {
            var order = await base.GetAsync(id);

            if (order != null)
            {
                await _context.Entry(order)
                   .Reference(o => o.OrderProduct).LoadAsync();
            }

            return order;
        }

        public async Task<Product> GetProductAsync(Guid id)
        {
            var order = await base.GetAsync(id);

            var order_product = await _context.Products.FindAsync(order.ProductId);

            return order_product;
        }

    }
}
